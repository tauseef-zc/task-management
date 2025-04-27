<?php

namespace App\Http\Controllers\Api\V1\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\V1\Interfaces\ServiceInterface;
use App\Services\V1\Interfaces\Tasks\ITaskService;

class TaskAttachmentController extends Controller
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
    public function __invoke(Task $task)
    {
        $data = request()->validate([
            'attachments' => 'required|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        list($data, $statusCode) = $this->service->uploadAttachments($task, $data);
        return response()->json($data, $statusCode);
    }
}