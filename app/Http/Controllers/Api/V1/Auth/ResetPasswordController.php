<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\V1\Interfaces\Auth\IAuthService;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    private ServiceInterface $service;

    public function __construct(IAuthService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:8', 'max:32', 'confirmed']
        ]);

        list($data, $statusCode) = $this->service->resetPassword($payload);
        return response()->json($data, $statusCode);
    }
}
