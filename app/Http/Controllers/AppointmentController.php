<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorClinic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
class AppointmentController extends Controller
{
    public function doctors(){
        try {
            $doctors = Doctor::all();
            if($doctors->isEmpty()){
                return response()->json(['message'=>'No Doctors Founded'],404);
            }
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
            'user_ID' => 'required|int|exists:users,id',
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
            $doctors = DoctorClinic::with('doctor')
            ->where('ClinicID',$clinic_id)->get();
            if ($doctors->isEmpty()) {
                return response()->json(['message' => 'No Doctors Found'], 404);
            }
            return response()->json([
                'message'=> 'Doctors Retrieved Successfully',
                'data'=> $doctors,
            ],200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }



}
