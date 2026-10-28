<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationLabel = 'Certificados';
    protected static ?string $modelLabel = 'certificado';
    protected static ?string $pluralModelLabel = 'Certificados';
    protected static ?string $slug = 'certificados';
    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Certificado y participante')->schema([
                Forms\Components\TextInput::make('code')->label('Código único')->disabled()->dehydrated(false)
                    ->placeholder('Se genera automáticamente al guardar'),
                Forms\Components\TextInput::make('recipient_name')->label('Nombre del participante')->required()->maxLength(255),
                Forms\Components\Select::make('course_id')->label('Curso del catálogo (opcional)')
                    ->relationship('course', 'title')->searchable()->live()
                    ->afterStateUpdated(function ($state, Set $set): void {
                        if ($state && ($course = Course::find($state))) {
                            $set('training_title', $course->title);
                        }
                    }),
                Forms\Components\TextInput::make('training_title')->label('Nombre del curso o capacitación')
                    ->required()->maxLength(255)->helperText('También puedes escribir una capacitación que no esté en el catálogo.'),
                Forms\Components\DatePicker::make('issued_at')->label('Fecha de emisión')->default(today())->required(),
                Forms\Components\DatePicker::make('expires_at')->label('Fecha de vencimiento')->afterOrEqual('issued_at')
                    ->helperText('Opcional. Déjalo vacío si no tiene vencimiento.'),
                Forms\Components\TextInput::make('hours')->label('Duración en horas')->numeric()->minValue(0.01)->maxValue(99999.99)->step(0.01),
                Forms\Components\Select::make('status')->label('Estado')->options(Certificate::STATUSES)->default('draft')->required(),
            ])->columns(2),
            Forms\Components\Section::make('Documento de respaldo')->schema([
                Forms\Components\FileUpload::make('evidence_image')->label('Imagen de la constancia o certificado')
                    ->disk('local')->directory('certificates/evidence')->visibility('private')
                    ->image()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(8192)->required()
                    ->getUploadedFileUsing(function (string $file, ?Certificate $record): ?array {
                        $disk = Storage::disk('local');
                        if (!$record || !$disk->exists($file)) {
                            return null;
                        }

                        return [
                            'name' => basename($file), 'size' => $disk->size($file), 'type' => $disk->mimeType($file),
                            'url' => route('admin.certificates.evidence', $record),
                        ];
                    })->helperText('JPG, PNG o WebP de hasta 8 MB. Esta imagen se mostrará en la verificación pública cuando publiques el certificado.'),
                Forms\Components\Textarea::make('public_notes')->label('Observaciones públicas')->rows(3)->maxLength(5000),
            ]),
            Forms\Components\Section::make('Enlace y QR')->schema([
                Forms\Components\Placeholder::make('verification')->label('')
                    ->content(fn (?Certificate $record) => $record
                        ? view('filament.certificates.verification', ['certificate' => $record])
                        : 'Guarda el certificado para generar su código, enlace y QR.'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('code')->label('Código')->searchable()->copyable(),
            Tables\Columns\TextColumn::make('recipient_name')->label('Participante')->searchable(),
            Tables\Columns\TextColumn::make('training_title')->label('Curso / capacitación')->searchable()->wrap(),
            Tables\Columns\TextColumn::make('issued_at')->label('Emisión')->date('d/m/Y')->sortable(),
            Tables\Columns\TextColumn::make('status_label')->label('Estado')->badge()
                ->color(fn (Certificate $record) => match ($record->verification_status) {
                    'valid' => 'success', 'revoked' => 'danger', 'expired' => 'warning', default => 'gray',
                }),
            Tables\Columns\TextColumn::make('verification_url')->label('Enlace público')->copyable()->toggleable(isToggledHiddenByDefault: true),
        ])->defaultSort('id', 'desc')->filters([
            Tables\Filters\SelectFilter::make('status')->label('Estado registrado')->options(Certificate::STATUSES),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('verify')->label('Ver página')->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (Certificate $record) => route('certificates.show', ['code' => $record->code]))->openUrlInNewTab()
                ->visible(fn (Certificate $record) => $record->status !== 'draft'),
            Tables\Actions\Action::make('qr')->label('QR PNG')->icon('heroicon-o-qr-code')
                ->url(fn (Certificate $record) => route('admin.certificates.qr', ['certificate' => $record, 'format' => 'png'])),
            Tables\Actions\Action::make('qrSvg')->label('QR SVG')
                ->url(fn (Certificate $record) => route('admin.certificates.qr', ['certificate' => $record, 'format' => 'svg'])),
            Tables\Actions\Action::make('revoke')->label('Revocar')->color('danger')->requiresConfirmation()
                ->modalDescription('El enlace seguirá funcionando y mostrará el certificado como revocado.')
                ->visible(fn (Certificate $record) => $record->status === 'valid')
                ->action(fn (Certificate $record) => $record->update(['status' => 'revoked'])),
        ])->emptyStateHeading('Todavía no hay certificados')
            ->emptyStateDescription('Registra el participante y la constancia para generar su enlace de verificación y QR.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
