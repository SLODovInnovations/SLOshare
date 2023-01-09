<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateForumRequest extends FormRequest
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
            'name'            => 'required',
            'position'        => 'required',
            'description'     => 'required',
            'parent_id'       => 'exists:forums,id',
            'permissions'     => 'array',
            'permissions.*'   => 'exists:groups,id',
            'permissions.*.show_forum'  => 'boolean',
            'permissions.*.read_topic'  => 'boolean',
            'permissions.*.reply_topic' => 'boolean',
            'permissions.*.start_topic' => 'boolean',
            'forum_type'      => 'in:category,forum',
        ];
    }
}
