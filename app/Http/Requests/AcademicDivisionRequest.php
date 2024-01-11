<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicDivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [

        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:academic_divisions,name',
        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:academic_divisions,name,' . $this->route('id'),
        ];
    }
}
