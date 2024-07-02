<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LateRequest extends FormRequest
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
            'employee_id'=>'numeric|required|exists:users,id' ?? null ,
            'date'=>'date' ?? null,
            'hours'=>'numeric' ?? null,
            'branch_id'=>'numeric|required|exists:branches,id' ?? null,
        ];
    }
}
