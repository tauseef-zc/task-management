<?php

namespace App\Services\V1\Tasks;

use App\Models\Task;
use App\Services\V1\BaseService;
use App\Services\V1\Interfaces\Tasks\ITaskService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class TaskService extends BaseService implements ITaskService
{
    private Model $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * getTasks
     *
     * @return Collection
     */
    public function getTasks(): Collection
    {
        return $this->model->get();
    }

    /**
     * create
     *
     * @param  array $data
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $task = $this->model->create($data);
            return $this->payload([
                    'id' => $task->id,
                    'message' => 'Task created successfully',
                ], Response::HTTP_CREATED,
            );
        } catch (\Exception | \Throwable $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * update
     *
     * @param  Task $task
     * @param  array $data
     * @return array
     */
    public function update(Task $task, array $data): array
    {
        try {
            $task->update($data);
            return $this->payload([
                    'id' => $task->id,
                    'message' => 'Task updated successfully',
                ], Response::HTTP_OK,
            );
        } catch (\Exception | \Throwable $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}