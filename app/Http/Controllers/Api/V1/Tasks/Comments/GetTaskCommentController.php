<?php

namespace App\Http\Controllers\Api\V1\Tasks\Comments;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Tasks\TaskCommentResource;
use App\Models\Task;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskCommentService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as JsonResource;

class GetTaskCommentController extends Controller
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
     * @return JsonResource
     */
    public function __invoke(Task $task): JsonResource
    {
        $comments = $this->service->getComments($task);
        $comments->load('user', 'replies.user');

        return TaskCommentResource::collection($comments);
    }
}