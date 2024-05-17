<?php

namespace App\Filament\Resources\EmpleadoResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EmpleadoResource;

class CreateEmpleado extends CreateRecord
{
    protected static string $resource = EmpleadoResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->color('info')  
            ->duration(8000) 
            ->icon('heroicon-o-check-circle')
            ->iconColor('warning')
            ->title('EMPLEADO REGISTRADO OK')
            ->body('El EMPLEADO ha sido registrado correctamente.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    
}
