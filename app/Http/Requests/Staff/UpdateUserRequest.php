<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username'    => 'required',
            'email'       => 'required|max:255',
            'uploaded'    => 'required|integer',
            'downloaded'  => 'required|integer',
            'title'       => 'nullable|present|string|max:255',
            'about'       => 'nullable|present|string|max:16777216',
            'group_id'    => 'required|exists:groups,id',
            'internal_id' => 'nullable|exists:internals,id',
        ];
    }
}
