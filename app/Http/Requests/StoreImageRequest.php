<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'images' => 'required|array|size:2',
            'images.0.type' => 'required|string|in:before',
            'images.0.image' => 'required|image',
            'images.1.type' => 'required|string|in:after',
            'images.1.image' => 'required|image',
            'description' => 'string'
        ];
    }
}
