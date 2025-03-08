<?php

namespace MixCode\DaftraClient\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class InvoicePaymentPayload implements Arrayable
{
    public function __construct(
        public int $invoiceId,
        public string $paymentMethod,
        public float $amount,
        public string $timestamp,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return [
            'invoice_id'     => $this->invoiceId,
            'payment_method' => $this->paymentMethod,
            'amount'         => $this->amount,
            'date'           => $this->timestamp,
            ...$this->additional,
        ];
    }
}
