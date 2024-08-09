<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
        if ($this->isMethod('post')){
            $rules = [
                'user_id' => 'required|numeric|exists:users,id',
                'employee_id' => 'numeric|exists:users,id',
                'operation_id' => 'required|numeric|exists:operations,id',
                'branch_id' => 'required|numeric|exists:branches,id',
                'date' => 'date_format:Y-m-d',
                'time' => 'date_format:H:i:s',
                'status' => 'in:waiting,done,declined',
            ];

        }


        if ($this->isMethod('put')) {
            $rules = [
                'user_id' => 'numeric|exists:users,id' ?? null,
                'employee_id' => 'numeric|exists:users,id' ?? null,
                'operation_id' => 'numeric|exists:operations,id' ?? null,
                'branch_id' => 'numeric|exists:branches,id' ?? null,
                'date' => 'date_format:Y-m-d' ?? null,
                'time' => 'date_format:H:i:s' ?? null,
                'status' => 'in:waiting,done,declined' ?? null,
            ];
        }

        return $rules;
    }
    }

