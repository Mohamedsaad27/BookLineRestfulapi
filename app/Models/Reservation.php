<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservations';
    protected $fillable = [
        'name',
        'email',
        'members',
        'user_id',
        'Restaurant_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
