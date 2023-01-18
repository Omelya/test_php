<?php

namespace App\Services\RegisteredUser;

use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RegisteredUserServices
{
    public function create(Request $request)
    {


        $user = User::create([
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        return Token::create([
            'user_id' => $user->id,
            'active' => true,
            'token' => Str::random(64),
            'expires_at' => Carbon::now()->addDay(7)
        ]);
    }

    public function hasUser(Request $request): bool
    {
        return (bool) User
            ::query()
            ->where('username', $request->username)
            ->first();
    }

    public function update(Request $request)
    {
        $user = User
            ::query()
            ->where('username', $request->username)
            ->first();

        $isMatch = Hash::check($request->password ,$user->password);

        if (!$isMatch) {
            throw new AccessDeniedHttpException('Password mismatch');
        }

        return Token::create([
            'user_id' => $user->id,
            'active' => true,
            'token' => Str::random(64),
            'expires_at' => Carbon::now()->addDay(7)
        ]);
    }

    public function action(Request $request)
    {
        return $this->hasUser($request)
            ? $this->update($request)
            : $this->create($request);
    }
}
