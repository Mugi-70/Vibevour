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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->dateTime('open_date')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->enum('result_visibility', ['public', 'private'])->default('private');
            $table->boolean('is_protected')->default(false);
            $table->string('access_code', 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
