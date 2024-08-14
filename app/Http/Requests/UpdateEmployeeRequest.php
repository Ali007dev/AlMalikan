<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'first_name' => 'nullable|string' ?? null,
            'middle_name' => 'string' ?? null,
            'last_name' => 'string' ?? null,
            'phone_number' => 'numeric|nullable' ?? null,
            'password' => 'nullable' ?? null,
            'salary' => 'nullable|numeric' ?? null,
            'ratio' => 'nullable|numeric' ?? null,
            'isFixed' => 'boolean'?? null ,
            'role' => 'string'?? null,
            'position' => 'string'?? null,
            'start_date' => 'date_format:Y-m-d'?? null,
            'email' => 'email|nullable'?? null,
            'national_id'=> 'numeric' ?? null,
            'branch_id'=> 'numeric|exists:branches,id'?? null,
            'branches.*'=> ['exists:branches,id']?? null,
            'services.*'=> ['exists:operations,id']?? null,
        ];
    }
}
