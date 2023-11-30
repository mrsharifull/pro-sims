<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // public function rules()
    // {
    //     return [
    //         'name' => [
    //             'required', 'min:3'
    //         ],
    //         'email' => [
    //             'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)
    //         ],
    //         'password' => [
    //             $this->route()->user ? 'required_with:password_confirmation' : 'required', 'nullable', 'confirmed', 'min:6'
    //         ],
    //     ];
    // }
    public function rules(): array
    {
        return [
            'name' => 'required|min:4',

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
