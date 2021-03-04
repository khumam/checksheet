<?php

namespace App\Services;

use App\Http\Requests\TokenRequest;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TokenService
{
    public function createToken(TokenRequest $request)
    {
        return Token::create(
            [
                'user_id' => $request->user_id,
                'token' => Hash::make($request->token),
                'type' => strtoupper($request->type),
                'isUsed' => 0
            ]
        );
    }

    public function useToken($credential)
    {
        return Token::where('id', $credential->id)->update(['isUsed' => 1]);
    }

    public function checkToken($credential)
    {
        return Token::where($credential)->first();
    }

    public function deleteToken(Request $request)
    {
        return Token::where('id', $request->id)->delete();
    }
}
