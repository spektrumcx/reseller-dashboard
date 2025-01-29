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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable(); // Code
            $table->string('status')->nullable(); // Status
            $table->integer('resource_id')->nullable(); // Resource ID
            $table->string('room_name')->nullable(); // Room Name
            $table->string('hotel_name')->nullable(); // Hotel Name
            $table->string('customer_name')->nullable(); // Customer Name
            $table->string('dates')->nullable(); // Dates
            $table->string('source_type')->nullable(); // Source Type
            $table->string('booking_number')->nullable(); // Booking Number
            $table->decimal('cost', 10, 2)->nullable(); // Cost
            $table->integer('guests_count')->nullable(); // Guests Count
            $table->string('formatted_cost')->nullable(); // Formatted Cost
            $table->string('cost_symbol')->nullable(); // Cost Symbol
            $table->integer('nights')->nullable(); // Nights
            $table->string('payment_status')->nullable(); // Payment Status
            $table->string('payment_status_color')->nullable(); // Payment Status Color
            $table->string('country_flag')->nullable(); // Country Flag URL
            $table->string('status_value')->nullable(); // Status Value
            $table->string('status_color')->nullable(); // Status Color
            $table->integer('reseller_id')->nullable(); // Reseller ID

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
