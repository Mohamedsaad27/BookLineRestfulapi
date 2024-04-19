<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Failed to authenticate'], 500);
        }

        return response()->json(['name' => $user->name]);
    }
}
