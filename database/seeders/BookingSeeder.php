<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = [];

        for ($i = 1; $i <= 10; $i++) {
            $bookings[] = [
                'booking_id' => 'BK' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => Str::random(10),
                'reseller_id' => "reseller-secret",
                'booking_created_at' => now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'unit_name' => 'Unit ' . $i,
                'property_name' => 'Property ' . rand(1, 5),
                'user_name' => 'User ' . $i,
                'booking_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                'payment_status' => rand(0, 1) ? 'paid' : 'pending',
                'amount' => rand(100, 5000),
                'source' => rand(0, 1) ? 'online' : 'offline',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('bookings')->insert($bookings);
    }
}
