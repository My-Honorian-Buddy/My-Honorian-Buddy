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
        Schema::create('tutors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');  
            $table->string('fname');
            $table->string('lname');
            $table->float('rate_session'); //price
            $table->string('exp');         //experience    
            $table->integer('rating')->default(0); //rating
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('gcash')->nullable(); // Required
            $table->string('grabpay')->nullable();
            $table->string('maya')->nullable();
            $table->string('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};
