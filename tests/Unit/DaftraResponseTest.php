<?php

use MixCode\DaftraClient\DaftraResponse;

it('creates a valid DaftraResponse instance', function () {
    $response = new DaftraResponse(
        result: 'success',
        code: 200,
        message: 'Operation successful',
        validationErrors: [],
        id: 123,
        data: ['key' => 'value'],
        pagination: ['current_page' => 1, 'total' => 10],
        extra: ['custom_field' => 'custom_value']
    );

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->result)->toBe('success')
        ->and($response->code)->toBe(200)
        ->and($response->message)->toBe('Operation successful')
        ->and($response->validationErrors)->toBe([])
        ->and($response->id)->toBe(123)
        ->and($response->data)->toBe(['key' => 'value'])
        ->and($response->pagination)->toBe(['current_page' => 1, 'total' => 10]);
});

it('converts to array correctly', function () {
    $response = new DaftraResponse(
        result: 'error',
        code: 400,
        message: 'Invalid request',
        validationErrors: ['field' => 'Required'],
        id: null,
        data: [],
        pagination: [],
        extra: ['extra_key' => 'extra_value']
    );

    $expectedArray = [
        'result'            => 'error',
        'code'              => 400,
        'id'                => null,
        'message'           => 'Invalid request',
        'validation_errors' => ['field' => 'Required'],
        'data'              => [],
        'pagination'        => [],
        'extra_key'         => 'extra_value',
    ];

    expect($response->toArray())->toBe($expectedArray);
});
