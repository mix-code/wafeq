<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Collection;

class TaxRate extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all tax rates.
     */
    public function list(): WafeqResponse
    {
        return $this->send('get', "{$this->endpoint}/{$this->apiPrefix}/tax-rates/");
    }

    /**
     * List all tax rates as a tree.
     */
    public function listAsTree(): Collection
    {
        return collect($this->list()->data)
            ->map(fn($item) => [
                'id' => $item['id'],
                'description' => $item['description'] . ' (' . ($item['rate'] * 100) . '%)',
                'tax_type' => str($item['tax_type'])->lower()->toString(),
            ])
            ->groupBy('tax_type')
            ->mapWithKeys(fn($items, $key) => [$key => $items->pluck('description', 'id')]);
    }
}
