<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    /**
     * දත්ත සමුදායට (Database) එකවර ඇතුළත් කිරීමට අවසර දෙන තීරු (Columns).
     * මේවා අපි migration එකේදී හදපු නම්ම විය යුතුයි.
     */
    protected $fillable = [
        'brand',
        'model',
        'price',
        'specifications',
        'stock',
        'image',
    ];
}