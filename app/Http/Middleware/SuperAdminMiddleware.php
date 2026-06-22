<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_super_admin) {
            return redirect()->route('admin.dashboard')->with('error', 'لا تملك صلاحية الوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}
