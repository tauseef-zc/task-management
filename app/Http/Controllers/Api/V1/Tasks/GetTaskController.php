<?php

namespace App\Http\Controllers\Api\V1\Tasks;

use App\Filters\TaskFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Tasks\TaskResource;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskService;

class GetTaskController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ITaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(TaskFilter $filter)
    {
        $tasks = $this->service->getTasks($filter);
        if ($tasks->count()) {
           $tasks->load('createdBy', 'assignedTo', 'project', 'status');
        }
        
        return TaskResource::collection($tasks);
    }
}
