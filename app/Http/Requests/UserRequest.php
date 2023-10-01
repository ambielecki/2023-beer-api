<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'string|required|max:100',
            'last_name' => 'string|required|max:100',
            'email' => 'email|required|max:255',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
