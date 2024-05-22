    <?php

    use App\Http\Controllers\AppointmentController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ClinicController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\MenuController;
    use App\Http\Controllers\RestaurantController;
    use App\Http\Controllers\SearchController;
    use App\Http\Controllers\TaxiController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "api" middleware group. Make something great!
    |
    */
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout')->middleware('verify.token');
        Route::post('refresh', 'refresh')->middleware('verify.token');

    });

    Route::get('/home',[HomeController::class,'index'])->middleware('auth:api');

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    // Hotels Routes
    Route::resource('hotels', \App\Http\Controllers\HotelController::class)->middleware(['auth:api','verify.token']);
    Route::post('bookRoom',[\App\Http\Controllers\BookingRoomController::class,'bookingRoom'])->middleware(['auth:api','verify.token']);
    Route::post('delete-book-Room/{booking_id}',[\App\Http\Controllers\BookingRoomController::class,'deleteBookingRoom'])->middleware(['auth:api','verify.token']);


    // Restaurants Routes
    Route::group(['middleware' => [ 'auth:api','verify.token']], function () {
        Route::get('restaurants', [RestaurantController::class, 'index']);
        Route::get('restaurant_details/{restaurant_id}', [RestaurantController::class, 'restaurantDetails']);
        Route::post('bookRestaurant/{id}', [RestaurantController::class, 'bookRestaurant']);
        Route::post('delete-booking/{booking_id}', [RestaurantController::class, 'deleteBooking']);
    });

    // Clinics Routes
    Route::group(['middleware' => [ 'auth:api','verify.token']], function () {
        Route::get('doctors', [AppointmentController::class, 'doctors']);
        Route::get('clinics', [AppointmentController::class, 'clinics']);
        Route::get('doctors-by-clinic-id/{clinic_id}', [AppointmentController::class, 'getDoctorsByClinicId']);
        Route::post('book-appointment', [AppointmentController::class, 'bookAppointment']);
        Route::post('delete-appointment/{appointment_id}', [AppointmentController::class, 'deleteAppointment']);
    });

    Route::get('search',[SearchController::class,'search'])->middleware('auth:api');

    Route::group(['middleware' => [ 'auth:api','verify.token']], function () {
        Route::get('taxis', [TaxiController::class, 'index']);
        Route::post('book-taxi', [TaxiController::class, 'bookTaxi']);
        Route::post('delete-book-taxi/{booking_id}', [TaxiController::class, 'cancelBookTaxi']);
    });

    Route::get('get-menu-by-restaurant-id/{id}',[MenuController::class,'getMenuByRestaurantId'])
            ->middleware('auth:api');
