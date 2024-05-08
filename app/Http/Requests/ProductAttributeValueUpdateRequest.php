<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeValueUpdateRequest extends FormRequest
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
            'id'=>['required','exists:product_attribute_values,id'],
            'value'=>['required','min:3', 'max:100'],
        ];
    }
    public function  messages(): array
    {
        return [
            'id.required'=>"The id field is Required",
            'id.exists'=>"Cannot Update this Product attribute value",
            'value.required' => "The :attribute field is Required",
        ];
    }
}
