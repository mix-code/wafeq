<?php

use Illuminate\Support\Facades\Http;
use MixCode\Wafeq\Payloads\ContactPayload;
use MixCode\Wafeq\Contact;
use MixCode\Wafeq\WafeqResponse;

beforeEach(function () {
    config()->set('wafeq.endpoint', 'https://fake-api.com');
    config()->set('wafeq.api_key', 'test-api-key');
    $this->contact = new Contact;
});

it('lists contacts successfully', function () {
    Http::fake([
        '*/contacts*' => Http::response([
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
        ], 200),
    ]);

    $response = $this->contact->list();

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->data)->toHaveCount(2)
        ->and($response->data[0]['id'])->toBe(1)
        ->and($response->data[0]['name'])->toBe('Alice');
});

it('shows a single contact', function () {
    Http::fake([
        '*/contacts/1' => Http::response([
            'id' => 1,
            'name' => 'Alice',
        ], 200),
    ]);

    $response = $this->contact->show(1);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->id)->toBe(1)
        ->and($response->code)->toBe(200);
});

it('creates a new contact', function () {
    $payload = new ContactPayload(
        name: 'New Contact',
        email: 'new@example.com',
        phone: '123456789'
    );

    Http::fake([
        '*/contacts' => Http::response([
            'id' => 99,
        ], 201),
    ]);

    $response = $this->contact->create($payload);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->id)->toBe(99)
        ->and($response->code)->toBe(201);
});

it('updates an existing contact', function () {
    $payload = new ContactPayload(
        name: 'Updated Contact',
        email: 'updated@example.com',
        phone: '987654321'
    );

    Http::fake([
        '*/contacts/1' => Http::response([
            'id' => 1,
            'name' => 'Updated Contact',
        ], 200),
    ]);

    $response = $this->contact->update($payload, 1);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->id)->toBe(1)
        ->and($response->code)->toBe(200);
});

it('deletes a contact', function () {
    Http::fake([
        '*/contacts/1' => Http::response([], 204),
    ]);

    $response = $this->contact->delete(1);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->id)->toBe(1)
        ->and($response->code)->toBe(204);
});
