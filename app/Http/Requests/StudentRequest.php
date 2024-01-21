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
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'ad_id' => 'required|exists:academic_divisions,id',
            'bg_id' => 'required|exists:bloodgroups,id',
            'name' => 'required|min:4',
            'father_name' => 'required|min:4',
            'mother_name' => 'required|min:4',
            'roll' => 'required|numeric|digits:6',
            'registration' => 'required|numeric|digits:10',
            'address' => 'required|max:100',
            'date_of_birth' => 'required|date|before:today',
            'number' => 'required|numeric|digits:11',
            'parents_number' => 'required|numeric|digits:11',
            'age' => 'required|numeric|digits:2',
            'gender' => 'required|in:male,female,other',
            


        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ];
    }

    protected function update(): array
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
