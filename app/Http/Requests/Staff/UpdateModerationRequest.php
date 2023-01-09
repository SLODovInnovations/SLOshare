<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModerationRequest extends FormRequest
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
            'old_status' => 'required|in:0,1,2,3',
            'status'     => 'required|in:1,2,3',
            'message'    => 'required_if:status,2,3|string'
        ];
    }
}
