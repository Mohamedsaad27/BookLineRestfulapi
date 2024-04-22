<?php

namespace App\Http\Controllers;

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
                $results = Taxi::where('name', 'like', "%$query%")
                    ->orWhere('startDestination', 'like', "%$query%")
                    ->orWhere('endDestination', 'like', "%$query%")
                    ->paginate($perPage);
                break;
            case 'restaurant':
                $results = Restaurant::where('Restaurant_Name', 'like', "%$query%")
                    ->paginate($perPage);
                break;
            case 'clinic':
                $results = Clinic::where('ClinicName', 'like', "%$query%")
                    ->orWhere('ClinicLocation', 'like', "%$query%")
                    ->paginate($perPage);
                break;
            case 'hotel':
                $results = Hotel::where('hotel_Name', 'like', "%$query%")
                    ->orWhere('hotel_location', 'like', "%$query%")
                    ->paginate($perPage);
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
