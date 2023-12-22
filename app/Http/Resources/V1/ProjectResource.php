<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'unitUuid' => $this->unit_uuid,
            'name' => $this->name,
            'startDate' => $this->start_date,
            'dueDate' => $this->due_date,
            'completedDate' => $this->completed_date
        ];
    }
}
