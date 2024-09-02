<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticateGuest
{
    public function handle($request, Closure $next)
    {
        if (! $request->user()) {
            Auth::login(
                User::factory([
                    'id' => (int) str_replace('.', '', microtime(true)),
                ])->create()
            );
        }

        return $next($request);
    }
}
