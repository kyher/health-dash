<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trackers', function (Blueprint $table) {
            $table->dropColumn('next_appointment_at');
        });

        Schema::create('tracker_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracker_id')->constrained('trackers')->cascadeOnDelete();
            $table->dateTime('appointment_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracker_appointments');

        Schema::table('trackers', function (Blueprint $table) {
            $table->dateTime('next_appointment_at')->nullable();
        });
    }
};
