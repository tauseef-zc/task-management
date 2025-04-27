<?php

namespace App\Http\Controllers\Api\V1\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Tasks\TaskResource;
use App\Models\Task;

class SingleTaskController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Task $task)
    {
        $task->load('createdBy', 'assignedTo', 'project', 'status', 'contributors');
        return TaskResource::make($task);
    }
    
}
