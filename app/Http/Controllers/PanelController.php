<?php

namespace App\Http\Controllers;

use App\Http\Requests\panel\AddUserRequest;
use App\Http\Requests\panel\StoreRequest;
use App\Http\Requests\panel\UpdateRequest;
use App\Models\Panel;
use App\Models\User;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        return response()->success(['panels' => Panel::latest()->get()]);
    }

    public function store(StoreRequest $request)
    {
        //
    }

    public function addUser(AddUserRequest $request, Panel $panel)
    {
        //
    }

    public function show(Panel $panel)
    {
        //
    }

    public function showUsers(Panel $panel)
    {

    }

    public function update(UpdateRequest $request, string $id)
    {
        //
    }

    public function destroy(Panel $panel)
    {
        //
    }

    public function removeUser(Panel $panel, User $user)
    {
        //
    }
}
