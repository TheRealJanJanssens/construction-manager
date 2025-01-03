<?php

namespace App\Http\Resources\V1;

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
            'uuid' => $this->uuid,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'meta' => new UserMetaResource($this->whenLoaded('meta')), //UserMetaResource::collection() for multiple results
            // 'company' => new CompanyResource($this->whenLoaded('company'))
            // 'role' => $this->role,
            // 'status' => $this->status,
        ];
    }
}
