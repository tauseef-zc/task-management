<?php

namespace App\Http\Controllers\Api\V1\Tasks\Comments;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskComment;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskCommentService;
use Illuminate\Http\JsonResponse;

class DeleteTaskCommentController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ITaskCommentService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     *
     * @param Task $task
     * @param TaskComment $comment
     * @return JsonResponse
     */
    public function __invoke(Task $task, TaskComment $comment): JsonResponse
    {
        list($data, $statusCode) = $this->service->deleteComment($task, $comment);
        return response()->json($data, $statusCode);
    }
}