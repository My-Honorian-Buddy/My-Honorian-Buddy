<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSesUpdateToBookedsessionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->date('sesUpdate')->nullable()->after('num_session')->comment('Date when num_session was last updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->dropColumn('sesUpdate');
        });
    }
}
