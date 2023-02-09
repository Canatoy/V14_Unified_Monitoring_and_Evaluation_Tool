<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\StudentResource\Pages\ListStudents;
use App\Filament\Resources\StudentsResource\Widgets\StudentsStatsOverview;
use App\Models\Student;
use Closure;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestStudent extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        

        return Student::query()

            ->latest()
            ->take(5); 
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('entry_id')->label('Entry ID')->sortable()->searchable()->toggleable(),
            TextColumn::make('name')->sortable()->searchable(),
            // TextColumn::make('year_graduated')->label('Year Graduated')->sortable()->searchable()->toggleable(),
            TextColumn::make('province')->sortable()->searchable()->toggleable(),
            TextColumn::make('barangay')->sortable()->searchable()->toggleable(),
            TextColumn::make('municipality')->sortable()->searchable()->toggleable(),
            // IconColumn::make('honors_received')->boolean()->toggleable(),
            // TextColumn::make('status')->label('Current Status')->sortable()->searchable()->toggleable()->wrap(),
            // TextColumn::make('employment')->label('Details')->sortable()->searchable()->toggleable()->wrap(),
            // TextColumn::make('others')->label('Others Please Specify')->sortable()->searchable()->toggleable(),
            // TextColumn::make('remarks')->label('Remarks')->sortable()->searchable()->toggleable(),
        ];
    }

    protected function isTablePaginationEnabled(): bool{
        return false;
    }

}
