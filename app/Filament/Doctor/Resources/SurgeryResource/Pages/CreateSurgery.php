<?php

namespace App\Filament\Doctor\Resources\SurgeryResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Doctor\Resources\SurgeryResource;

class CreateSurgery extends CreateRecord
{
    protected static string $resource = SurgeryResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Surgery created')
            ->body('The Surgery has been created successfully.');
    }
}
