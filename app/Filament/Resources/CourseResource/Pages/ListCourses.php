<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Models\CourseSection;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('section')->label('Textos de la sección')->icon('heroicon-o-pencil-square')
                ->modalHeading('Editar sección de cursos')
                ->fillForm(fn (): array => CourseSection::current()->attributesToArray())
                ->form([
                    Forms\Components\TextInput::make('eyebrow')->label('Etiqueta superior')->required()->maxLength(255),
                    Forms\Components\Textarea::make('title')->label('Título de la sección')->required()->maxLength(255),
                    Forms\Components\TextInput::make('empty_text')->label('Mensaje cuando no hay cursos publicados')->required()->maxLength(255),
                    Forms\Components\TextInput::make('button_text')->label('Texto del botón al final de la sección')->maxLength(255),
                    Forms\Components\TextInput::make('button_url')->label('Enlace del botón')->url()->rules(['starts_with:http://,https://'])->maxLength(2048)
                        ->helperText('Opcional. El botón aparece solo si completas el texto y un enlace con https://.'),
                ])->action(function (array $data): void {
                    CourseSection::updateOrCreate(['id' => 1], $data);
                    Notification::make()->title('Sección de cursos actualizada')->success()->send();
                }),
            Actions\CreateAction::make()->label('Crear curso'),
        ];
    }
}
