<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFriendRequest extends FormRequest
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
        // Write the custom validation rules
        return [
            "group" => ["required", "string"],
            "points" => ["required", "integer"],
        ];
    }

    /**
     * Messages function - defines the error messages returned when validation rules are broken
     * @return array{string, string}
     */
    public function messages(): array
    {
        // Define the custom error messages
        $messages = [
            "group.required" => "Group is a required field",
            "group.string" => "Group must be a string value",
            "points.required" => "Points is a required field",
            "points.integer" => "Points must be an integer value",
        ];

        // Return the custom error messages
        return $messages;
    }
}
