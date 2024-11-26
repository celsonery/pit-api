<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'cep' => ['required', 'string', 'min:5', 'max:8'],
            'address' => ['required', 'string'],
            'number' => ['nullable', 'string'],
            'complement' => ['nullable', 'string'],
            'neighborhood' => ['required', 'string'],
            'province' => ['required', 'string'],
            'reference' => ['nullable', 'string'],
            'main' => ['nullable', 'boolean'],
            'nickname' => ['nullable', 'string'],
        ];
    }
}
