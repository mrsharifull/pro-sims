<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }
    public function rules(): array
    {
        return [
            'name' => 'required|min:4',
            'role' => 'required',

        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'required|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
