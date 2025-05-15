<?php

namespace Tests\Unit\Services;

use App\Models\Menu;
use App\Services\MenuService;
use App\Services\WeekSelectorService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeekSelectorServiceTest extends TestCase
{
    use RefreshDatabase;

    private WeekSelectorService $weekSelectorService;

    public function setUp(): void
    {
        parent::setUp();
        $this->weekSelectorService = $this->app->make(WeekSelectorService::class);
    }

    public function test_week_selector_with_empty_string(): void
    {
        $result = $this->weekSelectorService->weekSelector('');

        $currentDate = CarbonImmutable::now();
        $this->assertEquals($currentDate->isoWeek(), $result->getWeek());
        $this->assertEquals($currentDate->year, $result->getYear());
        $this->assertEquals($currentDate->startOfWeek()->format('Y-m-d'), $result->getWeekStart());
    }

    public function test_week_selector_with_last_week_parameter(): void
    {
        $weekStart = CarbonImmutable::now()->subWeek()->startOfWeek();

        $result = $this->weekSelectorService->weekSelector($weekStart);

        $this->assertEquals(CarbonImmutable::now()->isoWeek(), $result->getWeek());
        $this->assertEquals(CarbonImmutable::now()->year, $result->getYear());
    }

    public function test_week_selector_with_end_of_year(): void
    {
        Menu::factory()->create([
            'week_day' => '2041-01-05',
        ]);

        $knownDate = Carbon::create(2040, 12, 31);
        Carbon::setTestNow($knownDate);
        $weekStart = Carbon::now()->startOfWeek()->format('Y-m-d');

        $result = $this->weekSelectorService->weekSelector($weekStart);

        $this->assertEquals(1, $result->getWeek());
        $this->assertEquals(2041, $result->getYear());
        $this->assertEquals('2040-12-31', $result->getWeekStart());
        Carbon::setTestNow();
    }

    public function test_does_menu_exists(): void
    {
        Menu::factory()->create([
            'week_day' => '2035-12-28',
        ]);
        $weekStart = CarbonImmutable::parse('2040-12-12')->startOfWeek();
        $expectedWeekStart = CarbonImmutable::parse('2035-12-28');

        $result = $this->weekSelectorService->weekSelector($weekStart);

        $this->assertEquals($expectedWeekStart->isoWeek(), $result->getWeek());
        $this->assertEquals($expectedWeekStart->year, $result->getYear());
        $this->assertEquals($expectedWeekStart->startOfWeek()->format('Y-m-d'), $result->getWeekStart());
    }

    public function test_week_selector_with_invalid_parameters(): void
    {
        $weekStart = 'invalidInput';

        $result = $this->weekSelectorService->weekSelector($weekStart);

        $currentDate = CarbonImmutable::now();
        $this->assertEquals($currentDate->isoWeek(), $result->getWeek());
        $this->assertEquals($currentDate->year, $result->getYear());
        $this->assertEquals($currentDate->startOfWeek()->format('Y-m-d'), $result->getWeekStart());
    }
}
