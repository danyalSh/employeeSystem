<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTaskRequest extends FormRequest
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
            'task_project' => 'required',
            'task_title' => 'required',
            'task_desc' => 'required',
            'task_status' => 'required'
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
            'task_project.required' => 'Please select a project',
            'task_title.required' => 'Enter a title for this task',
            'task_desc.required' => 'Enter description for this task',
            'task_status.required' => 'Please select a status for this task',
        ];
    }
}
