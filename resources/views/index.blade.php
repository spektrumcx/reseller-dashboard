@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    <div class="p-4 mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h3 class=" mb-0" id="reseller_name"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form>
                            <div class="row g-3 justify-content-end">
                                <div class="col-xxl-10 col-sm-10">
                                    <div class="search-box">
                                        <input type="text" class="form-control search"
                                               value=""
                                               placeholder="Search for Reseller Secret..." id="reseller_key">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>

                                <!--end col-->
                                <div class="col-xxl-2 col-sm-2">
                                    <div>
                                        <button type="button" class="btn btn-primary w-100" onclick="getBookings();">
                                            Get Bookings
                                            <i class="ri-calendar-2-line me-1 align-bottom"></i>
                                        </button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <div class="card-body pt-0">
                        <div class="my-4">


                            <div class="table-responsive table-card mb-1">
                                {{--                                <table class="table table-nowrap align-middle" id="bookingTable">--}}
                                {{--                                    <thead class="text-muted table-light">--}}
                                {{--                                    <tr>--}}
                                {{--                                        <h3 class="p-4">All Bookings </h3>--}}
                                {{--                                    </tr>--}}
                                {{--                                    <tr class="text-uppercase">--}}
                                {{--                                        <th scope="col" style="width: 25px;">--}}
                                {{--                                            <div class="form-check">--}}
                                {{--                                                <input class="form-check-input" type="checkbox" id="checkAll"--}}
                                {{--                                                       value="option">--}}
                                {{--                                            </div>--}}
                                {{--                                        </th>--}}
                                {{--                                        --}}{{--                                    <th class="sort desc" data-sort="id">Booking ID</th>--}}
                                {{--                                        <th class="sort" data-sort="id">Status</th>--}}
                                {{--                                        --}}{{--                                    created at--}}
                                {{--                                        <th class="sort" data-sort="created_at">Created At</th>--}}
                                {{--                                        <th class="sort" data-sort="unit_name">Unit Name</th>--}}
                                {{--                                        <th class="sort" data-sort="property_name">Property</th>--}}
                                {{--                                        <th class="sort" data-sort="user_name">User Name</th>--}}
                                {{--                                        <th class="sort" data-sort="dates">Dates</th>--}}
                                {{--                                        <th class="sort" data-sort="payment_status">Payment Status</th>--}}
                                {{--                                        <th class="sort" data-sort="amount">Amount</th>--}}
                                {{--                                        <th class="sort" data-sort="source">Source</th>--}}

                                {{--                                    </tr>--}}
                                {{--                                    </thead>--}}
                                {{--                                    <tbody class="list form-check-all">--}}

                                {{--                                    </tbody>--}}
                                {{--                                </table>--}}

                                <table class="table table-nowrap align-middle" id="bookingTable">
                                    <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
{{--                                        <th scope="col" style="width: 25px;">--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="checkbox" id="checkAll"--}}
{{--                                                       value="option">--}}
{{--                                            </div>--}}
{{--                                        </th>--}}
                                        <th>Status</th>
                                        <th>Booking Number</th>
                                        <th>Unit Name</th>
                                        <th>Property</th>
                                        <th>User Name</th>
                                        <th>Dates</th>
                                        <th>Payment Status</th>
                                        <th>Amount</th>
                                        <th>Source</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>


                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="pagination-wrap hstack gap-2" style="display: flex;">
                                    <a class="page-item pagination-prev disabled" href="#">
                                        Previous
                                    </a>
                                    <ul class="pagination listjs-pagination mb-0">
                                        <li class="active"><a class="page" href="#" data-i="1" data-page="8">1</a></li>
                                        <li><a class="page" href="#" data-i="2" data-page="8">2</a></li>
                                    </ul>
                                    <a class="page-item pagination-next" href="#">
                                        Next
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!--end col-->
        </div>
    </div>
