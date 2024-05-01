<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PictureService
{
    public function uploadPicture(UploadedFile $file, string $path): string|bool
    {
        return Storage::disk(config('app.storage_disk'))->put($path, $file);
    }

    public function destroyPicture(string|null $imagePath): void
    {
        if ($imagePath) {
            if (Storage::disk(config('app.storage_disk'))->exists($imagePath)) {
                Storage::disk(config('app.storage_disk'))->delete($imagePath);
            }
        }
    }
}

