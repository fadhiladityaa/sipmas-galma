<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if ($request->routeIs('login')) {
                    return response()->view('auth.already-logg-in', [
                        'user' => $user,
                    ]);
                }

                return redirect()->route($user->dashboardRouteName());
            }
        }

        return $next($request);
    }
}