<?php

namespace App\Filament\Exports;

use DateTime;
use App\Models\Registro;
use Filament\Actions\Exports\Exporter;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\Enums\ExportFormat;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;

class RegistroExporter extends Exporter
{
    protected static ?string $model = Registro::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('fecha')
                ->label('FECHA'),
            ExportColumn::make('empnum')
                ->label('EMPLEADO'),
            ExportColumn::make('nombre')
                ->label('NOMBRE EMPLEADO'),
            ExportColumn::make('entrada')
                ->label('ENTRADA')
                ->formatStateUsing(function (DateTime $state): void {
                    date('H:i', time($state));
                }),
            ExportColumn::make('salida')
                ->label('SALIDA')
                ->formatStateUsing(function (DateTime $state): void {
                    date('H:i', time($state));
                }),
        ];
    }

    public function getFormats(): array
    {
        return [
            ExportFormat::Xlsx,
        ];
    }

    public function getXlsxHeaderCellStyle(): ?Style
    {
        return (new Style())
            ->setFontBold()
            ->setFontSize(14)
            ->setFontName('Consolas')
            ->setFontColor(Color::rgb(255, 255, 77))
            ->setBackgroundColor(Color::rgb(0, 0, 0))
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
    }
    
    public function getXlsxCellStyle(): ?Style
    {
        return (new Style())
            ->setFontSize(14)
            ->setFontName('Consolas');
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your registro export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
