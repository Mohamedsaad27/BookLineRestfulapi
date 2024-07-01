<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Booking extends Model
{
    use HasFactory;

    protected $table = 'room_bookings';
    public $timestamps = false;
    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'room_id',
        'hotel_ID',
        'user_id',
        'booking_time',
        'special_requests',
        'num_guests'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_ID');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

