<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Fecha;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FechaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FechaResource\RelationManagers;

class FechaResource extends Resource
{

    protected static ?string $model = Fecha::class;
    protected static ?string $modelLabel = 'Fecha';
    protected static ?string $pluralModelLabel = 'Fechas';
    protected static ?string $navigationLabel = 'Fechas';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'PERSONAL';
    protected static ?int $navigationSort = 2; 

    public static function form(Form $form): Form
    {
        return $form

            ->schema([

                Section::make('DATOS PRINCIPALES')

                    ->schema([

                        DatePicker::make('fecha')
                            ->label('Fecha de Asistencias')
                            ->autofocus()
                            ->required()
                            ->format('Y/m/d')
                            ->native(false)
                            ->live(debounce: 2000),

                    ])

                ->columns(1)
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([15, 50, 100, 'all'])
            ->defaultPaginationPageOption(15)
            ->deferLoading()
            ->striped()
            ->columns([

                TextColumn::make('fecha')
                    ->label('Fecha Cargada')
                    ->color('naranja')
                    ->date(format: 'd/m/Y')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),  

                TextColumn::make('datos')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono)
                    ->label('Regidtros'),

                TextColumn::make('created_at')
                    ->label('Registrada')
                    ->dateTime(format: 'd/m/Y H:i')
                    ->wrap(),

                TextColumn::make('updated_at')
                    ->label('Cargada')
                    ->dateTime(format: 'd/m/Y H:i')
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFechas::route('/'),
            'create' => Pages\CreateFecha::route('/create'),
            'edit' => Pages\EditFecha::route('/{record}/edit'),
        ];
    }
}
