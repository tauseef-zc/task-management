<?php

namespace App\Services\V1\Tasks;

use App\Filters\TaskFilter;
use App\Models\Task;
use App\Services\V1\BaseService;
use App\Services\V1\Interfaces\Tasks\ITaskService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

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
     * @param  TaskFilter $filter
     * @return Collection
     */
    public function getTasks(TaskFilter $filter): Collection
    {
        return $this->model->filter($filter)->latest()->get();
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
            $data['created_by'] = auth()->user()->id;
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
    
    /**
     * uploadAttachments
     *
     * @param  Task $task
     * @param  array $data
     * @return array
     */
    public function uploadAttachments(Task $task, array $data): array
    {
        try {

            $attachments = $task->attachments ?? [];
           
            if (!isset($data['attachments']) || !is_array($data['attachments'])) {
                return $this->error('Attachments are required', Response::HTTP_BAD_REQUEST);
            }

            foreach ($data['attachments'] as $attachment) {
                $attachments[] = $this->upload($attachment);
            }

            $task->update([
                'attachments' => $attachments,
            ]);
            
            return $this->payload([
                    'message' => 'Attachments uploaded successfully',
                ], Response::HTTP_OK,
            );
            
        } catch (\Exception | \Throwable $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function upload(UploadedFile $file): string
    {
        $path = 'uploads/tasks/attachments/' . date('Y-m-d') . '/';
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $fileName, 'public');

        return $path . $fileName;
    }
   
}