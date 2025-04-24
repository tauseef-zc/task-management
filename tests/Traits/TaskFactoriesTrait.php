<?php

namespace Tests\Traits;

use App\Models\TaskStatus;
use Database\Factories\TaskStatusFactory;

trait TaskFactoriesTrait
{
    
    public function makeTaskStatus(?int $count = null): TaskStatusFactory
    {
        return TaskStatus::factory()->count($count);
    }

}