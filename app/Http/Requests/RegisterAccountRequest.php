<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAccountRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email'    => 'required|email|max:100|unique:accounts,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'email'    => 'Email Address',
            'password' => 'Password',
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => 'Please enter your email address.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already registered.',
            'email.max'         => 'Email cannot exceed :max characters.',

            'password.required' => 'Please enter a password.',
            'password.min'      => 'Password must be at least :min characters.',
            'password.confirmed'=> 'Password confirmation does not match.',
        ];
    }
}
