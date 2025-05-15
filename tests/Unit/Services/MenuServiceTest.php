<?php

namespace Tests\Unit\Services;

use App\Models\Menu;
use App\Models\MenuWeek;
use App\Services\MenuService;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuServiceTest extends TestCase
{
    use RefreshDatabase;

    private MenuService $menuService;

    public function setUp(): void
    {
        parent::setUp();
        $this->menuService = $this->app->make(MenuService::class);
    }

    public function test_is_get_menus_returns_data(): void
    {
        $week = MenuWeek::factory(['calendar_year' => 2050, 'calender_week' => 1])->create();
        Menu::factory()
            ->count(5)
            ->create([
                'week_day' => '2050-01-03',
                'menu_week_id' => $week->id,
                'name' => 'ferivagyok',
            ]);

        $result = $this->menuService->getMenus(1, 2050);

        $this->assertTrue($result->contains('week_day', '=', '2050-01-03'));
        $this->assertTrue($result->contains('name', '=', 'ferivagyok'));
        $this->assertCount(5, $result);
    }

    public function test_is_get_menus_returns_no_data(): void
    {
        Menu::factory()->create();

        $result = $this->menuService->getMenus(1, 1999);

        $this->assertEmpty($result);
    }

    public function test_does_menu_exist(): void
    {
        Menu::factory()->create();
        $selectedWeek = CarbonImmutable::now()->isoWeek();
        $selectedYear = now()->year;

        $result = $this->menuService->doesMenuExist($selectedWeek, $selectedYear);

        $this->assertTrue($result);
    }

    public function test_does_menu_does_not_exist(): void
    {
        Menu::factory()->create();

        $result = $this->menuService->doesMenuExist(1, 1920);

        $this->assertFalse($result);
    }

    public function test_last_existing_menu(): void
    {
        Menu::factory()->create([
            'week_day' => '2040-02-11',
        ]);

        $result = $this->menuService->lastExistingMenu();

        $this->assertEquals('2040-02-11', $result);
    }
}
