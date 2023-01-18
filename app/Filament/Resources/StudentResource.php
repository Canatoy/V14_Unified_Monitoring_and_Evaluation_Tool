<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Filament\Resources\StudentsResource\Widgets\StudentsStatsOverview;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Student;
use BladeUI\Icons\Components\Icon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('name')->required()->maxLength(100),
                    TextInput::make('entry_id')->label('Enrty ID')->required()->maxLength(100),
                    TextInput::make('year_graduated')->required()->maxLength(100),
                    Select::make('municipality_id')
                        ->label('Municipality')
                        ->options(Municipality::all()->pluck('name', 'id')
                        ->toArray())
                        ->reactive()
                        // ->afterStateUpdated(fn (callable $set) => $set('barangay_id', null))
                        ->required(),
                        
                    Select::make('barangay_id')
                        ->label('Barangay')
                        ->options(function (callable $get){
                            $municipality = Municipality::find($get('municipality_id'));
                            if (!$municipality){
                                    return Barangay::all()->pluck('barangay', 'id');
                            }
                            return $municipality->barangays->pluck('barangay', 'id');
                        })
                        ->required(),

                    // Select::make('honors_received')
                    //     ->label('With Honors Received')
                    //     ->options([
                    //         'Yes' => 'Yes',
                    //         'No' => 'No',
                    //     ])->required()->boolean()

                    Toggle::make('honors_received')->label('With Honors Received')

                    
                    
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('entry_id')->label('Entry ID')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('year_graduated')->label('Year Graduated')->sortable()->searchable(),
                TextColumn::make('barangay.barangay')->sortable()->searchable(),
                TextColumn::make('municipality.name')->sortable()->searchable(),
                // IconColumn::make('honors_received')->label('With Honors Received')->sortable(),
                IconColumn::make('honors_received')->boolean()
                // TextColumn::make('created_at')->dateTime()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StudentsStatsOverview::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }    
}
