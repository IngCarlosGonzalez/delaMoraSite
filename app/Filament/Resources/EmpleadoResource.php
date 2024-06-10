<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Empleado;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmpleadoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmpleadoResource\RelationManagers;

class EmpleadoResource extends Resource
{

    protected static ?string $model = Empleado::class;
    protected static ?string $modelLabel = 'Empleado';
    protected static ?string $pluralModelLabel = 'Personas';
    protected static ?string $navigationLabel = 'Nombres';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'ASISTENCIA';
    protected static ?int $navigationSort = 1; 

    public static function form(Form $form): Form
    {
        return $form

            ->schema([

                Section::make('DATOS PRINCIPALES')

                    ->schema([

                        TextInput::make('empnum')
                        ->label('Número de Empleado')
                        ->autofocus()
                        ->required()
                        ->mask('999999')
                        ->placeholder('000000')
                        ->minLength(2)
                        ->maxLength(6)
                        ->autocomplete(false)
                        ->live(debounce: 2000),

                        TextInput::make('nombre')
                        ->label('Nombre del Empleado')
                        ->required()
                        ->maxLength(50)
                        ->autocomplete(false)
                        ->dehydrateStateUsing(fn (string $state): string => strtoupper($state))
                        ->live(debounce: 2000),

                        TextInput::make('oficina')
                        ->label('Area o Departamento')
                        ->maxLength(30)
                        ->autocomplete(false)
                        ->dehydrateStateUsing(fn (string $state): string => strtoupper($state))
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

                TextColumn::make('empnum')
                    ->label('Número')
                    ->grow(false)
                    ->color('success')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),  

                TextColumn::make('nombre')
                    ->label('Nombre del Empleado')
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                    TextColumn::make('oficina')
                    ->label('Area o Departamento')
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime()
                    ->sortable()
                    ->wrap()
                    ->since(),
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
            'index' => Pages\ListEmpleados::route('/'),
            'create' => Pages\CreateEmpleado::route('/create'),
            'edit' => Pages\EditEmpleado::route('/{record}/edit'),
        ];
    }
}
