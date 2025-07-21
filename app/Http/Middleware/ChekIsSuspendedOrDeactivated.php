<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LoginController;
use Closure;
use Illuminate\Http\Request;
use Auth;

class ChekIsSuspendedOrDeactivated
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
        if (($status = Auth::user()->status) != 1) {
            LoginController::revokeToken();
            Auth::logout();
    
            return redirect('login')
                    ->withInput()
                    ->with([
                        'type' => 'danger', 
                        'message' => $status == 0 ? __('message.user_deactivated') : __('message.user_suspended')
                    ]);
        }

        return $next($request);
    }
}
