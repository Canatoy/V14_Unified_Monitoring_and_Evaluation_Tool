<?php

namespace App\Filament\Resources\BArangayResource\RelationManagers;

use App\Models\Barangay;
use App\Models\Municipality;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('municipality_id')
                ->label('Municipality')
                ->options(Municipality::all()->pluck('name', 'id')
                ->toArray())
                ->reactive()
                // ->afterStateUpdated(fn (callable $set) => $set('barangay_id', null))
                ->required(),
                
                Forms\Components\Select::make('barangay_id')
                ->label('Barangay')
                ->options(function (callable $get){
                    $municipality = Municipality::find($get('municipality_id'));
                    if (!$municipality){
                            return Barangay::all()->pluck('barangay', 'id');
                    }
                    return $municipality->barangays->pluck('barangay', 'id');
                })
                ->required()    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
