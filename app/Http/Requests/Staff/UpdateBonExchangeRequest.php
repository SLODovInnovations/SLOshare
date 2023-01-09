<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBonExchangeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'value'       => 'required|numeric',
            'cost'        => 'required|numeric',
            'type'        => 'required|string|in:upload,download,personal_freeleech,invite|exclude',
        ];
    }
}
