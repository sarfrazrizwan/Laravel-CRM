<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        $userTypes = UserType::getValues();
        unset($userTypes[UserType::SUPER_ADMIN]);
        $userTypes = implode(',', $userTypes);

        return [
            'id' => 'nullable|exists:users,uuid',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->id,'uuid')],
            'postal_code' => 'required',
            'town' => 'required',
            'password' => 'nullable|required_without:id|min:8',
            'company_id' => 'required|exists:companies,uuid',
            'user_type' => ['required', "in:$userTypes"]
        ];
    }
}