@endsection
@section('script')
    {{--    <script src="{{ URL::asset('build/js/app.js') }}"></script>--}}
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $('#bookingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/getBookings',
                    type: 'POST',
                    data: function (d) {
                        d.reseller_key = $('#reseller_key').val(); // Add reseller_key dynamically
                        d._token = '{{ csrf_token() }}';
                    },
                },
                columns: [
                    // {data: 'check', orderable: false, searchable: false},
                    {data: 'status'},
                    {data: 'booking_number'},
                    {data: 'unit_name'},
                    {data: 'property_name'},
                    {data: 'user_name'},
                    {data: 'dates'},
                    {data: 'payment_status'},
                    {data: 'amount'},
                    {data: 'source'},
                ],
                pageLength: 10,

                lengthMenu: [5, 10, 25, 50],
            });
        });


        function getBookings() {
            var reseller_key = $('#reseller_key').val();
            $.ajax({
                url: '/getBookings',
                type: 'POST',
                data: {
                    reseller_key: reseller_key,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.status == 'success') {
                        var bookings = response.bookings;
                        console.log(bookings)
                        $('#reseller_name').text('Welcome ' + bookings[0].reseller_name + " !");
                        // 'status' => ucfirst($booking->status),
                        //     'room_name' => $booking->room_name,
                        //     'hotel_name' => $booking->hotel_name,
                        //     'customer_name' => $booking->customer_name,
                        //     'dates' => $booking->dates,
                        //     'payment_status' => ucfirst($booking->payment_status),
                        //     'cost' => $booking->cost,
                        //     'source_type' => $booking->source_type,
                        var html = '';
                        for (var i = 0; i < bookings.length; i++) {
                            var booking = bookings[i];
                            html += '<tr>';
                            // html += '<th scope="row">';
                            // // html += '<div class="form-check">';
                            // // html += '<input class="form-check-input" type="checkbox" name="checkAll" value="option1">';
                            // // html += '</div>';
                            // html += '</th>';
                            html += '<td class="status"><span class="badge text-uppercase" style="background-color: ' + booking.status_color + ';">' + booking.status + '</span></td>';
                            html += '<td class="booking_number">' + booking.booking_number + '</td>';
                            html += '<td class="unit_name">' + booking.room_name + '</td>';
                            html += '<td class="property_name">' + booking.hotel_name + '</td>';
                            html += '<td class="user_name">' + booking.customer_name + '</td>';
                            html += '<td class="dates">' + booking.dates + '</td>';
                            html += '<td class="payment_status"><span class="badge text-uppercase" style="background-color: ' + booking.payment_status_color + ';">' + booking.payment_status + '</span></td>';
                            html += '<td class="amount">' + booking.cost + '</td>';
                            html += '<td class="source">' + booking.source_type + '</td>';
                            // add dropdown of marked paid or unpaid
                            html += '<td class="action">';
                            html += '<div class="dropdown">';
                            html += '<button class="btn btn-sm btn-soft-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">';
                            html += 'Action';
                            html += '</button>';
                            html += '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            html += '<li><a class="dropdown-item" href="#">Mark as Paid</a></li>';
                            html += '<li><a class="dropdown-item" href="#">Mark as Unpaid</a></li>';
                            html += '</ul>';
                            html += '</div>';
                            html += '</td>';
                            html += '</tr>';
                        }
                        $('#bookingTable tbody').html(html);
                    } else {
                        console.error(response.message);
                        $('#bookingTable').DataTable().clear().draw(); // Clear the DataTable
                        Swal.fire({
                            title: 'Warning!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'Retry'
                        })
                    }
                },
            });
        }


        {{--function getBookings(){--}}
        {{--    var reseller_key = $('#reseller_key').val();--}}
        {{--    $.ajax({--}}
        {{--        url: '/getBookings',--}}
        {{--        type: 'POST',--}}
        {{--        data: {--}}
        {{--            reseller_key: reseller_key,--}}
        {{--            _token: '{{ csrf_token() }}'--}}
        {{--        },--}}
        {{--        success: function (response) {--}}
        {{--            console.log(response);--}}
        {{--            if(response.status == 'success'){--}}
        {{--                var bookings = response.bookings;--}}
        {{--                var html = '';--}}
        {{--                for(var i = 0; i < bookings.length; i++){--}}
        {{--                    var booking = bookings[i];--}}
        {{--                    html += '<tr>';--}}
        {{--                    html += '<th scope="row">';--}}
        {{--                    html += '<div class="form-check">';--}}
        {{--                    html += '<input class="form-check-input" type="checkbox" name="checkAll" value="option1">';--}}
        {{--                    html += '</div>';--}}
        {{--                    html += '</th>';--}}
        {{--                    html += '<td class="status"><span class="badge bg-success-subtle text-success text-uppercase">'+booking.status+'</span></td>';--}}
        {{--                    html += '<td class="created_at">'+booking.created_at+'</td>';--}}
        {{--                    html += '<td class="unit_name">'+booking.unit_name+'</td>';--}}
        {{--                    html += '<td class="property_name">'+booking.property_name+'</td>';--}}
        {{--                    html += '<td class="user_name">'+booking.user_name+'</td>';--}}
        {{--                    html += '<td class="dates">'+booking.dates+'</td>';--}}
        {{--                    html += '<td class="payment_status"><span class="badge bg-warning-subtle text-warning text-uppercase">'+booking.payment_status+'</span></td>';--}}
        {{--                    html += '<td class="amount">'+booking.amount+'</td>';--}}
        {{--                    html += '<td class="source">'+booking.source+'</td>';--}}
        {{--                    html += '</tr>';--}}
        {{--                }--}}
        {{--                $('#bookingTable tbody').html(html);--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

    </script>
@endsection
