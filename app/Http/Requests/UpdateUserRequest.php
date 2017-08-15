<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'employee_fname2' => 'required',
            'employee_lname2' => 'required',
            'employee_username2' => 'required',
            'employee_email2' => 'required',
            'employee_password2' => 'required | min:6',
//            'employee_role' => 'required',
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
            'employee_fname2.required' => 'First name is required',
            'employee_lname2.required' => 'Last name is required',
            'employee_username2.required' => 'Username is required',
            'employee_email2.required' => 'Email is required',
            'password2.required' => 'Please enter password',
//            'employee_role.required' => 'Please select at least one role',
        ];
    }
}
