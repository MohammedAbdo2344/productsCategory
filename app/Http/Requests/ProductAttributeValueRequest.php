<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeValueRequest extends FormRequest
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
            'id',
            'product_id',
            'value'=>['required','unique:product_attribute_values,value','min:3', 'max:100'],
        ];
    }
    public function  messages(): array
    {
        return [
            'value.required' => "The :attribute field is Required",
            'value.unique'   => "This :attribute has already been taken.",
        ];
    }
}
