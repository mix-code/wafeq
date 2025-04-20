<?php

namespace MixCode\Wafeq;

use MixCode\Wafeq\WafeqBase;
use Illuminate\Support\Facades\Http;
use MixCode\Wafeq\Payloads\ContactPayload;

class Contact extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List all contacts.
     *
     * @return WafeqResponse
     */
    public function list(): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/contacts/");

        return $this->formatResponse($res->json(), [
            'code' => $res->status(),
        ]);
    }

    /**
     * Create a new contact.
     *
     * @param ContactPayload $contactPayload
     * @return WafeqResponse
     */
    public function create(ContactPayload $contactPayload): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->post("{$this->endpoint}/{$this->apiPrefix}/contacts/", $contactPayload->toArray());

        return $this->formatResponse($res->json(), [
            'id'   => $res->json()['id'] ?? null,
            'code' => $res->status(),
        ]);
    }

    /**
     * Update an existing contact.
     *
     * @param ContactPayload $contactPayload
     * @param string|int $contactId
     * @return WafeqResponse
     */
    public function update(ContactPayload $contactPayload, $contactId): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->put("{$this->endpoint}/{$this->apiPrefix}/contacts/{$contactId}/", $contactPayload->toArray());

        return $this->formatResponse($res->json(), [
            'id'   => $contactId,
            'code' => $res->status(),
        ]);
    }

    /**
     * Show a single contact.
     *
     * @param string|int $contactId
     * @return WafeqResponse
     */
    public function show($contactId): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/contacts/{$contactId}/");

        return $this->formatResponse($res->json(), [
            'id'   => $contactId,
            'code' => $res->status(),
        ]);
    }

    /**
     * Delete a contact.
     *
     * @param string|int $contactId
     * @return WafeqResponse
     */
    public function delete($contactId): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->delete("{$this->endpoint}/{$this->apiPrefix}/contacts/{$contactId}/");

        return $this->formatResponse([], [
            'id'   => $contactId,
            'code' => $res->status(),
        ]);
    }
}
