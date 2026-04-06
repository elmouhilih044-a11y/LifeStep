<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next,$role)
    {

      if (!Auth::check()) {
            return redirect()->route('login');
        }
  if (Auth::user()->role !== $role) {
        return redirect()->route('logements.index');
    }
        return $next($request);
    }
}
