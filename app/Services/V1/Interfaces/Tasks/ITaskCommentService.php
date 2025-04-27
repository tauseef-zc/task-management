<?php

namespace App\Services\V1\Interfaces\Tasks;

use App\Models\Task;
use App\Models\TaskComment;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;

interface ITaskCommentService extends ServiceInterface
{
    /**
     * getComments
     *
     * @param  Task $task
     * @return Collection
     */
    public function getComments(Task $task): Collection;

    /**
     * addComment
     *
     * @param  Task $task
     * @param  array $data
     * @return array
     */
    public function addComment(Task $task, array $data): array;
    
    /**
     * deleteComment
     *
     * @param  Task $task
     * @param  TaskComment $comment
     * @return array
     */
    public function deleteComment(Task $task, TaskComment $comment): array;
    
}