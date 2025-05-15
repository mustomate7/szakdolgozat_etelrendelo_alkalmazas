<?php

namespace App\Http\Resources;

use App\Services\MenuService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'menu_week_id' => $this->menu_week_id,
            'name' => $this->name,
            'week_day' => $this->week_day,
            'cartItem' => new CartResource($this->cartItem),
            'foods' => FoodResource::collection($this->foods),
            'disabled' => MenuService::isCutoff(Carbon::parse($this->week_day)),
        ];
    }
}
