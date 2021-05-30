<?php

namespace App\Http\Controllers\v1\User\Projects;

use App\Models\User;
use App\Services\JSONAPIService;
use App\Http\Controllers\Controller;

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
}