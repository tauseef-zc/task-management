<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TaskStatus extends Model
{
    const ICON_PATH = 'uploads/icons/';

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

        
    /**
     * Accessor for the icon attribute.
     *
     * @return string|null
     */
    public function getIconAttribute(): ?string
    {
        return $this->attributes['icon'] ? asset(self::ICON_PATH . $this->attributes['icon']) : null;
    }

    /**
     * Generate a unique slug for the task status.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty('name')) {
                $slug = Str::slug($model->name);
                if (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                    $model->slug = $slug . '-' . $model->id;
                } else {
                    $model->slug = Str::slug($model->name);
                }
            }
        });
    }
        
}
