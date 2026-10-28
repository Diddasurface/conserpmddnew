<?php

namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Livewire\Features\SupportFileUploads\FileUploadController;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PathSafeFileUploadController extends FileUploadController
{
    public function validateAndStore($files, $disk)
    {
        if (collect($files)->every(fn ($file) => !($file instanceof UploadedFile) || $file->getRealPath() !== false)) {
            return parent::validateAndStore($files, $disk);
        }

        // Some Windows PHP temporary directories allow reads but not realpath().
        // Keep Livewire's validation and signed endpoint, and stream the original path.
        Validator::make(['files' => $files], [
            'files.*' => FileUploadConfiguration::rules(),
        ])->validate();

        return collect($files)->map(function ($file) use ($disk) {
            $filename = TemporaryUploadedFile::generateHashNameWithOriginalNameEmbedded($file);
            $path = Storage::disk($disk)->putFileAs(
                FileUploadConfiguration::path(), $file->getPathname(), $filename,
            );

            if ($path === false) {
                throw ValidationException::withMessages(['files' => 'No se pudo guardar el archivo temporal. Intenta subirlo nuevamente.']);
            }

            return str_replace(FileUploadConfiguration::path('/'), '', $path);
        });
    }
}
