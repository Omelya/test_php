<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = Auth
            ::user()
            ->tokens()
            ->where('active', 1)
            ->first();

        if ($token) {
            $token->expires_at < now() && throw new AccessDeniedException('Token expired');
        } else {
            throw new AccessDeniedException('Unauthorized');
        }

        return $next($request);
    }
}
