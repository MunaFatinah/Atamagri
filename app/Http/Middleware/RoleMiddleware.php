<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.index');
            }
            return redirect()->route('dashboard.index');
        }

        return $next($request);
    }
}
