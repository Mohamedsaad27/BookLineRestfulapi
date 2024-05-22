<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteAppointmentWhenCreatedAtMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-appointment-when-created-at-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete appointments that match the current time and date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        $currentDate = $now->format('Y-m-d');

        $appointmentsToDelete = DB::table('appointments')
            ->where('AppointmentTime', $currentTime)
            ->where('AppointmentDate', $currentDate)
            ->get();

        if ($appointmentsToDelete->isEmpty()) {
            $this->info('No matching appointments found');
        } else {
            DB::table('appointments')
                ->where('AppointmentTime', $currentTime)
                ->where('AppointmentDate', $currentDate)
                ->delete();

            $this->info('Matching appointments deleted successfully');
        }
    }
}
