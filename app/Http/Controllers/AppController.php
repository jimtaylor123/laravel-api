<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AppController extends Controller
{
    public function version(): JsonResponse
    {
        return response()->json([
            'name' => config('app.name'),
            'version' => config('app.version'),
        ]);
    }
}
