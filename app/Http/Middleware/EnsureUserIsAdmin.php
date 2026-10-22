<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login')->with('warning', 'Please login with an administrator account to access the control panel.');
        }

        if (! $request->user()->isAdmin()) {
            abort(403, 'Access denied. You need administrator privileges to access this area.');
        }

        return $next($request);
    }
}
