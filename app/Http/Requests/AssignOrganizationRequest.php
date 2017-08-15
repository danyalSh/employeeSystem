<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignOrganizationRequest extends FormRequest
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
            'org_id' => 'required'
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
            'org_id.required' => 'Please select at least one organization',
        ];
    }
}
