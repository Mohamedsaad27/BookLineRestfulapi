<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';
    protected $primaryKey = 'hotel_ID';
    protected $fillable = [
        'hotel_Name',
        'hotel_ID',
        'hotel_location',
        'hotel_phone',
        'Room_Price'
        ,'image'
    ];
    public function rooms(){
        return $this->hasMany(Room::class);
    }
    public function bookings()
    {
        return $this->hasMany(Room_Booking::class, 'hotel_ID');
    }
}
