<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class RegisterRequest extends FormRequest
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
        // Define and return the custom validation rules
        return [
            "first_name" => ["required", "string", "max:55"],
            "last_name" => ["required", "string", "max:55"],
            "email" => ["required", "string", "email", "unique:users", "max:55"],
            "password" => ["required", "string", "min:6"],
        ];
    }

    /**
     * Define the error messages if validation rules are not met
     * @return array<string, string>
     */
    public function messages():array
    {
        // Define the custom error messages
        $messages = [
            "first_name.required" => "First name is a required field",
            "first_name.string" => "First name must be of data type string",
            "first_name.max" => "First name can not be longer than 55 characters",
            "last_name.required" => "Last name is a required field",
            "last_name.string" => "Last name must be of data type string",
            "last_name.max" => "Last name can not be longer than 55 characters",
            "email.required" => "Email is a required field",
            "email.string" => "Email must be of data type string",
            "email.email" => "Email must be in a valid email format",
            "email.unique" => "This email is already being used for an account, please log into your account or choose a new email",
            "email.max" => "Email can not be longer than 55 characters",
            "password.required" => "Password is a required field",
            "password.string" => "Password must be of the data type string",
            "password.min" => "Password must be at least 6 characters long",
        ];

        // Return the custom error messages
        return $messages;
    }
}
