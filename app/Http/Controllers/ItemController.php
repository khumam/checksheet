<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\ItemService;
use Illuminate\Http\Request;
use DataTables;

class ItemController extends Controller
{
    public function index()
    {
        return view('item.index');
    }

    public function show($id, ItemService $itemService)
    {
        $detail = $itemService->detail($id);
        $totalPrice = Stock::where('item_id', $id)->max('price');
        $expired = Stock::where('item_id', $id)->min('expired');

        return view('item.show', compact('detail', 'totalPrice', 'expired'));
    }

    public function list(ItemService $itemService)
    {
        $data = $itemService->getAllData();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return "<div class='btn-group'>
                        <a class='btn btn-primary btn-sm detailButton' href='" . route('item_show', $data->id) . "'>
                            <i class='anticon anticon-search'></i>
                        </a>
                        <button class='btn btn-danger btn-sm deleteButton' data-id='$data->id'>
                            <i class='anticon anticon-delete'></i>
                        </button>
                    </div>";
            })
            ->rawColumns(['artikel', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request, ItemService $itemService)
    {
        if ($itemService->checkDuplicate($request->name)) {
            $act = $itemService->store($request);

            if ($act) {
                return redirect()->back()->with('success', 'Berhasil menambahkan item');
            } else {
                return redirect()->back()->with('error', 'Gagal menambahkan item');
            }
        } else {
            return redirect()->back()->with('error', 'Item telah tersedia');
        }
    }

    public function update(Request $request, ItemService $itemService)
    {
        if ($itemService->checkDuplicate($request->name, $request->id)) {
            $act = $itemService->update($request);

            if ($act) {
                return redirect()->back()->with('success', 'Berhasil mengubah item');
            } else {
                return redirect()->back()->with('error', 'Gagal mengubah item');
            }
        } else {
            return redirect()->back()->with('error', 'Item telah tersedia');
        }
    }

    public function delete(Request $request, ItemService $itemService)
    {
        $act = $itemService->delete($request);

        if ($act) {
            return $this->sendNotificiation('success', 'Berhasil menghapus item');
        } else {
            return $this->sendNotificiation('error', 'Gagal menghapus item');
        }
    }
}
