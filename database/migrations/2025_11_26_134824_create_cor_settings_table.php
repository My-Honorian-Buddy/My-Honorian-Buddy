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
        Schema::create('cor_settings', function (Blueprint $table) {
            $table->id();
            $table->string('university_name');
            $table->string('cor_title')->default('Certificate of Registration');
            $table->string('campus_name');
            $table->string('academic_year'); // Format: AY 2025-2026
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('is_active')->default(true);
            $table->text('additional_keywords')->nullable(); // JSON field for extra keywords
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cor_settings');
    }
};
