<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteRoomBookingsWhenMinuteMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-room-bookings-when-minute-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete room bookings where the booking_time minute matches the current minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now('Africa/Cairo'); // Use the timezone set in your application
        $currentMinute = $now->format('i');

        $this->info("Current Minute: $currentMinute");

        $bookingsToDelete = DB::table('room_bookings')
            ->whereRaw('MINUTE(booking_time) = ?', [$currentMinute])
            ->get();

        $this->info("Room bookings to delete: " . $bookingsToDelete->count());

        if ($bookingsToDelete->isEmpty()) {
            $this->info('No matching room bookings found');
        } else {
            foreach ($bookingsToDelete as $booking) {
                $this->info("Deleting Booking ID: " . $booking->booking_id);
            }

            DB::table('room_bookings')
                ->whereRaw('MINUTE(booking_time) = ?', [$currentMinute])
                ->delete();

            $this->info('Matching room bookings deleted successfully');
        }
    }
}
