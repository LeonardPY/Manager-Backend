<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuccessResource;
use App\Services\FilesystemService;
use Illuminate\Http\Request;

class VideoUploadController extends Controller
{

    public function __construct(
        private readonly FilesystemService $pictureService
    ) {
    }

    public function store(Request $request): SuccessResource
    {
        $request->validate([
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:20000'
        ]);
            $path = $this->pictureService->uploadPicture(
                $request->file('video'),
                'videos'
            );
            return SuccessResource::make([
                'message' => 'Video uploaded successfully',
                'data' => $path
            ]);
    }
}
