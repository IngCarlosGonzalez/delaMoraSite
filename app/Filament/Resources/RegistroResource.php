<?php

namespace App\Filament\Resources;

use Exception;
use Carbon\Carbon;
use Filament\Tables;
use App\Models\Empleado;
use App\Models\Registro;
use Filament\Forms\Form;
use App\Models\Historico;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use App\Filament\Imports\RegistroImporter;
use Illuminate\Database\Eloquent\Collection;
 //use EightyNine\ExcelImport\ExcelImportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\RegistroResource\Pages;
use EightyNine\ExcelImport\Facades\ExcelImportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;


class RegistroResource extends Resource
{

    protected static ?string $model = Registro::class;
    protected static ?string $modelLabel = 'Registro';
    protected static ?string $pluralModelLabel = 'Tiempos';
    protected static ?string $navigationLabel = 'Registrar';
    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';
    protected static ?string $navigationGroup = 'ASISTENCIA';
    protected static ?int $navigationSort = 2; 

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
                        ->native(false),

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

                TextColumn::make('id')
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->color('info')
                    ->sortable(),

                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->color('naranja')
                    ->searchable()
                    ->sortable()
                    ->date(format: 'd/m/Y')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono),  

                TextColumn::make('empnum')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono)
                    ->sortable()
                    ->label('Empleado'),

                TextColumn::make('nombre')
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Medium)
                    ->fontFamily(FontFamily::Mono)
                    ->sortable()
                    ->label('Nombre'),

                TextColumn::make('entrada')
                    ->label('Entrada')
                    ->color('seccess')
                    ->time(format: 'H:i')
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono),  

                TextColumn::make('salida')
                    ->label('Salida')
                    ->color('seccess')
                    ->time(format: 'H:i')
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->size(TextColumn\TextColumnSize::Large)
                    ->fontFamily(FontFamily::Mono)  

            ])

            ->filters([

                DateRangeFilter::make('fecha')
                    ->minDate(Carbon::now()->subMonth(2))
                    ->maxDate(Carbon::now())
                    ->firstDayOfWeek(1)
                ,

            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            
            ->headerActions([

                /* ImportAction::make()
                    ->importer(RegistroImporter::class)
                    ->successRedirectUrl(route('filament.admin.resources.registros.index'))
                    ->color('fiucha'), */

            ])
            
            ->bulkActions([

                Tables\Actions\DeleteBulkAction::make(),

                Tables\Actions\BulkAction::make('ponerNombres')
                    ->icon('heroicon-m-pencil-square')
                    ->requiresConfirmation()
                    ->color('warning')
                    ->successRedirectUrl(route('filament.admin.resources.registros.index'))
                    ->action(function (Collection $selectedRecords) {

                    $cuantos = $selectedRecords->count();

                    if ($cuantos > 0) {

                        try {
                
                            $selectedRecords->each( function (Model $selectedRecord) {
                                    $datos = Empleado::where('empnum', $selectedRecord->empnum)->first();
                                    Registro::Where('empnum',$selectedRecord->empnum)->update(['nombre' => $datos->nombre]);
                                }
                            );

                        } catch(Exception $e) {
                
                            RegistroResource::makeNotification(
                                'ERROR AL PROCESAR SELECCION',
                                $e->getMessage(),
                                'danger',
                                'heroicon-m-shield-exclamation',
                                true,
                            )->send();
                
                        }
                
                    } else {
                
                        RegistroResource::makeNotification(
                            'NO SE PUEDE PROCESAR',
                            'NO DISPPONE DE REGISTROS SELECCIONADOS',
                            'warning',
                            'heroicon-m-exclamation-triangle',
                            true,
                        )->send();
                
                    }
                }),

                Tables\Actions\BulkAction::make('acumulaHistoria')
                    ->icon('heroicon-m-user-plus')
                    ->requiresConfirmation()
                    ->color('success')
                    ->successRedirectUrl(route('filament.admin.resources.registros.index'))
                    ->action(function (Collection $selectedRecords) {

                    $cuantos = $selectedRecords->count();

                    if ($cuantos > 0) {

                        try {
                
                            $selectedRecords->each( function (Model $selectedRecord) {

                                Historico::create([
                                    'fecha' => $selectedRecord->fecha,
                                    'empnum' => $selectedRecord->empnum,
                                    'nombre' => $selectedRecord->nombre,
                                    'entrada' => $selectedRecord->entrada,
                                    'salida' => $selectedRecord->salida,
                                    ]);

                                $selectedRecord->delete();

                                }
                            );

                            DB::table('fechas')->truncate();

                            DB::table('fechas')
                            ->insertUsing([
                                'fecha',
                                 'datos'
                                ], DB::table('historicos')
                                    ->select(DB::raw('fecha, count(*) as datos'))
                                    ->groupBy('fecha')
                                    ->orderBy('fecha'))
                            ;
                
                        } catch(Exception $e) {
                
                            RegistroResource::makeNotification(
                                'ERROR AL PROCESAR SELECCION',
                                $e->getMessage(),
                                'danger',
                                'heroicon-m-shield-exclamation',
                                true,
                            )->send();
                
                        }
                
                    } else {
                
                        RegistroResource::makeNotification(
                            'NO SE PUEDE PROCESAR',
                            'NO DISPPONE DE REGISTROS SELECCIONADOS',
                            'warning',
                            'heroicon-m-exclamation-triangle',
                            true,
                        )->send();
                
                    }
                }),

                ExportBulkAction::make()->exports([
                    ExcelExport::make('table')
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->askForFilename()
                        ->withColumns([
                            Column::make('fecha')->heading('FECHA'),
                            Column::make('empnum')->heading('EMPLEADO'),
                            Column::make('nombre')->heading('NOMBRE'),
                            Column::make('entrada')->heading('ENTRADA'),
                            Column::make('salida')->heading('SALIDA'),
                        ]),
    
                ])

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
        
    private static function makeNotification(string $title, string $body, string $color, string $iconito, bool $asegun): Notification
    {
        return Notification::make('RESULTADOS:')
            ->icon($iconito)
            ->color($color)
            ->title($title)
            ->body($body)
            ->persistent($asegun);
    }

}
