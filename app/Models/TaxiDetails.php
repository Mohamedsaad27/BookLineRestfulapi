<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxiDetails extends Model
{
    use HasFactory;
    protected $table = 'taxi_details';
    protected $fillable = [
        'car_name',
        'driver_name',
        'driver_phone',
        'driver_rate',
        'image',
        'Availability',
        'price',
    ];
}
