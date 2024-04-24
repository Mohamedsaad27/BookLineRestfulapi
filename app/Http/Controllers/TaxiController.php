<?php

namespace App\Http\Controllers;

use App\Models\Taxi;
use App\Models\TaxiDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaxiController extends Controller
{
    public function index(Request $request){
        $taxis = TaxiDetails::all();
        if($taxis->isEmpty()){
            return response()->json(['message'=>'No Taxis Founded'],'404');
        }else{
            return response()->json($taxis,'200');
        }
    }
    public function bookTaxi(Request $request): \Illuminate\Http\JsonResponse
    {
        $time = Carbon::createFromFormat('h:i A', $request->input('time'))->format('H:i:s');
        $date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->format('Y-m-d');
        $validInputs = validator($request->all(), [
            'passengers' => 'required|int',
            'startDestination' => 'required|string',
            'endDestination' => 'required|string',
            'time' => 'required|date_format:h:i A',
            'date' => 'required|date_format:m/d/Y',
            'name' => 'required|string',
            'phoneNumber' => 'required|string|unique:appointments,phone',
        ]);
        if ($validInputs->fails()) {
            return response()->json($validInputs->errors(), '400');
        }
        $taxi = [
            'passengers' => $request->passengers,
            'startDestination' => $request->startDestination,
            'endDestination' => $request->endDestination,
            'user_ID' => Auth::id(),
            'time' => $time,
            'date' => $date,
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
        ];
        DB::table('taxi')->insert($taxi);

        return response()->json(['data'=>$taxi,'message' =>'taxi booked successful'], 200);

    }
}
