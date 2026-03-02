<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized access.');
        }

        $allowed = array_map('trim', explode('|', $roles));
        $userRole = auth()->user()->role ?? 'user';

        if (!in_array($userRole, $allowed, true)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
