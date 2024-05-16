<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('doctor_clinic', function (Blueprint $table) {
            $table->foreignId('DoctorID')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('ClinicID')->constrained('clinics')->onDelete('cascade');
            $table->primary(['DoctorID', 'ClinicID']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('doctor_clinic');
    }
};
