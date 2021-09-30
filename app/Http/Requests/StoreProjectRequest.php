<?php

namespace App\Http\Requests;

use App\Enums\ProjectType;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
        $types = implode(',', ProjectType::getValues());
        return [
            'id' => 'nullable|exists:projects,uuid',
            'title' => 'required',
            'description' => 'nullable',
            'project_status_id' => 'required|exists:project_statuses,uuid',
            'type' => 'required|in:'.$types,
            'fields' => 'nullable|array'
        ];
    }
}
