<?php

namespace App\Services;

use App\Entities\WeekSelector;
use Carbon\CarbonImmutable;
use Carbon\Exceptions\InvalidFormatException;

class WeekSelectorService
{
    private MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function weekSelector(?string $weekStart): WeekSelector
    {
        $weekStart = $this->parseDate($weekStart);
        $currentWeekStart = CarbonImmutable::now()->startOfWeek();
        $selectedWeek = $weekStart->isoWeek();
        $selectedYear = $weekStart->yearIso;

        if ($weekStart->lessThan($currentWeekStart)) {
            $selectedWeek = $currentWeekStart->isoWeek();
            $selectedYear = now()->yearIso;
        }
        if (!$this->menuService->doesMenuExist($selectedWeek, $selectedYear)) {
            $lastMenuDate = $this->menuService->lastExistingMenu();
            $weekStart = $this->parseDate($lastMenuDate)->startOfWeek();
            $selectedWeek = $weekStart->isoWeek();
            $selectedYear = $weekStart->yearIso;
        }

        return new WeekSelector($selectedWeek, $selectedYear);
    }

    private function parseDate($date): CarbonImmutable
    {
        try {
            return CarbonImmutable::parse($date);
        } catch (InvalidFormatException $e) {
            return CarbonImmutable::now()->startOfWeek();
        }
    }
}
