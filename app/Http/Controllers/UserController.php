<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use App\Traits\RedirectNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use RedirectNotification;

    protected $userInterface;

    /**
     * __construct
     *
     * @param  UserInterface $userInterface
     * @return void
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $act = $this->userInterface->store($request);
        return $this->sendRedirectTo($act, 'Berhasil menambahkan user baru', 'Gagal menambahkan user baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->userInterface->get(['id' => $id]);
        return view('user.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->userInterface->get(['id' => $id]);
        return view('user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $act = $this->userInterface->update($request, ['id' => $id]);
        return $this->sendRedirectTo($act, 'Berhasil merubah data user', 'Gagal merubah data user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $act = $this->userInterface->destroy(['id' => $id]);
        return $this->sendRedirectTo($act, 'Berhasil menghapus data user', 'Gagal menghapus data user');
    }

    public function list()
    {
        $data = $this->userInterface->getAll();

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
}
