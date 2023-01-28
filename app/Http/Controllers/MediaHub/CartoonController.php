<?php

namespace App\Http\Controllers\MediaHub;

use App\Http\Controllers\Controller;
use App\Models\Cartoon;
use Illuminate\Http\Request;

class CartoonController extends Controller
{
    /**
     * Display All Cartoon.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('mediahub.cartoon.index');
    }

    /**
     * Show A Cartoon.
     */
    public function show(Request $request, int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $user = $request->user();
        $personalFreeleech = \cache()->rememberForever(
            'personal_freeleech:'.$user->id,
            fn () => $user->personalFreeleeches()->exists()
        );
        $cartoon = Cartoon::with(['cast', 'collection', 'genres', 'companies'])->findOrFail($id);

        return \view('mediahub.cartoon.show', [
            'cartoon'            => $cartoon,
            'user'               => $user,
            'personal_freeleech' => $personalFreeleech,
        ]);
    }
}
