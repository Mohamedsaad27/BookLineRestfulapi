<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteBookingTaxiWhenTimeMatchNow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-booking-taxi-when-time-match-now';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle()
    {
        $now = Carbon::now('Africa/Cairo'); // Use the timezone set in your application
        $currentTime = $now->format('H:i:s');

        $this->info("Current Time: $currentTime");

        $bookingsToDelete = DB::table('taxi')
            ->where('time', $currentTime)
            ->get();

        $this->info("Bookings to delete: " . $bookingsToDelete->count());

        if ($bookingsToDelete->isEmpty()) {
            $this->info('No matching bookings found');
        } else {
            DB::table('taxi')
                ->where('time', $currentTime)
                ->delete();

            $this->info('Matching bookings deleted successfully');
        }
    }
}
