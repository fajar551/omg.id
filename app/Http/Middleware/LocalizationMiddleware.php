<?php

namespace App\Http\Middleware;

use App\Src\Services\Eloquent\SettingService;
use Closure;
use Illuminate\Http\Request;

class LocalizationMiddleware
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
        $locale = config('app.locale');
        if (auth()->check()) {   
            if ($request->has("settings") && isset($request->input("settings")['language'])) {
                $locale = $request->input("settings")['language'];
            } else {
                $locale = SettingService::getInstance()->get('language', $locale, auth()->user()->id);
            }

            app()->setLocale($locale);
        }

        return $next($request);
    }
}
