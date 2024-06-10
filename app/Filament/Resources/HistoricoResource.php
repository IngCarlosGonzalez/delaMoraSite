<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Fechax;
use Filament\Forms\Form;
use App\Models\Historico;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use pxlrbt\FilamentExcel\Columns\Column;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\HistoricoResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class HistoricoResource extends Resource
{
    protected static ?string $model = Historico::class;
    protected static ?string $modelLabel = 'Historico';
    protected static ?string $pluralModelLabel = 'Registros';
    protected static ?string $navigationLabel = 'Historicos';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'ASISTENCIA';
    protected static ?int $navigationSort = 4; 

    protected static bool $shouldRegisterNavigation = false;

    public static function getEloquentQuery(): Builder
    {
        $parametro = Fechax::where('id', 1)->first()->fecha;
        return parent::getEloquentQuery()
            ->where('fecha', '=', $parametro);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha')
                    ->required(),
                Forms\Components\TextInput::make('empnum')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('nombre')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('entrada'),
                Forms\Components\TextInput::make('salida'),
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
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->color('naranja')
                    ->url(fn ($record): string => route('filament.admin.resources.historicos.index'))
                    ->date(format: 'd/m/Y'),
                Tables\Columns\TextColumn::make('empnum')
                    ->fontFamily(FontFamily::Mono)
                    ->url(fn ($record): string => route('filament.admin.resources.historicos.index'))
                    ->label('Empleado'),
                Tables\Columns\TextColumn::make('nombre')
                    ->fontFamily(FontFamily::Mono)
                    ->url(fn ($record): string => route('filament.admin.resources.historicos.index'))
                    ->label('Empleado'),
                Tables\Columns\TextColumn::make('entrada')
                    ->label('Entrada')
                    ->color('seccess')
                    ->url(fn ($record): string => route('filament.admin.resources.historicos.index'))
                    ->time(format: 'H:i')
                    ->fontFamily(FontFamily::Mono), 
                Tables\Columns\TextColumn::make('salida')
                    ->label('Entrada')
                    ->color('danger')
                    ->url(fn ($record): string => route('filament.admin.resources.historicos.index'))
                    ->time(format: 'H:i')
                    ->fontFamily(FontFamily::Mono), 
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\DeleteBulkAction::make(),

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
            'index' => Pages\ListHistoricos::route('/'),
            'create' => Pages\CreateHistorico::route('/create'),
            'edit' => Pages\EditHistorico::route('/{record}/edit'),
        ];
    }
}
