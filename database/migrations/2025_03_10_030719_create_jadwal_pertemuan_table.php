<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_pertemuan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grup_id');
            $table->foreign('grup_id')->references('id_grup')->on('table__grup')->onDelete('cascade');
            $table->string('judul', 255);
            $table->string('tanggal', 255);
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pertemuan');
    }
};
