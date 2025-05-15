<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeeklyMenuResource;
use App\Services\MenuService;
use App\Services\WeekSelectorService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private MenuService $menuService;
    private WeekSelectorService $weekSelectorService;

    public function __construct(MenuService $menuService, WeekSelectorService $weekSelectorService)
    {
        $this->menuService = $menuService;
        $this->weekSelectorService = $weekSelectorService;
    }

    public function getWeeklyMenu(Request $request): WeeklyMenuResource
    {
        $selectedWeek = $this->weekSelectorService->weekSelector($request->query('weekStart'));
        $menus = $this->menuService->getMenus($selectedWeek->getWeek(), $selectedWeek->getYear());

        return new WeeklyMenuResource($menus, $selectedWeek);
    }
}
