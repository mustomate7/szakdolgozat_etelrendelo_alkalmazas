<?php

namespace Database\Factories;

use App\Models\MenuWeek;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_week_id' => MenuWeek::factory(),
            'name' => $this->faker->word,
            'week_day' => $this->faker->date,
        ];
    }
}
