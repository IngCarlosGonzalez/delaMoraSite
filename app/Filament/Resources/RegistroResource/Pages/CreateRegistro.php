<?php

namespace App\Filament\Resources\RegistroResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\RegistroResource;

class CreateRegistro extends CreateRecord
{
    protected static string $resource = RegistroResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->color('info')  
            ->duration(8000) 
            ->icon('heroicon-o-check-circle')
            ->iconColor('warning')
            ->title('REGISTRADO OK')
            ->body('El REGISTRO se almacenó correctamente.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    
}
