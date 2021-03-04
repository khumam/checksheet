<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenRequest;
use App\Services\TokenService;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function createToken(TokenRequest $request, TokenService $tokenService)
    {
        $act = $tokenService->createToken($request);

        if ($act) {
            return redirect()->back()->with('success', 'Berhasil merubah data');
        } else {
            return redirect()->back()->with('error', 'Gagal merubah data');
        }
    }
}
