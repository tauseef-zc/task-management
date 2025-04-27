<?php

namespace App\Http\Resources\V1\Tasks;

use App\Http\Resources\V1\Auth\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->whenLoaded('status', fn($record) => TaskStatusResource::make($record)),
            'created_by' => $this->whenLoaded('createdBy', fn($record) => UserResource::make($record)),
            'assigned_to' => $this->whenLoaded('assignedTo', fn($record) => UserResource::make($record)),
            'project' => $this->whenLoaded('project', fn($record) => ProjectResource::make($record)),
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'progress' => $this->progress,
            'estimated_time' => $this->estimated_time,
            'spent_time' => $this->spent_time,
            'attachments' => $this->attachments,
            'comments' => $this->comments,
            'contributors' => $this->whenLoaded('contributors', fn($record) => UserResource::collection($record)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}