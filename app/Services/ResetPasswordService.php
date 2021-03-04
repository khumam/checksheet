<?php

namespace App\Services;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ResetPasswordService
{
    const TOKEN_TYPE = 'RESET PASSWORD';

    public function changePassword(Request $request, TokenService $tokenService)
    {
        $tokenData = $this->_checkPasswordToken($request);

        if ($tokenData != null) {
            User::where('id', $tokenData->user_id)->update(
                [
                    'password' => Hash::make($request->password)
                ]
            );

            return $tokenService->useToken($tokenData);
        }
    }

    private function _checkPasswordToken(Request $request, TokenService $tokenService)
    {
        $credential = [
            'token' => $request->token,
            'type' => ResetPasswordService::TOKEN_TYPE,
            'isUsed' => 0
        ];

        return $tokenService->checkToken($credential);
    }
}
