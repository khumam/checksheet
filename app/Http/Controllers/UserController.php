<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function list(UserService $userService)
    {
        $data = $userService->getAllData();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return "<div class='btn-group'>
                        <a class='btn btn-primary btn-sm' href='" . route('user.show', $data->id) . "'>
                            <i class='anticon anticon-search'></i>
                        </a>
                        <button class='btn btn-danger btn-sm deleteButton' data-id='$data->id' data-form='#userDeleteButton$data->id'>
                            <i class='anticon anticon-delete'></i>
                        </button>
                        <form id='userDeleteButton$data->id' action='" . route('user.destroy', $data->id) . "' method='POST'>" . csrf_field() . " " . method_field('DELETE') . "
                        </form>
                    </div>";
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, UserService $userService)
    {
        $act = $userService->update($request);

        if ($act) {
            return redirect()->back()->with('success', 'Berhasil mengubah user');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah user');
        }
    }

    public function detail(Request $request, UserService $userService)
    {
        $act = $userService->detail($request);

        return response()->json($act);
    }

    public function destroy($id, userService $userService)
    {
        $act = $userService->delete($id);

        if ($act) {
            return redirect()->back()->with('success', 'Berhasil menghapus user');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus user');
        }
    }

    public function show($id, UserService $userService)
    {
        $detail = $userService->get($id);

        return view('user.show', compact('detail'));
    }
}
