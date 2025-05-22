<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorise the user to continue
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Define the custom validation rules
        return [
            "email" => ["required", "string", "email", "max:55"],
            "password" => ["required", "string", "min:6"],
        ];
    }

    /**
     * Define the error messages for if the validation rules are broken
     * @return array<string, string>
     */
    public function messages(): array
    {
        // Define the error messages
        $messages = [
            "email.required" => "Email is a required field",
            "email.string" => "Email must be of data type string",
            "email.email" => "Email must be a valid email",
            "email.max" => "Email must be 55 characters or less",
            "password.required" => "Password is a required field",
            "password.string" => "Password must be a string",
            "password.max" => "Password must be at least 6 characters",
        ];

        // Return the error messages
        return $messages;
    }
}
