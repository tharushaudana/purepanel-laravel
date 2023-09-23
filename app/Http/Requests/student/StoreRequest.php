<?php

namespace App\Http\Requests\student;

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
            'id' => ['required', 'integer', 'unique:students,id'],
            'center_id' => ['required', 'integer', 'exists:centers,id'],
            'name' => ['required', 'min:1'],
            'email' => ['sometimes', 'email', 'unique:students,email'],
            'mobile' => ['sometimes', 'size:10'],
            'whatsapp' => ['sometimes', 'size:10'],
        ];
    }
}
