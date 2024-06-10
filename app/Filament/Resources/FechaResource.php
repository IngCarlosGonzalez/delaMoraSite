<?php

namespace App\Filament\Resources;

use Exception;
use Filament\Forms;
use Filament\Tables;
use App\Models\Fecha;
use App\Models\Fechax;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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
    protected static ?string $navigationLabel = 'Acumulados';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'ASISTENCIA';
    protected static ?int $navigationSort = 3; 

    public static function form(Form $form): Form
    {
        return $form

            ->schema([

                Section::make('DATOS DE FECHA')

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
                    ->url(fn ($record): string => route('filament.admin.resources.fechas.index'))
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),  

                TextColumn::make('datos')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->url(fn ($record): string => route('filament.admin.resources.fechas.index'))
                    ->fontFamily(FontFamily::Mono)
                    ->label('Regidtros'),

            ])

            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\Action::make('verRegistros')
                    ->icon('heroicon-m-eye')
                    ->color('danger')
                    ->action(function ($record) {
                        $fechita = $record->fecha;

                        FechaResource::makeNotification(
                            'AVISO DEL PROGRAMA',
                            'PROCESANDO FECHA: ' . $fechita,
                            'warning',
                            'heroicon-m-exclamation-triangle',
                        )->send();

                        try {

                            DB::table('fechaxes')->truncate();

                            Fechax::create([
                                'fecha' => $fechita
                            ]);

                            return redirect(route('filament.admin.resources.historicos.index'));

                        } catch(Exception $e) {
                
                            RegistroResource::makeNotification(
                                'ERROR AL PROCESAR FECHA',
                                $e->getMessage(),
                                'danger',
                                'heroicon-m-shield-exclamation',
                            )->send();
                
                        }

                    })
                    ,
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
            
    private static function makeNotification(string $title, string $body, string $color, string $iconito): Notification
    {
        return Notification::make('RESULTADOS:')
            ->icon($iconito)
            ->color($color)
            ->title($title)
            ->body($body);
    }

}
