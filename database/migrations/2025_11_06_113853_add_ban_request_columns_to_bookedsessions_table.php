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
            $table->boolean('ban_requested')->default(false)->after('admin_approved');
            $table->text('ban_reason')->nullable()->after('ban_requested');
            $table->timestamp('ban_requested_at')->nullable()->after('ban_reason');
            $table->text('tutor_report')->nullable()->after('ban_requested_at');
            $table->json('tutor_report_images')->nullable()->after('tutor_report');
            $table->timestamp('tutor_report_submitted_at')->nullable()->after('tutor_report_images');
            $table->enum('ban_status', ['pending', 'report_submitted', 'approved', 'rejected'])->nullable()->after('tutor_report_submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookedsessions', function (Blueprint $table) {
            $table->dropColumn([
                'ban_requested',
                'ban_reason',
                'ban_requested_at',
                'tutor_report',
                'tutor_report_images',
                'tutor_report_submitted_at',
                'ban_status'
            ]);
        });
    }
};
