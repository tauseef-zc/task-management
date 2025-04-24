<?php
namespace App\Services\V1\Tasks;

use App\Models\TaskStatus;
use App\Services\V1\BaseService;
use App\Services\V1\Interfaces\Tasks\ITaskStatusService;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class TaskStatusService extends BaseService implements ITaskStatusService
{
    private TaskStatus $taskStatus;

    public function __construct(TaskStatus $taskStatus)
    {
        $this->taskStatus = $taskStatus;
    }
    
    /**
     * Create a new task status.
     *
     * @param array $payload
     * @return array
     */
    public function create(array $payload): array
    {
        try {
            
            $payload['color'] = $payload['color'] ?? '#000000';
            $payload['created_by'] = auth()->user()->id;
        
            if (request()->hasFile('icon')) {
                $payload['icon'] = request()->file('icon')->store('uploads/icons', 'public');
            }

            $taskStatus = $this->taskStatus->create($payload);

            return $this->payload([
                'message' => 'Task status created successfully',
                'id' => $taskStatus->id
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Update an existing task status.
     *
     * @param int $id
     * @param array $payload
     * @return array
     */
    public function update(int $id, array $payload): array
    {
        try {
            $taskStatus = $this->taskStatus->findOrFail($id);

            if (request()->hasFile('icon')) {
                $payload['icon'] = request()->file('icon')->store('uploads/icons', 'public');
            }

            $taskStatus->update($payload);

            return $this->payload([
                'message' => 'Task status updated successfully',
                'id' => $taskStatus->id
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete a task status.
     *
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        try {
            $taskStatus = $this->taskStatus->findOrFail($id);
            $taskStatus->delete();

            return $this->payload([
                'message' => 'Task status deleted successfully'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}