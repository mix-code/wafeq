<?php

namespace MixCode\DaftraClient\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class InvoiceItemPayload implements Arrayable
{
    public function __construct(
        public int $productId,
        public float $price,
        public int $quantity = 1,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'unit_price' => $this->price,
            'quantity'   => $this->quantity,
            ...$this->additional,
        ];
    }
}
