<?php

namespace App\Filament\Resources\BarangayResource\Pages;

use App\Filament\Resources\BarangayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangay extends EditRecord
{
    protected static string $resource = BarangayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
