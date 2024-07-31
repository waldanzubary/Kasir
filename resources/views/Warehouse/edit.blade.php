@extends('Layout.Layout')

@section('content')
<div class="container">
    <h1>Edit Item</h1>

    <form action="{{ route('warehouse.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="itemName">Item Name</label>
            <input type="text" class="form-control" id="itemName" name="itemName" value="{{ $item->itemName }}" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $item->stock }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ $item->price }}" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @if ($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="Current Image" style="width: 100px; height: auto; margin-top: 10px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
