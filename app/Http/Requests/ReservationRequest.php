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
                'user_id' => 'exists:users,id',
                'employee_id' => 'exists:users,id',
                'operation_id' => 'required|exists:operations,id',
                'branch_id' => 'required|exists:branches,id',
                'date' => 'date_format:Y-m-d',
                'time' => 'date_format:H:i:s',
                'status' => 'in:waiting,done,declined',
            ];

        }


        if ($this->isMethod('put')) {
            $rules = [
                'user_id' => 'exists:users,id' ?? null,
                'employee_id' => 'exists:users,id' ?? null,
                'operation_id' => 'exists:operations,id' ?? null,
                'branch_id' => 'exists:branches,id' ?? null,
                'date' => 'date_format:Y-m-d' ?? null,
                'time' => 'date_format:H:i:s' ?? null,
                'status' => 'in:waiting,done,declined' ?? null,
            ];
        }

        return $rules;
    }
    }

