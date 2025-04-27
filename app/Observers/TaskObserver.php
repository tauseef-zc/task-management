<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Str;

class TaskObserver
{
    /**
     * Handle the Task "creating" event.
     */
    public function creating(Task $task): void
    {
        // Automatically set the slug before creating the task
        $slugExists = Task::where('slug', 'LIKE', '%' . Str::slug($task->name) . '%')->count();
        $task->slug = $slugExists ? Str::slug($task->name) . '-' . uniqid() : Str::slug($task->name);
        $task->status_id = $task->status_id ?? TaskStatus::where('name', 'Pending')->first()->id; 
    }
    
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "updating" event.
     */
    public function updating(Task $task): void
    {
        if($task->isDirty('name')) {
            // Automatically set the slug before updating the task
            $slugExists = Task::where('slug', 'LIKE', '%' . Str::slug($task->name) . '%')->count();
            $task->slug = $slugExists ? Str::slug($task->name) . '-' . uniqid() : Str::slug($task->name);
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
