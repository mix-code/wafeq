<?php

namespace MixCode\Wafeq\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class ProjectPayload implements Arrayable
{
    public function __construct(
        public string $name,
        public array $additional = [],
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            ...$this->additional,
        ];
    }
}
