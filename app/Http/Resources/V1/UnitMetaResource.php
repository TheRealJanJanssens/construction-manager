<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'unit_uuid' => $this->unitUuid,
            'type' => $this->type,
            'address'  => $this->address,
            'city' => $this->city,
            'postalCode' => $this->postal_code,
            'startDate' => $this->start_date,
            'dueDate' => $this->due_date,
            'completedDate' => $this->completed_date,
            'extra' => $this->extra
        ];
    }
}
