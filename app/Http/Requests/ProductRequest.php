<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
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
            'category_id'=>['required'],
            'name'=>['required',"unique:products,name",'min:3', 'max:10'],
            'description' => ['nullable','min:5'],
            'price'=>['required','decimal:2','gt:0.0'],
            'quantity'=>['required','integer'],
        ];
    }
    public function  messages(): array
    {
        return [
            'id.required'=>"The category_id field is Required",
            'name.required' => "The :attribute field is Required",
            'name.min' => "The name must be at least :min characters.",
            'name.max' => "The name may not be greater than :max characters.",
            'name:unique'=>"This Product has already been stored",
            'description.min' => "The description must be at least :min characters.",
            'price.required'=>"The :attribute field is Required",
            'price.decimal' => "The price field must have 2 decimal places.",
            'price.gt'=>"The price field must have greater than 0.",
            'quantity.required'=> "The :attribute field is Required",
            'quantity.integer'=> "The :attribute field should be integer",
        ];
    }
}
