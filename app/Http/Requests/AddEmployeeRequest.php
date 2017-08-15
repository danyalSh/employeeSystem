<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployeeRequest extends FormRequest
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
            'employee_fname' => 'required',
            'employee_lname' => 'required',
            'employee_username' => 'required | unique:users,username',
            'employee_email' => 'required | unique:users,email',
            'employee_password' => 'required | min:6',
            'employee_designation' => 'required',
            'employee_role' => 'required',
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
            'employee_fname.required' => 'First name is required',
            'employee_lname.required' => 'Last name is required',
            'employee_username.required' => 'Username is required',
            'employee_username.unique' => 'Username is already exists',
            'employee_email.required' => 'Email is required',
            'employee_email.unique' => 'Email is already exists',
            'password.required' => 'Please enter password',
            'employee_designation.required' => 'Please select a designation',
            'employee_role.required' => 'Please select at least one role',
        ];
    }
}
