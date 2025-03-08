<?php

use Illuminate\Support\Facades\Http;
use MixCode\DaftraClient\DaftraClient;
use MixCode\DaftraClient\DaftraResponse;
use MixCode\DaftraClient\Payloads\ClientPayload;

beforeEach(function () {
    config()->set('daftra-client.endpoint', 'https://fake-api.com'); // Fake API to prevent real requests
    config()->set('daftra-client.api_key', 'test-api-key'); // Fake API key
    $this->client = new DaftraClient;
});

it('lists clients successfully', function () {
    Http::fake([
        '*/api2/clients' => Http::response([
            'result' => true,
            'data'   => [
                ['Client' => ['id' => 1, 'name' => 'John Doe']],
                ['Client' => ['id' => 2, 'name' => 'Jane Doe']],
            ],
        ], 200),
    ]);

    $response = $this->client->listClients();

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->data)->toHaveCount(2)
        ->and($response->data[0])->toBe(['id' => 1, 'name' => 'John Doe']);
});

it('shows a single client', function () {
    Http::fake([
        '*/api2/clients/1' => Http::response([
            'result' => true,
            'data'   => ['Client' => ['id' => 1, 'name' => 'John Doe']],
        ], 200),
    ]);

    $response = $this->client->showClient(1);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->data)->toBe(['id' => 1, 'name' => 'John Doe']);
});

it('creates a new client', function () {
    $payload = new ClientPayload(
        firstName: 'John',
        lastName: 'Doe',
        businessName: 'JD Enterprises',
        email: 'john@example.com',
        phone: '1234567890',
        password: 'password'
    );

    Http::fake([
        '*/api2/clients' => Http::response([
            'result' => true,
            'id'     => 10,
        ], 201),
    ]);

    $response = $this->client->createClient($payload);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->id)->toBe(10);
});

it('updates an existing client', function () {
    $payload = new ClientPayload(
        firstName: 'John',
        lastName: 'Doe',
        businessName: 'JD Enterprises',
        email: 'john@example.com',
        phone: '1234567890',
        password: 'newpassword'
    );

    Http::fake([
        '*/api2/clients/1' => Http::response([
            'result' => 'success',
        ], 200),
    ]);

    $response = $this->client->updateClient($payload, 1);

    expect($response)->toBeInstanceOf(DaftraResponse::class)
        ->and($response->result)->toBe('success');
});

it('deletes a client', function () {
    Http::fake([
        '*/api2/clients/1' => Http::response([
            'result' => 'success',
        ], 200),
    ]);

    $response = $this->client->deleteClient(1);

    expect($response)->toBeInstanceOf(DaftraResponse::class)
        ->and($response->result)->toBe('success');
});
