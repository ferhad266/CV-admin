<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
            'title' => 'required|max:255|min:2',
            'tags' => 'required|max:255|min:2',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title must not be empty',
            'title.max' => 'title length is not big then 255',
            'title.min' => 'title length is not less then 2',
            'tags.required' => 'Title must not be empty',
            'tags.max' => 'title length is not big than 255',
            'tags.min' => 'title length is not less then 2',
            'images.*.mimes' => 'This type is valid: jpg, jpeg, png',
            'images.*.max' => 'File size is not big than 2048'
        ];
    }
}
