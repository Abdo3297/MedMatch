<?php

namespace App\Filament\Doctor\Resources\DiseaseResource\Pages;

use App\Filament\Doctor\Resources\DiseaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiseases extends ListRecords
{
    protected static string $resource = DiseaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
