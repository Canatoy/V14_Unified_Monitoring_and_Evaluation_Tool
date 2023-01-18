<?php

namespace App\Filament\Resources\StudentsResource\Widgets;

use App\Models\Municipality;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StudentsStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('All Students', Student::all()->count()),
            Card::make('Municipality', Municipality::all()->count()),
        ];
    }
}
