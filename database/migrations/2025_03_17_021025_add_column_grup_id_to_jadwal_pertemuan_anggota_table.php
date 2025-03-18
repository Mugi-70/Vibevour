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
        Schema::table('jadwal_pertemuan_anggota', function (Blueprint $table) {
            $table->unsignedInteger('grup_id')->after('jadwal_id');
            $table->foreign('grup_id')->references('id_grup')->on('table__grup')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pertemuan_anggota', function (Blueprint $table) {
            $table->dropForeign(['grup_id']);
            $table->dropColumn('grup_id');
        });
    }
};
