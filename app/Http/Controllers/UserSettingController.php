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

    /**
     * __construct
     *
     * @param  mixed $userSettingInterface
     * @return void
     */
    public function __construct(UserSettingInterface $userSettingInterface)
    {
        $this->userSettingInterface = $userSettingInterface;
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return view('usersetting.index');
    }

    /**
     * saveUser
     *
     * @param  mixed $request
     * @return void
     */
    public function saveUser(SettingUserRequest $request)
    {
        $act = $this->userSettingInterface->saveUser($request);
        return $this->sendRedirectTo($act, 'Berhasil merubah data user', 'Gagal merubah data user');
    }

    /**
     * savePassword
     *
     * @param  mixed $request
     * @return void
     */
    public function savePassword(UpdatePasswordRequest $request)
    {
        $act = $this->userSettingInterface->savePassword($request);
        return $this->sendRedirectTo($act, 'Berhasil merubah password user', 'Gagal merubah password user');
    }

    /**
     * saveProfilePicture
     *
     * @param  mixed $request
     * @return void
     */
    public function saveProfilePicture(UpdateProfilPicRequest $request)
    {
        $this->userSettingInterface->deleteOldImage();
        $act = $this->userSettingInterface->saveProfilePicture($request);

        return $this->sendRedirectTo($act, 'Berhasil merubah foto profil user', 'Gagal merubah foto profil user');
    }
}
