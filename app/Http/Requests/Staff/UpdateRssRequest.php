<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRssRequest extends FormRequest
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
            'name'            => 'required|min:3|max:255',
            'search'          => 'max:255',
            'description'     => 'max:255',
            'uploader'        => 'max:255',
            'categories'      => 'sometimes|array|max:999',
            'categories.*'    => 'sometimes|exists:categories,id',
            'types'           => 'sometimes|array|max:999',
            'types.*'         => 'sometimes|exists:types,id',
            'resolutions'     => 'sometimes|array|max:999',
            'resolutions.*'   => 'sometimes|exists:resolutions,id',
            'genres'          => 'sometimes|array|max:999',
            'genres.*'        => 'sometimes|exists:genres,id',
            'position'        => 'sometimes|integer|max:9999',
            'imdb'            => 'sometimes|integer',
            'tvdb'            => 'sometimes|integer',
            'tmdb'            => 'sometimes|integer',
            'mal'             => 'sometimes|integer',
            'freeleech'       => 'sometimes|boolean',
            'doubleupload'    => 'sometimes|boolean',
            'featured'        => 'sometimes|boolean',
            'stream'          => 'sometimes|boolean',
            'highspeed'       => 'sometimes|boolean',
            'sd'              => 'sometimes|boolean',
            'internal'        => 'sometimes|boolean',
            'personalrelease' => 'sometimes|boolean',
            'bookmark'        => 'sometimes|boolean',
            'alive'           => 'sometimes|boolean',
            'dying'           => 'sometimes|boolean',
            'dead'            => 'sometimes|boolean',
        ];
    }
}
