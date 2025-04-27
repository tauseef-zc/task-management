<?php

namespace App\Http\Controllers\Api\V1\Tasks\Statuses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Tasks\Statuses\UpdateTaskStatusRequest;
use App\Models\TaskStatus;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskStatusService;

class UpdateTaskStatusController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ITaskStatusService $service)
    {
        $this->service = $service;
    }

    public function __invoke(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $payload = $request->validated();
        list($data, $statusCode) = $this->service->update($taskStatus->id, $payload);

        return response()->json($data, $statusCode);
    }
}