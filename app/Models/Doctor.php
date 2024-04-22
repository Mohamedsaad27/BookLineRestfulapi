<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctors';
    protected $fillable = [
        'DoctorName',
        'Specialization'
    ];
    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
