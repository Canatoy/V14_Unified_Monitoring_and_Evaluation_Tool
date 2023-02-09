<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use App\Models\Barangay;
use App\Models\Municipality;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use BladeUI\Icons\Components\Icon;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\TernaryFilter;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\StudentResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\StudentsResource\Widgets\StudentsStatsOverview;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('entry_id')->label('Enrty ID')->required()->maxLength(100)->integer()->nullable(),
                    TextInput::make('name')->required()->maxLength(100)->nullable(),
                    TextInput::make('province')->required()->maxLength(100)->nullable(),
                    TextInput::make('municipality')->required()->maxLength(100)->nullable(),
                    TextInput::make('barangay')->required()->maxLength(100)->nullable(),
                    TextInput::make('year_graduated')->label('SHS Grad Year')->required()->maxLength(100)->nullable(),
                    
                        
                    

                    Select::make('status')
                    ->label('Current Status')
                    
                    ->options([
                        'In School - Senior High' => 'In School - Senior High',
                        'In School - College Degree Course' => 'In School - College Degree Course',
                        'In School - Vocational' => 'In School - Vocational',
                        'Single Teenage Young Parent' => 'Single Teenage Young Parent',
                        'Legally Married' => 'Legally Married',
                        'Out of School' => 'Out of School',
                        'College Graduate' => 'College Graduate',
                        'Others (Specify)' => 'Others (Specify)',
                    ])->nullable()->searchable(),

                    TextArea::make('others')->placeholder('Fill only if current status is others (specify)')->label('Others Please Specify')->nullable(),


                    Select::make('employment')
                        ->label('Details')
                        ->options([
                            'Employed' => 'Employed',
                            'Unemployed' => 'Unemployed',
                            'No scholarship' => 'No scholarship',
                            'with LGU scholarship' => 'with LGU scholarship',
                            'with CHED scholarship' => 'with CHED scholarship',
                            'with CSO scholarship' => 'with CSO scholarship',
                            'TESDA sponsorship' => 'TESDA sponsorship',
                            'CSO sponsorship' => 'CSO sponsorship',
                            'Private Agencies Institution sponsorship' => 'Private Agencies Institution sponsorship',
                            'Public School/SUC sponsorship' => 'Public School/SUC sponsorship',
                        ])->nullable()->searchable(),
                        

                    Toggle::make('honors_received')->label('With Honors Received'),

                    TextArea::make('honors_received_details')->placeholder('Fill only if there is honor received')->label('Honors Received Details')->nullable(),

                    

                        
                    Textarea::make('remarks')->label('Remarks')->nullable(),
                    
                    
                ])

                
            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('entry_id')->label('Entry ID')->sortable()->searchable()->toggleable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('province')->sortable()->searchable()->toggleable(),
                TextColumn::make('municipality')->sortable()->searchable()->toggleable(),
                TextColumn::make('barangay')->sortable()->searchable()->toggleable(),
                TextColumn::make('year_graduated')->label('SHS Grad Year')->sortable()->searchable()->toggleable(),
                TextColumn::make('status')->label('Current Status')->sortable()->searchable()->toggleable()->wrap(),
                TextColumn::make('others')->label('Others Please Specify')->sortable()->searchable()->toggleable(),
                TextColumn::make('employment')->label('Details')->sortable()->searchable()->toggleable()->wrap(),


                IconColumn::make('honors_received')->boolean()->toggleable(),
                TextColumn::make('honors_received_details')->label('Honors Received Details')->sortable()->searchable()->toggleable(),
                TextColumn::make('remarks')->label('Remarks')->sortable()->searchable()->toggleable(),
                
                // TextColumn::make('created_at')->dateTime()   
            ])
            ->filters([
                TernaryFilter::make('honors_received')->trueLabel('Yes')
                ->falseLabel('No')
                ->placeholder('Filter by Honors received'),

                SelectFilter::make('status')
                    ->label('Current Status')
                    ->options([
                        'In School - Senior High' => 'In School - Senior High',
                        'In School - College Degree Course' => 'In School - College Degree Course',
                        'In School - Vocational' => 'In School - Vocational',
                        'Single Teenage Young Parent' => 'Single Teenage Young Parent',
                        'Legally Married' => 'Legally Married',
                        'Out of School' => 'Out of School',
                        'Graduated' => 'Graduated',
                        'Others (Specify)' => 'Others (Specify)',
                    ])
                    ->placeholder('Filter by Current Status'),

                SelectFilter::make('employment')
                    ->label('Details')
                    ->options([
                        'Employed' => 'Employed',
                        'Unemployed' => 'Unemployed',
                        'No scholarship' => 'No scholarship',
                        'with LGU scholarship' => 'with LGU scholarship',
                        'with CHED scholarship' => 'with CHED scholarship',
                        'with CSO scholarship' => 'with CSO scholarship',
                        'TESDA sponsorship' => 'TESDA sponsorship',
                        'CSO sponsorship' => 'CSO sponsorship',
                        'Private Agencies Institution sponsorship' => 'Private Agencies Institution sponsorship',
                        'Public School/SUC sponsorship' => 'Public School/SUC sponsorship',
                    ])
                    ->placeholder('Filter by Details'),
                    
                        
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export')
                ->disableAdditionalColumns(),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                ->disableAdditionalColumns(),
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
    
    protected static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }
}
