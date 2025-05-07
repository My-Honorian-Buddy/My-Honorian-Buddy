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
        Schema::create('notif_sessions', function (Blueprint $table) {
            $table->id();
            $table->json('notif_info'); // Notification information in JSON format
            $table->string('to'); // to student or tutor
            $table->bigInteger('user_id'); // user_id of the student or tutor
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notif_sessions');
    }
};
