<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Stock;
use Illuminate\Http\Request;

class ItemService
{
    public function getAllData()
    {
        return Item::latest()->get();
    }

    public function detail($id)
    {
        return Item::where('id', $id)->first();
    }

    public function store(Request $request)
    {
        return Item::create(
            [
                'name' => $request->name,
            ]
        );
    }

    public function update(Request $request)
    {
        return Item::where('id', $request->id)->update(
            [
                'name' => $request->name,
            ]
        );
    }

    public function delete(Request $request)
    {
        Stock::where('item_id', $request->id)->delete();
        return Item::where('id', $request->id)->delete();
    }

    public function transactions($id)
    {
        return Stock::where('item_id', $id)->with('item')->get();
    }

    public function calculateStock($item_id = null)
    {
        $stock = Stock::where('item_id', $item_id)->sum('total');

        return Item::where('id', $item_id)->update(
            [
                'stock' => $stock,
            ]
        );
    }

    public function checkDuplicate($name = null, $id = null)
    {
        return ($id == null) ? (Item::where('name', $name)->count() == 0 ? true : false) : (Item::where('name', $name)->whereNotIn('id', [$id])->count() == 0 ? true : false);
    }
}
