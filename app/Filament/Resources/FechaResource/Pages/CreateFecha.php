<?php

namespace App\Filament\Resources\FechaResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\FechaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFecha extends CreateRecord
{
    protected static string $resource = FechaResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->color('info')  
            ->duration(8000) 
            ->icon('heroicon-o-check-circle')
            ->iconColor('warning')
            ->title('FECHA REGISTRADA OK')
            ->body('La FECHA ha sido registrada correctamente.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    
}
