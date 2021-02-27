<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function update(Request $request)
    {
        return User::where('id', $request->id)->update(
            [
                'name' => $request->name,
                'email' => $request->email
            ]
        );
    }

    public function detail(Request $request)
    {
        return User::where('id', $request->id)->first();
    }

    public function beAdmin(Request $request)
    {
        $checkUser = $this->detail($request);

        if ($checkUser->role) {
            return User::where('id', $request->id)->update(
                [
                    'role' => 'admin'
                ]
            );
        } else {
            return false;
        }
    }

    public function delete(Request $request)
    {
        return User::where('id', $request->id)->delete();
    }

    public function getAllData()
    {
        return User::latest()->get();
    }
}
