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
        Schema::table('bookings', function (Blueprint $table) {
//            check in check oout date booking created at
           Schema::table('bookings', function (Blueprint $table) {
    if (!Schema::hasColumn('bookings', 'check_in_date')) {
        $table->dateTime('check_in_date')->nullable()->after('booking_number');
    }
    if (!Schema::hasColumn('bookings', 'check_out_date')) {
        $table->dateTime('check_out_date')->nullable()->after('check_in_date');
    }
    if (!Schema::hasColumn('bookings', 'booking_created_at')) {
        $table->date('booking_created_at')->nullable()->after('check_out_date');
    }
    if (!Schema::hasColumn('bookings', 'commission_paid')) {
        $table->boolean('commission_paid')->default(0)->after('reseller_key');
    }
});
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('check_in_date');
            $table->dropColumn('check_out_date');
            $table->dropColumn('booking_created_at');
            $table->dropColumn('commission_paid');
        });
    }
};
