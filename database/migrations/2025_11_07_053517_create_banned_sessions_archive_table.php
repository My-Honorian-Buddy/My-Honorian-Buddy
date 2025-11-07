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
        Schema::create('banned_sessions_archive', function (Blueprint $table) {
            $table->id();
            
            // Original session data
            $table->unsignedBigInteger('original_session_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('tutor_id');
            $table->string('student_name');
            $table->string('tutor_name');
            $table->text('tutoring_subject');
            $table->dateTime('schedule_time');
            $table->integer('duration')->nullable();
            $table->string('status')->nullable();
            $table->integer('num_session')->nullable();
            $table->integer('total_session')->nullable();
            $table->text('feedback')->nullable();
            $table->string('room')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->boolean('reviewed')->default(false);
            
            // Ban information
            $table->text('ban_reason');
            $table->timestamp('ban_requested_at')->nullable();
            $table->text('tutor_report')->nullable();
            $table->json('tutor_report_images')->nullable();
            $table->timestamp('tutor_report_submitted_at')->nullable();
            $table->string('ban_status');
            $table->timestamp('banned_at')->nullable();
            $table->unsignedBigInteger('banned_by')->nullable(); // Admin who approved the ban
            
            $table->timestamps();
            
            $table->index('original_session_id');
            $table->index('student_id');
            $table->index('tutor_id');
            $table->index('banned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banned_sessions_archive');
    }
};
