<?php

namespace App\Http\Controllers\Api\V1\Tasks\Comments;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskCommentService;
use Illuminate\Http\JsonResponse;

class AddTaskCommentController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ITaskCommentService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     *
     * @return JsonResponse
     */
    public function __invoke(Task $task): JsonResponse
    {
        $data = request()->validate([
            'comment' => 'required|string',
            'reply_to' => 'sometimes|nullable|integer|exists:task_comments,id',
        ]);

        list($data, $statusCode) = $this->service->addComment($task, $data);
        return response()->json($data, $statusCode);
    }

}