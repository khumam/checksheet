<?php

namespace App\Interfaces;

use App\Http\Requests\SettingUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilPicRequest;

interface UserSettingInterface
{
    public function saveUser(SettingUserRequest $request);
    public function savePassword(UpdatePasswordRequest $request);
    public function saveProfilePicture(UpdateProfilPicRequest $request);
    public function deleteOldImage();
}
