<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function Warehouse()
    {
        $Item = items::all();

        return view('Warehouse.index', ['Item'=> $Item]);
        // return view ('Warehouse.index');
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

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        items::create($validated);

        return redirect('Warehouse');
    }


    public function edit($id)
{
    $item = items::findOrFail($id);
    return view('warehouse.edit', compact('item'));
}

public function update(Request $request, $id)
{
    $item = items::findOrFail($id);
    $item->itemName = $request->input('itemName');
    $item->stock = $request->input('stock');
    $item->price = $request->input('price');

    // Handle image upload if needed
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $item->image = $imagePath;
    }

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
