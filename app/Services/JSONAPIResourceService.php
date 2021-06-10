<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\JSONAPIResource;
use App\Http\Resources\JSONAPICollection;
use App\Services\JSONAPIRelationshipService;

class JSONAPIResourceService
{
    private JSONAPIRelationshipService $relationshipService;

    public function __construct(JSONAPIRelationshipService $relationshipService)
    {
        $this->relationshipService = $relationshipService;
    }

    public function fetchResources(string $modelClass): JSONAPICollection
    {
        $type = Str::plural(Str::lower(class_basename($modelClass)));

        $models = QueryBuilder::for($modelClass)
            ->allowedSorts(config("jsonapi.resources.{$type}.allowedSorts"))
            ->allowedIncludes(config("jsonapi.resources.{$type}.allowedIncludes"))
            ->allowedFilters(config("jsonapi.resources.{$type}.allowedFilters"))
            ->jsonPaginate();

        return new JSONAPICollection($models);
    }

    public function fetchResource(
        string $modelClass, 
        string $uuid
    ): JSONAPIResource {
        $type = Str::plural($modelClass);

        $query = QueryBuilder::for($modelClass::where('id', $uuid))
            ->allowedIncludes(config("jsonapi.resources.{$type}.allowedIncludes"))
            ->firstOrFail();

        return new JSONAPIResource($query);
    }

    public function createResource(
        string $modelClass, 
        array $attributes, 
        array $relationships = null
    ): JsonResponse {

        $model = $modelClass::create($attributes);

        if ($relationships) {
            $this->relationshipService->handleRelationship($relationships, $model);
        }

        return (new JSONAPIResource($model))
            ->response()
            ->header('Location', route("{$model->type()}.show", [
                Str::singular($model->type()) => $model->id,
            ]));
    }

    public function updateResource(
        string $modelClass, 
        string $uuid,
        array $attributes, 
        array $relationships = null
    ): JSONAPIResource {

        $model = $modelClass::findOrFail($uuid);
        
        $model->update($attributes);

        if ($relationships) {
            $this->relationshipService->handleRelationship($relationships, $model);
        }

        return new JSONAPIResource($model);
    }

    public function deleteResource(
        string $modelClass, 
        string $uuid
    ): Response {

        $model = $modelClass::findOrFail($uuid);

        $model->delete();
        
        return response(null, 204);
    }
}
