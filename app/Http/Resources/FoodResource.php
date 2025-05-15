<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
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
            'food_category_id' => $this->food_category_id,
            'food_category' => new FoodCategoryResource($this->whenLoaded('foodCategory')),
            'images' => ImageResource::collection($this->images),
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
