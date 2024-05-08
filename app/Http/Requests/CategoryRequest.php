<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required',"unique:categories,name", 'min:3', 'max:10'],
            'description' => ['nullable','min:5']
        ];
    }
    public function  messages(): array
    {
        return [
            'name.required' => "The :attribute field is Required",
            'name.min' => "The name must be at least :min characters.",
            'name.max' => "The name may not be greater than :max characters.",
            'name.unique'=>"This Category has already been recorded",
            'description.min' => "The description must be at least :min characters.",
        ];
    }
}
