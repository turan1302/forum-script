<?php

namespace App\Http\Middleware\back;

use Closure;
use Illuminate\Http\Request;

class isAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->isAdmin == 1){
            return $next($request);
        }

        return redirect()->route('front.index')->with(array(
            "type" => "error",
            "title" => "Hata",
            "message" => "Gözüme battın seyyar !!!"
        ));

    }
}
