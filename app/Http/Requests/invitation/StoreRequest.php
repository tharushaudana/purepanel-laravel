<?php

namespace App\Http\Requests\invitation;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'student_id' => ['required', 'integer', 'exists:students,id', 'unique:invitations,student_id'],
            'panel_id' => ['required', 'integer', 'exists:panels,id'],
            'level' => ['required', 'string', 'in:l,g']
        ];
    }
}
