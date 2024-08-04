<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function transactions()
    {
        // Fetch sales related to the logged-in user and eager load the user data
        $sales = Sale::where('user_id', Auth::id())->with('user', 'salesItems.item')->get();

        // Calculate totals
        $totalTransactions = $sales->count();
        $totalItems = $sales->reduce(function ($carry, $sale) {
            return $carry + $sale->salesItems->sum('quantity');
        }, 0);
        $totalSpent = $sales->sum('total_price');

        // Pass sales data and totals to the view
        return view('Transaction.StaffTransaction', compact('sales', 'totalTransactions', 'totalItems', 'totalSpent'));
    }

    // public function show($id)
    // {
    //     // Fetch the sale record by id, including related user and salesItems
    //     $sale = Sale::with('user', 'salesItems.item')->findOrFail($id);

    //     // Return the detail view with the sale data
    //     return view('Transaction.detail', compact('sale'));
    // }
}
