<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($locale = $request->session()->get('locale')) {
            App::setLocale($locale);
        } else {
            $browserLang = substr($request->server('HTTP_ACCEPT_LANGUAGE') ?? 'ar', 0, 2);
            $locale = in_array($browserLang, ['ar', 'en']) ? $browserLang : 'ar';
            App::setLocale($locale);
            $request->session()->put('locale', $locale);
        }

        return $next($request);
    }
}