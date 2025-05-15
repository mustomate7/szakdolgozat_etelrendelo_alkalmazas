<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuWeek>
 */
class MenuWeekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $count = -1;
        $count++;
        return [
            'calendar_year' => now()->addWeeks($count)->year,
            'calender_week' => now()->addWeeks($count)->isoWeek(),
        ];
    }
}
