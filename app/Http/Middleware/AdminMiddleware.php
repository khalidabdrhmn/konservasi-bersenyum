<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        // Memastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Memastikan pengguna adalah administrator
        $user = auth()->user();
        if (!$user->is_admin && !$user->hasAnyRole(['super-admin', 'admin', 'editor'])) {
            abort(403, 'Anda tidak memiliki akses administrator.');
        }

        return $next($request);
    }
}
