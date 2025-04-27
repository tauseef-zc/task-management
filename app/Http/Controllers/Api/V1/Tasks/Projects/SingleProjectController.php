<?php

namespace App\Http\Controllers\Api\V1\Tasks\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Tasks\ProjectResource;
use App\Models\Project;

class SingleProjectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Project $project)
    {
        return ProjectResource::make($project);
    }

}