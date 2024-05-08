<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'id'=>['required','exists:products,id'],
            'name'=>['nullable',"unique:products,name",'min:3', 'max:100'],
            'description' => ['nullable','min:5'],
            'price'=>['nullable','between:0,99.99'],
            'quantity'=>['nullable','numeric'],
            'category_id'=>['nullable'],
        ];
    }
    public function  messages(): array
    {
        return [
            'id.required'=>"The id field is Required",
            'id.exists'=>"Cannot Update this Product",
            'name.min' => "The name must be at least :min characters.",
            'name.max' => "The name may not be greater than :max characters.",
            'name:unique'=>"This Product has already been stored",
            'description.min' => "The description must be at least :min characters.",
            'price.between' => "The price should be between 0 and 99.99",
            'quantity.numeric'=> "The :attribute field should be numeric",
        ];
    }
}
