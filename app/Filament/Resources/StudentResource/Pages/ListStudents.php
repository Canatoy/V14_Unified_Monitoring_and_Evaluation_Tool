<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StudentResource;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;
use App\Filament\Resources\StudentsResource\Widgets\StudentsStatsOverview;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),   

            ImportAction::make()
            
            ->massCreate(false)
            ->fields([
                ImportField::make('entry_id')
                    ->label('Entry ID'),
                ImportField::make('name')
                    ->label('Name'), 
                ImportField::make('year_graduated')
                    ->label('Year Graduated'),
                ImportField::make('barangay')
                    ->label('Barangay'),
                ImportField::make('municipality')
                    ->label('Municipality'),                
                ImportField::make('honors_received')
                    ->label('Honors_received'),
                    
                
                
            ], columns:2)
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StudentsStatsOverview::class,
        ];
    }
}
