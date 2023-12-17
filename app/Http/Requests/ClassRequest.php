<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
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
            'name' => 'required|unique:classes,name',
            'number' => 'required|unique:classes,number',
        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:classes,name,' . $this->route('id'),
            'number' => 'required|unique:classes,number,' . $this->route('id')
        ];
    }
}
