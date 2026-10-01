@extends('master.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
@endsection
@section('breadcrum')
    <ol class="breadcrumb p-4">
        <li class="breadcrumb-item font-weight-bold">
            <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
        </li>

        <?php $link = ' '; ?>
        @for ($i = 1; $i <= count(Request::segments()); $i++)
            @if (($i < count(Request::segments())) & ($i > 0))
                <?php        $link .= ' /' . Request::segment($i); ?>
                @if ($i == 1)
                    <li class="breadcrumb-item font-weight-bold">
                        <a href="<?= $link ?>" class="inactive">
                            {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item font-weight-bold">
                        <a href="<?= $link ?>" class="inactive">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                    </li>
                @endif
            @else
                <li class="breadcrumb-item font-weight-bold">
                    <a class="active"> {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                </li>
            @endif
        @endfor
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card-group">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title mb-2">Practice Name:</h3>
                        <h3><a
                                href="{{ route('practice.show', auth()->user()->practice) }}">{{ auth()->user()->practice->practice_name }}</a>
                        </h3>
                        @can('create_practice')
                            <a href="{{ route('patient.create') }}" class="btn btn-success mt-4"><i class="fas fa-plus"></i></a>
                        @endcan
                        @can('crud_practice')
                            <a type="button" href="{{ route('practice.index') }}" class="btn btn-success mt-4">View all
                                Practices</a>
                        @endcan
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title mb-2">Total Patients:</h3>
                        <h3>{{ $total_patient }}</h3>
                        @can('create_patient')
                            <a href="{{ route('patient.create') }}" class="btn btn-success mt-4"><i class="fas fa-plus"></i></a>
                        @endcan
                        @can('view_all_patient')
                            <a href="{{ route('patient.index') }}" class="btn btn-success mt-4">View All Patient</a>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card-group">
                <!-- Column -->
                <div class="card shadow bg-success">
                    <div class="card-body text-center">
                        <h3 class="card-title text-white mb-2">CCM Patient:</h3>
                        <h3 class="text-white">{{ $ccm_patient_count }}</h3>
                        <div class="row text-center text-white">
                            <div class="col-6">
                                <span class="font-14">Simple</span>
                                <p class="font-14">{{ $simple }}</p>
                            </div>
                            <div class="col-6">
                                <span class="font-14">Complex</span>
                                <p class="font-14">{{ $complex }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card shadow bg-success">
                    <div class="card-body text-center text-white">
                        <h3 class="text-white">RPM Patient</h3>
                        <h5 class="text-white display-7">{{ $rpm_patient_count }}</h5>
                    </div>
                </div>
                <!-- Column -->
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header bg-success text-center shadow">
                    <h4 class="text-white">Care Plan</h4>
                </div>
                <div class="card-body weather-small">
                    <div class="row">
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'all']) }}">{{ $all_care_plan }}</a>
                            </h1>
                            <small>Total</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'remaining']) }}">{{ $remaining_care_plan }}</a>
                            </h1>
                            <small>Remaining</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'less-than']) }}">{{ $less_than_care_plan }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-left" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'greater-than']) }}">{{ $greater_than_care_plan }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-right" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header bg-success text-center shadow">
                    <h4 class="text-white">Monthly Review</h4>
                </div>
                <div class="card-body weather-small">
                    <div class="row">
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'all']) }}">{{ $all_monthly_review }}</a>
                            </h1>
                            <small>Total</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'remaining']) }}">{{ $remaining_monthly_review }}</a>
                            </h1>
                            <small>Remaining</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'less-than']) }}">{{ $less_than_monthly_review }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-left" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'greater-than']) }}">{{ $greater_than_monthly_review }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-right" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="#ccm" id="ccm_link" data-toggle="tab" aria-expanded="true"
                                class="nav-link {{ $ccm ? 'active' : '' }}">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">CCM Patient</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#rpm" id="rpm_link" data-toggle="tab" aria-expanded="false"
                                class="nav-link {{ $rpm ? 'active' : '' }}">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">RPM Patient</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#unenrolled" id="unenrolled_link" data-toggle="tab" aria-expanded="false"
                                class="nav-link {{ $unenrolled ? 'active' : '' }}">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Unenrolled Patient</span>
                            </a>
                        </li>
                    </ul>



                    <div class="tab-content">
                        <div class="tab-pane {{ $ccm ? 'show active' : '' }}" id="ccm">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <select class="form-control" name="select_care_manager_ccm"
                                            id="select_care_manager_ccm" style="width: 200px;">
                                            <option value="None"> --select care manager--</option>
                                        </select>
                                        <select class="form-control" name="select_last_ccm_performed"
                                            id="select_last_ccm_performed" style="width: 200px;">
                                            <option value="None" {{ $select_last_ccm_performed == 'None' ? 'selected' : '' }}>
                                                --Last CCM
                                                Performed--</option>
                                            <option value="Today" {{ $select_last_ccm_performed == 'Today' ? 'selected' : '' }}>Today
                                            </option>
                                            <option value="Yesterday" {{ $select_last_ccm_performed == 'Yesterday' ? 'selected' : '' }}>Yesterday
                                            </option>
                                            <option value="This-Month" {{ $select_last_ccm_performed == 'This-Month' ? 'selected' : '' }}>This
                                                Month</option>
                                            <option value="Prev-Month" {{ $select_last_ccm_performed == 'Prev-Month' ? 'selected' : '' }}>Prev
                                                Month</option>
                                        </select>
                                        <select class="form-control" name="select_covid_status_ccm"
                                            id="select_covid_status_ccm" style="width: 200px;">
                                            <option value="None" {{ $select_covid_status_ccm == 'None' ? 'selected' : '' }}>
                                                --covid
                                                status--</option>
                                            <option value="Positive" {{ $select_covid_status_ccm == 'Positive' ? 'selected' : '' }}>Positive
                                            </option>
                                            <option value="Negative" {{ $select_covid_status_ccm == 'Negative' ? 'selected' : '' }}>Negative
                                            </option>
                                            <option value="Unknown" {{ $select_covid_status_ccm == 'Unknown' ? 'selected' : '' }}>Unknown
                                            </option>
                                        </select>
                                        <select class="form-control" name="select_gender_ccm" id="select_gender_ccm"
                                            style="width: 200px;">
                                            <option value="None" {{ $select_gender_ccm == 'None' ? 'selected' : '' }}>
                                                --select gender--</option>
                                            <option value="Male" {{ $select_gender_ccm == 'Male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="Female" {{ $select_gender_ccm == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                        <form action="{{ route('reset.ccm.sort') }}" method="post">
                                            @csrf
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-filter mr-1" aria-hidden="true"></i>Reset
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive position-relative" id="rpm_patient_table_wrapper">
                                <div id="rpm-loader" style="
                                            display:none;
                                            position:absolute;
                                            top:0;
                                            left:0;
                                            width:100%;
                                            height:100%;
                                            background:rgba(255,255,255,0.8);
                                            z-index:9999;
                                            align-items:center;
                                            justify-content:center;
                                        ">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary mb-2" style="width:3rem;height:3rem;"></div>
                                        <div><strong>Loading patients...</strong></div>
                                    </div>
                                </div>
                                <table id="ccm_patient_table" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient Name</th>
                                            <th>Covid Status</th>
                                            <th>Gender</th>
                                            <th class="d-none">DOB</th>
                                            <th>Contact No</th>
                                            <th class="d-none">Email</th>
                                            <th>Enrol Date</th>
                                            <th>Care Manager</th>
                                            <th>Care Plan Created</th>
                                            <th>Last CCM Performed</th>
                                            <th class="d-none">Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane {{ $rpm ? 'show active' : '' }}" id="rpm">

                            <div class="row mb-3">
                                <div class="col-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Rpm Record Date"
                                            value="{{ $from }}" readonly>
                                        <button type="button" class="btn btn-danger">To</button>
                                        <input type="text" class="form-control" placeholder="Rpm Record Date"
                                            value="{{ $to }}" readonly>
                                        @can('reset_rpm_record')
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#rpm_reset_modal">Reset</button>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="button" data-toggle="modal" data-target="#filter_modal"
                                        class="btn btn-md btn-success">
                                        <i class="fas fa-filter mr-2"></i>Filters
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive position-relative" id="rpm_patient_table_wrapper">
                                <table id="rpm_patient_table" class="table table-striped table-bordered w-100 nowrap"
                                    data-url="{{ route('home') }}">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Avg(BP)</th>
                                            <th data-id="select_category_rpm">Category</th>
                                            <th>Last BP</th>
                                            <th data-id="select_status_rpm">Status</th>
                                            <th>Avg(PR)</th>
                                            <th>Last PR</th>
                                            <th data-id="select_time_taken_rpm">Time Taken</th>
                                            <th data-id="select_last_checked_rpm">Last Checked</th>
                                            <th data-id="select_minutes_rpm">Minutes(Month)</th>
                                            <th data-id="select_days_with_reading_rpm">Days With Reading</th>
                                            <th>Completed Call</th>
                                            <th>Covid Status</th>
                                            <th>Provider</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="tab-pane {{ $unenrolled ? 'show active' : '' }}" id="unenrolled">
                            <div class="table-responsive">
                                <table id="unenrolled_patient_table" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient Name</th>
                                            <th>Gender</th>
                                            <th>Contact no</th>
                                            <th>Address</th>
                                            <th>Un-Enroll Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>





                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="filter_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Apply Filter</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Care Manager</label>
                                <select class="form-control" name="select_care_manager_rpm" id="select_care_manager_rpm">
                                    <option value=""> --select care manger--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Category</label>
                                <select class="form-control" name="select_category_rpm" id="select_category_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --select
                                        Category--</option>
                                    <option value="Min-Max" {{ $select_category_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_category_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Status</label>
                                <select class="form-control" name="select_status_rpm" id="select_status_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --select
                                        Status--</option>
                                    <option value="Min-Max" {{ $select_status_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_status_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Time Taken</label>
                                <select class="form-control" name="select_time_taken_rpm" id="select_time_taken_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --Time
                                        Taken--</option>
                                    <option value="Min-Max" {{ $select_time_taken_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_time_taken_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Last Checked</label>
                                <select class="form-control" name="select_last_checked_rpm" id="select_last_checked_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --Last
                                        Checked--</option>
                                    <option value="Min-Max" {{ $select_last_checked_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_last_checked_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Min This Month</label>
                                <select class="form-control" name="select_minutes_rpm" id="select_minutes_rpm">
                                    <option value="None" {{ $select_minutes_rpm == 'None' ? 'selected' : '' }}> --Min
                                        This Month--</option>
                                    <option value="Min-Max" {{ $select_minutes_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_minutes_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Days With Reading</label>
                                <select class="form-control" name="select_days_with_reading_rpm"
                                    id="select_days_with_reading_rpm">
                                    <option value="None" {{ $select_days_with_reading_rpm == 'None' ? 'selected' : '' }}>
                                        --Days With
                                        Reading--</option>
                                    <option value="Min-Max" {{ $select_days_with_reading_rpm == 'Min-Max' ? 'selected' : '' }}>Min-Max
                                    </option>
                                    <option value="Max-Min" {{ $select_days_with_reading_rpm == 'Max-Min' ? 'selected' : '' }}>Max-Min
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <form action="{{ route('reset.rpm.sort') }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">
                                        <i class="fa fa-filter mr-1" aria-hidden="true"></i>Clear
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rpm_reset_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Are You Sure?</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('setting.rpm') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection









@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            // Handle URL hash for correct tab on load
            if (window.location.hash) {
                var hash = window.location.hash.substring(1);
                if (hash === "rpm") {
                    $('#rpm_link').trigger('click');
                } else if (hash === "unenrolled") {
                    $('#unenrolled_link').trigger('click');
                } else {
                    $('#ccm_link').trigger('click');
                }
            }

            // Helper function to fetch all data in chunks
            function fetchAllData(url, searchValue, callback) {
                var allData = [];
                var start = 0;
                var length = 1000; // Fetch 1000 records at a time
                
                function fetchChunk() {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            draw: 1,
                            start: start,
                            length: length,
                            search: { value: searchValue }
                        },
                        success: function(json) {
                            allData = allData.concat(json.data);
                            
                            // Check if there are more records
                            if (json.data.length === length && allData.length < json.recordsFiltered) {
                                start += length;
                                fetchChunk(); // Fetch next chunk
                            } else {
                                // All data fetched
                                callback(allData);
                            }
                        },
                        error: function() {
                            alert('Error fetching data for export');
                            callback(null);
                        }
                    });
                }
                
                fetchChunk();
            }

            // Helper function to strip HTML tags safely
            function stripHtml(html) {
                if (!html) return '';
                var tmp = document.createElement("DIV");
                tmp.innerHTML = html;
                return tmp.textContent || tmp.innerText || "";
            }

            // CCM Table - Server Side
            var ccm_table = $('#ccm_patient_table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '/patients/ccm',
                dom: '<lBf<t>ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm text-white px-3 py-2',
                        filename: 'CCM-Patients_' + new Date().toISOString().slice(0, 10),
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)', // This includes hidden columns but excludes action column
                            header: true,
                            format: {
                                body: function(data, row, column, node) {
                                    return stripHtml(data);
                                }
                            }
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Exporting...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/ccm', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures.bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide = originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                }, 100);
                            });
                        },
                        customizeData: function(data) {
                            // 1. Manually set the header
                            var newHeader = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB', 'Contact No', 'Email', 'Enrol Date', 'Care Manager', 'Care Plan Created', 'Last CCM Performed', 'Address'];
                            
                            // Safety Check: Ensure header length matches body length to prevent corruption
                            if (data.body.length > 0 && newHeader.length === data.body[0].length) {
                                data.header = newHeader;
                            }

                            // 2. Format Body Data
                            const nameColIndex = 1;
                            const dobColIndex = 4;
                            const enrolDateColIndex = 7;
                            const carePlanDateColIndex = 9;
                            const lastCcmDateColIndex = 10;

                            // Helper for dates inside the loop
                            function formatDate(dateStr) {
                                if (!dateStr || dateStr === "-" || dateStr === "N/A") return dateStr;
                                const d = new Date(dateStr);
                                if (isNaN(d.getTime())) return dateStr;
                                return d.toLocaleDateString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit' });
                            }

                            data.body.forEach(function(row) {
                                // Fix Name (Last, First)
                                if (row[nameColIndex]) {
                                    const parts = row[nameColIndex].trim().split(" ");
                                    if (parts.length >= 2) {
                                        row[nameColIndex] = parts[parts.length - 1] + ", " + parts.slice(0, -1).join(" ");
                                    }
                                }
                                // Fix Dates
                                row[dobColIndex] = formatDate(row[dobColIndex]);
                                row[enrolDateColIndex] = formatDate(row[enrolDateColIndex]);
                                row[carePlanDateColIndex] = formatDate(row[carePlanDateColIndex]);
                                row[lastCcmDateColIndex] = formatDate(row[lastCcmDateColIndex]);
                            });
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm text-white px-3 py-2',
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            stripHtml: false, // Often better for print to keep some formatting
                            header: true
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/ccm', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures.bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.print.action.call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide = originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                }, 500); // Increased timeout to ensure DOM renders before print dialog
                            });
                        },
                        // CUSTOMIZE DATA DOES NOT WORK FOR PRINT. USE THIS INSTEAD:
                        customize: function(win) {
                            var doc = win.document;
                            
                            // Manual Header Injection if missing (Print takes a snapshot of DOM)
                            var headers = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB', 'Contact No', 'Email', 'Enrol Date', 'Care Manager', 'Care Plan Created', 'Last CCM Performed', 'Address'];
                            
                            // Find the table header in the print window
                            var tHead = $(doc).find('thead');
                            
                            // Ideally, the 'dt.draw(false)' in the action should have rendered the header.
                            // But if you need to force change the text:
                            if(tHead.length > 0) {
                                 var ths = tHead.find('th');
                                 if(ths.length === headers.length) {
                                     ths.each(function(index) {
                                         $(this).text(headers[index]);
                                     });
                                 }
                            }
                            
                            // Optional: Styling for print
                            $(doc.body).find('table').addClass('table table-bordered');
                            $(doc.body).find('h1').css('text-align', 'center').css('font-size', '18px');
                        }
                    }
                    /* Commented out Current Page buttons
                    ,{
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Current Page',
                        className: 'btn btn-outline-success btn-sm text-white px-3 py-2',
                        filename: 'CCM-Patients_' + new Date().toISOString().slice(0,10),
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB', 'Contact No', 'Email', 'Enrol Date', 'Care Manager', 'Care Plan Created', 'Last CCM Performed', 'Address'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        },
                        customizeData: function(data) {
                            const nameColIndex = 1;
                            const dobColIndex = 4;
                            const enrolDateColIndex = 7;
                            const carePlanDateColIndex = 9;
                            const lastCcmDateColIndex = 10;

                            data.body.forEach(function(row) {
                                // Name reorder
                                const nameCell = row[nameColIndex];
                                const parts = nameCell.trim().split(" ");
                                if (parts.length >= 2) {
                                    const firstName = parts.slice(0, -1).join(" ");
                                    const lastName = parts[parts.length - 1];
                                    row[nameColIndex] = `${lastName}, ${firstName}`;
                                }

                                // Date formatting
                                function formatDate(dateStr) {
                                    if (!dateStr || dateStr === "-" || dateStr === "N/A")
                                        return dateStr;
                                    const d = new Date(dateStr);
                                    if (isNaN(d.getTime())) return dateStr;
                                    const mm = String(d.getMonth() + 1).padStart(2, "0");
                                    const dd = String(d.getDate()).padStart(2, "0");
                                    const yyyy = d.getFullYear();
                                    return `${mm}/${dd}/${yyyy}`;
                                }

                                row[dobColIndex] = formatDate(row[dobColIndex]);
                                row[enrolDateColIndex] = formatDate(row[enrolDateColIndex]);
                                row[carePlanDateColIndex] = formatDate(row[carePlanDateColIndex]);
                                row[lastCcmDateColIndex] = formatDate(row[lastCcmDateColIndex]);
                            });
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Current Page',
                        className: 'btn btn-outline-secondary btn-sm text-white px-3 py-2',
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB', 'Contact No', 'Email', 'Enrol Date', 'Care Manager', 'Care Plan Created', 'Last CCM Performed', 'Address'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    }
                    */
                ],
                responsive: true,
                pageLength: 25,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [
                    {
                        targets: [4, 6, 11],
                        visible: false
                    }
                ],
                initComplete: function() {
                    this.api().columns(8).every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-control form-control-sm"><option value="">All Care Managers</option></select>'
                            )
                            .appendTo('#select_care_manager_ccm')
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d) {
                            var val = $('<div>').html(d).text().trim();
                            if (val) {
                                select.append('<option value="' + val + '">' + val +
                                    '</option>');
                            }
                        });
                    });
                }
            });




            // RPM Table - Server Side
            var rpm_table = $('#rpm_patient_table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '/patients/rpm',
                dom: '<lBf<t>ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm text-white px-3 py-2',
                        filename: 'RPM-Patients_' + new Date().toISOString().slice(0, 10),
                        title: 'RPM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            header: true,
                            format: {
                                body: function(data, row, column, node) {
                                    return stripHtml(data);
                                }
                            }
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Exporting...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/rpm', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures.bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide = originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                }, 100);
                            });
                        },
                        customizeData: function(data) {
                            var newHeader = ['#', 'Patient', 'Avg(BP)', 'Category', 'Last BP', 'Status', 'Avg(PR)', 'Last PR', 'Time Taken', 'Last Checked', 'Minutes(Month)', 'Days With Reading', 'Completed Call', 'Covid Status', 'Provider'];
                            
                            if (data.body.length > 0 && newHeader.length === data.body[0].length) {
                                data.header = newHeader;
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm text-white px-3 py-2',
                        title: 'RPM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            stripHtml: false,
                            header: true
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/rpm', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures.bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.print.action.call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide = originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                }, 500);
                            });
                        },
                        customize: function(win) {
                            var doc = win.document;
                            var headers = ['#', 'Patient', 'Avg(BP)', 'Category', 'Last BP', 'Status', 'Avg(PR)', 'Last PR', 'Time Taken', 'Last Checked', 'Minutes(Month)', 'Days With Reading', 'Completed Call', 'Covid Status', 'Provider'];
                            var tHead = $(doc).find('thead');
                            
                            if(tHead.length > 0) {
                                 var ths = tHead.find('th');
                                 if(ths.length === headers.length) {
                                     ths.each(function(index) {
                                         $(this).text(headers[index]);
                                     });
                                 }
                            }
                            
                            $(doc.body).find('table').addClass('table table-bordered');
                            $(doc.body).find('h1').css('text-align', 'center').css('font-size', '18px');
                        }
                    }
                    /* Commented out Current Page buttons
                    ,{
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Current Page',
                        className: 'btn btn-outline-success btn-sm text-white px-3 py-2',
                        filename: 'RPM-Patients_' + new Date().toISOString().slice(0,10),
                        title: 'RPM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient', 'Avg(BP)', 'Category', 'Last BP', 'Status', 'Avg(PR)', 'Last PR', 'Time Taken', 'Last Checked', 'Minutes(Month)', 'Days With Reading', 'Completed Call', 'Covid Status', 'Provider'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Current Page',
                        className: 'btn btn-outline-secondary btn-sm text-white px-3 py-2',
                        title: 'RPM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient', 'Avg(BP)', 'Category', 'Last BP', 'Status', 'Avg(PR)', 'Last PR', 'Time Taken', 'Last Checked', 'Minutes(Month)', 'Days With Reading', 'Completed Call', 'Covid Status', 'Provider'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    }
                    */
                ],
                responsive: true,
                pageLength: 25,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [
                    {
                        targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                        className: 'text-nowrap'
                    },
                    {
                        targets: [0],
                        width: '50px'
                    },
                    {
                        targets: [2, 6],
                        width: '80px'
                    },
                    {
                        targets: [5],
                        width: '100px'
                    }
                ],
                language: {
                    processing: `
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <strong>Loading patients...</strong>
                    </div>
                `
                },
                initComplete: function() {
                    this.api().columns(14).every(
                        function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-control form-control-sm"><option value="">All Care Managers</option></select>'
                                )
                                .appendTo('#select_care_manager_rpm')
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d) {
                                var val = $('<div>').html(d).text().trim();
                                if (val) {
                                    select.append('<option value="' + val + '">' + val +
                                        '</option>');
                                }
                            });
                        });
                }
            });
            
            // Show loader on any processing event
            rpm_table.on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $('#rpm-loader').fadeIn(100);
                } else {
                    $('#rpm-loader').fadeOut(150);
                }
            });


    
            // Unenrolled Table - Server Side
            var unenrolled_table = $('#unenrolled_patient_table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '/patients/unenrolled',
                dom: '<lBf<t>ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm text-white px-3 py-2',
                        filename: 'Unenrolled-Patients_' + new Date().toISOString().slice(0, 10),
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            header: true,
                            format: {
                                body: function(data, row, column, node) {
                                    return stripHtml(data);
                                }
                            }
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Exporting...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/unenrolled', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures.bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide = originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                }, 100);
                            });
                        },
                        customizeData: function(data) {
                            var newHeader = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address', 'Un-Enroll Note'];
                            
                            if (data.body.length > 0 && newHeader.length === data.body[0].length) {
                                data.header = newHeader;
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm text-white px-3 py-2',
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            stripHtml: false,
                            header: true
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/unenrolled', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures.bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.print.action.call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide = originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                }, 500);
                            });
                        },
                        customize: function(win) {
                            var doc = win.document;
                            var headers = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address', 'Un-Enroll Note'];
                            var tHead = $(doc).find('thead');
                            
                            if(tHead.length > 0) {
                                 var ths = tHead.find('th');
                                 if(ths.length === headers.length) {
                                     ths.each(function(index) {
                                         $(this).text(headers[index]);
                                     });
                                 }
                            }
                            
                            $(doc.body).find('table').addClass('table table-bordered');
                            $(doc.body).find('h1').css('text-align', 'center').css('font-size', '18px');
                        }
                    }
                    /* Commented out Current Page buttons
                    ,{
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Current Page',
                        className: 'btn btn-outline-success btn-sm text-white px-3 py-2',
                        filename: 'Unenrolled-Patients_' + new Date().toISOString().slice(0,10),
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address', 'Un-Enroll Note'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Current Page',
                        className: 'btn btn-outline-secondary btn-sm text-white px-3 py-2',
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address', 'Un-Enroll Note'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    }
                    */
                ],
                responsive: true,
                pageLength: 25,
                order: [
                    [0, 'asc']
                ]
            });

            // Restore saved filters
            @if ($select_covid_status_ccm !== 'None')
                $('#select_covid_status_ccm').val('{{ $select_covid_status_ccm }}');
                filter_select_covid_status_ccm('{{ $select_covid_status_ccm }}');
            @endif

            @if ($select_gender_ccm !== 'None')
                $('#select_gender_ccm').val('{{ $select_gender_ccm }}');
                filter_select_gender_ccm('{{ $select_gender_ccm }}');
            @endif

            @if ($select_last_ccm_performed !== 'None')
                $('#select_last_ccm_performed').val('{{ $select_last_ccm_performed }}');
                filter_select_last_ccm_performed('{{ $select_last_ccm_performed }}');
            @endif

            // Tab activation
            $('#ccm_link, #rpm_link, #unenrolled_link').click(function() {
                var tab = $(this).attr('id').replace('_link', '');
                active_tab(tab, true);
            });

            function active_tab(key, value) {
                $.post("{{ route('custom.sort') }}", {
                    key: key,
                    value: value,
                    type: "tab",
                    _token: '{{ csrf_token() }}'
                });
            }

            // Adjust columns when tab changes
            $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust()
                    .responsive.recalc();
            });

            // Fixed: Last CCM Performed filter
            $('#select_last_ccm_performed').on('change', function() {
                var value = $(this).val();
                sort('select_last_ccm_performed', value, 'ccm');
                filter_select_last_ccm_performed(value);
            });

            function filter_select_last_ccm_performed(search) {
                var date = new Date();
                var month = date.getMonth() + 1;
                var day = date.getDate();

                if (search === "Yesterday") day -= 1;
                if (day < 1) {
                    day = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
                    month -= 1;
                    if (month < 1) month = 12;
                }
                day = day < 10 ? "0" + day : day;
                month = month < 10 ? "0" + month : month;

                var pattern = "";
                if (search === "Today") pattern = month + "-" + day;
                else if (search === "Yesterday") pattern = month + "-" + day;
                else if (search === "This-Month") pattern = "^" + month + "-";
                else if (search === "Prev-Month") {
                    var prev = month - 1 || 12;
                    prev = prev < 10 ? "0" + prev : prev;
                    pattern = "^" + prev + "-";
                }

                ccm_table.column(10).search(pattern, true, false).draw();
            }

            // Gender & Covid filters
            $('#select_gender_ccm').on('change', function() {
                var val = $(this).val();
                sort('select_gender_ccm', val, 'ccm');
                ccm_table.column(3).search(val ? '(^' + val + '$)' : '', true, false).draw();
            });

            $('#select_covid_status_ccm').on('change', function() {
                var val = $(this).val();
                sort('select_covid_status_ccm', val, 'ccm');
                ccm_table.column(2).search(val ? '(^' + val + '$)' : '', true, false).draw();
            });

            // RPM sorting filters (Min-Max etc.)
            $('#select_category_rpm, #select_status_rpm, #select_time_taken_rpm, #select_last_checked_rpm, #select_minutes_rpm, #select_days_with_reading_rpm')
                .change(function() {
                    var id = $(this).attr('id');
                    var value = $(this).val();
                    sort(id, value, 'rpm');

                    var colMap = {
                        select_category_rpm: 3,
                        select_status_rpm: 5,
                        select_time_taken_rpm: 8,
                        select_last_checked_rpm: 9,
                        select_minutes_rpm: 10,
                        select_days_with_reading_rpm: 11
                    };

                    var col = colMap[id];
                    if (value === "Min-Max") rpm_table.order([col, 'asc']).draw();
                    else if (value === "Max-Min") rpm_table.order([col, 'desc']).draw();
                    else rpm_table.order([1, 'asc']).draw();
                });

            function sort(key, value, type) {
                $.post("{{ route('custom.sort') }}", {
                    key: key,
                    value: value,
                    type: type,
                    _token: '{{ csrf_token() }}'
                });
            }
        });
    </script>
@endsection