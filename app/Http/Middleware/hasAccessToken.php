<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LoginController;
use Closure;
use Illuminate\Http\Request;
use Auth;

class hasAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $existToken = Auth::user()->tokens()->where("name", LoginController::TOKEN_NAME ."-" .session()->getId())->first();

            if (!session('access_token') || !$existToken) {
                LoginController::generateAccessToken();
            }
        }

        return $next($request);
    }
}
