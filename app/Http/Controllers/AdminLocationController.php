<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\LocationRequest;
use App\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;

class AdminLocationController extends Controller
{
    public function getList(Request $request): View {
        $query = Location::query();

        if ($request->query('search')) {
            $search = "%{$request->query('search')}%";
            $query = $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', $search)
                    ->orWhere('description', 'LIKE', $search)
                    ->orWhere('address', 'LIKE', $search);
            });
        }

        $locations = $query
            ->with(['group'])
            ->paginate(25);

        return view('admin.locations.list', [
            'locations' => $locations,
        ]);
    }

    public function getCreate(): View {
        $location = new Location();
        $groups = Group::all();

        return view('admin.locations.create', [
            'location' => $location,
            'groups' => $groups,
        ]);
    }

    public function postCreate(LocationRequest $request): RedirectResponse {
        $location = new Location($request->all());

        if ($location->save()) {
            Session::flash('flash_success', "Location: $location->name Created Successfully");

            return redirect()->route('location_list');
        }

        Session::flash('flash_error', 'There was a problem saving your location, please try again.');

        return back()->withInput();
    }

    public function getEdit($location_id): View {
        $location = Location::with('group')->find($location_id);
        $groups = Group::all();

        return view('admin.locations.edit', [
            'location' => $location,
            'groups' => $groups,
        ]);
    }

    public function postEdit(LocationRequest $request, $location_id): RedirectResponse {
        $location = Location::find($location_id);

        if ($location->update($request->all())) {
            Session::flash('flash_success', "Location: $location->name Updated Successfully");

            return redirect()->route('location_edit', $location_id);
        }

        Session::flash('flash_error', 'There was a problem updating your location, please try again.');

        return back()->withInput();
    }
}
