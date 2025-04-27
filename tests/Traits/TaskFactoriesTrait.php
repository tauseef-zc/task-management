<?php

namespace Tests\Traits;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskStatus;
use Database\Factories\ProjectFactory;
use Database\Factories\TaskCommentFactory;
use Database\Factories\TaskFactory;
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

    /**
     * makeTask
     *
     * @param  int|null $count
     * @return TaskFactory
     */
    public function makeTask(?int $count = null): TaskFactory
    {
        return Task::factory()->count($count);
    }

    /**
     * makeTaskComment
     *
     * @param  int|null $count
     * @return TaskCommentFactory
     */
    public function makeTaskComment(?int $count = null): TaskCommentFactory
    {
        return TaskComment::factory()->count($count);
    }

}