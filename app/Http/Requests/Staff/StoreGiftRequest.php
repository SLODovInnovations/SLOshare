<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StoreGiftRequest extends FormRequest
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
            'username'  => 'required|exists:users,username|max:180',
            'seedbonus' => 'required|integer|min:0',
            'invites'   => 'required|integer|min:0',
            'fl_tokens' => 'required|integer|min:0',
        ];
    }
}
