<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcceptToBookedsessionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->integer('accept')->default(0)->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->dropColumn('accept');
        });
    }
}
