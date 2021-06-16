<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Http\Resources\JSONAPIResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\JSONAPICollection;
use App\Http\Resources\JSONAPIIdentifierResource;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JSONAPIRelationshipService
{
    public function fetchRelationship(
        string $modelClass,
        string $uuid,
        string $relationship
    ): JSONAPIIdentifierResource | AnonymousResourceCollection {
        
        $model = $modelClass::findOrFail($uuid);

        if ($model->$relationship instanceof Model) {
            return new JSONAPIIdentifierResource($model->$relationship);
        }

        return JSONAPIIdentifierResource::collection($model->$relationship);
    }

    public function updateToOneRelationship(
        Model $model, 
        string $relationship,
        array $uuids,
    ): Response {

        $relatedModel = $model->$relationship()->getRelated();

        $model->$relationship()->dissociate();

        if ($uuids) {
            $newModel = $relatedModel->newQuery()->findOrFail($uuids[0]);
            $model->$relationship()->associate($newModel);
        }

        $model->save();
        return response(null, 204);
    }

    public function updateToManyRelationships(
        Model $model,
        string $relationship, 
        array $uuids,
    ): Response {

        $foreignKey = $model->$relationship()->getForeignKeyName();
        $relatedModel = $model->$relationship()->getRelated();
        
        dd($uuids);
        $relatedModel->newQuery()->findOrFail($uuids);
        dd($relatedModel->newQuery()->findOrFail($uuids));

        $relatedModel->newQuery()->where($foreignKey, $model->id)->update([
            $foreignKey => null,
        ]);

        $relatedModel->newQuery()->whereIn('id', $uuids)->update([
            $foreignKey => $model->id,
        ]);

        return response(null, 204);
    }

    public function updateManyToManyRelationships(
        Model $model,
        string $relationship, 
        array $uuids,
    ): Response {
        $model->$relationship()->sync($uuids);
        return response(null, 204);
    }

    public function fetchRelated(
        string $modelClass, 
        string $uuid,
        string $relationship
    ): JSONAPIResource | JSONAPICollection {

        $model = $modelClass::findOrFail($uuid);
        
        if ($model->$relationship instanceof Model) {
            return new JSONAPIResource($model->$relationship);
        }

        return new JSONAPICollection($model->$relationship);
    }

    public function handleRelationship(
        array $relationships, 
        $model
    ): void {
        foreach ($relationships as $relationshipName => $contents) {
            if ($model->$relationshipName() instanceof BelongsTo) {
                $this->updateToOneRelationship($model, $relationshipName, $contents['data']['id']);
            }
            if ($model->$relationshipName() instanceof BelongsToMany) {
                $this->updateManyToManyRelationships($model, $relationshipName, collect($contents['data'])->pluck('id'));
            }
        }

        $model->load(array_keys($relationships));
    }
}
