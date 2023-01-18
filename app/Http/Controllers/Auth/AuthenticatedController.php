<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(string $requestToken): Response
    {
        $token = Token::query()
            ->where('token', $requestToken)
            ->where('active', true)
            ->whereDate('expires_at', '>', now())
            ->firstOrFail();

        $user = $token->user;

        Auth::login($user);

        return Inertia::render('Dashboard', ['token' => $token]);
    }
}
