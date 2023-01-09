<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreBlacklistClientRequest;
use App\Http\Requests\Staff\UpdateBlacklistClientRequest;
use App\Models\BlacklistClient;

/**
 * @see \Tests\Feature\Http\Controllers\Staff\GroupControllerTest
 */
class BlacklistClientController extends Controller
{
    /**
     * Display All Blacklisted Clients.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $clients = BlacklistClient::latest()->get();

        return \view('Staff.blacklist.clients.index', ['clients' => $clients]);
    }

    /**
     * Blacklisted Client Edit Form.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $client = BlacklistClient::findOrFail($id);

        return \view('Staff.blacklist.clients.edit', ['client' => $client]);
    }

    /**
     * Edit A Blacklisted Client.
     */
    public function update(UpdateBlacklistClientRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        BlacklistClient::where('id', '=', $id)->update($request->validated());

        \cache()->forget('client_blacklist');

        return \to_route('staff.blacklists.clients.index')
            ->withSuccess('Odjemalec na črnem seznamu je bil uspešno posodobljen!');
    }

    /**
     * Blacklisted Client Add Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('Staff.blacklist.clients.create');
    }

    /**
     * Store A New Blacklisted Client.
     */
    public function store(StoreBlacklistClientRequest $request): \Illuminate\Http\RedirectResponse
    {
        BlacklistClient::create($request->validated());

        \cache()->forget('client_blacklist');

        return \to_route('staff.blacklists.clients.index')
            ->withSuccess('Odjemalec na črnem seznamu je bil uspešno shranjen!');
    }

    /**
     * Delete A Blacklisted Client.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        BlacklistClient::findOrFail($id)->delete();

        \cache()->forget('client_blacklist');

        return \to_route('staff.blacklists.clients.index')
            ->withSuccess('Odjemalec na črnem seznamu je bil uspešno uničen!');
    }
}
