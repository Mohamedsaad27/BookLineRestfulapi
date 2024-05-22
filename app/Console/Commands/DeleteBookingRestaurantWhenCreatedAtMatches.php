<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteBookingRestaurantWhenCreatedAtMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-booking-restaurant-when-created-at-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete reservations where the created_at minute matches the current minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now('Africa/Cairo'); // Use the timezone set in your application
        $currentMinute = $now->format('i');

        $this->info("Current Minute: $currentMinute");

        $reservationsToDelete = DB::table('reservations')
            ->whereRaw('MINUTE(created_at) = ?', [$currentMinute])
            ->get();

        $this->info("Reservations to delete: " . $reservationsToDelete->count());

        if ($reservationsToDelete->isEmpty()) {
            $this->info('No matching reservations found');
        } else {
            foreach ($reservationsToDelete as $reservation) {
                $this->info("Deleting Reservation ID: " . $reservation->reservation_id);
            }

            DB::table('reservations')
                ->whereRaw('MINUTE(created_at) = ?', [$currentMinute])
                ->delete();

            $this->info('Matching reservations deleted successfully');
        }
    }
}
