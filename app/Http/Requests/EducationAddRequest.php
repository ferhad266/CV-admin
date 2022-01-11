<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationAddRequest extends FormRequest
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
            "education_date" => "required|max:255",
            "university_name" => "required|max:255",
            "university_faculty" => "required|max:255",
            "university_degree" => "required|max:255"
        ];
    }

    public function messages()
    {
        return [
            'education_date.required' => 'Education Date is empty',
            'education_date.max' => 'Education Dates\'s max equal to 255',
            'university_name.required' => 'University name is empty',
            'university_name.max' => 'University name\'s max equal to 255',
            'university_faculty.required' => 'University faculty is empty',
            'university_faculty.max' => 'University faculty\'s max equal to 255',
            'university_degree.required' => 'University degree is empty',
            'university_degree.max' => 'University degree\'s max equal to 255',
        ];
    }
}
