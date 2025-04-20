<?php

use Illuminate\Support\Facades\Http;
use MixCode\Wafeq\Account;
use MixCode\Wafeq\WafeqResponse;

beforeEach(function () {
    config()->set('wafeq.endpoint', 'https://fake-api.com');
    config()->set('wafeq.api_key', 'test-api-key');
    $this->account = new Account;
});

it('lists accounts successfully', function () {
    Http::fake([
        '*/accounts*' => Http::response([
            ['id' => 1, 'name' => 'Cash'],
            ['id' => 2, 'name' => 'Bank'],
        ], 200),
    ]);

    $response = $this->account->list();

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->data)->toHaveCount(2)
        ->and($response->data[0]['id'])->toBe(1)
        ->and($response->data[0]['name'])->toBe('Cash');
});
