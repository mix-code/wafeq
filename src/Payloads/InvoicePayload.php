<?php

namespace MixCode\DaftraClient\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class InvoicePayload implements Arrayable
{
    public function __construct(
        public int $clientId,
        public array $items,
        public string $date,
        public array $additional = [],
    ) {
        // Ensure all items are instances of InvoiceItemPayload
        foreach ($this->items as $item) {
            if (!$item instanceof InvoiceItemPayload) {
                throw new \InvalidArgumentException('Each item must be an instance of InvoiceItemPayload');
            }
        }
    }

    public function toArray(): array
    {
        return [
            'client_id' => $this->clientId,
            'date'      => $this->date,
            'items'     => collect($this->items)->map(fn (InvoiceItemPayload $item) => $item->toArray())->toArray(),
            ...$this->additional,
        ];
    }
}
