<?php

namespace App\Http\Controllers\Api\V1\Tasks\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Tasks\Projects\CreateProjectRequest;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\IProjectService;

class CreateProjectController extends Controller
{
    private ServiceInterface $service;

    public function __construct(IProjectService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the incoming request.
     *
     * @param  CreateProjectRequest  $request
     * @return Response
     */
    public function __invoke(CreateProjectRequest $request)
    {
        $data = $request->validated();
        list($data, $statusCode) = $this->service->create($data);

        return response()->json($data, $statusCode);
    }
}