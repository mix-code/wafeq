<?php

namespace MixCode\Wafeq;

use MixCode\Wafeq\WafeqBase;
use Illuminate\Support\Facades\Http;
use MixCode\Wafeq\Payloads\ProjectPayload;

class Project extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List all projects.
     *
     * @return WafeqResponse
     */
    public function list(): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/projects/");

        return $this->formatResponse($res->json(), [
            'code' => $res->status(),
        ]);
    }

    /**
     * Create a new project.
     *
     * @param ProjectPayload $projectPayload The payload containing project details.
     * @return WafeqResponse The response containing the created project's ID and status code.
     */

    public function create(ProjectPayload $projectPayload): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->post("{$this->endpoint}/{$this->apiPrefix}/projects/", $projectPayload->toArray());
            ;

        return $this->formatResponse($res->json(), [
            'id' => $res['id'] ?? null,
            'code' => $res->status(),
        ]);
    }

    /**
     * Update a project.
     *
     * @param ProjectPayload $projectPayload The payload containing project details.
     * @param int $projectId The ID of the project to be updated.
     * @return WafeqResponse The response containing the updated project's ID and status code.
     */
    public function update(ProjectPayload $projectPayload, $projectId): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->put("{$this->endpoint}/{$this->apiPrefix}/projects/{$projectId}/", $projectPayload->toArray());

        return $this->formatResponse($res->json(), [
            'id'   => $projectId,
            'code' => $res->status(),
        ]);
    }

    /**
     * Retrieve a project by its ID.
     *
     * @param int $projectId The ID of the project to be retrieved.
     * @return WafeqResponse The response containing the project's data and status code.
     */
    public function show($projectId): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->get("{$this->endpoint}/{$this->apiPrefix}/projects/{$projectId}/");

        return $this->formatResponse([], [
            'data'   => $res->json(),
            'id'   => $projectId,
            'code' => $res->status(),
        ]);
    }

    /**
     * Delete a project.
     *
     * @param int $projectId The ID of the project to be deleted.
     * @return WafeqResponse The response containing the deleted project's ID and status code.
     */
    public function delete($projectId): WafeqResponse
    {
        $res = Http::asJson()
            ->withHeaders($this->headers())
            ->delete("{$this->endpoint}/{$this->apiPrefix}/projects/{$projectId}/");

        return $this->formatResponse([], [
            'id'   => $projectId,
            'code' => $res->status(),
        ]);
    }
}
