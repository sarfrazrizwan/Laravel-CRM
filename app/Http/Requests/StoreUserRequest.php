<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\UserType;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return auth()->user()->isCompanyAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roles = [UserType::USER, UserType::SUPERVISOR];
        $roles = implode(',', $roles);
        return [
            'id' => 'nullable|exists:users,uuid',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->id,'uuid')],
            'postal_code' => 'required',
            'town' => 'required',
            'password' => 'nullable|required_without:id|min:8',
            'company_group_ids' => 'nullable|array',
            'user_type' => ['required', 'in:'.$roles]

        ];
    }
}
