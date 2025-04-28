<?php

namespace MixCode\Wafeq\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class ManualJournalLineItemPayload implements Arrayable
{
    public function __construct(
        public string $account,
        public float $amount,
        public float $amountToBcy,
        public string $currency,
        public string $description,
        public ?string $branch = null,
        public ?string $contact = null,
        public ?string $costCenter = null,
        public ?float $exchangeRate = null,
        public ?string $placeOfSupply = null,
        public ?string $project = null,
        public ?float $taxAmount = null,
        public ?string $taxRate = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'account'         => $this->account,
            'amount'          => $this->amount,
            'amount_to_bcy'   => $this->amountToBcy,
            'currency'        => $this->currency,
            'description'     => $this->description,
            'branch'          => $this->branch,
            'contact'         => $this->contact,
            'cost_center'     => $this->costCenter,
            'exchange_rate'   => $this->exchangeRate,
            'place_of_supply' => $this->placeOfSupply,
            'project'         => $this->project,
            'tax_amount'      => $this->taxAmount,
            'tax_rate'        => $this->taxRate,
        ], fn ($value) => !is_null($value)); // Remove nulls
    }
}
