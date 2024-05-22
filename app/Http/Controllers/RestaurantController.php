<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\Restaurant;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class RestaurantController extends Controller
{
    public function index(Request $request){
        $restaurants = Restaurant::all();
        if($restaurants->isEmpty()){
            return response()->json(['message'=>'No Restaurants Founded'],'404');
        }else{
            return response()->json($restaurants,'200');
        }
    }

    public function restaurantDetails(Request $request, $restaurant_id)
    {
        $restaurantsDetails = Restaurant::with('menus')->find($restaurant_id);
        try {
            if ($restaurantsDetails) {
                return response()->json($restaurantsDetails, 200);
            } else {
                return response()->json(['message' => 'No Restaurant Found'], 404);
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function bookRestaurant(Request $request, $id){
        $valid = validator($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:reservations,email',
            'members' => 'required|int',
            'user_id' => 'required|int|exists:users,id',
            'restaurant_id' => 'required|int|exists:restaurants,Restaurant_id'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }

        $user_id = $request->user_id;
        $data = $request->only(['name', 'email', 'members']);

        $reservationData = array_merge($data, [
            'user_id' => $user_id,
            'restaurant_id' => $id
        ]);

        DB::table('reservations')->insert($reservationData);

        return response()->json($data, 200);
    }

    public function deleteBooking(Request $request , $booking_id){
        try {
            $reservation = Reservation::find($booking_id);
            if(!$reservation){
                return response()->json(['message'=>'No Reservation Found'],404);
            }
            $today  = Carbon::now()->format('Y-m-d');
            $reservationDate = Carbon::parse($reservation->created_at)->format('Y-m-d');

            if($today === $reservationDate){
                return response()->json(['message' => 'You cannot delete an reservation scheduled for today'], 403);
            }
            $reservation->delete();
            return response()->json(['message' => 'Reservation deleted successfully'], 200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],500);
        }

    }
}
