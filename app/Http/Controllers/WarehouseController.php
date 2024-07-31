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


    public function CreateItem()

    {

    }




}
