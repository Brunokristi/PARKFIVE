<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_page_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('page_key');
            $table->string('locale_code', 8);
            $table->json('content_json');
            $table->timestamps();

            $table->unique(['hotel_id', 'page_key', 'locale_code'], 'hotel_page_contents_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_page_contents');
    }
};