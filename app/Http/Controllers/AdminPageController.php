<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;

class AdminPageController extends Controller
{
    public function getList(): View {
        $query = Page::query();
        $pages = $query->paginate(25);

        return view('admin.pages.list', [
            'pages' => $pages,
        ]);
    }

    public function getCreate(): View {
        $page = new Page();

        return view('admin.pages.create', [
            'page' => $page,
        ]);
    }

    public function postCreate(PageRequest $request): RedirectResponse {
        $page = new Page();
        $page->fill($request->all());

        if ($page->save()) {
            Session::flash('flash_success', "Page Updated Successfully");

            return redirect()->route('page_list');
        }

        return back()->withInput();
    }

    public function getEdit($page_id): View {
        $page = Page::find($page_id);

        return view('admin.pages.edit', [
            'page' => $page,
        ]);
    }

    public function postEdit(PageRequest $request, $page_id): RedirectResponse {
        $page = Page::find($page_id);

        if ($page->update($request->all())) {
            Session::flash('flash_success', "Page Updated Successfully");

            return redirect()->route('page_list');
        }

        return back()->withInput();
    }

    public function getDelete(Request $request, $page_id): View {
        $page = Page::find($page_id);

        return view('admin.pages.delete', [
            'page' => $page,
        ]);
    }

    public function postDelete(Request $request, $page_id): RedirectResponse {
        $page = Page::find($page_id);

        if ($page->delete()) {
            Session::flash('flash_success', "Page Deleted");

            return redirect()->route('page_list');
        }

        Session::flash('flash_warning', "There was a problem deleting this page");

        return back()->withInput();
    }
}
