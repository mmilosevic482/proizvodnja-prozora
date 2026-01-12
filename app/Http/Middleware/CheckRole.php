<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Proveri da li je korisnik ulogovan
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Ako nema specificiranih uloga, dozvoli pristup
        if (empty($roles)) {
            return $next($request);
        }

        // 3. Proveri da li korisnik ima neku od traženih uloga
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // 4. Ako nema prava, vrati ga na dashboard
        return redirect('/dashboard')->with('error', 'Nemate pristup ovoj stranici.');
    }
}
