<?php

namespace MixCode\Wafeq;

use Illuminate\Contracts\Support\Arrayable;

class WafeqResponse implements Arrayable
{
    private array $extra; // Not accessible by child classes

    public function __construct(
        public int $code,
        public ?string $message = null,
        public array $validationErrors = [],
        public ?string $id = null,
        public ?string $next = null,
        public ?string $previous = null,
        public array $data = [],
        array $extra = [] // Capture additional keys
    ) {
        $this->extra = $extra;
    }

    public function toArray(): array
    {
        return array_merge([
            'next'              => $this->next,
            'previous'          => $this->previous,
            'code'              => $this->code,
            'id'                => $this->id,
            'message'           => $this->message,
            'validation_errors' => $this->validationErrors,
            'data'              => $this->data,
        ], $this->extra);
    }
}
