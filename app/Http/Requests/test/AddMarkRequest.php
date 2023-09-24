<?php

namespace App\Http\Requests\test;

use Illuminate\Foundation\Http\FormRequest;

class AddMarkRequest extends FormRequest
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
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'mark' => ['required', 'integer', 'min:0', 'max:100']
        ];
    }
}
