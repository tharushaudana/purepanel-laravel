<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAccessTo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::user()->hasLevel('a|m')) return $next($request);

        $to = $role;

        switch ($to) {
            case 'panel':
                $access = $this->checkAccessToPanel($request);
                break;

            case 'center':
                $access = $this->checkAccessToCenter($request);
                break;
            
            default:
                $access = true;
                break;
        }

        if (!$access) return response()->error('You has not access to this '.$to.'.');

        return $next($request);
    }

    private function checkAccessToPanel(Request $request) {
        $panel = $request->route('panel');
        return Auth::user()->hasAccessToPanel($panel->id);
    }

    private function checkAccessToCenter(Request $request) {
        $center = $request->route('center');
        return Auth::user()->hasAccessToCenter($center->id);
    }
}
