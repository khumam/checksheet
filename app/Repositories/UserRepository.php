<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use App\Traits\RedirectNotification;
use Illuminate\Http\Request;

class UserRepository extends Repository implements UserInterface
{
    use RedirectNotification;

    public function __construct()
    {
        $this->model = new User();
        $this->fillable = $this->model->getFillable();
        $this->datatableSourceData = $this->getAll();
        $this->datatableAction = ["SHOW", "DELETE"];
        $this->datatableHeader = ["Nama" => "name", "Email" => "email"];
        $this->datatableRoute = 'admin.user';
    }

    public function beAdmin(Request $request)
    {
        $checkUser = $this->get(['id', $request->id]);

        if ($checkUser->role) {
            $data = (object) ['role' => 'admin'];
            return $this->update($data, ['id', $request->id]);
        }

        return true;
    }
}
