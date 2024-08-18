<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationRequest extends FormRequest
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
                'name' => 'string|required',
                'price' => 'numeric|required',
                'image' => 'file',
                'from' => 'required_with:to|date_format:H:i:s',
                'to' => 'date_format:H:i:s',
                'period' => 'numeric',
                'branch_id'=>'numeric|required|exists:branches,id' ,
            ];

        }


        if ($this->isMethod('put')) {
            $rules = [
                'name' => 'string' ?? null,
                'price' => 'numeric'?? null,
                'image' => 'file'?? null,
                'from' => 'required_with:to|date_format:H:i:s'?? null,
                'to' => 'date_format:H:i:s'?? null,
                'period' => 'numeric'?? null,
                'branch_id'=>'numeric|exists:branches,id'?? null ,
            ];
        }

        return $rules;
    }

}
