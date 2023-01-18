<?php

namespace App\Filament\Resources\MunicipalityResource\RelationManagers;

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
                Forms\Components\TextInput::make('entry_id')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('year_graduated')
                    ->required()
                    ->maxLength(100),

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
                ->required(),

                Forms\Components\Select::make('honors_received')
                        ->label('With Honors Received')
                        ->options([
                            'Yes' => 'Yes',
                            'No' => 'No',
                        ])->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('entry_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('year_graduated')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('barangay.barangay')->sortable()->searchable(),
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
