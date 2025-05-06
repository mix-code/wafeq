<?php

namespace MixCode\Wafeq\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class InvoiceLineItemPayload implements Arrayable
{
    public function __construct(
        public string $account,
        public string $description,
        public float $quantity,
        public float $unitAmount,
        public ?string $item = null,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'account'     => $this->account,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'unit_amount' => $this->unitAmount,
            'item'        => $this->item,
            ...$this->additional,
        ], fn ($value) => !is_null($value));
    }
}
