<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        Token
            ::query()
            ->where('user_id', Auth::user()->id)
            ->where('token', $request->input('token'))
            ->update([
                'token' => $request->input('update_token')
                    ? Str::random(64)
                    : $request->input('token'),
                'active' => $request->input('active') ?? true
            ]);


        return response()->json(['data' => [
            'token' => Token
                ::query()
                ->where('user_id', Auth::user()->id)
                ->first()
        ]]);
    }
}
