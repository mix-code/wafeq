<?php

use MixCode\DaftraClient\Payloads\InvoiceItemPayload;
use MixCode\DaftraClient\Payloads\InvoicePayload;

it('converts invoice payload to array correctly', function () {
    $items = [
        new InvoiceItemPayload(productId: 101, price: 50.75, quantity: 2),
        new InvoiceItemPayload(productId: 102, price: 30.00),
    ];

    $payload = new InvoicePayload(
        clientId: 1,
        items: $items,
        date: '2025-03-08',
        additional: ['notes' => 'Thank you for your purchase']
    );

    $expectedArray = [
        'client_id' => 1,
        'date'      => '2025-03-08',
        'items'     => [
            ['product_id' => 101, 'unit_price' => 50.75, 'quantity' => 2],
            ['product_id' => 102, 'unit_price' => 30.00, 'quantity' => 1],
        ],
        'notes' => 'Thank you for your purchase',
    ];

    expect($payload->toArray())->toBe($expectedArray);
});

it('throws an exception if items are not instances of InvoiceItemPayload', function () {
    new InvoicePayload(
        clientId: 1,
        items: [['product_id' => 101, 'unit_price' => 50.75]], // Invalid item
        date: '2025-03-08'
    );
})->throws(InvalidArgumentException::class, 'Each item must be an instance of InvoiceItemPayload');
