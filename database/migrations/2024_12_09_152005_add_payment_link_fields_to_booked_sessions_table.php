<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentLinkFieldsToBookedSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->boolean('payment_link_sent')->default(false)->after('is_completed');
            $table->string('payment_link_url')->nullable()->after('payment_link_sent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->dropColumn(['payment_link_sent', 'payment_link_url']);
        });
    }
}
