<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'week_day' => $this->week_day,
            'menu_id' => $this->menu_id,
            'quantity' => $this->quantity,
            'foods' => $this->foods ? FoodResource::collection($this->foods) : null,
        ];
    }
}
