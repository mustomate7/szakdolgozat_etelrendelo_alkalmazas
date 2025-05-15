<?php

namespace Database\Seeders;

use App\Models\Menu;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $period = CarbonPeriod::create(now()->startOfWeek(), '1 day', 5);

        foreach ($period as $day){
            Menu::factory()->create([
                'menu_week_id' => 1,
                'name' => 'Menu A',
                'week_day' => $day,
            ]);
            Menu::factory()->create([
                'menu_week_id' => 1,
                'name' => 'Menu B',
                'week_day' => $day,
            ]);
            Menu::factory()->create([
                'menu_week_id' => 1,
                'name' => 'Menu C',
                'week_day' => $day,
            ]);
        }

        $period = CarbonPeriod::create(now()->addWeek()->startOfWeek(), '1 day', 5);

        foreach ($period as $day){
            Menu::factory()->create([
                'menu_week_id' => 2,
                'name' => 'Menu A',
                'week_day' => $day,
            ]);
            Menu::factory()->create([
                'menu_week_id' => 2,
                'name' => 'Menu B',
                'week_day' => $day,
            ]);
            Menu::factory()->create([
                'menu_week_id' => 2,
                'name' => 'Menu C',
                'week_day' => $day,
            ]);
        }
    }
}
