<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name'       => 'required|string',
            'position'   => 'required|numeric',
            'icon'       => 'required|string',
            'meta'       => 'required|string|in:movie,tv,game,music,no|exclude',
            'image'      => 'max:10240',
        ];
    }
}
