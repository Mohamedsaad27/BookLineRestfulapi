<?php

namespace App\Http\Controllers;

use App\Models\TaxiDetails;
use Illuminate\Http\Request;
use App\Models\Taxi;
use App\Models\Restaurant;
use App\Models\Clinic;
use App\Models\Hotel;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $type = $request->input('type');
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);

        switch ($type) {
            case 'taxi':
                $results = TaxiDetails::where('car_name', 'like', "%$query%")
                    ->orWhere('driver_phone', 'like', "%$query%")
                    ->orWhere('driver_name', 'like', "%$query%")
                    ->paginate($perPage);
                $results->each(function ($taxi) {
                    $taxi->image = '/storage/' . $taxi->image;
                });
                break;
            case 'restaurant':
                $results = Restaurant::where('Restaurant_Name', 'like', "%$query%")
                    ->paginate($perPage);
                $results->each(function ($restaurant) {
                    $restaurant->image = '/storage/' . $restaurant->image;
                });
                break;
            case 'clinic':
                $results = Clinic::where('ClinicName', 'like', "%$query%")
                    ->orWhere('ClinicLocation', 'like', "%$query%")
                    ->paginate($perPage);
                $results->each(function ($clinic) {
                    $clinic->image = '/storage/' . $clinic->image;
                });
                break;
            case 'hotel':
                $results = Hotel::where('hotel_Name', 'like', "%$query%")
                    ->orWhere('hotel_location', 'like', "%$query%")
                    ->paginate($perPage);
                $results->each(function ($hotel) {
                    $hotel->image = '/storage/' . $hotel->image;
                });
                break;
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        if ($results->isEmpty()) {
            return response()->json(['error' => "No $type Found"], 404);
        }

        return response()->json($results->items());
    }

}
