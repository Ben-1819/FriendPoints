<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHistoryRequest extends FormRequest
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
        // Define the validation rules
        return [
            "title" => ["required", "string", "max:55"],
            "reason" => ["required", "string", "max:255"],
            "before" => ["required", "integer"],
            "after" => ["required", "integer"],
            "change" => ["required", "integer"],
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
            "reason.string" => "Reason must be a string value",
            "reason.max" => "Reason can't be longer than 255 characters",
            "before.required" => "Before is a required field",
            "before.integer" => "Before must be an integer value",
            "after.required" => "After is a required field",
            "after.integer" => "After must be an integer value",
            "change.required" => "Change is a required field",
            "change.integer" => "Change must be an integer value",
        ];

        // Return the custom error messages
        return $messages;
    }
}
