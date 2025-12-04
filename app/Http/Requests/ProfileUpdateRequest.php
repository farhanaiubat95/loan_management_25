<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Phone (11 digits)
            'phone' => ['nullable', 'digits:11'],

            // Date of birth
            'dob' => ['nullable', 'date'],

            // NID (optional)
            'nid' => ['nullable', 'string', 'max:50'],

            // NID image upload
            'nid_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            // Address
            'address' => ['nullable', 'string'],

            // Occupation
            'occupation' => ['nullable', 'string', 'max:255'],

            // Income (numeric)
            'income' => ['nullable', 'numeric'],

            // Role (optional)
            'role' => ['nullable', 'string']
        ];
    }
}
