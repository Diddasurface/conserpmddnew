<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $modelLabel = 'curso';
    protected static ?string $pluralModelLabel = 'Cursos';
    protected static ?string $navigationLabel = 'Cursos';
    protected static ?string $slug = 'cursos';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Contenido del curso')->schema([
                Forms\Components\TextInput::make('title')->label('Título')->required()->maxLength(255),
                Forms\Components\TextInput::make('category')->label('Categoría')->maxLength(255),
                Forms\Components\Textarea::make('description')->label('Descripción')->required()->rows(4)->columnSpanFull(),
                Forms\Components\FileUpload::make('image')->label('Foto del curso')
                    ->disk('public')->directory('courses')->visibility('public')
                    ->image()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(4096)
                    ->helperText('JPG, PNG o WebP, máximo 4 MB. Recomendado: imagen horizontal de 800 × 500 px.'),
                Forms\Components\TextInput::make('image_alt')->label('Descripción de la foto')->maxLength(255)
                    ->helperText('Texto alternativo para accesibilidad. Si se deja vacío, se usará el título.'),
            ])->columns(2),
            Forms\Components\Section::make('Instructor y datos de la tarjeta')->schema([
                Forms\Components\TextInput::make('instructor')->label('Nombre del instructor')->maxLength(255),
                Forms\Components\FileUpload::make('instructor_image')->label('Foto del instructor')
                    ->disk('public')->directory('courses/instructors')->visibility('public')
                    ->image()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(2048),
                Forms\Components\TextInput::make('lessons_count')->label('Cantidad de lecciones')->integer()->minValue(0)->maxValue(4294967295),
                Forms\Components\TextInput::make('lessons_label')->label('Texto de lecciones')->default('lecciones')->required()->maxLength(255),
                Forms\Components\TextInput::make('students_count')->label('Cantidad de participantes')->integer()->minValue(0)->maxValue(4294967295),
                Forms\Components\TextInput::make('students_label')->label('Texto de participantes')->default('participantes')->required()->maxLength(255),
                Forms\Components\TextInput::make('rating')->label('Calificación (0 a 5 estrellas)')->integer()->minValue(0)->maxValue(5),
                Forms\Components\TextInput::make('reviews_count')->label('Cantidad de valoraciones')->integer()->minValue(0)->maxValue(4294967295),
                Forms\Components\TextInput::make('reviews_label')->label('Texto de valoraciones')->default('valoraciones')->required()->maxLength(255),
            ])->description('Deja las cantidades, calificación o instructor vacíos para ocultarlos en la página.')->columns(2)->collapsible(),
            Forms\Components\Section::make('Precio, etiqueta y botón')->schema([
                Forms\Components\TextInput::make('price')->label('Precio actual')->numeric()->minValue(0)->maxValue(99999999.99)->step(0.01),
                Forms\Components\TextInput::make('original_price')->label('Precio anterior (tachado)')->numeric()->minValue(0)->maxValue(99999999.99)->step(0.01),
                Forms\Components\TextInput::make('currency')->label('Símbolo de moneda')->default('S/')->required()->maxLength(10),
                Forms\Components\TextInput::make('badge_text')->label('Etiqueta destacada')->placeholder('Ej.: Inscripciones abiertas')->maxLength(255),
                Forms\Components\TextInput::make('badge_caption')->label('Texto adicional de la etiqueta')->maxLength(255),
                Forms\Components\TextInput::make('button_text')->label('Texto del botón')->default('Solicitar información')->required()->maxLength(255),
                Forms\Components\TextInput::make('button_url')->label('Enlace del botón')->url()->rules(['starts_with:http://,https://'])->maxLength(2048)
                    ->helperText('Enlace completo con https://. Si se deja vacío, llevará a Contáctanos.')->columnSpanFull(),
            ])->description('Deja el precio vacío para ocultarlo. El precio 0 se muestra como 0,00.')->columns(2),
            Forms\Components\Section::make('Publicación')->schema([
                Forms\Components\Toggle::make('is_published')->label('Publicado en la página')->default(false),
                Forms\Components\TextInput::make('sort_order')->label('Orden de aparición')->integer()->minValue(0)->maxValue(4294967295)->default(0)->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->label('Foto')->disk('public'),
            Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category')->label('Categoría')->searchable(),
            Tables\Columns\TextColumn::make('price')->label('Precio')->sortable(),
            Tables\Columns\IconColumn::make('is_published')->label('Publicado')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->label('Orden')->sortable(),
        ])->defaultSort('sort_order')->reorderable('sort_order')->filters([
            Tables\Filters\TernaryFilter::make('is_published')->label('Publicado'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])->emptyStateHeading('Todavía no hay cursos')
            ->emptyStateDescription('Crea un curso y publícalo para mostrarlo en la página.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
