<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
            Schema::create('bookedsessions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('student_id')->references('user_id')->on('students')->onDelete('cascade');
                $table->bigInteger('tutor_id')->references('user_id')->on('tutors')->onDelete('cascade');

                $table->json('tutoring_subject');
                $table->integer('num_session')->default(0);
                $table->integer('total_session');
                $table->boolean('is_completed')->default(false);
                $table->dateTime('schedule_time');
                $table->integer('duration')->comment('Duration in minutes');
                $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
                $table->text('feedback')->nullable();
                $table->timestamps();
            });
    }  
        
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookedsessions');
    }
};
