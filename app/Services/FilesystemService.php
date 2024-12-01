<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;

readonly class FilesystemService
{
    public function __construct(
      private FilesystemManager $filesystemManager,
    ) {
    }

    public function uploadPicture(UploadedFile $file, string $path): string|bool
    {
        return $this->filesystemManager->disk(config('app.storage_disk'))->put($path, $file);
    }

    public function destroyPicture(string|null $imagePath): void
    {
        if ($imagePath) {
            if ($this->filesystemManager->disk(config('app.storage_disk'))->exists($imagePath)) {
                $this->filesystemManager->disk(config('app.storage_disk'))->delete($imagePath);
            }
        }
    }
}

