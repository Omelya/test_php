<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\RegisteredUser\RegisteredUserServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request, RegisteredUserServices $registeredUserServices): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $token = $registeredUserServices->action($request);

        return redirect(RouteServiceProvider::HOME . '/' . $token->token);
    }
}
