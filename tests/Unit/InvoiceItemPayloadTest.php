<?php

use MixCode\DaftraClient\Payloads\InvoiceItemPayload;

it('converts invoice item payload to array correctly', function () {
    $payload = new InvoiceItemPayload(
        productId: 101,
        price: 50.75,
        quantity: 2,
        additional: ['discount' => 5.00]
    );

    $expectedArray = [
        'product_id' => 101,
        'unit_price' => 50.75,
        'quantity'   => 2,
        'discount'   => 5.00,
    ];

    expect($payload->toArray())->toBe($expectedArray);
});

it('sets default quantity to 1 if not provided', function () {
    $payload = new InvoiceItemPayload(
        productId: 202,
        price: 30.00
    );

    expect($payload->toArray()['quantity'])->toBe(1);
});
