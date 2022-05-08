<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilPicRequest;
use App\Interfaces\UserSettingInterface;
use App\Models\User;
use App\Repositories\SettingService;
use App\Traits\RedirectNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    use RedirectNotification;

    protected $userSettingInterface;

    public function __construct(UserSettingInterface $userSettingInterface)
    {
        $this->userSettingInterface = $userSettingInterface;
    }

    public function index()
    {
        return view('usersetting.index');
    }

    public function saveUser(SettingUserRequest $request)
    {
        $act = $this->userSettingInterface->saveUser($request);
        return $this->sendRedirectTo($act, 'Berhasil merubah data user', 'Gagal merubah data user');
    }

    public function savePassword(UpdatePasswordRequest $request)
    {
        $act = $this->userSettingInterface->savePassword($request);
        return $this->sendRedirectTo($act, 'Berhasil merubah password user', 'Gagal merubah password user');
    }

    public function saveProfilePicture(UpdateProfilPicRequest $request)
    {
        $this->userSettingInterface->deleteOldImage();
        $act = $this->userSettingInterface->saveProfilePicture($request);

        return $this->sendRedirectTo($act, 'Berhasil merubah foto profil user', 'Gagal merubah foto profil user');
    }
}
