<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'middle_name' => 'string',
            'last_name' => 'required|string',
            'phone_number' => 'numeric|nullable|unique:users,phone_number,id',
            'password' => 'nullable',
            'salary' => 'nullable|numeric',
            'isFixed' => 'boolean',
            'role' => 'string',
            'position' => 'string',
            'start_date' => 'date_format:Y-m-d',
            'email' => 'email|nullable|unique:users,email,id',
            'description.*.' => 'array',
            'name.*.'=> 'array',
            'national_id'=> 'numeric',
        ];
    }
}
