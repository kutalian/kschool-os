<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $studentUserId = $this->route('student')->user_id ?? null;

        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => ['nullable', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($studentUserId)],
            'class_id' => 'required|exists:classes,id',
            'transport_route_id' => 'nullable|exists:school_transport_routes,id',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'nationality' => 'required|string|max:100',
            'religion' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:50',
            'roll_no' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',
            'prev_school_name' => 'nullable|string|max:255',
            'prev_school_tc_no' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:parents,id',
        ];
    }
}
