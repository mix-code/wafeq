<?php

use Illuminate\Support\Facades\Http;
use MixCode\DaftraClient\DaftraClient;
use MixCode\DaftraClient\DaftraResponse;
use MixCode\DaftraClient\Payloads\ProductPayload;

beforeEach(function () {
    config()->set('daftra-client.endpoint', 'https://fake-api.com');
    config()->set('daftra-client.api_key', 'test-api-key');

    $this->client = new DaftraClient;
});

it('lists products successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/products' => Http::response([
            'result' => 'success',
            'data'   => [
                ['Product' => ['id' => 1, 'name' => 'Product A']],
                ['Product' => ['id' => 2, 'name' => 'Product B']],
            ],
        ], 200),
    ]);

    $response = $this->client->listProducts();

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->data)->toHaveCount(2)
        ->and($response->data[0])->toBe(['id' => 1, 'name' => 'Product A']);
});

it('fetches a single product successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/products/1' => Http::response([
            'result' => 'success',
            'data'   => ['Product' => ['id' => 1, 'name' => 'Product A']],
        ], 200),
    ]);

    $response = $this->client->showProduct(1);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->data)->toBe(['id' => 1, 'name' => 'Product A']);
});

it('creates a new product successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/products' => Http::response([
            'result' => 'success',
            'id'     => 123,
        ], 201),
    ]);

    $productPayload = new ProductPayload(
        name: 'New Product',
        description: 'A test product',
        price: 99.99,
        isProduct: true
    );

    $response = $this->client->createProduct($productPayload);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->id)->toBe(123);
});

it('updates a product successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/products/123' => Http::response([
            'result' => 'success',
        ], 200),
    ]);

    $productPayload = new ProductPayload(
        name: 'Updated Product',
        description: 'Updated description',
        price: 149.99,
        isProduct: true
    );

    $response = $this->client->updateProduct($productPayload, 123);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->result)->toBe('success');
});

it('deletes a product successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/products/123' => Http::response([
            'result' => 'success',
        ], 200),
    ]);

    $response = $this->client->deleteProduct(123);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->result)->toBe('success');
});
