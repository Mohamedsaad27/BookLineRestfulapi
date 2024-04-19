<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_Name',
        'hotel_ID',
        'hotel_location',
        'hotel_phone',
        'Room_Price'
    ];
}
