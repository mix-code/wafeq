<?php

use MixCode\Wafeq\WafeqResponse;

it('creates a valid WafeqResponse instance', function () {
    $response = new WafeqResponse(
        code: 200,
        message: 'Operation successful',
        validationErrors: [],
        id: '123',
        next: null,
        previous: null,
        data: ['key' => 'value'],
        extra: ['custom_field' => 'custom_value']
    );

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->code)->toBe(200)
        ->and($response->message)->toBe('Operation successful')
        ->and($response->validationErrors)->toBe([])
        ->and($response->id)->toBe('123')
        ->and($response->data)->toBe(['key' => 'value'])
        ->and($response->next)->toBe(null)
        ->and($response->previous)->toBe(null);
});

it('converts to array correctly', function () {
    $response = new WafeqResponse(
        code: 400,
        message: 'Invalid request',
        validationErrors: ['field' => 'Required'],
        id: null,
        next: 'next_page',
        previous: 'prev_page',
        data: [],
        extra: ['extra_key' => 'extra_value']
    );

    $expectedArray = [
        'next'              => 'next_page',
        'previous'          => 'prev_page',
        'code'              => 400,
        'id'                => null,
        'message'           => 'Invalid request',
        'validation_errors' => ['field' => 'Required'],
        'data'              => [],
        'extra_key'         => 'extra_value',
    ];

    expect($response->toArray())->toBe($expectedArray);
});
