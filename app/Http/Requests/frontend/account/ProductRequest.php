<?php

namespace App\Http\Requests\frontend\account;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'company' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Please enter your :attribute product',
            'category.required' => 'Please chose your :attribute product',
            'brand.required' => 'Please chose your :attribute product',
        ];
    }
}
