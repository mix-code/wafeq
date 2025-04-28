<?php

namespace MixCode\Wafeq;

use MixCode\Wafeq\Payloads\ContactPayload;

class Contact extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List all contacts.
     */
    public function list(): WafeqResponse
    {
        return $this->send('get', "{$this->endpoint}/{$this->apiPrefix}/contacts/");
    }

    /**
     * Create a new contact.
     */
    public function create(ContactPayload $contactPayload): WafeqResponse
    {
        return $this->send('post', "{$this->endpoint}/{$this->apiPrefix}/contacts/", $contactPayload->toArray());
    }

    /**
     * Update an existing contact.
     *
     * @param  string|int  $contactId
     */
    public function update(ContactPayload $contactPayload, $contactId): WafeqResponse
    {
        return $this->send('put', "{$this->endpoint}/{$this->apiPrefix}/contacts/{$contactId}/", $contactPayload->toArray());
    }

    /**
     * Show a single contact.
     *
     * @param  string|int  $contactId
     */
    public function show($contactId): WafeqResponse
    {
        return $this->send('get', "{$this->endpoint}/{$this->apiPrefix}/contacts/{$contactId}/");
    }

    /**
     * Delete a contact.
     *
     * @param  string|int  $contactId
     */
    public function delete($contactId): WafeqResponse
    {
        return $this->send('delete', "{$this->endpoint}/{$this->apiPrefix}/contacts/{$contactId}/");
    }
}
