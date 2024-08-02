<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function transaction()
    {
        // Fetch sales related to the logged-in user and eager load the user data
        $sales = Sale::where('buyer_id', Auth::id())->with('user')->get();

        // Pass sales data to the view
        return view('Transaction.Transaction', compact('sales'));
    }

    public function show($id)
{
    // Fetch the sale record by id
    $sale = Sale::with('user', 'salesItems')->findOrFail($id);

    // Return the detail view with sale data
    return view('Transaction.detail', compact('sale'));
}

}

