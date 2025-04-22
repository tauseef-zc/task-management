<?php

namespace App\Http\Resources\V1\Auth;

use App\Enums\UserTypesEnum;
use App\Http\Resources\Guide\GuideResource;
use App\Http\Resources\Traveler\TravelerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'verified' => $this->hasVerifiedEmail(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
