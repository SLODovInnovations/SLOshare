<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $request->user()->group->is_owner || $request->is_owner != 1;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string',
            'position'       => 'required|integer',
            'level'          => 'required|integer',
            'download_slots' => 'integer',
            'color'          => 'required',
            'icon'           => 'required',
            'effect',
            'is_internal'      => 'required|boolean',
            'is_modo'          => 'required|boolean',
            'is_admin'         => 'required|boolean',
            'is_owner'         => 'required|boolean',
            'is_trusted'       => 'required|boolean',
            'is_immune'        => 'required|boolean',
            'is_freeleech'     => 'required|boolean',
            'is_double_upload' => 'required|boolean',
            'is_incognito'     => 'required|boolean',
            'can_upload'       => 'required|boolean',
            'autogroup'        => 'required|boolean',
        ];
    }
}
