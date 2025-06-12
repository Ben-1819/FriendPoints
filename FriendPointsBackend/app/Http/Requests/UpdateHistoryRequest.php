<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Define the validation rules
        return [
            "title" => ["required", "string", "max:55"],
            "reason" => ["required", "string", "max:255"],
        ];
    }

    public function messages(): array
    {
        // Define the custom error messages
        $messages = [
            "title.required" => "Title is a required field",
            "title.string" => "Title must be a string value",
            "title.max" => "Title can't be longer than 55 characters",
            "reason.required" => "Reason is a required field",
            "reason.string" => "Reason must be string value",
            "reason.max" => "Reason can't be longer than 255 characters",
        ];

        // Return the custom error messages
        return $messages;
    }
}
