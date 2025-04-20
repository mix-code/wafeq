<?php
namespace MixCode\Wafeq;

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
            ->get("{$this->endpoint}/{$this->apiPrefix}/accounts/")
            ->json();


        return $this->formatResponse($res);
    }
}