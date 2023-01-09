<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChatBotRequest extends FormRequest
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
            'name'     => 'required|min:3|max:255',
            'command'  => 'required|alpha_dash|min:3|max:255',
            'position' => 'required',
            'color'    => 'required',
            'icon'     => 'required',
            'emoji'    => 'required',
            'help'     => 'sometimes|max:9999',
            'info'     => 'sometimes|max:9999',
            'about'    => 'sometimes|max:9999',
        ];
    }
}
