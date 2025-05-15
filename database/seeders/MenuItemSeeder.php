<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            MenuItem::factory()->create([
                'menu_id' => $i,
                'food_id' => random_int(1, 10),
            ]);
            MenuItem::factory()->create([
                'menu_id' => $i,
                'food_id' => random_int(11, 20),
            ]);
            MenuItem::factory()->create([
                'menu_id' => $i,
                'food_id' => random_int(21, 30),
            ]);
        }
    }
}
