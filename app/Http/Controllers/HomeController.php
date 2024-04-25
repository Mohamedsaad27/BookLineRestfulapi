<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\Room_Booking;
use App\Models\Taxi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
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
            } else {
                $appointments = Appointment::where('user_ID', $user->id)->get();
                $taxiBookings = Taxi::where('user_id', $user->id)->get();
                $reservations = Reservation::where('user_id', $user->id)->get();
                $hotelBookings = Room_Booking::where('user_id', $user->id)->get();

                if ($appointments->isEmpty() && $taxiBookings->isEmpty() && $reservations->isEmpty() && $hotelBookings->isEmpty()) {
                    return response()->json([
                            'name' => $user->firstname .' '.$user->lastname,
                            'message' => 'No appointments, taxi bookings, reservations, or hotel bookings found',
                    ]);
                } else {
                    $responseData = [
                        'message' => 'User Found',
                        'name' => $user->firstname .' '.$user->lastname,
                    ];
                    if (!$appointments->isEmpty()) {
                        $responseData['ClinicAppointment'] = $appointments;
                    }
                    if (!$taxiBookings->isEmpty()) {
                        $responseData['taxiBookings'] = $taxiBookings;
                    }
                    if (!$reservations->isEmpty()) {
                        $responseData['restaurantReservations'] = $reservations;
                    }
                    if (!$hotelBookings->isEmpty()) {
                        $responseData['hotelBookings'] = $hotelBookings;
                    }

                    return response()->json($responseData);
                }
            }
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
