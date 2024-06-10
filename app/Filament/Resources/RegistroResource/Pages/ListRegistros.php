<?php

namespace App\Filament\Resources\RegistroResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\RegistroResource;
use EightyNine\ExcelImport\ExcelImportAction;

class ListRegistros extends ListRecords
{
    protected static string $resource = RegistroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
            ExcelImportAction::make()
                ->color("info"),

            Actions\CreateAction::make()
                ->color("gray"),
                
        ];
    }
}
