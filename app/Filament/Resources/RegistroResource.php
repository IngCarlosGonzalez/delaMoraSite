<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Registro;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Imports\RegistroImporter;
use App\Filament\Resources\RegistroResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistroResource\RelationManagers;

class RegistroResource extends Resource
{

    protected static ?string $model = Registro::class;
    protected static ?string $modelLabel = 'Registro';
    protected static ?string $pluralModelLabel = 'Registros';
    protected static ?string $navigationLabel = 'Registros';
    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';
    protected static ?string $navigationGroup = 'PERSONAL';
    protected static ?int $navigationSort = 3; 

    public static function form(Form $form): Form
    {
        return $form

        ->schema([

            Section::make('DATOS REGISTRO')

                ->schema([

                    DatePicker::make('fecha')
                        ->label('Fecha')
                        ->autofocus()
                        ->required()
                        ->format('Y/m/d')
                        ->native(false)
                        ->live(debounce: 2000),

                    TextInput::make('empnum')
                        ->label('Empnum')
                        ->required(),

                    Hidden::make('nombre')
                        ->label('Empnum'),

                    TimePicker::make('entrada')
                        ->format('H:i')
                        ->seconds(false)
                        ->label('Entrada'),

                    TimePicker::make('salida')
                        ->format('H:i')
                        ->seconds(false)
                        ->label('Salida'),
                    
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
                    ->label('Fecha')
                    ->color('naranja')
                    ->date(format: 'd/m/Y')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono),  

                TextColumn::make('empnum')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono)
                    ->label('Empleado'),

                TextColumn::make('nombre')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Medium)
                    ->fontFamily(FontFamily::Mono)
                    ->label('Nombre'),

                TextColumn::make('entrada')
                    ->label('Entrada')
                    ->color('seccess')
                    ->time(format: 'H:i')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono),  

                TextColumn::make('salida')
                    ->label('Salida')
                    ->color('seccess')
                    ->time(format: 'H:i')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono)  

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(RegistroImporter::class)
                    ->color('fiucha'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRegistros::route('/'),
            'create' => Pages\CreateRegistro::route('/create'),
            'edit' => Pages\EditRegistro::route('/{record}/edit'),
        ];
    }
}
