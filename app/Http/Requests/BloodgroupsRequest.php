<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BloodgroupsRequest extends FormRequest
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

        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:bloodgroups,name',
        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:bloodgroups,name,' . $this->route('id'),
        ];
    }
}
