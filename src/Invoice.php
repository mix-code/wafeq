<?php

namespace MixCode\Wafeq;

use MixCode\Wafeq\Payloads\InvoicePayload;

class Invoice extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new invoice.
     */
    public function create(InvoicePayload $invoicePayload): WafeqResponse
    {
        return $this->send('post', "{$this->endpoint}/{$this->apiPrefix}/invoices/", $invoicePayload->toArray());
    }
}
