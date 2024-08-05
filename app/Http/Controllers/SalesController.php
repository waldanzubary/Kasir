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
        $items = Items::all(); // Perbaiki penggunaan model
        $sales = Sale::with('user')->get();
        $buyers = User::all();
        return view('Cashier.scanner', compact('items', 'sales', 'buyers'));
    }

    public function store(Request $request)
{
    $request->validate([
        'sale_date' => 'required|date',
        'payment' => 'required|in:Cash,E-Wallet,Bank',
        'buyer_id' => 'nullable|exists:users,id',
        'items' => 'required|array',
        'items.*.item_id' => 'required|exists:item,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    // Create a new sale instance
    $sale = new Sale([
        'user_id' => auth()->id(),
        'sale_date' => $request->sale_date,
        'total_price' => $request->total_price,
        'payment' => $request->payment,
        'buyer_id' => $request->buyer_id,
    ]);

    // Validate stock for each item
    foreach ($request->items as $item) {
        $itemModel = Items::find($item['item_id']);
        if (!$itemModel || $itemModel->stock < $item['quantity']) {
            return redirect()->back()->with('error', 'Not enough stock for item: ' . $itemModel->itemName)->withInput();
        }
    }

    // Save the sale
    $sale->save();

    // Save each item and update stock
    foreach ($request->items as $item) {
        SalesItem::create([
            'sale_id' => $sale->id,
            'item_id' => $item['item_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);

        $itemModel = Items::find($item['item_id']);
        $itemModel->reduceStock($item['quantity']);
    }

    return redirect()->route('sales.creates')->with('success', 'Sale created successfully!');
}


    public function barcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string'
        ]);

        $item = Items::where('id', $request->barcode)->first();

        if ($item) {
            if ($item->isInStock()) {
                return response()->json([
                    'status' => 'success',
                    'item' => $item
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item is out of stock'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found'
            ]);
        }
    }
}
