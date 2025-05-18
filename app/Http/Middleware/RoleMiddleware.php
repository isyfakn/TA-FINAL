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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if user has completed their profile
            if ($user->role == 'mahasiswa' && !$user->mahasiswa) {
                return redirect()->route('mahasiswa.create');
            }
            
            if ($user->role == 'organisasi' && !$user->organisasi) {
                return redirect()->route('organisasi.create');
            }
        }
        
        return $next($request);
    }
}
