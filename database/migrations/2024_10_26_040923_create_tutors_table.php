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
            $table->integer('exp')->default(0);//experience
            $table->integer('rating')->default(0); //rating
            $table->integer('NoOfReviews')->default(0);
            $table->string('gender')->nullable();
            $table->integer('points')->default(0);
            $table->string('address')->nullable();
            $table->string('bio')->nullable();
            $table->string('year_level');
            $table->string('college');
            $table->string('department');
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
