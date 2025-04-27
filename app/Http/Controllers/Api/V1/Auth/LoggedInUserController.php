<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Auth\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoggedInUserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'data' => [
                'user'  => UserResource::make($user)
            ]
        ]);
    }
}
