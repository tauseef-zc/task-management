<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\V1\Interfaces\Auth\IAuthService;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
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
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        list($data, $statusCode) = $this->service->forgotPassword($request->email);

        return response()->json($data, $statusCode);
    }
}
