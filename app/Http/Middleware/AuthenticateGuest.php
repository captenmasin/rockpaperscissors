<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateGuest
{
    public function handle($request, Closure $next)
    {
        if (!$request->user()) {
            Auth::login(
                User::factory([
                    'id' => (int)str_replace('.', '', microtime(true))
                ])->create()
            );
        }

        return $next($request);
    }
}
