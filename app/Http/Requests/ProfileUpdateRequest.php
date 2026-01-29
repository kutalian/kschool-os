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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        if ($this->user()->role === 'staff') {
            $rules = array_merge($rules, [
                'profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
                'phone' => ['required', 'string', 'max:20'],
                'gender' => ['required', 'in:Male,Female,Other'],
                'dob' => ['nullable', 'date'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'country' => ['required', 'string', 'max:100'],
                'current_address' => ['nullable', 'string'],
                'permanent_address' => ['nullable', 'string'],
                'emergency_contact_name' => ['nullable', 'string', 'max:100'],
                'emergency_contact_number' => ['nullable', 'string', 'max:20'],
                'qualification' => ['nullable', 'string', 'max:255'],
                'specialization' => ['nullable', 'string', 'max:255'],
                'university' => ['nullable', 'string', 'max:255'],
                'experience_years' => ['required', 'integer', 'min:0'],
                'bank_name' => ['nullable', 'string', 'max:100'],
                'bank_account_no' => ['nullable', 'string', 'max:50'],
                'bank_code' => ['nullable', 'string', 'max:20'],
            ]);
        }

        return $rules;
    }
}
