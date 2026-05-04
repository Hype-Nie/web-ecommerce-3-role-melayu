<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $hasRole = false;

        foreach ($roles as $role) {
            $hasRole = match ($role) {
                'admin' => $user->isAdmin(),
                'seller' => $user->isSeller(),
                'customer' => $user->isCustomer(),
                default => false,
            };

            if ($hasRole) {
                break;
            }
        }

        if (!$hasRole) {
            abort(403, 'Anda tidak mempunyai akses ke halaman ini.');
        }

        return $next($request);
    }
}
