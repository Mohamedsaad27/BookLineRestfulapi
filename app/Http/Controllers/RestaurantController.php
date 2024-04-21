<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class RestaurantController extends Controller
{
    public function index(Request $request){
        $restaurants = Restaurant::all();
        if($restaurants){
            return response()->json($restaurants,'200');
        }else{
            return response()->json(['message'=>'No Restaurants Founded'],'404');
        }
    }

    public function restaurantDetails(Request $request,$restaurant_id){
        $restaurantsDetails = Restaurant::where('Restaurant_id','=',$restaurant_id)->first();
        try {
            if($restaurantsDetails){
                return response()->json($restaurantsDetails,'200');
            }else{
                return response()->json(['message'=>'No Restaurant Founded'],'404');
            }
        }catch (\Exception $exception){
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

}
