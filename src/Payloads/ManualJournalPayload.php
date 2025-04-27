<?php

namespace MixCode\Wafeq\Payloads;

use Illuminate\Contracts\Support\Arrayable;
use MixCode\Wafeq\Payloads\ManualJournalLineItemPayload;
/** @implements Arrayable<string, mixed> */
class ManualJournalPayload implements Arrayable
{
    /**
     * @param string $date
     * @param array $lineItems
     * @param string|null $reference
     * @param string|null $notes
     * @param array $additional
     */
    public function __construct(
        public string $date,
        public array $lineItems,
        public ?string $reference = null,
        public ?string $notes = null,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'date' => $this->date,
            'reference' => $this->reference,
            'notes' => $this->notes,
            'line_items' => array_map(
                fn (ManualJournalLineItemPayload $item) => $item->toArray(),
                $this->lineItems
            ),
        ], fn ($value) => !is_null($value));
    }
}
