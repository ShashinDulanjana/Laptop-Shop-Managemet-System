<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // ඩේටාබේස් එකට එකපාර දත්ත ඇතුළත් කිරීමට අවසර දෙන තීරු (Columns)
    protected $fillable = [
        'laptop_id', 
        'name', 
        'phone', 
        'email', 
        'address', 
        'quantity', 
        'payment_method', 
        'card_name', 
        'card_number', 
        'card_expiry', 
        'card_cvc', 
        'status'
    ];

    // Laptop මොඩල් එක සමඟ ඇති සම්බන්ධතාවය (Relationship)
    public function laptop()
    {
        return $this->belongsTo(Laptop::class);
    }
}