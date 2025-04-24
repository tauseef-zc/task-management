<?php

namespace App\Http\Requests\V1\Tasks\Statuses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest 
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'color' => ['sometimes', 'string', 'max:7'],
            'icon' => ['sometimes', 'file', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }
}