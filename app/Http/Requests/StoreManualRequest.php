<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualRequest extends FormRequest
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
            // Manual Title (required, max length)
            'manual_title' => [
                'required', 
                'string', 
                'max:255'
            ],

            // Description (optional, max length)
            'manual_description' => [
                'nullable', 
                'string', 
                'max:1000'
            ],

            // Category validation based on the select options in the view
            'category_id' => [
                'required', 
            ],

            // File upload validation
            'manual_file' => [
                'required', 
                // 'nullable',
                'file', 
                'mimes:pdf', // Restrict to PDF files
                'max:102400' // Maximum file size (10MB)
            ],

            // Optional additional metadata
            // 'model_number' => [
            //     'nullable', 
            //     'string', 
            //     'max:100'
            // ],
        ];
    }
}
