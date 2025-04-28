<?php

namespace MixCode\Wafeq;

use MixCode\Wafeq\Payloads\ManualJournalPayload;

class ManualJournal extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new manual journal.
     */
    public function create(ManualJournalPayload $manualJournalPayload): WafeqResponse
    {
        return $this->send('post', "{$this->endpoint}/{$this->apiPrefix}/manual-journals/", $manualJournalPayload->toArray());
    }
}
