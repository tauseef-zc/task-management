<?php

namespace App\Http\Controllers\Api\V1\Tasks\Statuses;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Tasks\TaskStatusResource;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskStatusService;

class GetTaskStatusController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ITaskStatusService $service)
    {
        $this->service = $service;
    }

    public function __invoke()
    {
        $statuses = $this->service->getTaskStatuses();
        return TaskStatusResource::collection($statuses);
    }
}