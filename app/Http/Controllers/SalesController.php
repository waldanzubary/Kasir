<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use App\Models\Items;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function create()
    {
        $items = Items::all();
        $sales = Sale::with('user')->get();
        $buyers = User::all(); // Fetch all buyers
        return view('Cashier.scanner', compact('items', 'sales', 'buyers'));
    }
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'sale_date' => 'required|date',
            'payment' => 'required|in:Cash,E-Wallet,Bank',
            'buyer_id' => 'nullable|exists:users,id',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Create the sale
        $sale = Sale::create([
            'user_id' => auth()->id(),
            'sale_date' => $request->sale_date,
            'total_price' => $request->total_price,
            'payment' => $request->payment,
            'buyer_id' => $request->buyer_id,
        ]);

        // Create sales items
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
