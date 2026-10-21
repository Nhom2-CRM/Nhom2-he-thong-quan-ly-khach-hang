<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'due_date' => $this->due_date?->toIso8601String(),
            'priority' => $this->priority,
            'status' => $this->status,
            'postpone_reason' => $this->postpone_reason,
            'assigned_to' => [
                'id' => $this->assignedTo?->id,
                'name' => $this->assignedTo?->name,
            ],
            'created_by' => [
                'id' => $this->createdBy?->id,
                'name' => $this->createdBy?->name,
            ],
            'customer' => $this->whenLoaded('customer'),
            'opportunity' => $this->whenLoaded('opportunity'),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}