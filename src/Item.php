<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Collection;

class Item extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all items.
     */
    public function list(): WafeqResponse
    {
        return $this->send('get', "{$this->endpoint}/{$this->apiPrefix}/items/");
    }
}
