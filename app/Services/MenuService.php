<?php

namespace App\Services;

use App\Facades\Settings as SettingsFacade;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    public function getMenus(int $selectedWeek, int $selectedYear): Collection
    {
        return $this->menuQuery($selectedWeek, $selectedYear)->get();
    }

    public function doesMenuExist(int $selectedWeek, int $selectedYear): bool
    {
        return $this->menuQuery($selectedWeek, $selectedYear)->exists();
    }

    public function lastExistingMenu(): string
    {
        return Menu::query()
            ->select('week_day')
            ->max('week_day');
    }

    private function menuQuery(int $selectedWeek, int $selectedYear): \Illuminate\Database\Eloquent\Builder
    {
        return Menu::query()
            ->select('menus.*', 'menu_weeks.calendar_year', 'menu_weeks.calender_week')
            ->with(['foods.foodCategory','foods.images', 'cartItem'])
            ->join('menu_weeks', 'menu_weeks.id', '=', 'menus.menu_week_id')
            ->leftJoin('cart', 'menus.id', '=', 'cart.menu_id')
            ->where('menu_weeks.calendar_year', '=', $selectedYear)
            ->where('menu_weeks.calender_week', '=', $selectedWeek);
    }

    public static function isCutoff(Carbon $date): bool
    {
        $preparationHour = SettingsFacade::getData('menu_preparation_time', '20:00');
        $cutoffHour = SettingsFacade::getData('cutoff_time', '10:00');
        $timeBeforeCutoff = now()->addHours((int)$preparationHour - (int)$cutoffHour);

        return $date->isBefore($timeBeforeCutoff);
    }
}
