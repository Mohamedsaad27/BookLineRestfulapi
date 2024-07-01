<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    protected $fillable = [
        'hotel_id',
        'room_number',
        'room_type',
        'capacity',
        'price',
        'description',
        'status',
    ];
    public function bookings()
    {
        return $this->hasMany(Room_Booking::class, 'room_id');
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class,'hotel_id');
    }
}
