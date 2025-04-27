<?php

namespace App\Http\Controllers\Api\V1\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Tasks\UpdateTaskRequest;
use App\Models\Task;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskService;

class UpdateTaskController extends Controller
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
    public function __invoke(Task $task, UpdateTaskRequest $request)
    {
        list($data, $statusCode) = $this->service->update($task, $request->validated());
        return response()->json($data, $statusCode);
    }
}
