<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
protected $table = 'clinics';
    protected $primaryKey = 'ClinicID';
    protected $fillable = [
        'ClinicName',
        'ClinicLocation',
        'image'
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_clinic', 'ClinicID', 'DoctorID');
    }
}
