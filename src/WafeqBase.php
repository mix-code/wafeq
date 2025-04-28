<?php

namespace MixCode\Wafeq;

use MixCode\Wafeq\Exceptions\WafeqDisabledException;

class WafeqBase
{
    protected ?string $endpoint;

    protected ?string $apiKey;

    protected ?string $apiPrefix;

    protected bool $isEnabled;

    public function __construct()
    {
        $this->endpoint = config('wafeq.endpoint');
        $this->apiKey = config('wafeq.api_key');
        $this->apiPrefix = 'v1';
        $this->isEnabled = config('wafeq.is_enabled', false);

        if (!$this->isEnabled) {
            throw new WafeqDisabledException;
        }
    }

    /**
     * Return the headers for the API request.
     *
     * @return array The headers, where each key is a header name and each value is a header value.
     */
    protected function headers(): array
    {
        return [
            'Authorization' => 'Api-Key ' . $this->apiKey,
        ];
    }

    /**
     * Format the API response array into a WafeqResponse instance.
     *
     * @param  array  $res  The API response array.
     * @param  array  $overrides  Optional. An array of overrides.
     */
    protected function formatResponse(array $res, array $overrides = []): WafeqResponse
    {
        $responseData = array_merge([
            'code'             => $res['code'] ?? 500,
            'message'          => $res['detail'] ?? null,
            'validationErrors' => $res['validation_errors'] ?? [],
            'data'             => $res['data'] ?? $res['results'] ?? [],
            'next'             => $res['next'] ?? null,
            'previous'         => $res['previous'] ?? null,
            'extra'            => array_diff_key($res, array_flip([
                'code', 'detail', 'validation_errors', 'data', 'results', 'next', 'previous',
            ])),
        ], $overrides);

        return new WafeqResponse(...$responseData);
    }
}
