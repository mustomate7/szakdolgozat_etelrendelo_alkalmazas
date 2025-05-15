<?php

namespace App\Http\Resources;

use App\Entities\WeekSelector;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyMenuResource extends JsonResource
{
    public function __construct($resource, readonly WeekSelector $selectedWeek)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'menus' => MenuResource::collection($this->resource),
            'weekStart' => $this->selectedWeek->getWeekStart(),
        ];
    }
}
