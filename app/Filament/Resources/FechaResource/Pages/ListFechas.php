<?php

namespace App\Filament\Resources\FechaResource\Pages;

use App\Filament\Resources\FechaResource;
use Filament\Resources\Pages\ListRecords;

class ListFechas extends ListRecords
{
    protected static string $resource = FechaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            /* Actions\CreateAction::make()
                ->createAnother(false), */
        ];
    }
    
}
