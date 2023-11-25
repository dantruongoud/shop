<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|max:255',
            'phone' => 'required',
            'address' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_country' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Please enter your :attribute',
            'max' => 'Please enter :max characters',
            'avatar.image' => 'Avatar is image!',
            'avatar.mimes' => 'Avatar is type: jpeg, png, jpg, gif',
        ];
    }
}
