<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ErrorResource extends JsonResource
{
    public function withResponse(Request $request, Response|JsonResponse $response): void
    {
        $response->setStatusCode(500);
    }

    public function toArray($request): array
    {
        self::withoutWrapping();

        return [
            'success' => false,
            'message' => $this['message'] ?? '',
        ];
    }
}
