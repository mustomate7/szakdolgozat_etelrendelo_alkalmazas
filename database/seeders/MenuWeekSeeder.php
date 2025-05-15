<?php

namespace Database\Seeders;

use App\Models\MenuWeek;
use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weeksInYear = CarbonImmutable::now()->isoWeeksInYear - CarbonImmutable::now()->isoWeek();
        $weeksInNextYear = CarbonImmutable::now()->addYear()->isoWeeksInYear;

        MenuWeek::factory()->count($weeksInYear)->create();
        MenuWeek::factory()->count($weeksInNextYear)->create();
    }
}
