<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('TeacherMiddleware', [
            'user' => $request->user(),
            'role' => $request->user() ? $request->user()->role : null
        ]);

        if (!$request->user() || $request->user()->role !== 'teacher') {
            Log::warning('Acceso denegado a profesor', [
                'user_id' => $request->user() ? $request->user()->id : null,
                'role' => $request->user() ? $request->user()->role : null
            ]);
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
