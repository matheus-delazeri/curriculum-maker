<?php

namespace App\Http\Middlewares;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, \Closure $next): Response
    {
        $locale = Auth::user()->getLocale();
        app()->setLocale($locale);

        return $next($request);
    }
}
