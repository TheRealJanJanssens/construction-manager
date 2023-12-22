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
            'unitUuid' => $this->unit_uuid,
            'type' => $this->type,
            'address'  => $this->address,
            'city' => $this->city,
            'postalCode' => $this->postal_code,
            'extra' => $this->extra
        ];
    }
}
