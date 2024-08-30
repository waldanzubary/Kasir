<?php
namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WarehouseController extends Controller
{
    public function Warehouse()
    {
        // Fetch only items belonging to the authenticated user
        $items = Items::where('user_id', Auth::id())->get();
        return view('Warehouse.index', compact('items'));
    }

    public function CreateIndex()
    {
        return view('Warehouse.ItemCreate');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'itemName' => 'required|string|max:255',
        'price' => 'required|integer',
        'stock' => 'required|integer',
        'image' => 'nullable|image|max:2048',
    ]);

    // Create a new item instance
    $item = new Items($validated);
    $item->user_id = Auth::id();  // Associate item with the authenticated user
    $item->setStatus();
    $item->save();

    $barcodeData = $item->id;
    $barcodeUrl = "https://barcodeapi.org/api/128/{$barcodeData}";
    $response = Http::get($barcodeUrl);

    if ($response->successful()) {
        $barcodeImagePath = 'barcodes/' . $barcodeData . '.png';
        Storage::disk('public')->put($barcodeImagePath, $response->body());
        $item->barcode = $barcodeImagePath;
    }

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $item->image = $imagePath;
    }

    $item->save();

    // Set a flash message
    return redirect('Warehouse')->with('success', 'Item added successfully!');
}


    public function edit($id)
    {
        // Ensure the user can only edit their own items
        $item = Items::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('warehouse.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Items::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->itemName = $request->input('itemName');
        $item->stock = $request->input('stock');
        $item->price = $request->input('price');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $item->image = $imagePath;
        }

        if (!$item->barcode) {
            $barcodeData = $item->id;
            $barcodeUrl = "https://barcodeapi.org/api/128/{$barcodeData}";
            $response = Http::get($barcodeUrl);

            if ($response->successful()) {
                $barcodeImagePath = 'barcodes/' . $barcodeData . '.png';
                Storage::disk('public')->put($barcodeImagePath, $response->body());
                $item->barcode = $barcodeImagePath;
            }
        }

        $item->setStatus();
        $item->save();

        return redirect('Warehouse');
    }

    public function destroy($id)
    {
        // Ensure the user can only delete their own items
        $item = Items::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->delete();

        return redirect('Warehouse');
    }

    public function downloadBarcode($id)
    {
        // Ensure the user can only download barcodes for their own items
        $item = Items::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($item->barcode) {
            $barcodePath = storage_path('app/public/' . $item->barcode);
            if (file_exists($barcodePath)) {
                return response()->download($barcodePath);
            } else {
                return redirect()->back()->with('error', 'Barcode file not found.');
            }
        } else {
            return redirect()->back()->with('error', 'No barcode available for this item.');
        }
    }
}
