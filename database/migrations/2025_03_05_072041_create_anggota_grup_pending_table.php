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
        Schema::create('anggota_grup_pending', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grup_id');
            $table->foreign('grup_id')->references('id_grup')->on('table__grup')->onDelete('cascade');
            $table->string('email');
            $table->enum('status', ['Pending', 'Complete'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_grup_pending');
    }
};
