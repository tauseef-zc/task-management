<?php

namespace App\Http\Resources\V1\Tasks;

use App\Http\Resources\V1\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['replies', 'replies.user']);

        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'replies' => $this->whenLoaded('replies', fn($record) => TaskCommentResource::collection($record)),
            'user' => $this->whenLoaded('user', fn($record) => UserResource::make($record)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
