<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'laptop_id',
        'quantity',
        'total_price',
        'user_id'
    ];

    // Laptop එක සමඟ ඇති සම්බන්ධතාවය (Relationship)
    public function laptop()
    {
        return $this->belongsTo(Laptop::class);
    }

    // බිල්පත දැමූ පරිශීලකයා (User/Sales Assistant)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}