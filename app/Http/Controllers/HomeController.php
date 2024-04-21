<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['message' => 'Token not provided'], 401);
            }

            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }else{
                return response()->json([
                    'message'=>'User Founded',
                    'name' => $user->name]);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
