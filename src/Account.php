<?php
namespace MixCode\Wafeq;

use Illuminate\Support\Collection;
use MixCode\Wafeq\WafeqBase;
use Illuminate\Support\Facades\Http;

class Account extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all accounts.
     *
     * @return WafeqResponse
     */
    public function list(): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/accounts/", [
                'include_system' => true,
            ])
            ->json();


        return $this->formatResponse($res);
    }

    /**
     * List all accounts as a tree.
     *
     * @return Collection
     */
    public function listAsTree() : Collection
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
     * @param Collection $items
     * @param int|null $parentId
     * @return Collection
     */
    protected function buildTree(Collection $items, $parentId = null): Collection
    {
        return $items
            ->where('parent', $parentId)
            ->sortBy('account_code')
            ->map(function ($item) use ($items) {
                $children = $this->buildTree($items, $item['id']);
                
                if($children->isEmpty()) {
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