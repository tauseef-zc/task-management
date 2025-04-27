<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskContributor extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'is_active',
    ];

    /**
     * The task that belongs to the contributor.
     *
     * @var array
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * The user that belongs to the contributor.
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
