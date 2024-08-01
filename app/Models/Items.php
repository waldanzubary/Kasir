<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;
    protected $table = 'item';

    protected $fillable = [
        'itemName',
        'id',
        'price',
        'stock',
        'image',

    ];

    /**
     * Get the peminjamans for the book.
     */


}
