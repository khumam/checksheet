<?php

namespace App\Repositories;

use App\Http\Requests\SettingUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilPicRequest;
use App\Interfaces\UserSettingInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserSettingRepository extends Repository implements UserSettingInterface
{
    public function __construct()
    {
        $this->model = new User();
        $this->fillable = $this->model->getFillable();
    }

    public function saveUser(SettingUserRequest $request)
    {
        return $this->model::where('id', Auth()->id())->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    }

    public function savePassword(UpdatePasswordRequest $request)
    {
        $request->password = Hash::make($request->password);
        return $this->model::where('id', Auth()->id())->update([
            'password' => $request->password,
        ]);
    }

    public function deleteOldImage()
    {
        $data = $this->get(['id' => Auth()->id()]);
        return Storage::delete($data->pic);
    }

    public function saveProfilePicture(UpdateProfilPicRequest $request)
    {
        $path = $request->file('photo')->store('profile');
        return $this->model::where('id', Auth()->id())->update(['pic' => $path]);
    }
}
