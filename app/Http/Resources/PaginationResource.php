<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        $pagination = data_get($this->resource, 'pagination', []);
        $message = data_get($this->resource, 'message', '');
        $data = data_get($this->resource, 'data', []);
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'pagination' => [
                'currentPage' => $pagination->currentPage() ?? null,
                'perPage' => $pagination->perPage() ?? null,
                'total' => $pagination->total() ?? null,
            ]
        ];
    }

}
