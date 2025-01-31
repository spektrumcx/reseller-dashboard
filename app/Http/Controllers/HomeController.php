<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if (empty($resellerKey)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reseller key is required.',
            ]);
        }
        $bookings = Booking::where('reseller_key', $resellerKey)->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'status' => 'info',
                'message' => 'No bookings found for the provided reseller key.',
            ]);
        }

        // Handle DataTables AJAX request
        if ($request->has('draw')) {

            $query = Booking::where('reseller_key', $resellerKey)
            ->when($request->input('date_range'), function ($query, $request) {
                [$start, $end] = explode(' to ', $request);
                return $query->whereDate('check_in_date', '>=', $start )
                ->whereDate('check_in_date', '<=', $end);
            })
            ;



            return datatables()
                ->eloquent($query)
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                            <select class="form-select" aria-label="Default select example">
                            <option value="2">Mark as Unpaid</option>
                            <option value="1">Mark as Paid</option>
                            </select>
                            </div>';
                })
                ->addColumn('status_color', function ($row) {
                    return '<span class="badge text-uppercase" style="background-color: ' . $row->status_color . ';">' . $row->status . '</span>';
                })
                ->editColumn('payment_status', function ($row) {
                    return ucfirst($row->payment_status);
                })
                ->addColumn('payment_status_color', function ($row) {
//                    return '<span class="badge text-uppercase" style="background-color: ' . $row->payment_status_color . ';">' . htmlspecialchars($row->payment_status, ENT_QUOTES, 'UTF-8') . '</span>';
                    return '<span class="badge text-uppercase" style="background-color: ' . $row->payment_status_color . ';">' . htmlspecialchars($row->payment_status, ENT_QUOTES, 'UTF-8') . '</span>';
                })
                ->editColumn('dates', function ($row) {
                    return $row->dates;
                })
                ->editColumn('room_name', function ($row) {
                    return $row->room_name;
                })
                ->editColumn('hotel_name', function ($row) {
                    return $row->hotel_name;
                })
                ->rawColumns(['action', 'status_color' , 'payment_status_color'])
                ->make(true);
        }

        // Handle manual AJAX request


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
        $bookings = $request->input('bookings');
        foreach ($bookings as $booking) {
            DB::table('bookings')->updateOrInsert(
                ['booking_id' => $booking['booking_id']], // Condition to check for existing record
                [
                    'booking_number' => $booking['booking_number'],
                    'code' => $booking['code'],
                    'cost' => $booking['cost'],
                    'cost_symbol' => $booking['cost_symbol'],
                    'country_flag' => $booking['country_flag'],
                    'customer_name' => $booking['customer_name'],
                    'dates' => $booking['dates'],
                    'formatted_cost' => $booking['formatted_cost'],
                    'guests_count' => $booking['guests_count'],
                    'hotel_name' => $booking['hotel_name'],
                    'nights' => $booking['nights'],
                    'payment_status' => $booking['payment_status'],
                    'payment_status_color' => $booking['payment_status_color'],
                    'reseller_id' => $booking['reseller_id'],
                    'resource_id' => (string)$booking['resource_id'],
                    'room_name' => $booking['room_name'],
                    'source_type' => $booking['source_type'],
                    'status' => $booking['status'],
                    'status_color' => $booking['status_color'],
                    'status_value' => $booking['status_value'],
                    'updated_at' => now(),
                    'reseller_name' => isset($booking['reseller'][0]) ? $booking['reseller'][0]['name'] : null,
                    'reseller_key' => isset($booking['reseller'][0]) ? $booking['reseller'][0]['key'] : null,
                    'check_in_date' => $booking['check_in_date'],
                    'check_out_date' => $booking['check_out_date'],
                    'booking_created_at' => $booking['booking_created_at']
                ]
            );
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Bookings synced successfully.',
        ]);
    }
}
