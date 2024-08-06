<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class TotalController extends Controller
{

    public function latest()
    {
        // Fetch the latest sale record, including related user and salesItems
        $sale = Sale::with('user', 'salesItems.item')->latest()->first();

        // Return the detail view with the latest sale data
        return view('Transaction.total', compact('sale'));
    }
}
