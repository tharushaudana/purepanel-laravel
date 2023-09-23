<?php

namespace App\Http\Controllers;

use App\Http\Requests\panel\AddUserRequest;
use App\Http\Requests\panel\StoreRequest;
use App\Http\Requests\panel\UpdateRequest;
use App\Models\Panel;
use App\Models\PanelAccess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasLevel('a|m')) {
            $panels = Panel::latest()->get();
        } else {
            $panels = Auth::user()->getPanels();
        }

        return response()->success(['panels' => $panels]);
    }

    public function store(StoreRequest $request)
    {
        $district_id = $request->get('district_id');
        $year = $request->get('year');

        $count = Panel::where('district_id', '=', $district_id)->where('year', '=', $year)->count();

        if ($count > 0) {
            return response()->error('This panel is already exists.');    
        }

        $panel = Panel::create($request->validated());

        return response()->success(['panel' => $panel]);
    }

    public function addUser(AddUserRequest $request, Panel $panel)
    {
        $user_id = $request->get('user_id');

        $user = User::find($user_id);

        if ($user->hasLevel('a|m')) {
            return response()->error('This action is not required to admins & moderators.');
        }

        if ($user->hasAccessToPanel($panel->id)) {
            return response()->error('The user is already been added to this panel.');
        }

        PanelAccess::create([
            'panel_id' => $panel->id,
            'user_id' => $user->id
        ]);

        return response()->success(null, 'Successfully added.');
    }

    public function show(Panel $panel)
    {
        return response()->success(['panel' => $panel]);
    }

    public function showUsers(Panel $panel)
    {        
        return response()->success(['users' => $panel->getUsers()]);
    }

    public function update(UpdateRequest $request, Panel $panel)
    {
        //
    }

    public function destroy(Panel $panel)
    {
        //
    }

    public function removeUser(Panel $panel, User $user)
    {
        $access = PanelAccess::where('panel_id', $panel->id)->where('user_id', $user->id)->first();

        if ($access == null) {
            return response()->error('The user is not in this panel.');            
        }

        $access->delete();

        return response()->success(null, 'Successfully removed.');
    }
}
