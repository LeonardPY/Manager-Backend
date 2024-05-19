<?php

namespace App\Services\ExchangeRate;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    private string $requestUrl = 'https://api.fastforex.io/fetch-multi';

    public function getExchangeRate(string $from = 'AMD', string $to = 'AMD'): int|float
    {
        try {
            $response =  Http::withOptions(['verify' => false])->get(
                $this->requestUrl, [
                    'from' => $from,
                    'to' => $to,
                    'api_key' => 'demo',
                ]
            )->json();

            return $response['results'][$to] ?? 1;

        } catch (ConnectionException $exception) {
            Log::error($exception->getMessage());
        }
        return 1;
    }
}
