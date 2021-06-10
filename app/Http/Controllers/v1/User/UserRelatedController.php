<?php

namespace App\Http\Controllers\v1\User\Projects;

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

    public function __construct(JSONAPIRelationshipService $service)
    {
        $this->service = $service;
        $this->class = User::class;
    }

    // Related models

    public function indexRelated(string $uuid, string $relationship)
    {
        $model = $this->class::findOrFail($uuid);

        return $this->service->fetchRelated($model, $relationship);
    }

    // Model relationships 

    public function showRelationship(User $user)
    {
        return $this->service->fetchRelationship($user, 'projects');
    }

    public function updateRelationship(JSONAPIRelationshipRequest $request, User $user)
    {
        // need to determine the type of relationship here - to one, to many or many to many
        return $this->service->updateToManyRelationships($user, 'projects', $request->input('data.*.id'));
    }
}