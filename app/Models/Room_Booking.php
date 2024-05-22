<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Booking extends Model
{
    use HasFactory;
    protected $table = 'room_bookings';
    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'booking_id',
        'first_name',
        'last_name',
        'email',
        'room_type'
        ,'Room_Number'
        ,'hotel_ID'
        ,'hotel_Name'
        ,'user_id'
        ,'booking_time'
        ,'special_requests'
        ,'num_guests'
    ];

}
