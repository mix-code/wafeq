<?php

namespace MixCode\Wafeq\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class InvoicePayload implements Arrayable
{
    public function __construct(
        public string $contact,
        public string $currency,
        public string $invoiceDate,
        public ?string $invoiceDueDate = null,
        public string $invoiceNumber,
        public array $lineItems,
        public ?string $reference = null,
        public ?string $project = null,
        public ?string $notes = null,
        public ?string $status = 'DRAFT',
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'invoice_number'      => $this->invoiceNumber,
            'invoice_date'        => $this->invoiceDate,
            'currency'            => $this->currency,
            'invoice_due_date'=> $this->invoiceDueDate,
            'contact'             => $this->contact,
            'project'             => $this->project,
            'line_items'          => array_map(
                fn (InvoiceLineItemPayload $item) => $item->toArray(),
                $this->lineItems
            ),
            'reference'           => $this->reference,
            'notes'               => $this->notes,
            'status'               => $this->status,
            ...$this->additional,
        ], fn ($value) => !is_null($value));
    }
}
