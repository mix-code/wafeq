<?php

namespace MixCode\Wafeq\Payloads;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
class ProjectPayload implements Arrayable
{
    public function __construct(
        public string $name,
    ) {}

    public function toArray(): array
    {
        return [
            'name'        => $this->name,
        ];
    }
}
