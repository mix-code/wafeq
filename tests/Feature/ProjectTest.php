<?php

use Illuminate\Support\Facades\Http;
use MixCode\Wafeq\Payloads\ProjectPayload;
use MixCode\Wafeq\Project;
use MixCode\Wafeq\WafeqResponse;

beforeEach(function () {
    config()->set('wafeq.endpoint', 'https://fake-api.com'); // Fake API to prevent real requests
    config()->set('wafeq.api_key', 'test-api-key'); // Fake API key
    $this->project = new Project;
});

it('lists projects successfully', function () {
    Http::fake([
        '*/projects*' => Http::response([
            [
                'id'   => 1,
                'name' => 'Project Alpha',
            ],
            [
                'id'   => 2,
                'name' => 'Project Beta',
            ],
        ], 200),
    ]);

    $response = $this->project->list();

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->data)->toHaveCount(2)
        ->and($response->data[0]['id'])->toBe(1)
        ->and($response->data[0]['name'])->toBe('Project Alpha');
});

it('shows a single project', function () {
    Http::fake([
        '*/projects/1' => Http::response([
            'id'   => 1,
            'name' => 'Project Alpha',
        ], 200),
    ]);

    $response = $this->project->show(1);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->data['id'])->toBe(1)
        ->and($response->data['name'])->toBe('Project Alpha');
});

it('creates a new project', function () {
    $payload = new ProjectPayload(
        name: 'Project New'
    );

    Http::fake([
        '*/projects' => Http::response([
            'id' => 10,
        ], 201),
    ]);

    $response = $this->project->create($payload);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->id)->toBe(10);
});

it('updates an existing project', function () {
    $payload = new ProjectPayload(
        name: 'Project Updated'
    );

    Http::fake([
        '*/projects/1' => Http::response([
            'id'   => 1,
            'name' => 'Project Updated',
        ], 200),
    ]);

    $response = $this->project->update($payload, 1);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->id)->toBe(1);
});

it('deletes a project', function () {
    Http::fake([
        '*/projects/1' => Http::response([], 204),
    ]);

    $response = $this->project->delete(1);

    expect($response)
        ->toBeInstanceOf(WafeqResponse::class)
        ->and($response->id)->toBe(1)
        ->and($response->code)->toBe(204);
});
