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
        Schema::create('table__grup', function (Blueprint $table) {
            $table->increments('id_grup');
            $table->string('nama_grup', '255');
            $table->text('deskripsi')->nullable();
            $table->integer('durasi');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table__grup');
    }
};
