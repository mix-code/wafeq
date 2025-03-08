<?php

use Illuminate\Support\Facades\Http;
use MixCode\DaftraClient\DaftraClient;
use MixCode\DaftraClient\DaftraResponse;
use MixCode\DaftraClient\Payloads\InvoicePayload;
use MixCode\DaftraClient\Payloads\InvoicePaymentPayload;

beforeEach(function () {
    config()->set('daftra-client.endpoint', 'https://fake-api.com');
    config()->set('daftra-client.api_key', 'test-api-key');

    $this->client = new DaftraClient;
});

it('lists invoices successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/invoices' => Http::response([
            'result' => true,
            'data'   => [
                ['Invoice' => ['id' => 1, 'client_id' => 1001, 'date' => '2025-03-08']],
                ['Invoice' => ['id' => 2, 'client_id' => 1002, 'date' => '2025-03-07']],
            ],
        ], 200),
    ]);

    $response = $this->client->listInvoices();

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->data)->toHaveCount(2)
        ->and($response->data[0])->toBe(['id' => 1, 'client_id' => 1001, 'date' => '2025-03-08']);
});

it('fetches a single invoice successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/invoices/1' => Http::response([
            'result' => true,
            'data'   => ['Invoice' => ['id' => 1, 'client_id' => 1001, 'date' => '2025-03-08']],
        ], 200),
    ]);

    $response = $this->client->showInvoice(1);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->data)->toBe(['id' => 1, 'client_id' => 1001, 'date' => '2025-03-08']);
});

it('creates an invoice successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/invoices' => Http::response([
            'result' => true,
            'id'     => 123,
        ], 201),
    ]);

    $invoicePayload = new InvoicePayload(
        clientId: 1001,
        items: [],
        date: '2025-03-08'
    );

    $response = $this->client->createInvoice($invoicePayload);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->id)->toBe(123);
});

it('pays an invoice successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/invoice_payments' => Http::response([
            'result' => true,
            'id'     => 456,
        ], 201),
    ]);

    $invoicePaymentPayload = new InvoicePaymentPayload(
        invoiceId: 123,
        amount: 500.00,
        paymentMethod: 'Credit Card',
        timestamp: now()->toDateTimeString()
    );

    $response = $this->client->payInvoice($invoicePaymentPayload);

    expect($response)
        ->toBeInstanceOf(DaftraResponse::class)
        ->and($response->id)->toBe(456);
});

it('creates and pays an invoice successfully', function () {
    Http::fake([
        'https://fake-api.com/api2/invoices' => Http::response([
            'result' => true,
            'id'     => 789,
        ], 201),
        'https://fake-api.com/api2/invoice_payments' => Http::response([
            'result' => true,
            'id'     => 999,
        ], 201),
    ]);

    $invoicePayload = new InvoicePayload(
        clientId: 1001,
        items: [],
        date: '2025-03-08'
    );

    $response = $this->client->createAndPayInvoice($invoicePayload, 500.00, 'Credit Card');

    expect($response)
        ->toHaveKeys(['invoice', 'payment'])
        ->and($response['invoice'])->toBeInstanceOf(DaftraResponse::class)
        ->and($response['invoice']->id)->toBe(789)
        ->and($response['payment'])->toBeInstanceOf(DaftraResponse::class)
        ->and($response['payment']->id)->toBe(999);
});
