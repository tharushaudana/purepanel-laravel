<?php

namespace App\Http\Controllers;

use App\Http\Requests\invitation\StoreRequest;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index()
    {
        return response()->success(['invitations' => Invitation::latest()->get()]);
    }

    public function store(StoreRequest $request)
    {
        $invitation = Invitation::create($request->validated());
        return response()->success(['invitation' => $invitation]);
    }

    public function show(Invitation $invitation)
    {
        return response()->success(['invitation' => $invitation]);
    }

    public function destroy(Invitation $invitation)
    {
        //
    }
}
