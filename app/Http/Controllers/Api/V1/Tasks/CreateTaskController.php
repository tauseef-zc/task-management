<?php

namespace App\Http\Controllers\Api\V1\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Tasks\CreateTaskRequest;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskService;

class CreateTaskController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ITaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateTaskRequest $request)
    {
        list($data, $statusCode) = $this->service->create($request->validated());
        return response()->json($data, $statusCode);
    }
}
