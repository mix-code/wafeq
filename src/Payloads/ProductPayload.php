<?php

namespace MixCode\DaftraClient\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class ProductPayload implements Arrayable
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
        public bool $isProduct = false,
        public bool $isService = false,
        public bool $isBundle = false,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'unit_price'  => $this->price,
            'type'        => $this->type(),
            ...$this->additional,
        ];
    }

    protected function type(): ?int
    {
        if ($this->isProduct) {
            return 1;
        } elseif ($this->isService) {
            return 2;
        } elseif ($this->isBundle) {
            return 3;
        } else {
            return null;
        }
    }
}
