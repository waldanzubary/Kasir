<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    'buyer_id',
    'sale_date',
    'total_price',
    'payment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesItems()
    {
        return $this->hasMany(SalesItem::class);
    }

    

}
