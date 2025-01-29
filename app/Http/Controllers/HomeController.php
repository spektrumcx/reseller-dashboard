<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('index');
    }

    public function getBookings(Request $request)
    {
        $resellerKey = $request->input('reseller_key');

        // Handle DataTables AJAX request
        if ($request->has('draw')) {
            $query = Booking::where('reseller_key', $resellerKey);

            return datatables()
                ->eloquent($query)
                ->addColumn('check', function ($row) {
                    return '<div class="form-check">
                            <input class="form-check-input" type="checkbox" value="' . $row->id . '">
                        </div>';
                })
                ->editColumn('status', function ($row) {
                    return ucfirst($row->status);
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->editColumn('payment_status', function ($row) {
                    return ucfirst($row->payment_status);
                })
                ->rawColumns(['check'])
                ->make(true);
        }

        // Handle manual AJAX request
        $bookings = Booking::where('reseller_key', $resellerKey)->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No bookings found for the provided reseller key.',
            ]);
        }

        $formattedBookings = $bookings->map(function ($booking) {
            return [
               'status' => ucfirst($booking->status),
                'status_color' => $booking->status_color,
                'room_name' => $booking->room_name,
                'hotel_name' => $booking->hotel_name,
                'customer_name' => $booking->customer_name,
                'dates' => $booking->dates,
                'payment_status' => ucfirst($booking->payment_status),
                "payment_status_color" => $booking->payment_status_color,
                'cost' => $booking->cost,
                'source_type' => $booking->source_type,
                'booking_number' => $booking->booking_number,
                "reseller_name" => $booking->reseller_name,

            ];
        });

        return response()->json([
            'status' => 'success',
            'bookings' => $formattedBookings,
        ]);
    }

    public function bookings_sync(Request $request)
    {

////return
//            $bookings = $request->bookings;
//    dd($bookings);
//        $insertColumns = [
//            'booking_id',
//            'code',
//            'status',
//            'resource_id',
//            'room_name',
//            'hotel_name',
//            'customer_name',
//            'dates',
//            'source_type',
//            'booking_number',
//            'cost',
//            'guests_count',
//            'formatted_cost',
//            'cost_symbol',
//            'nights',
//            'payment_status',
//            'payment_status_color',
//            'country_flag',
//            'status_value',
//            'status_color',
//            'reseller_id',
//            'created_at',
//            'updated_at',
//        ];
//
//        $insertArray = collect($bookings)->map(function ($booking) use ($insertColumns) {
//            // Ensure created_at and updated_at are set properly
//            $booking['created_at'] = now();
//            $booking['updated_at'] = now();
//
//            // Ensure resource_id is numeric (Extract numbers only)
//            if (!is_numeric($booking['resource_id'])) {
//                $booking['resource_id'] = (int) filter_var($booking['resource_id'], FILTER_SANITIZE_NUMBER_INT);
//            }
//
//            // Filter only the required columns
//            return Arr::only($booking, $insertColumns);
//        })->toArray();


// Insert data into the bookings table
//        DB::table('bookings')->insert($insertArray);

        $bookings = $request->bookings;

        $mappedBookings = array_map(function ($booking) {
            return [
                'booking_id' => $booking['booking_id'],
                'booking_number' => $booking['booking_number'],
                'code' => $booking['code'],
                'cost' => $booking['cost'],
                'cost_symbol' => $booking['cost_symbol'],
                'country_flag' => $booking['country_flag'],
                'created_at' => now(),
                'customer_name' => $booking['customer_name'],
                'dates' => $booking['dates'],
                'formatted_cost' => $booking['formatted_cost'],
                'guests_count' => $booking['guests_count'],
                'hotel_name' => $booking['hotel_name'],
                'nights' => $booking['nights'],
                'payment_status' => $booking['payment_status'],
                'payment_status_color' => $booking['payment_status_color'],
                'reseller_id' => $booking['reseller_id'],
                'resource_id' => (string) $booking['resource_id'], // Convert resource_id to string
                'room_name' => $booking['room_name'],
                'source_type' => $booking['source_type'],
                'status' => $booking['status'],
                'status_color' => $booking['status_color'],
                'status_value' => $booking['status_value'],
                'updated_at' => now(),
                // **Newly Added Columns**
                'reseller_name' => isset($booking['reseller'][0]) ? $booking['reseller'][0]['name'] : null,
                'reseller_key' => isset($booking['reseller'][0]) ? $booking['reseller'][0]['key'] : null,
            ];
        }, $bookings);


        DB::table('bookings')->insert($mappedBookings);


        return response()->json([
            'status' => 'success',
            'message' => 'Bookings synced successfully.',
        ]);
    }
}
