<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegistrationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'phone' => ['required', 'string', 'regex:/^(\+88|88)?01(?:(?!2)[1-9])\d{8}$/'],
            'password' => ['required', 'confirmed', Password::min(6)->letters()
                                                                    ->mixedCase()
                                                                    ->numbers()
                                                                    ->symbols()]
        ];
    }
}
