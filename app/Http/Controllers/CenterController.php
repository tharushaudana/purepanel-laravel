<?php

namespace App\Http\Controllers;

use App\Http\Requests\center\StoreRequest;
use App\Http\Requests\center\UpdateRequest;
use App\Models\Center;
use Illuminate\Support\Facades\Auth;

class CenterController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasLevel('a|m')) {
            $centers = Center::latest()->get();
        } else {
            $centers = Auth::user()->getCenters();
        }

        return response()->success(['centers' => $centers]);
    }

    public function store(StoreRequest $request)
    {
        $center = Center::create($request->validated());
        return response()->success(['center' => $center]);
    }

    public function show(Center $center)
    {
        return response()->success(['center' => $center]);
    }

    public function update(UpdateRequest $request, Center $center)
    {
        //
    }

    public function destroy(Center $center)
    {
        //
    }
}
