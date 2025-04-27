<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Facades\Http;
use MixCode\Wafeq\WafeqBase;
use MixCode\Wafeq\Payloads\ManualJournalPayload;

class ManualJournal extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new manual journal.
     *
     * @param ManualJournalPayload $manualJournalPayload
     * @return WafeqResponse
     */
    public function create(ManualJournalPayload $manualJournalPayload): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->post("{$this->endpoint}/{$this->apiPrefix}/manual-journals/", $manualJournalPayload->toArray());

        return $this->formatResponse($res->json(), [
            'id'   => $res->json()['id'] ?? null,
            'code' => $res->status(),
        ]);
    }
}
