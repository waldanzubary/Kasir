<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WarehouseController extends Controller
{
    public function Warehouse()
    {
        $items = Items::all();
        return view('Warehouse.index', compact('items'));
    }
    
    public function CreateIndex()

    {
        return view ('Warehouse.ItemCreate');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'itemName' => 'required|string|max:255',
        'price' => 'required|integer',
        'stock' => 'required|integer',
        'image' => 'nullable|image|max:2048',
    ]);

    // Create item first to get the ID
    $item = new Items($validated);
    $item->setStatus();
    $item->save();

    // Generate barcode using the item's ID
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

    return redirect('Warehouse');
}

    public function edit($id)
    {
        $item = items::findOrFail($id);
        return view('warehouse.edit', compact('item'));
    }

    public function update(Request $request, $id)
{
    $item = Items::findOrFail($id);
    $item->itemName = $request->input('itemName');
    $item->stock = $request->input('stock');
    $item->price = $request->input('price');

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $item->image = $imagePath;
    }

    // Regenerate barcode if it doesn't exist
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
        $item = items::findOrFail($id);
        $item->delete();

        return redirect('Warehouse');
    }

}
