<?php

namespace App\Filament\Resources\HistoricoResource\Pages;

use App\Filament\Resources\HistoricoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistorico extends EditRecord
{
    protected static string $resource = HistoricoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
