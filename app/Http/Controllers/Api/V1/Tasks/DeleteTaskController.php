<?php

namespace App\Http\Controllers\Api\V1\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Response;

class DeleteTaskController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Task $task)
    {
        if($task->created_by !== auth()->user()->id) {
            return response()->json(['message' => 'You are not authorized to delete this task'], 
                Response::HTTP_FORBIDDEN);
        }
        
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 
            Response::HTTP_OK);
    }
}
