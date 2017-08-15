<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRoleRequest extends FormRequest
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
            'role_name' => 'required | unique:roles,name'
        ];
    }

    /**
     * Get the validation messages that will show on the page.
     *
     * @return array
     */
    public function messages()
    {

        return [
            'role_name.required' => 'This field is required!',
            'role_name.unique' => 'This role already exists!',
        ];
    }
}
