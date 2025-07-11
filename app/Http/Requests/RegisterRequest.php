<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'firstname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'lastname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|string|email|max:50|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|confirmed|string',
            // 'password' => [
            //     'required',
            //     'confirmed',
            //     Password::min(8)
            //         ->letters()
            //         ->numbers()
            //         ->uncompromised(),
            // ],
            'referral_code' => 'nullable|string|exists:users,referral_code',
            'bvn' => 'nullable|digits:11',
            'nin' => 'nullable|digits:11',
            'otp' => 'required|digits:6',
            'terms' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.regex' => 'First name can only contain letters and spaces',
            'last_name.regex' => 'Last name can only contain letters and spaces',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.required' => 'You must accept the terms and conditions',
        ];
    }
}