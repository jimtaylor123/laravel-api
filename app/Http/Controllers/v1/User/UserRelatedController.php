<?php

namespace App\Http\Controllers\v1\User;

use App\Models\User;
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

    public function indexRelationships(
        string $uuid, 
        string $relationship
    ){
        // $model = $this->class::findOrFail($uuid);

        // return $this->service->fetchRelated($model, $relationship);
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

        // need to determine the type of relationship here - to one, to many or many to many
        return $this->service->updateToManyRelationships(
            $model, 
            'projects', 
            $request->input('data.*.id')
        );
    }
}