<?php

use MixCode\Wafeq\Payloads\ProjectPayload;

it('converts project payload to array correctly', function () {
    $payload = new ProjectPayload(
        name: 'John',
    );

    $expectedArray = [
        'name'       => 'John',
    ];

    expect($payload->toArray())->toBe($expectedArray);
});