<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StoreForumRequest extends FormRequest
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
            'name'                      => 'required',
            'position'                  => 'required',
            'description'               => 'required',
            'parent_id'                 => 'sometimes|exists:forums,id',
            'permissions'               => 'sometimes|array',
            'permissions.*'             => 'sometimes|exists:groups,id',
            'permissions.*.show_forum'  => 'sometimes|boolean',
            'permissions.*.read_topic'  => 'sometimes|boolean',
            'permissions.*.reply_topic' => 'sometimes|boolean',
            'permissions.*.start_topic' => 'sometimes|boolean',
        ];
    }
}
