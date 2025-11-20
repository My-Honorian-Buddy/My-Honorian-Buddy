<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all NULL duration values to 0
        DB::table('bookedsessions')
            ->whereNull('duration')
            ->update(['duration' => 0]);
            
        // Make duration column NOT NULL with default value
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->integer('duration')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->integer('duration')->nullable()->change();
        });
    }
};
