<?php

namespace App\Http\Controllers;

use App\Services\StockService;
use Illuminate\Http\Request;
use DataTables;

class StockController extends Controller
{
    public function index()
    {
        return view('admin.stock.index');
    }

    public function list(Request $request, StockService $stockService)
    {
        $data = $stockService->getAllDataById($request->id);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return "<div class='btn-group'>
                        <button class='btn btn-danger btn-sm deleteButton' data-id='$data->id' data-itemid='$data->item_id'>
                            <i class='anticon anticon-delete'></i>
                        </button>
                    </div>";
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request, StockService $stockService)
    {
        if ($stockService->checkDuplicate($request->invoice, $request->item_id)) {
            $act = $stockService->store($request);

            if ($act) {
                return redirect()->back()->with('success', 'Berhasil menambahkan transaksi', 'Stok akan dihitung otomatis');
            } else {
                return redirect()->back()->with('error', 'Gagal menambahkan transaksi');
            }
        } else {
            return redirect()->back()->with('error', 'No Invoice harus berbeda');
        }
    }

    public function update(Request $request, StockService $stockService)
    {
        if ($stockService->checkDuplicate($request->invoice, $request->item_id, $request->id)) {
            $act = $stockService->update($request);

            if ($act) {
                return redirect()->back()->with('success', 'Berhasil mengubah transaksi');
            } else {
                return redirect()->back()->with('error', 'Gagal mengubah transaksi');
            }
        } else {
            return redirect()->back()->with('error', 'No Inoice harus berbeda');
        }
    }

    public function delete(Request $request, StockService $stockService)
    {
        $act = $stockService->delete($request);

        if ($act) {
            return $this->sendNotificiation('success', 'Berhasil menghapus transkasi', 'Stok akan dihitung otomatis');
        } else {
            return $this->sendNotificiation('error', 'Gagal menghapus transkasi');
        }
    }
}
