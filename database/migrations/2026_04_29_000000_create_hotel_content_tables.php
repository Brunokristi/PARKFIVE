<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('hotel_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('domain')->unique();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('hotel_property_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->unique()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('hotel_property_content_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_property_content_id')->constrained('hotel_property_contents')->cascadeOnDelete();
            $table->string('locale_code', 8);
            $table->text('subtitle');
            $table->text('description');
            $table->text('compare_heading');
            $table->text('compare_description');
            $table->timestamps();

            $table->unique(['hotel_property_content_id', 'locale_code'], 'hotel_property_content_locale_unique');
        });

        Schema::create('hotel_property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_property_content_id')->constrained('hotel_property_contents')->cascadeOnDelete();
            $table->string('src');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('hotel_property_image_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_property_image_id')->constrained('hotel_property_images')->cascadeOnDelete();
            $table->string('locale_code', 8);
            $table->string('alt');
            $table->timestamps();

            $table->unique(['hotel_property_image_id', 'locale_code'], 'hotel_property_image_locale_unique');
        });

        Schema::create('hotel_property_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_property_content_id')->constrained('hotel_property_contents')->cascadeOnDelete();
            $table->string('slug');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['hotel_property_content_id', 'slug']);
        });

        Schema::create('hotel_property_section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_property_section_id')->constrained('hotel_property_sections')->cascadeOnDelete();
            $table->string('locale_code', 8);
            $table->string('heading');
            $table->timestamps();

            $table->unique(['hotel_property_section_id', 'locale_code'], 'hotel_property_section_locale_unique');
        });

        Schema::create('hotel_property_section_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_property_section_id')->constrained('hotel_property_sections')->cascadeOnDelete();
            $table->string('slug');
            $table->enum('row_type', ['count', 'check'])->default('check');
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedInteger('count_value')->nullable();
            $table->timestamps();

            $table->unique(['hotel_property_section_id', 'slug']);
        });

        Schema::create('hotel_property_section_row_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_property_section_row_id')->constrained('hotel_property_section_rows')->cascadeOnDelete();
            $table->string('locale_code', 8);
            $table->string('label');
            $table->timestamps();

            $table->unique(['hotel_property_section_row_id', 'locale_code'], 'hotel_property_section_row_locale_unique');
        });

        Schema::create('hotel_room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['hotel_id', 'slug']);
        });

        Schema::create('hotel_room_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_room_type_id')->constrained('hotel_room_types')->cascadeOnDelete();
            $table->string('locale_code', 8);
            $table->string('title');
            $table->timestamps();

            $table->unique(['hotel_room_type_id', 'locale_code'], 'hotel_room_type_locale_unique');
        });

        Schema::create('hotel_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['hotel_id', 'code']);
        });

        Schema::create('hotel_feature_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_feature_id')->constrained('hotel_features')->cascadeOnDelete();
            $table->string('locale_code', 8);
            $table->string('label');
            $table->timestamps();

            $table->unique(['hotel_feature_id', 'locale_code'], 'hotel_feature_locale_unique');
        });

        Schema::create('hotel_room_type_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_room_type_id')->constrained('hotel_room_types')->cascadeOnDelete();
            $table->foreignId('hotel_feature_id')->constrained('hotel_features')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['hotel_room_type_id', 'hotel_feature_id'], 'hotel_room_type_feature_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_room_type_feature');
        Schema::dropIfExists('hotel_feature_translations');
        Schema::dropIfExists('hotel_features');
        Schema::dropIfExists('hotel_room_type_translations');
        Schema::dropIfExists('hotel_room_types');
        Schema::dropIfExists('hotel_property_section_row_translations');
        Schema::dropIfExists('hotel_property_section_rows');
        Schema::dropIfExists('hotel_property_section_translations');
        Schema::dropIfExists('hotel_property_sections');
        Schema::dropIfExists('hotel_property_image_translations');
        Schema::dropIfExists('hotel_property_images');
        Schema::dropIfExists('hotel_property_content_translations');
        Schema::dropIfExists('hotel_property_contents');
        Schema::dropIfExists('hotel_domains');
        Schema::dropIfExists('hotels');
    }
};