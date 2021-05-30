<?php

namespace App\Http\Controllers\v1\User\Projects;

use App\Models\User;
use App\Services\JSONAPIService;
use App\Http\Controllers\Controller;
use App\Http\Requests\JSONAPIRelationshipRequest;

class UserProjectRelationController extends Controller
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
        return $this->service->fetchRelationship($user, 'projects');
    }

    public function update(JSONAPIRelationshipRequest $request, User $user)
    {
        return $this->service->updateToManyRelationships($user, 'projects', $request->input('data.*.id'));
    }
}
