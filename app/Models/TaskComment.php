<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    /** @use HasFactory<\Database\Factories\TaskCommentFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'reply_to',
    ];

    /**
     * The task that the comment belongs to.
     *
     * @var array
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * The user that created the comment.
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The comment that the comment is replying to.
     *
     * @var array
     */
    public function replyTo()
    {
        return $this->belongsTo(TaskComment::class, 'reply_to');
    }

    /**
     * The replies to the comment.
     *
     * @var array
     */
    public function replies()
    {
        return $this->hasMany(TaskComment::class, 'reply_to');
    }
}
