<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorClinic extends Model
{
    use HasFactory;
    protected $table = 'doctor_clinic';
    protected $primaryKey = ['DoctorID','ClinicID'];
    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = [
        'DoctorID',
        'ClinicID'
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'DoctorID');
    }
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'DoctorID');
    }
}
