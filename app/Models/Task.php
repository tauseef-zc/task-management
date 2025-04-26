<?php

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFilter, HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'project_id',
        'parent_id',
        'created_by',
        'assigned_to',
        'status_id',
        'due_date',
        'priority',
        'progress',
        'estimated_time',
        'spent_time',
        'attachments',
        'comments',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
            'priority' => TaskPriorityEnum::class,
            'attachments' => 'json',
        ];
    }

    /**
     * The project that the task belongs to.
     *
     * @var array
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * The user that created the task.
     *
     * @var array
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user that the task is assigned to.
     *
     * @var array
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * The status of the task.
     *
     * @var array
     */
    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    /**
     * The parent task of the task.
     *
     * @var array
     */
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    /**
     * The child tasks of the task.
     *
     * @var array
     */
    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    
}
