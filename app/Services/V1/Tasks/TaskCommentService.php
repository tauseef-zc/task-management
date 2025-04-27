<?php

namespace App\Services\V1\Tasks;

use App\Models\Task;
use App\Models\TaskComment;
use App\Services\V1\BaseService;
use App\Services\V1\Interfaces\Tasks\ITaskCommentService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class TaskCommentService extends BaseService implements ITaskCommentService {

    private Model $model;

    public function __construct(TaskComment $model) {
        $this->model = $model;
    }

    /**
     * getComments
     *
     * @param  Task $task
     * @return Collection
     */
    public function getComments(Task $task): Collection 
    {
        return $task->comments()->whereNull('reply_to')->latest()->get();
    }
    
    /**
     * addComment
     *
     * @param  Task $task
     * @param  array $data
     * @return array
     */
    public function addComment(Task $task, array $data): array 
    {
        try {
            $payload = [
                'task_id' => $task->id,
                'comment' => $data['comment'],
                'user_id' => auth()->user()->id,
                'reply_to' => $data['reply_to'] ?? null,
            ];

            $comment = $this->model->create($payload);

            return $this->payload([
                    'id' => $comment->id,
                    'message' => 'Comment added successfully',
                ], Response::HTTP_CREATED,
            );
        } catch (\Exception | \Throwable $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * deleteComment
     *
     * @param  Task $task
     * @param  TaskComment $comment
     * @return array
     */
    public function deleteComment(Task $task, TaskComment $comment): array 
    {
        try {
           
            if ($comment->task_id !== $task->id) {
                return $this->error('Comment not found for this task', Response::HTTP_NOT_FOUND);
            }

            $comment->delete();

            return $this->payload([
                    'message' => 'Comment deleted successfully',
                ], Response::HTTP_OK,
            );
        } catch (\Exception | \Throwable $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }   
}