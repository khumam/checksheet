<?php

namespace App\Services;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Services\ItemService;

class StockService
{
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function getAllData()
    {
        return Stock::latest()->get();
    }

    public function getAllDataById($id)
    {
        return Stock::where('item_id', $id)->latest()->get();
    }

    public function store(Request $request)
    {
        Stock::create(
            [
                'item_id' => $request->item_id,
                'expired' => $request->expired,
                'invoice' => $request->invoice,
                'total' => $request->total,
                'price' => $request->price,
            ]
        );

        return $this->itemService->calculateStock($request->item_id);
    }

    public function update(Request $request)
    {
        Stock::where('id', $request->id)->update(
            [
                'expired' => $request->expired,
                'invoice' => $request->invoice,
                'total' => $request->total,
                'price' => $request->price,
            ]
        );

        return $this->itemService->calculateStock($request->item_id);
    }

    public function delete(Request $request)
    {
        Stock::where('id', $request->id)->delete();

        return $this->itemService->calculateStock($request->itemid);
    }

    public function checkDuplicate($invoice = null, $item_id = null, $id = null)
    {
        return ($id == null) ? (Stock::where('invoice', $invoice)->where('item_id', $item_id)->count() == 0 ? true : false) : (Stock::where('invoice', $invoice)->where('item_id', $item_id)->whereNotIn('id', [$id])->count() == 0 ? true : false);
    }
}
