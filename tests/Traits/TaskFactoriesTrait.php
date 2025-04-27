<?php

namespace Tests\Traits;

use App\Models\Project;
use App\Models\TaskStatus;
use Database\Factories\ProjectFactory;
use Database\Factories\TaskStatusFactory;

trait TaskFactoriesTrait
{
        
    /**
     * makeTaskStatus
     *
     * @param  int|null $count
     * @return TaskStatusFactory
     */
    public function makeTaskStatus(?int $count = null): TaskStatusFactory
    {
        return TaskStatus::factory()->count($count);
    }
    
    /**
     * makeProject
     *
     * @param  int|null $count
     * @return ProjectFactory
     */
    public function makeProject(?int $count = null): ProjectFactory
    {
        return Project::factory()->count($count);
    }

}