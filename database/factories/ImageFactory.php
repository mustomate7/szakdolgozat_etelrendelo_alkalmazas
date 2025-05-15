<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $food = Food::query()->inRandomOrder()->first() ?? Food::factory()->create();
        return [
            'imageable_id' => $food->id,
            'imageable_type' => $food::class,
            'path' => '/svgs/placeholder.svg',
        ];
    }
}
