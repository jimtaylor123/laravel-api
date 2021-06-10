<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\JSONAPIRequest;
use App\Http\Resources\JSONAPIResource;
use App\Services\JSONAPIResourceService;
use App\Http\Resources\JSONAPICollection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected JSONAPIResourceService $resourceService;
    public string $class;

    public function __construct(JSONAPIResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
        $this->class = '';
    }

    public function index(): JSONAPICollection
    {
        return $this->resourceService->fetchResources($this->class);
    }

    public function store(JSONAPIRequest $request): JsonResponse
    {
        return $this->resourceService->createResource(
            $this->class, 
            $request->input('data.attributes'),
        );
    }

    public function show(string $uuid): JSONAPIResource
    {
        return $this->resourceService->fetchResource(
            $this->class, 
            $uuid
        );
    }

    public function update(JSONAPIRequest $request, string $uuid): JSONAPIResource
    {
        return $this->resourceService->updateResource(
            $this->class, 
            $uuid, 
            $request->input('data.attributes')
        );
    }

    public function destroy(string $uuid): Response
    {
        return $this->resourceService->deleteResource(
            $this->class, 
            $uuid
        );
    }
}
