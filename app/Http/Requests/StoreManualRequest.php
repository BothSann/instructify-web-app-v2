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
            'manual_title' => [
                'required', 
                'string', 
                'max:255'
            ],
    
            'manual_description' => [
                'nullable', 
                'string', 
                'max:1000'
            ],
            
            'category_id' => [
                'required', 
            ],

            'manual_file' => [
                'required', 
                'file', 
                'mimes:pdf', // 
                'max:50240' // 
            ],
        ];
    }
}
