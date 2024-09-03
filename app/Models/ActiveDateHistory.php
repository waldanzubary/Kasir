<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveDateHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'duration',
        'activated_at',
        'active_date',    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}


