<?php

namespace App\Http\Requests;

use App\Helpers\DateTimeHelper;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable|exists:tasks,uuid',
            'title' => 'required',
            'description' => 'nullable',
            'task_status_id' => 'required|exists:task_statuses,uuid',
            'deadline' => 'nullable|date_format:d-m-Y H:i',
        ];
    }
}
