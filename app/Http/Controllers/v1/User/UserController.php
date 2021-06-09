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
        return $this->service->createResource(
            $this->class, 
            array_merge(
                $request->validated(), 
                [
                    'password' => Hash::make($request->input('data.attributes.password'))
                ]
            )
        );
    }

    public function update(JSONAPIRequest $request, string $uuid): JSONAPIResource
    {
        $attributes = $request->input('data.attributes');
        if(isset($attributes['password'])){
            $attributes['password'] = Hash::make($attributes['password']);
        }

        return $this->service->updateResource($this->class, $uuid, $attributes);
    }
}
