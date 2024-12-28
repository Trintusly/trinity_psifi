<?php

namespace App\Http\Requests\Startup;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewStartupRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'display_name' => 'required|string|max:255',  // Ensure the display name is required, a string, and not longer than 255 characters.
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',  // The logo is required and should be an image (jpeg, png, jpg, gif, or svg) with a max size of 2MB (2048KB).
            'description' => 'required|string|min:10|max:1000',  // Description is required, must be a string, with a minimum of 10 characters and a maximum of 1000 characters.
            'industries' => 'required|string|regex:/^([a-zA-Z0-9\s]+)(,[a-zA-Z0-9\s]+)*$/', // Validation for comma-separated industries
            'funding_raised' => 'required|numeric|min:0',  // Funding raised must be a number, and cannot be less than 0.
        ];
    }

    public function messages()
    {
        return [
            'industries.regex' => 'Industries must be comma-separated and only contain alphanumeric characters and spaces.',
        ];
    }
}
