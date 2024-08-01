<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Items;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    // public function showScanner()
    // {
    //     return view('cashier.scanner');
    // }

    public function processBarcode(Request $request)
{
    $barcode = $request->input('barcode');
    $item = Items::where('id', $barcode)->first();

    if ($item) {
        return response()->json([
            'status' => 'success',
            'item' => $item
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Item not found'
        ], 404);
    }
}
}

