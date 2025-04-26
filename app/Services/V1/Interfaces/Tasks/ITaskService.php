<?php

namespace App\Services\V1\Interfaces\Tasks;

use App\Filters\TaskFilter;
use App\Models\Task;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;

interface ITaskService extends ServiceInterface
{    
    /**
     * getTasks
     *
     * @param  TaskFilter $filter
     * @return Collection
     */
    public function getTasks(TaskFilter $filter): Collection;
    
    /**
     * create
     *
     * @param  array $data
     * @return array
     */
    public function create(array $data): array;
    
    /**
     * update
     *
     * @param  Task $task
     * @param  array $data
     * @return array
     */
    public function update(Task $task, array $data): array;
    
    /**
     * uploadAttachments
     *
     * @param  Task $task
     * @param  array $data
     * @return array
     */
    public function uploadAttachments(Task $task, array $data): array;

}