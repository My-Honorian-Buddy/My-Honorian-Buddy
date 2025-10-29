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
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('booked_session_id')->nullable()->after('user_id');
            $table->text('description')->nullable()->after('title');
            $table->string('event_type')->default('manual')->after('description');
            $table->integer('session_number')->nullable()->after('event_type');
            
            
            $table->foreign('booked_session_id')
                  ->references('id')
                  ->on('bookedsessions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['booked_session_id']);
            $table->dropColumn(['booked_session_id', 'description', 'event_type', 'session_number']);
        });
    }
};
