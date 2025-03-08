<?php

use MixCode\DaftraClient\Payloads\ProductPayload;

it('converts product payload to array correctly', function () {
    $payload = new ProductPayload(
        name: 'Laptop',
        description: 'High-performance laptop',
        price: 1200.50,
        isProduct: true,
        additional: ['sku' => 'LAP123']
    );

    $expectedArray = [
        'name'        => 'Laptop',
        'description' => 'High-performance laptop',
        'unit_price'  => 1200.50,
        'type'        => 1,
        'sku'         => 'LAP123',
    ];

    expect($payload->toArray())->toBe($expectedArray);
});

it('sets the correct type based on flags', function () {
    $product = new ProductPayload(
        name: 'Phone',
        description: 'Smartphone',
        price: 800.00,
        isProduct: true
    );

    $service = new ProductPayload(
        name: 'Repair Service',
        description: 'Phone repair service',
        price: 100.00,
        isService: true
    );

    $bundle = new ProductPayload(
        name: 'Gadget Bundle',
        description: 'Bundle of accessories',
        price: 50.00,
        isBundle: true
    );

    expect($product->toArray()['type'])->toBe(1);
    expect($service->toArray()['type'])->toBe(2);
    expect($bundle->toArray()['type'])->toBe(3);
});

it('returns null when no type flags are set', function () {
    $payload = new ProductPayload(
        name: 'Unknown Item',
        description: 'No specific type',
        price: 500.00
    );

    expect($payload->toArray()['type'])->toBeNull();
});
