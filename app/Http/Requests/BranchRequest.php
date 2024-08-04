<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'name' =>'string|required|unique:branches,name'?? null,
            'location'=>'required|string'?? null,
            'image' => 'file' ?? null,
            'start_time'=>'required_with:end_time|date_format:H:i:s'?? null,
            'end_time'=>'required_with:start_time|date_format:H:i:s'?? null,
            'description'=>'string' ?? null,
            'working_days' => 'required',
        ];
    }
}
