<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'icon',
        'created_by',
    ];

    /**
     * The tasks that belong to the task status.
     *
     * @var array
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }

    /**
     * The user that created the task status.
     *
     * @var array
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
