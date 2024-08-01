<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Models\Items;
use App\Models\SalesItem;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function create()
    {
        $items = Items::all();
        $sales = Sale::with('user')->get();
        return view('Cashier.scanner', compact('items', 'sales'));
    }

    public function store(Request $request)
    {
        $sale = Sale::create([
            'user_id' => auth()->id(),  // Assuming the user is authenticated
            'sale_date' => $request->sale_date,
            'total_price' => $request->total_price,
        ]);

        foreach ($request->items as $item) {
            SalesItem::create([
                'sale_id' => $sale->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('sales.creates')->with('success', 'Sale created successfully!');
    }
}

