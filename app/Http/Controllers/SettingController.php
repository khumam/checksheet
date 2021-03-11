<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilPicRequest;
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

    public function saveUser(SettingUserRequest $request, SettingService $settingService)
    {
        $act = $settingService->saveUser($request);

        if ($act) {
            return back()->with('success', 'Berhasil merubah data');
        } else {
            return back()->with('error', 'Gagal merubah data');
        }
    }

    public function savePassword(UpdatePasswordRequest $request, SettingService $settingService)
    {

        $act = $settingService->savePassword($request);

        if ($act) {
            return back()->with('success', 'Berhasil merubah password');
        } else {
            return back()->with('error', 'Password lama tidak sesuai');
        }
    }

    public function savePhotoProfile(UpdateProfilPicRequest $request, SettingService $settingService)
    {
        $deleteOldImage = $settingService->deleteOldImage();
        $save = $settingService->saveImage($request);

        if ($save) {
            return back()->with('success', 'Berhasil merubah gambar');
        } else {
            return back()->with('error', 'Gagal merubah gambar');
        }
    }
}
