<?php

use MixCode\DaftraClient\Payloads\ClientPayload;

it('converts client payload to array correctly', function () {
    $payload = new ClientPayload(
        firstName: 'John',
        lastName: 'Doe',
        businessName: 'Doe Inc.',
        email: 'john@example.com',
        phone: '123456789',
        password: 'secret',
        category: 'customers',
        startingBalance: 100.50,
        individual: true,
        additional: ['custom_field' => 'custom_value']
    );

    $expectedArray = [
        'first_name'       => 'John',
        'last_name'        => 'Doe',
        'business_name'    => 'Doe Inc.',
        'email'            => 'john@example.com',
        'phone1'           => '123456789',
        'password'         => 'secret',
        'category'         => 'customers',
        'starting_balance' => 100.50,
        'type'             => 2,
        'custom_field'     => 'custom_value',
    ];

    expect($payload->toArray())->toBe($expectedArray);
});

it('sets correct type based on individual status', function () {
    $individualPayload = new ClientPayload(
        firstName: 'Alice',
        lastName: 'Smith',
        businessName: 'Alice Co.',
        email: 'alice@example.com',
        phone: '987654321',
        password: 'password',
        individual: true
    );

    $businessPayload = new ClientPayload(
        firstName: 'Bob',
        lastName: 'Brown',
        businessName: 'Bob Ltd.',
        email: 'bob@example.com',
        phone: '555555555',
        password: 'securepass',
        individual: false
    );

    expect($individualPayload->toArray()['type'])->toBe(2);
    expect($businessPayload->toArray()['type'])->toBe(3);
});
