<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $table = 'clinics';
    protected $fillable = [
        'ClinicName',
        'ClinicLocation',
        'image'
    ];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
