<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteContentResource\Pages;
use App\Models\SiteContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteContentResource extends Resource
{
    protected static ?string $model = SiteContent::class;
    protected static ?string $navigationIcon = 'heroicon-o-window';
    protected static ?string $navigationLabel = 'Contenido web';
    protected static ?string $modelLabel = 'contenido web';
    protected static ?string $pluralModelLabel = 'Contenido web';
    protected static ?string $slug = 'contenido-web';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Contenido de la página')->tabs([
                Forms\Components\Tabs\Tab::make('Portada')->icon('heroicon-o-home')->schema([
                    Forms\Components\Section::make('Bloque principal')->schema([
                        Forms\Components\TextInput::make('content.hero.badge')->label('Etiqueta superior')->required()->maxLength(255),
                        Forms\Components\Textarea::make('content.hero.title')->label('Título principal')->required()->rows(2)
                            ->helperText('Puedes usar un salto de línea para dividir el título.'),
                        Forms\Components\Textarea::make('content.hero.description')->label('Descripción')->required()->rows(3)->columnSpanFull(),
                        Forms\Components\TextInput::make('content.hero.highlight')->label('Texto destacado')->required()->maxLength(255)->columnSpanFull(),
                        self::imageUpload('content.hero.image', 'Fotografía principal', 'site-content/hero')
                            ->helperText('Imagen PNG, JPG o WebP, máximo 6 MB.'),
                    ])->columns(2),
                    Forms\Components\Section::make('Presentación de servicios')->schema([
                        Forms\Components\TextInput::make('content.services_section.eyebrow')->label('Etiqueta superior')->required()->maxLength(255),
                        Forms\Components\TextInput::make('content.services_section.title')->label('Título')->required()->maxLength(255),
                        Forms\Components\Textarea::make('content.services_section.description')->label('Descripción')->required()->rows(3)->columnSpanFull(),
                    ])->columns(2),
                ]),

                Forms\Components\Tabs\Tab::make('Servicios')->icon('heroicon-o-briefcase')->schema([
                    Forms\Components\Repeater::make('content.services')->label('Servicios administrables')
                        ->schema([
                            Forms\Components\TextInput::make('short_title')->label('Nombre corto')->required()->maxLength(255),
                            Forms\Components\TextInput::make('title')->label('Título completo')->required()->maxLength(255),
                            Forms\Components\TextInput::make('slug')->label('Enlace interno')->required()->alphaDash()->maxLength(255)
                                ->helperText('Ejemplo: capacitaciones-sst. Cambiarlo modifica la URL pública.'),
                            Forms\Components\Toggle::make('is_active')->label('Visible en la página')->default(true),
                            self::imageUpload('image', 'Fotografía del servicio', 'site-content/services'),
                            Forms\Components\Textarea::make('summary')->label('Resumen para la tarjeta')->required()->rows(3),
                            Forms\Components\Textarea::make('intro')->label('Introducción de la página')->required()->rows(3)->columnSpanFull(),
                            Forms\Components\Repeater::make('includes')->label('Qué incluye el servicio')
                                ->simple(Forms\Components\TextInput::make('item')->required()->maxLength(500))
                                ->addActionLabel('Agregar punto')->columnSpanFull(),
                            Forms\Components\Textarea::make('benefit')->label('Resultado esperado')->required()->rows(3)->columnSpanFull(),
                        ])->columns(2)->collapsible()->cloneable()->reorderable()
                        ->itemLabel(fn (array $state): ?string => $state['short_title'] ?? 'Servicio')
                        ->addActionLabel('Agregar servicio')->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Nosotros')->icon('heroicon-o-building-office')->schema([
                    Forms\Components\Section::make('Presentación, misión y visión')->schema([
                        Forms\Components\TextInput::make('content.about.eyebrow')->label('Etiqueta superior')->required()->maxLength(255),
                        Forms\Components\TextInput::make('content.about.title')->label('Título')->required()->maxLength(255),
                        Forms\Components\Textarea::make('content.about.description')->label('Descripción de la empresa')->required()->rows(4)->columnSpanFull(),
                        Forms\Components\Textarea::make('content.about.mission')->label('Misión')->required()->rows(4),
                        Forms\Components\Textarea::make('content.about.vision')->label('Visión')->required()->rows(4),
                        self::imageUpload('content.about.image', 'Fotografía de la sección', 'site-content/about'),
                    ])->columns(2),
                ]),

                Forms\Components\Tabs\Tab::make('Clientes')->icon('heroicon-o-building-storefront')->schema([
                    Forms\Components\Section::make('Textos del carrusel')->schema([
                        Forms\Components\TextInput::make('content.clients_section.eyebrow')->label('Etiqueta superior')->required()->maxLength(255),
                        Forms\Components\TextInput::make('content.clients_section.title')->label('Título')->required()->maxLength(255),
                        Forms\Components\Textarea::make('content.clients_section.description')->label('Descripción')->required()->rows(3)->columnSpanFull(),
                    ])->columns(2),
                    Forms\Components\Repeater::make('content.clients')->label('Logos de clientes')
                        ->schema([
                            Forms\Components\TextInput::make('name')->label('Nombre de la organización')->required()->maxLength(255),
                            self::imageUpload('logo', 'Logo', 'site-content/clients')->required(),
                            Forms\Components\Toggle::make('is_active')->label('Visible')->default(true),
                        ])->columns(3)->collapsible()->cloneable()->reorderable()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Cliente')
                        ->addActionLabel('Agregar cliente')->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Normas ISO')->icon('heroicon-o-shield-check')->schema([
                    Forms\Components\Section::make('Textos de la sección ISO')->schema([
                        Forms\Components\TextInput::make('content.iso_section.eyebrow')->label('Etiqueta superior')->required()->maxLength(255),
                        Forms\Components\TextInput::make('content.iso_section.title')->label('Título')->required()->maxLength(255),
                        Forms\Components\Textarea::make('content.iso_section.description')->label('Descripción')->required()->rows(3)->columnSpanFull(),
                    ])->columns(2),
                    Forms\Components\Repeater::make('content.standards')->label('Normas ISO')
                        ->schema([
                            Forms\Components\TextInput::make('number')->label('Número')->required()->maxLength(20),
                            Forms\Components\TextInput::make('name')->label('Nombre')->required()->maxLength(255),
                            self::imageUpload('image', 'Imagen', 'site-content/iso')->required(),
                            Forms\Components\Toggle::make('is_active')->label('Visible')->default(true),
                        ])->columns(2)->collapsible()->cloneable()->reorderable()
                        ->itemLabel(fn (array $state): ?string => filled($state['number'] ?? null) ? 'ISO '.$state['number'] : 'Norma ISO')
                        ->addActionLabel('Agregar norma')->columnSpanFull(),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }

    private static function imageUpload(string $name, string $label, string $directory): Forms\Components\FileUpload
    {
        return Forms\Components\FileUpload::make($name)->label($label)
            ->disk('public')->directory($directory)->visibility('public')->image()
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
            ->maxSize(6144)->imagePreviewHeight('160');
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Sección'),
            Tables\Columns\TextColumn::make('updated_at')->label('Última actualización')->dateTime('d/m/Y H:i')->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Administrar contenido'),
        ])->paginated(false)->emptyStateHeading('Preparando el contenido web');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteContents::route('/'),
            'edit' => Pages\EditSiteContent::route('/{record}/edit'),
        ];
    }
}
