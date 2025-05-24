<?php

namespace App\Filament\Resources\ConsultingAreaResource\Pages;

use App\Filament\Resources\ConsultingAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsultingArea extends EditRecord
{
    protected static string $resource = ConsultingAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
