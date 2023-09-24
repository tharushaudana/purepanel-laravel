<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckHasRelation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $nameFirst, $nameSecond): Response
    {
        $modelFirst = $request->route($nameFirst);
        $modelSecond = $request->route($nameSecond);

        if ($modelFirst->getAttribute($nameSecond.'_id') != $modelSecond->id) {
            return response()->error('This '.$nameFirst.' is not related to the given '.$nameSecond.'.');
        }

        return $next($request);
    }
}
