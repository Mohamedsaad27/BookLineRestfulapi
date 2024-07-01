<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Room_Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingRoomController extends Controller
{
    public function bookingRoom(Request $request)
    {
        $valid = validator($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'room_id' => 'required|int|exists:rooms,id',
            'hotel_ID' => 'required|int|exists:hotels,hotel_ID',
            'special_requests' => 'string|nullable',
            'num_guests' => 'required|int',
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $room = Room::find($request->room_id);
        if ($room->status == 'not_available') {
            return response()->json(['error' => 'Room is not available for booking.'], 400);
        }
        $booking = Room_Booking::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'room_id' => $request->room_id,
            'hotel_ID' => $request->hotel_ID,
            'user_id' => Auth::id(),
            'special_requests' => $request->special_requests,
            'num_guests' => $request->num_guests,
            'booking_time' => now(),
        ]);
        return response()->json(['message' => 'Room booked successfully', 'booking' => $booking], 201);
    }

    public function deleteBookingRoom(Request $request, $booking_id){
        try {
            $booking = Room_Booking::find($booking_id);
            if(!$booking){
                return response()->json(['message'=>'No Booking On This Room Found'],404);
            }
            $today  = Carbon::now()->format('Y-m-d');
            $appointmentDate = Carbon::parse($booking->booking_time)->format('Y-m-d');
            if($today === $appointmentDate){
                return response()->json(['message' => 'You cannot delete an booking scheduled for today'], 403);
            }
            $booking->delete();
            return response()->json(['message' => 'Booking deleted successfully'], 200);

        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],500);
        }
    }
}
