<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\TokenRequest;
use App\Services\ResetPasswordService;
use App\Services\TokenService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index($token)
    {
        return view('auth.resetpassword', compact('token'));
    }

    public function confirm()
    {
        return view('auth.confirmemail');
    }

    public function changePassword(ResetPasswordRequest $request, ResetPasswordService $resetPasswordService)
    {
        $act = $resetPasswordService->changePassword($request);

        if ($act) {
            return redirect()->back()->with('success', 'Berhasil merubah password');
        } else {
            return redirect()->back()->with('error', 'Gagal merubah password');
        }
    }

    public function send(Request $request, UserService $userService, TokenService $tokenService)
    {
        $userData = $userService->getData(['email' => $request->email]);
        if ($userData != null) {
            $tokenRequest = new TokenRequest();
            $tokenRequest->user_id = $userData->id;
            $tokenRequest->type = 'RESET PASSWORD';
            $tokenRequest->isUsed = 0;
            $tokenRequest->token = Hash::make($userData->email . $userData->id . time());

            $tokenService->createToken($tokenRequest);

            //sendToEmail
        }

        return redirect()->back()->with('success', 'Email reset password berhasil dikirimkan');
    }
}
