<?php 

namespace App\Services\V1\Tasks;

use App\Models\Project;
use App\Services\V1\BaseService;
use App\Services\V1\Interfaces\Tasks\IProjectService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ProjectService extends BaseService implements IProjectService
{
    private Model $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }
    
    /**
     * get Projects
     *
     * @return Collection
     */
    public function getProjects(): Collection
    {
        return $this->model->all();
    }
    
    /**
     * create a new Project
     *
     * @param  array $data
     * @return array
     */
    public function create(array $data): array
    {
        try {
            // Set the created_by field to the authenticated user's ID
            $data['created_by'] = auth()->id();
            $project = $this->model->create($data);

            return $this->payload([
                'message' => 'Project created successfully',
                'id' => $project->id,
            ], Response::HTTP_CREATED);

        } catch (\Throwable | \Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * update a existing Project
     *
     * @param  Project $project
     * @param  array $data
     * @return array
     */
    public function update(Project $project, array $data): array
    {
        try {
            $project->update($data);

            return $this->payload([
                'message' => 'Project updated successfully',
                'id' => $project->id,
            ], Response::HTTP_OK);

        } catch (\Throwable | \Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}