<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FoodCategory::factory()->create(['name' => 'Soup']);
        FoodCategory::factory()->create(['name' => 'Main dish']);
        FoodCategory::factory()->create(['name' => 'Dessert']);
    }
}
