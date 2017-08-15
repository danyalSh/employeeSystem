<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProjectRequest extends FormRequest
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
            'project_title' => 'required',
            'project_desc' => 'required',
            'project_org' => 'required',
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
            'project_title.required' => 'Project Title is required',
            'project_desc.required' => 'Project Description is required',
            'project_org.required' => 'Project must belong to an Organization',
        ];
    }
}
