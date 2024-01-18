<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_id' => 'required|exists:classes',
            'section_id' => 'required|exists:sections',
            'ad_id' => 'required|exists:academic_divisions',
            'bg_id' => 'required|exists:bloodgroups',
            'name' => 'required|min:4',
            'father_name' => 'required|min:4',
            'mother_name' => 'required|min:4',
            'roll' => 'required|integer|min:6|max:8',
            'registration' => 'required|integer|min:10|max:15',
            'address' => 'required|max:100',
            'date_of_birth' => 'required|date|after:today',
            'number' => 'required|integer|min:11|max:11',
            'parents_number' => 'required|integer|min:11|max:11',
            'age' => 'required|integer|max:2',
            'gender' => 'required|in:male,female,other',
            


        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
