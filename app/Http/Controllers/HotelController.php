<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
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


}
