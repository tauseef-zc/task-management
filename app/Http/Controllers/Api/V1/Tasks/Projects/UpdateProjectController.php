<?php

namespace App\Http\Controllers\Api\V1\Tasks\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Tasks\Projects\UpdateProjectRequest;
use App\Models\Project;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\IProjectService;

class UpdateProjectController extends Controller
{
    private ServiceInterface $service;

    public function __construct(IProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     *
     * @param  UpdateProjectRequest  $request
     * @param  Project  $project
     * @return Response
     */
    public function __invoke(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        list($data, $statusCode) = $this->service->update($project, $data);

        return response()->json($data, $statusCode);
    }
}