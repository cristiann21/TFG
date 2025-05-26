<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        Log::info('CheckRole middleware', [
            'user' => $request->user(),
            'expected_role' => $role,
            'actual_role' => $request->user() ? $request->user()->role : null
        ]);

        if (!$request->user() || $request->user()->role !== $role) {
            Log::warning('Acceso denegado', [
                'user_id' => $request->user() ? $request->user()->id : null,
                'expected_role' => $role,
                'actual_role' => $request->user() ? $request->user()->role : null
            ]);
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
} 