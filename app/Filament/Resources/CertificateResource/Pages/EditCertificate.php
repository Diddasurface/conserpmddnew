<?php

namespace App\Filament\Resources\CertificateResource\Pages;

use App\Filament\Resources\CertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificate extends EditRecord
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('qr')->label('Descargar QR PNG')->icon('heroicon-o-qr-code')
                ->url(fn () => route('admin.certificates.qr', ['certificate' => $this->record, 'format' => 'png'])),
            Actions\Action::make('verify')->label('Ver validación')->openUrlInNewTab()
                ->url(fn () => route('certificates.show', ['code' => $this->record->code]))
                ->visible(fn () => $this->record->status !== 'draft'),
        ];
    }
}
