<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function saveUser(Request $request, SettingService $settingService)
    {
        $request->validate([
            'name' => 'string|required|min:4',
            'email' => 'email|required'
        ]);

        $act = $settingService->saveUser($request);

        if ($act) {
            return redirect()->back()->with('success', 'Berhasil merubah data');
        } else {
            return redirect()->back()->with('error', 'Gagal merubah data');
        }
    }

    public function savePassword(Request $request, SettingService $settingService)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'same:new_password|min:6|different:old_password'
        ]);

        $user = User::where('id', Auth()->user()->id)->first();

        if (Hash::check($request->old_password, $user->password)) {
            $settingService->savePassword($request);

            return redirect()->back()->with('success', 'Berhasil merubah password');
        } else {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }
    }

    public function savePhotoProfile(Request $request, SettingService $settingService)
    {
        $request->validate([
            'photo' => 'image|max:1024'
        ]);

        $deleteOldImage = $settingService->deleteOldImage();
        $save = ($deleteOldImage) ? $settingService->saveImage($request) : false;

        if ($save) {
            return redirect()->back()->with('success', 'Berhasil merubah gambar');
        } else {
            return redirect()->back()->with('error', 'Gagal merubah gambar');
        }
    }
}
