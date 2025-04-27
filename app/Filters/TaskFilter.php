<?php

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;

class TaskFilter extends Filter
{
    /**
     * The filters that are available for the task.
     *
     * @var array
     */
    protected array $filters = [
        'search',
        'status',
        'priority',
        'project',
        'assignedTo',
        'sortBy',
    ];
    
    /**
     * search
     *
     * @param  string $value
     * @return Builder
     */
    public function search(string $value): Builder
    {
        return $this->builder->where(function ($query) use ($value) {
            $query->where('name', 'like', "%{$value}%")
                ->orWhere('description', 'like', "%{$value}%");
        });
    }
    
    /**
     * status
     *
     * @param  string $value
     * @return Builder
     */
    public function status(string $value): Builder
    {
        return $this->builder->where('status_id', $value)
            ->orWhereHas('status', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            });
    }
    
    /**
     * priority
     *
     * @param  string $value
     * @return Builder
     */
    public function priority(string $value): Builder
    {
        return $this->builder->where('priority', $value);
    }

    /**
     * project
     *
     * @param  string $value
     * @return Builder
     */
    public function project(string $value): Builder
    {
        return $this->builder->where('project_id', $value)
            ->orWhereHas('project', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            });
    }

    /**
     * assignedTo
     *
     * @param  string $value
     * @return Builder
     */
    public function assignedTo(string $value): Builder
    {
        return $this->builder->where('assigned_to', $value)
            ->orWhereHas('assignedTo', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            });
    }
    
    /**
     * sortBy
     *
     * @param  string $value
     * @return Builder
     */
    public function sortBy(string $value): Builder
    {
        $sort = explode(',', $value);
        $column = $sort[0];
        $direction = $sort[1] ?? 'asc';

        return $this->builder->orderBy($column, $direction);
    }

}
