<?php

namespace App\Services;

use App\Author;
use App\Book;
use App\Http\Resources\JSONAPICollection;
use App\Http\Resources\JSONAPIIdentifierResource;
use App\Http\Resources\JSONAPIResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class JSONAPIService
{
    public function fetchResources(string $modelClass, string $type): JSONAPICollection
    {
        $models = QueryBuilder::for($modelClass)
            ->allowedSorts(config("jsonapi.resources.{$type}.allowedSorts"))
            ->allowedIncludes(config("jsonapi.resources.{$type}.allowedIncludes"))
            ->allowedFilters(config("jsonapi.resources.{$type}.allowedFilters"))
            ->jsonPaginate();

        return new JSONAPICollection($models);
    }

    /**
     * @param $model
     *
     * @param int $id
     * @param string $type
     *
     * @return JSONAPIResource
     */
    public function fetchResource($model, $id = 0, $type = '')
    {
        if($model instanceof Model){
            return new JSONAPIResource($model);
        }

        $query = QueryBuilder::for($model::where('id', $id))
            ->allowedIncludes(config("jsonapi.resources.{$type}.allowedIncludes"))
            ->firstOrFail();
        return new JSONAPIResource($query);
    }

    /**
     * @param string $modelClass
     * @param array $attributes
     *
     * @return Response
     */
    public function createResource(string $modelClass, array $attributes, array $relationships = null)
    {
        $model = $modelClass::create($attributes);

        if ($relationships) {
            $this->handleRelationship($relationships, $model);
        }

        return (new JSONAPIResource($model))
            ->response()
            ->header('Location', route("{$model->type()}.show", [
                Str::singular($model->type()) => $model,
            ]));
    }



    /**
     * @param $model
     * @param $attributes
     *
     * @return Response
     */
    public function updateResource($model, $attributes, $relationships = null)
    {
        $model->update($attributes);

        if($relationships){
            $this->handleRelationship($relationships, $model);
        }

        return new JSONAPIResource($model);
    }

    /**
     * @param $model
     *
     * @return Response
     */
    public function deleteResource($model)
    {
        $model->delete();
        return response(null, 204);
    }

    /**
     * @param $model
     * @param string $relationship
     *
     * @return Response
     */
    public function fetchRelationship($model, string $relationship)
    {
        if($model->$relationship instanceof Model){
            return new JSONAPIIdentifierResource($model->$relationship);
        }

        return JSONAPIIdentifierResource::collection($model->$relationship);
    }

    public function updateToOneRelationship($model, $relationship, $id)
    {
        $relatedModel = $model->$relationship()->getRelated();

        $model->$relationship()->dissociate();

        if($id){
            $newModel = $relatedModel->newQuery()->findOrFail($id);
            $model->$relationship()->associate($newModel);
        }

        $model->save();
        return response(null, 204);
    }

    public function updateToManyRelationships($model, $relationship, $ids)
    {
        $foreignKey = $model->$relationship()->getForeignKeyName();
        $relatedModel = $model->$relationship()->getRelated();


        $relatedModel->newQuery()->findOrFail($ids);


        $relatedModel->newQuery()->where($foreignKey, $model->id)->update([
            $foreignKey => null,
        ]);

        $relatedModel->newQuery()->whereIn('id', $ids)->update([
            $foreignKey => $model->id,
        ]);

        return response(null, 204);
    }

    /**
     * @param $model
     * @param $relationship
     * @param $ids
     *
     * @return Response
     */
    public function updateManyToManyRelationships($model, $relationship, $ids)
    {
        $model->$relationship()->sync($ids);
        return response(null, 204);
    }

    public function fetchRelated($model, $relationship)
    {
        if($model->$relationship instanceof Model){
            return new JSONAPIResource($model->$relationship);
        }

        return new JSONAPICollection($model->$relationship);
    }

    /**
     * @param array $relationships
     * @param $model
     */
    protected function handleRelationship(array $relationships, $model): void
    {
        foreach ($relationships as $relationshipName => $contents) {
            if ($model->$relationshipName() instanceof BelongsTo) {
                $this->updateToOneRelationship($model, $relationshipName, $contents['data']['id']);
            }
            if($model->$relationshipName() instanceof BelongsToMany){
                $this->updateManyToManyRelationships($model, $relationshipName, collect($contents['data'])->pluck('id'));
            }
        }

        $model->load(array_keys($relationships));
    }


}
