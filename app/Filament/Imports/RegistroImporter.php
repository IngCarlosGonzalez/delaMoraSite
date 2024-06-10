<?php

namespace App\Filament\Imports;

use App\Models\Registro;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class RegistroImporter extends Importer
{
    protected static ?string $model = Registro::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('fecha')
                ->label('fecha')
                ->requiredMapping()
                ->example('2024/05/16')
                ->rules(['required']),
            ImportColumn::make('empnum')
                ->label('empnum')
                ->numeric()
                ->requiredMapping()
                ->example('12345')
                ->rules(['required']),
            ImportColumn::make('nombre')
                ->label('nombre')
                ->example(''),
            ImportColumn::make('entrada')
                ->castStateUsing(function (string $state): ?string {
                    if (blank($state)) {
                        return null;
                    }
                    $state = preg_replace('/[^0-9:]/', '', $state);
                    $date=date_create($state);
                    $state = date_format($date,"H:i");
                    return $state;
                })
                ->example('08:01')
                ->label('entrada'),
            ImportColumn::make('salida')
                ->castStateUsing(function (string $state): ?string {
                    if (blank($state)) {
                        return null;
                    }
                    $state = preg_replace('/[^0-9:]/', '', $state);
                    $date=date_create($state);
                    $state = date_format($date,"H:i");
                    return $state;
                })
                ->example('15:16')
                ->label('salida'),
        ];
    }

    public function resolveRecord(): ?Registro
    {
        return new Registro();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your registro import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
