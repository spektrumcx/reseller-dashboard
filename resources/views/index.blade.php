@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    <style>
        #bookingTable_filter {
            /*display: none!important;*/
        }
    </style>
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
                                <div class="col-xxl-6 col-sm-6">
                                    <div class="search-box">
                                        <input type="text" class="form-control search"
                                               value=""
                                               placeholder="Search for Reseller Secret..." id="reseller_key">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-sm-4">
                                    <div class="date-picker" id="date-picker">
                                        <input type="text" class="form-control" placeholder="Select Date Range"
                                               id="input"/>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-sm-2">
                                    <div>
                                        <button type="button" class="btn btn-primary w-100"
                                                onclick="getBookings();">
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
                                    <tbody>

                                    </tbody>
                                </table>


                            </div>

                            {{--                            <div class="d-flex justify-content-end">--}}
                            {{--                                <div class="pagination-wrap hstack gap-2" style="display: flex;">--}}
                            {{--                                    <a class="page-item pagination-prev disabled" href="#">--}}
                            {{--                                        Previous--}}
                            {{--                                    </a>--}}
                            {{--                                    <ul class="pagination listjs-pagination mb-0">--}}
                            {{--                                        <li class="active"><a class="page" href="#" data-i="1" data-page="8">1</a></li>--}}
                            {{--                                        <li><a class="page" href="#" data-i="2" data-page="8">2</a></li>--}}
                            {{--                                    </ul>--}}
                            {{--                                    <a class="page-item pagination-next" href="#">--}}
                            {{--                                        Next--}}
                            {{--                                    </a>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script type="text/javascript">
        let dtTable;
        let selectedDateRange;

        {{--$(document).ready(function () {--}}
        {{--    let now = new Date();--}}
        {{--    let firstDay = new Date(now.getFullYear(), now.getMonth(), 1);--}}
        {{--    let lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);--}}

        {{--    // Format dates as YYYY-MM-DD--}}
        {{--    let firstDayStr = firstDay.toISOString().split('T')[0];--}}
        {{--    let lastDayStr = lastDay.toISOString().split('T')[0];--}}

        {{--    // Initialize Flatpickr with the date range--}}
        {{--    flatpickr("#input", {--}}
        {{--        mode: "range", // Enables date range selection--}}
        {{--        dateFormat: "Y-m-d", // Format: YYYY-MM-DD--}}
        {{--        defaultDate: [firstDayStr, lastDayStr], // Set initial value to current month's range--}}
        {{--        onClose: function(selectedDates, dateStr) {--}}
        {{--            alert("Selected Date Range: " + dateStr); // Show selected date range--}}
        {{--        }--}}
        {{--    });--}}



        {{--    $('#date_range').val(moment().subtract(1, 'month').format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD'));--}}

        {{--    dtTable = $('#bookingTable').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: {--}}
        {{--            url: '/getBookings',--}}
        {{--            type: 'POST',--}}
        {{--            data: function (d) {--}}
        {{--                d.reseller_key = $('#reseller_key').val(); // Add reseller_key dynamically--}}
        {{--                d._token = '{{ csrf_token() }}';--}}
        {{--                d._dtpick = "123";--}}
        {{--            },--}}
        {{--        },--}}
        {{--        columns: [--}}
        {{--            // {searchable: false},--}}
        {{--            // {data: 'status' , hidden: true},--}}
        {{--            {data: 'status_color'},--}}
        {{--            // {data: 'status_color'},--}}
        {{--            {data: 'booking_number'},--}}
        {{--            {data: 'room_name'},--}}
        {{--            {data: 'hotel_name'},--}}
        {{--            {data: 'customer_name'},--}}
        {{--            {data: 'dates'},--}}
        {{--            // {data: 'payment_status'},--}}
        {{--            {data: 'payment_status_color'},--}}
        {{--            {data: 'cost'},--}}
        {{--            {data: 'source_type'},--}}
        {{--            {data: 'action'},--}}
        {{--        ],--}}
        {{--        pageLength: 10,--}}

        {{--        lengthMenu: [5, 10, 25, 50],--}}
        {{--    });--}}
        {{--});--}}

            var isLoaded = false;

        $(document).ready(function () {
            let now = new Date();
            let firstDay = new Date(now.getFullYear(), now.getMonth(), 2);
            let lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 1);

// Format dates as YYYY-MM-DD
            let firstDayStr = firstDay.toISOString().split('T')[0];
            let lastDayStr = lastDay.toISOString().split('T')[0];

            // Store selected date range in a variable
            selectedDateRange = firstDayStr + ' to ' + lastDayStr;

            // Initialize Flatpickr with the date range
            flatpickr("#input", {
                mode: "range",
                dateFormat: "Y-m-d",
                defaultDate: [firstDayStr, lastDayStr],
                onClose: function (selectedDates, dateStr) {
                    selectedDateRange = dateStr; // Update the selected date range
                    // alert("Selected Date Range: " + dateStr);
                    dtTable.ajax.reload(); // Reload DataTable with the new date range
                }
            });

            // Initialize DataTable
            dtTable = $('#bookingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/getBookings',
                    type: 'POST',
                    data: function (d) {
                        d.reseller_key = $('#reseller_key').val(); // Add reseller_key dynamically
                        d._token = '{{ csrf_token() }}';
                        d.date_range = selectedDateRange; // Send selected date range in AJAX request
                    },
                    "dataSrc": function ( res ) {
                        if (!isLoaded) {
                            isLoaded = true;
                            return true
                        }
                        if(res.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message,
                                confirmButtonText: 'OK'
                            });

                        }  if(res.status === 'info') {
                            Swal.fire({
                                icon: 'info',
                                title: 'Warning',
                                text: res.message,
                                confirmButtonText: 'OK'
                            });

                        }
                        if(res.status === 'success') {
                            $('#reseller_name').text(res.reseller_name);
                        }

                    }

                },

                columns: [
                    {data: 'status_color'},
                    {data: 'booking_number'},
                    {data: 'room_name'},
                    {data: 'hotel_name'},
                    {data: 'customer_name'},
                    {data: 'dates'},
                    {data: 'payment_status_color'},
                    {data: 'cost'},
                    {data: 'source_type'},
                    {data: 'action'},
                ],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
            });
        });

        function getBookings() {
            if (dtTable) {
                dtTable.ajax.reload(null, false); // false = retain current pagination
            }
        }

    </script>
@endsection
