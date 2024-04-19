<?php

namespace App\Http\Controllers;

use App\Models\Room_Booking;
use Faker\Provider\en_IN\Internet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingRoomController extends Controller
{
    public function bookingRoom(Request $request){

        $valid=validator($request->all(),[
           'first_name'=>'required|string',
           'last_name'=>'required|string',
           'email'=>'required|email',
           'room_type'=>'required'
           ,'Room_Number'=>'required'
           ,'hotel_ID'=>'required|int'
           ,'hotel_Name'=>'required|string'
           ,'user_id'=>'required|int|exists:users,id'
           ,'special_requests'=>'string'
           ,'num_guests'=>'required|int'
       ]) ;
       if($valid->fails()){
           return response()->json($valid->errors(),'400');
       }
        $data= $request->only(
            'first_name',
            'last_name',
            'email',
            'room_type'
            ,'Room_Number'
            ,'hotel_ID'
            ,'hotel_Name'
            ,'user_id'
            ,'special_requests'
            ,'num_guests');
       DB::table('room_bookings')->insert([
            'first_name'=>$data['first_name'],
            'last_name'=>$data['last_name'],
            'email'=>$data['email'],
            'room_type'=>$data['room_type']
            ,'Room_Number'=>$data['Room_Number']
            ,'hotel_ID'=>$data['hotel_ID']
            ,'hotel_Name'=>$data['hotel_Name']
            ,'user_id'=>$data['user_id']
            ,'special_requests'=>$data['special_requests']
            ,'num_guests'=>$data['num_guests']
        ]);


        return response()->json($data,200);
    }


}
