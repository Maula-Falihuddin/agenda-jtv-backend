<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relasi ke users
            $table->string('title');                  // Judul agenda
            $table->enum('priority', ['low', 'medium', 'high']);  // Prioritas
            $table->date('meeting_date');            // Tanggal rapat
            $table->time('meeting_time');            // Jam rapat
            $table->text('description')->nullable(); // Deskripsi
            $table->text('minutes')->nullable();     // Notulensi rapat
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
