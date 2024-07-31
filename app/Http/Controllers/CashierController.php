<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Items;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function create()
    {
        $items = Items::all(); // Get all items to populate the dropdown
        $sales = Sale::with('user')->get(); // Fetch sales data with associated user
        return view('cashier.index', compact('items', 'sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:item,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id(); // Get the authenticated user's ID

        // Create the sale
        $sale = Sale::create([
            'user_id' => $userId,
            'sale_date' => $request->sale_date,
            'total_price' => 0, // Total price will be calculated later
        ]);

        $totalPrice = 0;

        // Create sales items
        foreach ($request->items as $itemData) {
            $item = Items::find($itemData['item_id']);
            $price = $item->price;
            $quantity = $itemData['quantity'];

            SalesItem::create([
                'sale_id' => $sale->id,
                'item_id' => $itemData['item_id'],
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $totalPrice += $price * $quantity;
        }

        // Update total price
        $sale->update(['total_price' => $totalPrice]);

        return redirect()->route('sales.create')->with('success', 'Sale created successfully!');
    }
}
