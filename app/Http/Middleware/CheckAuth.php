<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuth
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
        $value = $request->session()->get('user', "");
        if ($value == "")
            return redirect('/');
        else
            return $next($request);
    }
}
