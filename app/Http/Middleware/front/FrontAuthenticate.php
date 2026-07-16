<?php

namespace App\Http\Middleware\front;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class FrontAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
//            return route('login');
            return route('front.signin.index');
        }
    }
}
