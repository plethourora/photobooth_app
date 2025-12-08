<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheck
{
    public function handle($request, Closure $next)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
