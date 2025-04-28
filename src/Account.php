<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Collection;

class Account extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all accounts.
     */
    public function list(): WafeqResponse
    {
        return $this->send('get', "{$this->endpoint}/{$this->apiPrefix}/accounts/", [
            'include_system' => true,
        ]);
    }

    /**
     * List all accounts as a tree.
     */
    public function listAsTree(): Collection
    {
        return $this->buildTree(collect($this->list()->data));
    }

    /**
     * Build a tree of the accounts.
     *
     * This method takes a collection of the accounts and
     * returns the same collection but sorted and nested
     * in a tree structure.
     *
     * @param  int|null  $parentId
     */
    protected function buildTree(Collection $items, $parentId = null): Collection
    {
        return $items
            ->where('parent', $parentId)
            ->sortBy('account_code')
            ->map(function ($item) use ($items) {
                $children = $this->buildTree($items, $item['id']);

                if ($children->isEmpty()) {
                    return $item;
                }

                return [
                    ...$item,
                    'children' => $children->values(),
                ];
            })
            ->values();
    }
}
