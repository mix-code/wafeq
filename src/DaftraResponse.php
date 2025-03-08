<?php

namespace MixCode\DaftraClient;

use Illuminate\Contracts\Support\Arrayable;

class DaftraResponse implements Arrayable
{
    private array $extra; // Not accessible by child classes

    public function __construct(
        public string $result,
        public int $code,
        public ?string $message = null,
        public array $validationErrors = [],
        public ?int $id = null,
        public array $data = [],
        public array $pagination = [],
        array $extra = [] // Capture additional keys
    ) {
        $this->extra = $extra;
    }

    public function toArray(): array
    {
        return array_merge([
            'result'            => $this->result,
            'code'              => $this->code,
            'id'                => $this->id,
            'message'           => $this->message,
            'validation_errors' => $this->validationErrors,
            'data'              => $this->data,
            'pagination'        => $this->pagination,
        ], $this->extra);
    }
}
