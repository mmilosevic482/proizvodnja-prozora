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
        // 1. Ako je CREATE ruta, preskoči middleware (PRIVREMENO)
        if ($request->is('narudzbine/create') || $request->isMethod('post')) {
            return $next($request);
        }

        // 2. Proveri da li je korisnik ulogovan
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 3. Ako nema specificiranih uloga, dozvoli pristup
        if (empty($roles)) {
            return $next($request);
        }

        // 4. Proveri da li korisnik ima neku od traženih uloga
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // 5. Ako nema prava, dozvoli (PRIVREMENO) ili vrati 403
        // PRIVREMENO: Dozvoli sve
        return $next($request);
        // ILI: abort(403, 'Nemate pristup');
    }
}
