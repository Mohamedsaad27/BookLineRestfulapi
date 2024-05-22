<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $primaryKey = 'AppointmentID';
    protected $table = 'appointments';
    public $timestamps = false;
    protected $fillable = [
      'ClinicID',
      'DoctorID',
      'user_ID',
      'AppointmentTime',
      'AppointmentDate',
      'PatientName',
      'phone',
      'Email',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function clinic(){
        return $this->belongsTo(clinic::class);
    }

    public function Doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
