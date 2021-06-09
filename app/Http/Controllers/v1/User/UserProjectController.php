<?php

namespace App\Http\Controllers\v1\User\Projects;

use App\Models\User;
use App\Services\JSONAPIService;
use App\Http\Controllers\Controller;
use App\Http\Requests\JSONAPIRelationshipRequest;

class UserProjectController extends Controller
{
    /**
     * @var JSONAPIService
     */
    private $service;

    public function __construct(JSONAPIService $service)
    {
        $this->service = $service;
    }

    public function index(User $user)
    {
        return $this->service->fetchRelated($user, 'projects');
    }

    public function showRelationship(User $user)
    {
        return $this->service->fetchRelationship($user, 'projects');
    }

    public function updateRelationship(JSONAPIRelationshipRequest $request, User $user)
    {
        return $this->service->updateToManyRelationships($user, 'projects', $request->input('data.*.id'));
    }
}