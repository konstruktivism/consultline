<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalAvailabilityMeetingTables extends Migration
{
    public function up()
    {
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('specialization');
            $table->timestamps();
        });

        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->string('client_name');
            $table->string('client_email');
            $table->dateTime('scheduled_at');
            $table->integer('duration'); // duration in minutes
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meetings');
        Schema::dropIfExists('availabilities');
        Schema::dropIfExists('professionals');
    }
}
