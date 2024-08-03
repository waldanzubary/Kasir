<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Items;
use App\Models\SalesItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function create()
    {
        $items = Items::all(); // Get all items to populate the dropdown
        $buyers = User::all(); // Get all buyers
        $sales = Sale::with('user')->get(); // Fetch sales data with associated user
        return view('cashier.index', compact('items', 'buyers', 'sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'buyer_id' => 'nullable|exists:users,id',
            'payment' => 'required|in:Cash,E-Wallet,Bank',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:item,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id(); // Get the authenticated user's ID

        // Create the sale
        $sale = Sale::create([
            'user_id' => $userId,
            'buyer_id' => $request->buyer_id,
            'sale_date' => $request->sale_date,
            'total_price' => 0,
            'payment' => $request->payment,
        ]);

        $totalPrice = 0;

        // Create sales items and update stock
        foreach ($request->items as $itemData) {
            $item = Items::find($itemData['item_id']);
            $quantity = $itemData['quantity'];

            if ($item->reduceStock($quantity)) {
                $price = $item->price;
                SalesItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $itemData['item_id'],
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $totalPrice += $price * $quantity;
            } else {
                return redirect()->back()->withErrors(['message' => 'Not enough stock for item: ' . $item->itemName]);
            }
        }

        // Update total price
        $sale->update(['total_price' => $totalPrice]);

        return redirect()->route('sales.create')->with('success', 'Sale created successfully!');
    }
}
