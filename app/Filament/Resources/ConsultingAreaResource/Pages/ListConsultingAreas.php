<?php

namespace App\Filament\Resources\ConsultingAreaResource\Pages;

use App\Filament\Resources\ConsultingAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsultingAreas extends ListRecords
{
    protected static string $resource = ConsultingAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
