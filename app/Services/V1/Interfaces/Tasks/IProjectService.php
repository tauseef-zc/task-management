<?php

namespace App\Services\V1\Interfaces\Tasks;

use App\Models\Project;
use App\Services\V1\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;

interface IProjectService extends ServiceInterface 
{
    
    /**
     * getProjects
     *
     * @return Collection
     */
    public function getProjects(): Collection;
    
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
     * @param  Project $project
     * @param  array $data
     * @return array
     */
    public function update(Project $project, array $data): array;

}