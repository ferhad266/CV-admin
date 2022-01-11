<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
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
            'date' => 'required|max:255',
            'task_name' => 'required|max:255',
            'company_name' => 'required|max:255'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Please, Work date is required',
            'date.max' => 'Please, date max is 255 character',
            'task_name.required' => 'Please, task name is required',
            'task_name.max' => 'Please, task name is max 255 character',
            'company_name.required' => 'Please, company name is required',
            'company_name.max' => 'Please, company name is max 255 character ',
        ];
    }
}
