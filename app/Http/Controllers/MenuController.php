<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenuByRestaurantId(Request $request, $id)
    {
        try {
            $menuByRestaurantId = Menu::where('restaurant_id', $id)->get();
            if ($menuByRestaurantId->isEmpty())
            {
                return response()->json(['message' => 'No Menu For This Restaurant'], 404);
            }
            return response()->json(['data' => $menuByRestaurantId, 'message' => 'Menu Retrieved Successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
