<?php

namespace App\Http\Controllers\Api\V1\Tasks\Statuses;

use App\Http\Controllers\Controller;
use App\Models\TaskStatus;
use Illuminate\Http\Response;

class DeleteTaskStatusController extends Controller
{

    public function __invoke(TaskStatus $taskStatus)
    {
        $taskStatus->delete();
        return response()->json([
            'message' => 'Task status deleted successfully',
        ], Response::HTTP_ACCEPTED);
    }

}