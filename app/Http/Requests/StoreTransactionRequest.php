<?php

namespace App\Http\Requests;

use App\Models\BonExchange;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * @see \Tests\Todo\Unit\Http\Requests\StorePollTest
 */
class StoreTransactionRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'exchange'   => [
                'bail',
                'required',
                'exists:bon_exchange,id',
                function ($attribute, $value, $fail) use ($request) {
                    $user = $request->user();
                    $item = BonExchange::findOrFail($value);

                    switch (true) {
                        case $item->cost > $user->seedbonus:
                            $fail('Ni dovolj BON-ov.');
                            break;
                        case $item->download && $user->downloaded < $item->value:
                            $fail('Ni dovolj prenosa.');
                            break;
                        case $item->personal_freeleech && \cache()->rememberForever('personal_freeleech:'.$user()->id, fn () => $user->personalFreeleeches()->exists()):
                            $fail('Vaš prejšnji osebni freeleech je še vedno aktiven.');
                            break;
                    }
                },
            ],
        ];
    }
}
