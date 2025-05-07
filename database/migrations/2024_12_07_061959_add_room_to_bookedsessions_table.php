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
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->string('room')->nullable()->after('status')->comment('Unique room name for the session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->dropColumn('room');
        });
    }
};