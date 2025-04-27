<?php

namespace App\Http\Controllers\Api\V1\Tasks\Statuses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Tasks\Statuses\CreateTaskStatusRequest;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskStatusService;

class CreateTaskStatusController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ITaskStatusService $service)
    {
        $this->service = $service;
    }

    public function __invoke(CreateTaskStatusRequest $request)
    {
        $payload = $request->validated();
        list($data, $statusCode) = $this->service->create($payload);

        return response()->json($data, $statusCode);
    }
}