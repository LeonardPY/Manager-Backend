<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => $this['message'] ?? '',
            'data' => $this['data'] ?? [],
            'pagination' => [
                'currentPage' => $this['pagination']->currentPage(),
                'perPage' => $this['pagination']->perPage(),
                'total' => $this['pagination']->total(),
            ]
        ];
    }

}
