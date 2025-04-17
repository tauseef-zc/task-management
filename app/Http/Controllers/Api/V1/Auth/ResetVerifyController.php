<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\V1\Interfaces\Auth\IAuthService;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetVerifyController extends Controller
{
    private ServiceInterface $service;

    public function __construct(IAuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|exists:otps,otp',
        ]);

        list($data, $statusCode) = $this->service->verifyOtp($payload);

        return response()->json($data, $statusCode);
    }
}
