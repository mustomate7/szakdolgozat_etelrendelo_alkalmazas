<?php

namespace App\Entities;
use Carbon\CarbonImmutable;

class WeekSelector
{
    private int $week;
    private CarbonImmutable $weekStart;
    private int $year;

    public function __construct(int $week, int $year)
    {
        $this->week = $week;
        $this->weekStart = CarbonImmutable::now()->year($year)->isoWeek($week)->startOfWeek();
        $this->year = $year;
    }

    public function getWeek(): int
    {
        return $this->week;
    }

    public function getWeekStart(): string
    {
        return $this->weekStart->toDateString();
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
