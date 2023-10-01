<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEventController extends Controller
{
    public function getList(Request $request): View {
        $query = Event::query();

        if ($request->query('search')) {
            $search = "%{$request->query('search')}%";
            $query = $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', $search)
                    ->orWhere('description', 'LIKE', $search);
            });
        }

        $events = $query
            ->with(['group', 'location'])
            ->paginate(25);

        return view('admin.events.list', [
            'events' => $events,
        ]);
    }

    public function getCreate(): View {
        return view('admin.events.create');
    }

    public function postCreate(): RedirectResponse {
        return redirect()->route('event_list');
    }
}
