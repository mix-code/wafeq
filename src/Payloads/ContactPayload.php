<?php

namespace MixCode\Wafeq\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class ContactPayload implements Arrayable
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $phone = null,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return [
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            ...$this->additional,
        ];
    }
}
