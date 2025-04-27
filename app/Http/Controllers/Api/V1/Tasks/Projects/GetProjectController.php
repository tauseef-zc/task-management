<?php

namespace App\Http\Controllers\Api\V1\Tasks\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Tasks\ProjectResource;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\IProjectService;

class GetProjectController extends Controller
{
    private ServiceInterface $service;

    public function __construct(IProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
       $projects = $this->service->getProjects();
       return ProjectResource::collection($projects);
    }
}