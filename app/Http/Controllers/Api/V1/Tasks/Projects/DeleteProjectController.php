<?php

namespace App\Http\Controllers\Api\V1\Tasks\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Response;

class DeleteProjectController extends Controller
{    
    /**
     * handle the incoming delete request.
     *
     * @param  Project $project
     * @return void
     */
    public function __invoke(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ], Response::HTTP_ACCEPTED);   
    }
}