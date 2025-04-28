<?php

use MixCode\Wafeq\Payloads\ContactPayload;

it('converts contact payload to array correctly', function () {
    $payload = new ContactPayload(
        name: 'John Doe',
        email: 'johndoe@example.com',
        phone: '+1234567890'
    );

    $expectedArray = [
        'name'  => 'John Doe',
        'email' => 'johndoe@example.com',
        'phone' => '+1234567890',
    ];

    expect($payload->toArray())->toBe($expectedArray);
});

it('returns correct contact details when provided', function () {
    $payload = new ContactPayload(
        name: 'Jane Smith',
        email: 'janesmith@example.com',
        phone: '+0987654321'
    );

    expect($payload->toArray()['name'])->toBe('Jane Smith');
    expect($payload->toArray()['email'])->toBe('janesmith@example.com');
    expect($payload->toArray()['phone'])->toBe('+0987654321');
});
