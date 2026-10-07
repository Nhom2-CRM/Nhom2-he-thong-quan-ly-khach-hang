<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type,
            'unit' => $this->unit,
            'listPrice' => $this->list_price,
            'floorPrice' => $this->floor_price,
            'description' => $this->description,
            'isActive' => $this->is_active,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

        if ($request->user()?->role === 'SALES_DIRECTOR') {
            $data['costPrice'] = $this->cost_price;
        }

        return $data;
    }
}