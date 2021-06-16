<?php

namespace App\Http\Controllers\v1\User;

use App\Models\User;
use Illuminate\Support\Arr;
use App\Services\JSONAPIService;
use App\Http\Controllers\Controller;
use App\Services\JSONAPIRelationshipService;
use App\Http\Requests\JSONAPIRelationshipRequest;

class UserRelatedController extends Controller
{
    /**
     * @var JSONAPIService
     */
    private $service;

    public function __construct(JSONAPIRelationshipService $jsonAPIRelationshipService)
    {
        $this->service = $jsonAPIRelationshipService;
        $this->class = User::class;
    }

    // Related models

    public function indexRelatedResources(
        string $uuid, 
        string $relationship
    ){
        return $this->service->fetchRelated($this->class, $uuid, $relationship);
    }

    // Model relationships 

    public function showResourceRelationships(
        string $uuid, 
        string $relationship
    )
    {
        return $this->service->fetchRelationship($this->class, $uuid, $relationship);
    }

    public function updateResourceRelationships(
        JSONAPIRelationshipRequest $request, 
        string $uuid, 
        string $relationship
    ){
        $model = $this->class::findOrFail($uuid);

        $functionName = $this->getRelationshipFunctionName($model, $relationship, $request->input('data.*.id'));

        return $this->service->$functionName(
            $model, 
            $relationship, 
            $request->input('data.*.id')
        );
    }

    private function getRelationshipFunctionName($model, $relationship)
    {
        $relationshipDataArray = Arr::where($model->relationships(),  function($subArray, $key) use ($relationship) {
            return  $subArray['type'] === $relationship;
        });

        if (! $relationshipDataArray) {
            dd('whoops');

            // TODO throw a proper execption
        }

        $data = array_shift($relationshipDataArray);

        $relationMap = [
            'hasOne' => 'updateToOneRelationship',
            'hasMany' => 'updateToManyRelationships',
            'belongsTo' => 'updateToOneRelationship',
            'hasOneThrough' => 'updateToOneRelationship',
            'hasManyThrougn' => 'updateToManyRelationships',
            'belongsToMany' => 'updateToManyRelationships',
            'morphTo' => 'updateToOneRelationship',
            'morphToOne' => 'updateToOneRelationship',
            'morphToMany' => 'updateToManyRelationships',
            'morphedByMany' => 'updateToManyRelationships',
        ];

        return $functionName = $relationMap[$data['relationshipType']];
    }
}