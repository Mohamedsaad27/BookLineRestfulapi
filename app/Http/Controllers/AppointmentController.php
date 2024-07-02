<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorClinic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function doctors(){
        try {
            $doctors = Doctor::all();
            if($doctors->isEmpty()){
                return response()->json(['message'=>'No Doctors Founded'],404);
            }
            $doctors = $doctors->map(function ($doctors) {
                $doctors->image = '/storage/' . $doctors->image;
                return $doctors;
            });
            return response()->json($doctors,200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()]);
        }
    }
    public function clinics(){

        try {
            $clinics = Clinic::all();
            if($clinics->isEmpty()){
                return response()->json(['message'=>'No Clinic Founded'],404);
            }
            $clinics = $clinics->map(function ($clinics) {
                $clinics->image = '/storage/' . $clinics->image;
                return $clinics;
            });
            return response()->json($clinics,200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()]);
        }
    }
    public function bookAppointment(Request $request){
        $appointmentTime = Carbon::createFromFormat('h:i A', $request->input('AppointmentTime'))->format('H:i:s');
        $appointmentDate = Carbon::createFromFormat('m/d/Y', $request->input('AppointmentDate'))->format('Y-m-d');

        $validInputs = validator($request->all(), [
            'ClinicID' => 'required|int|exists:clinics,ClinicID',
            'DoctorID' => 'required|int|exists:doctors,DoctorID',
            'AppointmentTime' => 'required|date_format:h:i A',
            'AppointmentDate' => 'required|date_format:m/d/Y',
            'PatientName' => 'required|string',
            'phone' => 'required|string|unique:appointments,phone',
            'Email' => 'required|email|unique:appointments,Email',
        ]);
        if($validInputs->fails()){
            return response()->json($validInputs->errors(),'400');
        }

        $appointment = Appointment::create([
            'ClinicID' => $request->input('ClinicID'),
            'DoctorID' => $request->input('DoctorID'),
            'user_ID' => Auth::id(),
            'AppointmentTime' => $appointmentTime,
            'AppointmentDate' => $appointmentDate,
            'PatientName' => $request->input('PatientName'),
            'phone' => $request->input('phone'),
            'Email' => $request->input('Email'),
        ]);

        if ($appointment) {
            return response()->json(['message' => 'Appointment booked successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to book appointment'], 500);
        }
    }
    public function getDoctorsByClinicId(Request $request, $clinic_id)
    {
        try {
            $doctorClinics = DoctorClinic::with('doctor')
                ->where('ClinicID', $clinic_id)->get();

            if ($doctorClinics->isEmpty()) {
                return response()->json(['message' => 'No Doctors Found'], 404);
            }

            $doctors = $doctorClinics->pluck('doctor');

            $doctors->each(function($eachDoctor) {
                $eachDoctor->image = '/storage/' . $eachDoctor->image;
            });

            return response()->json([
                'message' => 'Doctors Retrieved Successfully',
                'data' => $doctors,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function deleteAppointment(Request $request , $appointment_id){
        try {
            $appointment = Appointment::find($appointment_id);
            if(!$appointment){
                return response()->json(['message'=>'No Appointment Found'],404);
            }
            $today  = Carbon::now()->format('Y-m-d');
            $appointmentDate = Carbon::parse($appointment->AppointmentDate)->format('Y-m-d');

            if($today === $appointmentDate){
                return response()->json(['message' => 'You cannot delete an appointment scheduled for today'], 403);
            }
            $appointment->delete();
            return response()->json(['message' => 'Appointment deleted successfully'], 200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],500);
        }
    }


}
