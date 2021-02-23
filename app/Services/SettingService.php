<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Str;

class SettingService
{
    public function saveUser(Request $request)
    {
        return User::where('id', Auth()->user()->id)->update(
            [
                'name' => $request->name,
                'email' => $request->email
            ]
        );
    }

    public function savePassword(Request $request)
    {
        return User::where('id', Auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
    }

    public function deleteOldImage()
    {
        $image = User::where('id', Auth()->user()->id)->first();
        return (Auth()->user()->pic != null) ? File::delete(public_path('profile/' . $image->pic)) : true;
    }

    public function saveImage(Request $request)
    {
        $name = Str::slug(Auth()->user()->name, '-') . Auth()->user()->id . '-' . time() . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->move(public_path('profile'), $name);
        return User::where('id', Auth()->user()->id)->update([
            'pic' => $name
        ]);
    }
}
