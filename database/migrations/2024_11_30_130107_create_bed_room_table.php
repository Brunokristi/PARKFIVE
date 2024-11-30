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
    Schema::create('bed_room', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('room_id');
        $table->unsignedBigInteger('bed_id');
        $table->timestamps();

        $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        $table->foreign('bed_id')->references('id')->on('beds')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed_room');
    }
};
