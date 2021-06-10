<?php

namespace App\Http\Controllers\v1\Me;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JSONAPIResource;

class MeController extends Controller
{
    protected function resourceMethodsWithoutModels(): array
    {
        return ['show', 'update'];
    }

    public function show(Request $request)
    {
        return new JSONAPIResource($request->user());
    }

    public function update(Request $request)
    {
        //
    }

}
