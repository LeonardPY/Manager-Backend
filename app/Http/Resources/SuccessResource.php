<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SuccessResource extends JsonResource
{
    protected int $statusCode = 200;

    public function withResponse(Request $request, Response|JsonResponse $response): void
    {
        $response->setStatusCode($this->statusCode);
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        $message = data_get($this->resource, 'message', '');
        $data = data_get($this->resource, 'data', []);

        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
    }
}

