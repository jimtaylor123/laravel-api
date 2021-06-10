<?php

namespace App\Http\Controllers\v1\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\JSONAPIRequest;
use App\Http\Resources\JSONAPIResource;
use App\Services\JSONAPIResourceService;

class UserController extends Controller
{
    public string $class;

    public function __construct(JSONAPIResourceService $resourceService)
    {
        Parent::__construct($resourceService);
        $this->class = User::class;
    }

    public function store(JSONAPIRequest $request): JsonResponse
    {
        $attributes = $request->input('data.attributes');
        $attributes['password'] = Hash::make($attributes['password']);

        return $this->resourceService->createResource(
            $this->class, 
            $attributes
        );
    }

    public function show(string $uuid): JSONAPIResource
    {
        return $this->resourceService->fetchResource($this->class, $uuid);
    }

    public function update(JSONAPIRequest $request, string $uuid): JSONAPIResource
    {
        $attributes = $request->input('data.attributes');

        if(isset($attributes['password'])){
            $attributes['password'] = Hash::make($attributes['password']);
        }

        return $this->resourceService->updateResource($this->class, $uuid, $attributes);
    }
}
