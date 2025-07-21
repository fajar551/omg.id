<?php

namespace App\Http\Middleware;

use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\ApiResponse;
use Closure;

class StreamKeyAsBearer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has("streamKey")) {
            return ApiResponse::error(new ValidatorException("Invalid stream key!", []));
        }
        
        $request->headers->set('Authorization', 'Bearer ' .$request->streamKey);
        return $next($request);
    }
}
