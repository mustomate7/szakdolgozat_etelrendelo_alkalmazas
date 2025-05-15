<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Food::factory(10)->create(['food_category_id' => 1]);
        Food::factory(10)->create(['food_category_id' => 2]);
        Food::factory(10)->create(['food_category_id' => 3]);
    }
}
