<?php

namespace MixCode\DaftraClient;

use Illuminate\Support\Facades\Http;
use MixCode\DaftraClient\Payloads\ClientPayload;
use MixCode\DaftraClient\Payloads\InvoicePayload;
use MixCode\DaftraClient\Payloads\InvoicePaymentPayload;
use MixCode\DaftraClient\Payloads\ProductPayload;

class DaftraClient
{
    protected ?string $endpoint;

    protected ?string $apiKey;

    protected ?string $apiPrefix;

    public function __construct()
    {
        $this->endpoint = config('daftra-client.endpoint');
        $this->apiKey = config('daftra-client.api_key');
        $this->apiPrefix = 'api2';
    }

    /** Clients API Methods */
    public function listClients(): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/clients")
            ->json();

        return $this->formatResponse($res, [
            'data' => collect($res['data'] ?? [])->pluck('Client')->toArray(),
        ]);
    }

    public function showClient($clientId): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/clients/{$clientId}")
            ->json();

        return $this->formatResponse($res, [
            'data' => collect($res['data'] ?? [])->get('Client') ?? [],
        ]);
    }

    public function createClient(ClientPayload $clientPayload): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->post("{$this->endpoint}/{$this->apiPrefix}/clients", ['Client' => $clientPayload->toArray()])
            ->json();

        return $this->formatResponse($res, [
            'id' => $res['id'] ?? null,
        ]);
    }

    public function updateClient(ClientPayload $clientPayload, $clientId): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->put("{$this->endpoint}/{$this->apiPrefix}/clients/{$clientId}", ['Client' => $clientPayload->toArray()])
            ->json();

        return $this->formatResponse($res);
    }

    public function deleteClient($clientId): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->delete("{$this->endpoint}/{$this->apiPrefix}/clients/{$clientId}")
            ->json();

        return $this->formatResponse($res);
    }

    /** Products API Methods */
    public function listProducts(): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/products")
            ->json();

        return $this->formatResponse($res, [
            'data' => collect($res['data'] ?? [])->pluck('Product')->toArray(),
        ]);
    }

    public function showProduct($productId): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/products/{$productId}")
            ->json();

        return $this->formatResponse($res, [
            'data' => collect($res['data'] ?? [])->get('Product') ?? [],
        ]);
    }

    public function createProduct(ProductPayload $productPayload): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->post("{$this->endpoint}/{$this->apiPrefix}/products", ['Product' => $productPayload->toArray()])
            ->json();

        return $this->formatResponse($res, [
            'id' => $res['id'] ?? null,
        ]);
    }

    public function updateProduct(ProductPayload $productPayload, $productId): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->put("{$this->endpoint}/{$this->apiPrefix}/products/{$productId}", ['Product' => $productPayload->toArray()])
            ->json();

        return $this->formatResponse($res);
    }

    public function deleteProduct($productId): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->delete("{$this->endpoint}/{$this->apiPrefix}/products/{$productId}")
            ->json();

        return $this->formatResponse($res);
    }

    /** Invoices API Methods */
    public function listInvoices(): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/invoices")
            ->json();

        return $this->formatResponse($res, [
            'data' => collect($res['data'] ?? [])->pluck('Invoice')->toArray(),
        ]);
    }

    public function showInvoice($invoiceId): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/invoices/{$invoiceId}")
            ->json();

        return $this->formatResponse($res, [
            'data' => collect($res['data'] ?? [])->get('Invoice') ?? [],
        ]);
    }

    public function createInvoice(InvoicePayload $invoicePayload): DaftraResponse
    {
        $payload = $invoicePayload->toArray();

        $items = $payload['items'];

        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->post("{$this->endpoint}/{$this->apiPrefix}/invoices", ['Invoice' => $payload, 'InvoiceItem' => $items])
            ->json();

        return $this->formatResponse($res, [
            'id' => $res['id'] ?? null,
        ]);
    }

    public function payInvoice(InvoicePaymentPayload $invoicePaymentPayload): DaftraResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->post("{$this->endpoint}/{$this->apiPrefix}/invoice_payments", ['InvoicePayment' => $invoicePaymentPayload->toArray()])
            ->json();

        return $this->formatResponse($res, [
            'id' => $res['id'] ?? null,
        ]);
    }

    public function createAndPayInvoice(InvoicePayload $invoicePayload, float $amount, string $paymentMethod): array
    {
        // Step 1: Create the invoice
        $invoiceResponse = $this->createInvoice($invoicePayload);

        if (!$invoiceResponse->id) {
            throw new \Exception('Invoice creation failed. Cannot proceed with payment.');
        }

        // Step 2: Initialize InvoicePaymentPayload with the generated invoice ID
        $invoicePaymentPayload = new InvoicePaymentPayload(
            invoiceId: $invoiceResponse->id,
            amount: $amount,
            paymentMethod: $paymentMethod,
            timestamp: now()->toDateTimeString()
        );

        // Step 3: Pay the invoice
        $paymentResponse = $this->payInvoice($invoicePaymentPayload);

        return [
            'invoice' => $invoiceResponse,
            'payment' => $paymentResponse,
        ];
    }

    /** Private Helpers */
    protected function headers(): array
    {
        return [
            'APIKEY' => $this->apiKey,
        ];
    }

    protected function formatResponse(array $res, array $overrides = []): DaftraResponse
    {
        $responseData = array_merge([
            'result'           => $res['result'] ?? false,
            'code'             => $res['code'] ?? 500,
            'message'          => $res['message'] ?? null,
            'validationErrors' => $res['validation_errors'] ?? [],
            'data'             => $res['data'] ?? [],
            'pagination'       => $res['pagination'] ?? [],
            'extra'            => array_diff_key($res, array_flip(['result', 'code', 'message', 'validation_errors', 'data', 'pagination'])),
        ], $overrides); // Merge overrides before passing

        return new DaftraResponse(...$responseData);
    }
}
