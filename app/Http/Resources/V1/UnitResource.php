<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'group_uuid' => $this->group_uuid,
            'name' => $this->name,
            'meta' => new UnitMetaResource($this->whenLoaded('meta')),
        ];
    }
}
