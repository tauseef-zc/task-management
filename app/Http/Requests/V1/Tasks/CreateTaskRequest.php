<?php

namespace App\Http\Requests\V1\Tasks;

use App\Enums\TaskPriorityEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'description' => ['sometimes', 'nullable', 'string', 'max:500'],
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'parent_id' => ['sometimes', 'nullable', 'integer', 'exists:tasks,id'],
            'assigned_to' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'status_id' => ['sometimes', 'integer', 'exists:task_statuses,id'],
            'due_date'  => ['sometimes', 'nullable', 'date'],
            'priority'  => ['sometimes', 'nullable', 'string', 'in:' . implode(',', TaskPriorityEnum::getValues())],
            'progress'  => ['sometimes', 'nullable', 'integer', 'min:0', 'max:100'],
            'estimated_time'    => ['sometimes', 'nullable', 'integer', 'min:0'],
            'spent_time'    => ['sometimes', 'nullable', 'integer', 'min:0'],            
        ]; 
    }
}