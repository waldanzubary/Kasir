<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    // Menampilkan transaksi
    public function transactions(Request $request)
    {
        $query = Sale::where('user_id', Auth::id())->with('user', 'salesItems.item');

        // Menerapkan filter tanggal jika disediakan
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('sale_date', [$startDate, $endDate]);
        }

        $sales = $query->get();

        // Menyiapkan data untuk grafik dan statistik
        $totalTransactions = $sales->count();
        $totalItems = $sales->sum('salesItems_count'); // Pastikan 'salesItems_count' adalah atribut yang benar
        $totalSpent = $sales->sum('total_price');
        $months = $sales->groupBy(function ($sale) {
            return Carbon::parse($sale->sale_date)->format('F'); // Kelompokkan berdasarkan bulan
        })->keys();
        $amounts = $sales->groupBy(function ($sale) {
            return Carbon::parse($sale->sale_date)->format('F'); // Kelompokkan berdasarkan bulan
        })->map->sum('total_price')->values();
        $overviewLabels = ['Sales', 'Items Sold', 'Total Gain'];
        $overviewValues = [$totalTransactions, $totalItems, $totalSpent];

        return view('Transaction.StaffTransaction', compact('sales', 'totalTransactions', 'totalItems', 'totalSpent', 'months', 'amounts', 'overviewLabels', 'overviewValues'));
    }

    // Mengekspor transaksi ke PDF
    public function exportPdf(Request $request, PDF $pdf)
{
    $query = Sale::where('user_id', Auth::id())->with('user', 'salesItems.item');

    if ($request->has('start_date') && $request->has('end_date')) {
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        $query->whereBetween('sale_date', [$startDate, $endDate]);
    }

    $sales = $query->get();

    // Debugging
    // dd($sales);

    $pdf = $pdf->loadView('Transaction.pdf', compact('sales'));
    return $pdf->download('sales_report.pdf');
}

}
