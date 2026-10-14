<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tax_code' => $this->tax_code,
            'website' => $this->website,
            'created_at' => $this->created_at?->toIso8601String(),
            'contacts' => $this->whenLoaded('contacts'),
            'opportunities' => $this->whenLoaded('opportunities'),
            'activities' => $this->whenLoaded('activities'),
        ];
    }
}