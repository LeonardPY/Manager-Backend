<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ErrorResource extends JsonResource
{
    protected int $statusCode = 500;
    public function withResponse(Request $request, Response|JsonResponse $response): void
    {
        $response->setStatusCode($this->statusCode);
    }

    public function toArray($request): array
    {
        self::withoutWrapping();

        $message = data_get($this->resource, 'message', '');
        return [
            'success' => false,
            'message' => $message,
        ];
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
