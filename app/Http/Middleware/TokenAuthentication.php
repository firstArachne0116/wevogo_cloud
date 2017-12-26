<?php

namespace App\Http\Middleware;

use App\Model\WevoUser;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\TokenGuard;

class TokenAuthentication
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
        $wevoUser = WevoUser::where('phone_number', '+' . $request->get('phoneNumber'))->first();
        if ($wevoUser !== null && $wevoUser->wevoDevice !== null && $wevoUser->wevoDevice->device_token === $request->bearerToken())
            return $next($request);
        else return response()->json('unauthorized', 401);
    }
}
