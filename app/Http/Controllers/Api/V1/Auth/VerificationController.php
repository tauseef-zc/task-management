<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Auth\VerifyUserEmail;
use App\Services\V1\Interfaces\Auth\IAuthService;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
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
    public function sendVerificationMail(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email|exists:users']);
        VerifyUserEmail::dispatchSync($request->email);

        return response()->json([
            'data' => ['message' => 'verification email send to your email!']
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyUser(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'email' => 'required|email|exists:users',
            'otp' => 'required|exists:otps',
        ]);

        list($data, $statusCode) = $this->service->verifyUserEmail($payload);

        return response()->json($data, $statusCode);
    }
}
