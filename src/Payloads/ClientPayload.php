<?php

namespace MixCode\DaftraClient\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class ClientPayload implements Arrayable
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $businessName,
        public string $email,
        public string $phone,
        public string $password,
        public string $category = 'customers',
        public float $startingBalance = 0,
        public bool $individual = true,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return [
            'first_name'       => $this->firstName,
            'last_name'        => $this->lastName,
            'business_name'    => $this->businessName,
            'email'            => $this->email,
            'phone1'           => $this->phone,
            'password'         => $this->password,
            'category'         => $this->category,
            'starting_balance' => $this->startingBalance,
            'type'             => $this->individual ? 2 : 3,
            ...$this->additional,
        ];
    }
}
