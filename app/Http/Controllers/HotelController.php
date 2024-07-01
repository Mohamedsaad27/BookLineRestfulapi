<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels=Hotel::all();
        $hotels->each(function ($hotel){
            $hotel->image = '/storage/hotelImages/' . $hotel->image;
        });
        return response()->json($hotels,'200');
    }
    public function show(string $id)
    {
        $hotel=Hotel::get()->where('hotel_ID',$id)->first();

        if(!$hotel){
            return response()->json('not found','404');
        }else{
                $hotel->image = '/storage/hotelImages/' . $hotel->image;
        return response()->json($hotel);
    }

    }
    public function getRoomsByHotel($hotel_id){
        try {
            $hotel = Hotel::find($hotel_id);
            if(!$hotel){
                return response()->json(['message'=>'No Hotel Founded'],500);
            }
            $rooms = Room::where('hotel_id',$hotel_id)->get();
            if ($rooms->isEmpty()){
                return response()->json(['message'=>'No Rooms Founded'],500);
            }
            return response()->json(['data'=>$rooms,'message'=> 'Rooms retrieved successfully']
                ,200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],500);
        }
    }
    public function addRoom(Request $request)
    {
        $valid = validator($request->all(), [
            'hotel_id' => 'required|int|exists:hotels,hotel_ID',
            'room_number' => 'required|string|max:255',
            'room_type' => 'required|string|max:255',
            'capacity' => 'required|int',
            'price' => 'required|numeric',
            'description' => 'string|nullable',
            'status' => 'required|string|in:available,not_available',
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $room = Room::create([
            'hotel_id' => $request->hotel_id,
            'room_number' => $request->room_number,
            'room_type' => $request->room_type,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'Room added successfully', 'room' => $room], 201);
    }
}
