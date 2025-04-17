<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Services\V1\Interfaces\Auth\IAuthService;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    private ServiceInterface $service;

    public function __construct(IAuthService $service)
    {
        $this->service = $service;
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        list($data, $statusCode) = $this->service->register($data);

        return response()->json($data, $statusCode);
    }
}
