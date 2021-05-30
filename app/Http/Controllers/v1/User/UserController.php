<?php

namespace App\Http\Controllers\v1\User;

use App\Models\User;
use Illuminate\Http\Response;
use App\Services\JSONAPIService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\JSONAPIRequest;
use App\Http\Resources\JSONAPIResource;
use App\Http\Resources\JSONAPICollection;

class UserController extends Controller
{

    protected function resourceMethodsWithoutModels()
    {
        return ['index', 'store', 'show'];
    }

    /**
     * @var JSONAPIService
     */
    private $service;

    public function __construct(JSONAPIService $service)
    {
        $this->service = $service;
    }
 
    public function index(): JSONAPICollection
    {
        return $this->service->fetchResources(User::class, 'users');
    }

    public function store(JSONAPIRequest $request): Response
    {
        return $this->service->createResource(User::class, [
            'first_name' => $request->input('data.attributes.first_name'),
            'last_name' => $request->input('data.attributes.last_name'),
            'email' => $request->input('data.attributes.email'),
            'password' => Hash::make(($request->input('data.attributes.password'))),
        ]);
    }

    public function show(int $user): JSONAPIResource
    {
        return $this->service->fetchResource(User::class, $user, 'users');
    }

    public function update(JSONAPIRequest $request, User $user): Response
    {
        $attributes = $request->input('data.attributes');
        if(isset($attributes['password'])){
            $attributes['password'] = Hash::make($attributes['password']);
        }

        return $this->service->updateResource($user, $attributes);
    }

    public function destroy(User $user): Response
    {
        return $this->service->deleteResource($user);
    }
}
