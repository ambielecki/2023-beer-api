<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupRequest;
use App\User;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;
use Str;

class AdminGroupController extends Controller
{
    public function getList(Request $request): View {
        $query = Group::query();

        if ($request->query('search')) {
            $search = "%{$request->query('search')}%";
            $query = $query->where('name', 'LIKE', $search);
        }

        $groups = $query->paginate(25);

        return view('admin.groups.list', [
            'groups' => $groups,
        ]);
    }

    public function getCreate(): View {
        $group = new Group();

        return view('admin.groups.create', [
            'group' => $group,
        ]);
    }

    public function postCreate(GroupRequest $request): RedirectResponse {
        $group = new Group();
        $group->name = $request->input('name');
        $group->options = [];

        if ($group->save()) {
            $user_emails = $request->input('users');
            $group_users = User::query()
                ->whereIn('email', $request->input('users'))
                ->pluck('email', 'id')
                ->toArray();

            $new_emails = array_diff($user_emails, $group_users);

            foreach ($new_emails as $new_email) {
                $user = new User();
                $user->first_name = '';
                $user->last_name = '';
                $user->email = $new_email;
                $user->password = Hash::make(Str::random(8));
                $user->is_admin = false;

                $user->save();

                $group_users[$user->id] = $user->email;
            }

            $group->users()->attach(array_keys($group_users));

            Session::flash('flash_success', "Group $group->name Created Successfully");

            return redirect()->route('group_list');
        }

        Session::flash('flash_warning', 'There was a problem saving your group, please try again');

        return back()->withInput();
    }

    public function getEdit($group_id): View {
        $group = Group::find($group_id);

        return view('admin.groups.edit', [
            'group' => $group,
        ]);
    }

    public function postEdit(GroupRequest $request, $group_id) {
        $group = Group::find($group_id);

        // TODO: Update

        return redirect()->route('group_edit', $group_id);
    }
}
