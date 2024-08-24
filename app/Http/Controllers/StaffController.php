<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function transactions()
    {
        $sales = Sale::where('user_id', Auth::id())->with('user', 'salesItems.item')->get();

        // Prepare monthly data
        $monthlyData = $sales->groupBy(function($sale) {
            return Carbon::parse($sale->sale_date)->format('Y-m');
        })->map(function($monthSales) {
            return $monthSales->sum('total_price');
        });

        $monthlyTransactionCounts = $sales->groupBy(function($sale) {
            return Carbon::parse($sale->sale_date)->format('Y-m');
        })->map(function($monthSales) {
            return $monthSales->count();
        });

        $months = $monthlyData->keys()->toArray();
        $amounts = $monthlyData->values()->toArray();
        $transactionCounts = $monthlyTransactionCounts->values()->toArray();

        // Prepare sales overview data
        $overviewData = $sales->groupBy('payment')->map->count();
        $overviewLabels = $overviewData->keys()->toArray();
        $overviewValues = $overviewData->values()->toArray();

        $totalTransactions = $sales->count();
        $totalItems = $sales->reduce(function ($carry, $sale) {
            return $carry + $sale->salesItems->sum('quantity');
        }, 0);
        $totalSpent = $sales->sum('total_price');

        return view('Transaction.StaffTransaction', compact('sales', 'totalTransactions', 'totalItems', 'totalSpent', 'months', 'amounts', 'transactionCounts', 'overviewLabels', 'overviewValues'));
    }


    // public function show($id)
    // {
    //     // Fetch the sale record by id, including related user and salesItems
    //     $sale = Sale::with('user', 'salesItems.item')->findOrFail($id);

    //     // Return the detail view with the sale data
    //     return view('Transaction.detail', compact('sale'));
    // }
}
