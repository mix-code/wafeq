<?php

namespace MixCode\Wafeq;

use MixCode\Wafeq\Payloads\ProjectPayload;

class Project extends WafeqBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List all projects.
     */
    public function list(): WafeqResponse
    {
        return $this->send('get', "{$this->endpoint}/{$this->apiPrefix}/projects/");
    }

    /**
     * Create a new project.
     *
     * @param  ProjectPayload  $projectPayload  The payload containing project details.
     * @return WafeqResponse The response containing the created project's ID and status code.
     */
    public function create(ProjectPayload $projectPayload): WafeqResponse
    {
        return $this->send('post', "{$this->endpoint}/{$this->apiPrefix}/projects/", $projectPayload->toArray());
    }

    /**
     * Update a project.
     *
     * @param  ProjectPayload  $projectPayload  The payload containing project details.
     * @param  int  $projectId  The ID of the project to be updated.
     * @return WafeqResponse The response containing the updated project's ID and status code.
     */
    public function update(ProjectPayload $projectPayload, $projectId): WafeqResponse
    {
        return $this->send('put', "{$this->endpoint}/{$this->apiPrefix}/projects/{$projectId}/", $projectPayload->toArray());
    }

    /**
     * Retrieve a project by its ID.
     *
     * @param  int  $projectId  The ID of the project to be retrieved.
     * @return WafeqResponse The response containing the project's data and status code.
     */
    public function show($projectId): WafeqResponse
    {
        return $this->send('get', "{$this->endpoint}/{$this->apiPrefix}/projects/{$projectId}/");
    }

    /**
     * Delete a project.
     *
     * @param  int  $projectId  The ID of the project to be deleted.
     * @return WafeqResponse The response containing the deleted project's ID and status code.
     */
    public function delete($projectId): WafeqResponse
    {
        return $this->send('delete', "{$this->endpoint}/{$this->apiPrefix}/projects/{$projectId}/");
    }
}
