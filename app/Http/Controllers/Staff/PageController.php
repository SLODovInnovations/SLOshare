<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StorePageRequest;
use App\Http\Requests\Staff\UpdatePageRequest;
use App\Models\Page;
use Exception;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\PageControllerTest
 */
class PageController extends Controller
{
    /**
     * Display All Pages.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $pages = Page::all();

        return view('Staff.page.index', ['pages' => $pages]);
    }

    /**
     * Page Add Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.page.create');
    }

    /**
     * Store A New Page.
     */
    public function store(StorePageRequest $request): \Illuminate\Http\RedirectResponse
    {
        Page::create($request->validated());

        return to_route('staff.pages.index')
            ->withSuccess('Stran je bila uspešno ustvarjena');
    }

    /**
     * Page Edit Form.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $page = Page::findOrFail($id);

        return view('Staff.page.edit', ['page' => $page]);
    }

    /**
     * Edit A Page.
     */
    public function update(UpdatePageRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        Page::where('id', '=', $id)->update($request->validated());

        return to_route('staff.pages.index')
            ->withSuccess('Stran je bila uspešno urejena');
    }

    /**
     * Delete A Page.
     *
     * @throws Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        Page::findOrFail($id)->delete();

        return to_route('staff.pages.index')
            ->withSuccess('Stran je bila uspešno izbrisana');
    }
}
