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
                <?php $link .= ' /' . Request::segment($i); ?>
                @if ($i == 1)
                    <li class="breadcrumb-item font-weight-bold">
                        <a href="<?= $link ?>" class="inactive">
                            {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item font-weight-bold">
                        <a href="<?= $link ?>"
                           class="inactive">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
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
                        <h3><a href="{{route('practice.show', auth()->user()->practice)}}">{{ auth()->user()->practice->practice_name }}</a></h3>
                        @can('create_practice')
                            <a href="{{route('patient.create')}}" class="btn btn-success mt-4"><i class="fas fa-plus"></i></a>
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
                            <a href="{{route('patient.create')}}" class="btn btn-success mt-4"><i class="fas fa-plus"></i></a>
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
                            <a href="#ccm" id="ccm_link" data-toggle="tab" aria-expanded="true" class="nav-link {{$ccm ? 'active' : ''}}">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">CCM Patient</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#rpm" id="rpm_link" data-toggle="tab" aria-expanded="false" class="nav-link {{$rpm ? 'active' : ''}}">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">RPM Patient</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#unenrolled" id="unenrolled_link" data-toggle="tab" aria-expanded="false" class="nav-link {{$unenrolled ? 'active' : ''}}">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Unenrolled Patient</span>
                            </a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane {{$ccm ? 'show active' : ''}}" id="ccm">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <select class="form-control" name="select_care_manager_ccm" id="select_care_manager_ccm" style="width: 200px;">
                                            <option value="None"> --select care manager--</option>
                                        </select>
                                        <select class="form-control" name="select_last_ccm_performed" id="select_last_ccm_performed" style="width: 200px;">
                                            <option value="None" {{$select_last_ccm_performed == "None" ? 'selected' : ''}}> --Last CCM Performed--</option>
                                            <option value="Today" {{$select_last_ccm_performed == "Today" ? 'selected' : ''}}>Today</option>
                                            <option value="Yesterday" {{$select_last_ccm_performed == "Yesterday" ? 'selected' : ''}}>Yesterday</option>
                                            <option value="This-Month" {{$select_last_ccm_performed == "This-Month" ? 'selected' : ''}}>This Month</option>
                                            <option value="Prev-Month" {{$select_last_ccm_performed == "Prev-Month" ? 'selected' : ''}}>Prev Month</option>
                                        </select>
                                        <select class="form-control" name="select_covid_status_ccm"
                                                id="select_covid_status_ccm" style="width: 200px;">
                                            <option value="None" {{$select_covid_status_ccm == "None" ? 'selected' : ''}}> --covid status--</option>
                                            <option value="Positive" {{$select_covid_status_ccm == "Positive" ? 'selected' : ''}}>Positive</option>
                                            <option value="Negative" {{$select_covid_status_ccm == "Negative" ? 'selected' : ''}}>Negative</option>
                                            <option value="Unknown" {{$select_covid_status_ccm == "Unknown" ? 'selected' : ''}}>Unknown</option>
                                        </select>
                                        <select class="form-control" name="select_gender_ccm" id="select_gender_ccm"
                                                style="width: 200px;">
                                            <option value="None" {{$select_gender_ccm == "None" ? 'selected' : ''}}> --select gender--</option>
                                            <option value="Male" {{$select_gender_ccm == "Male" ? 'selected' : ''}}>Male</option>
                                            <option value="Female" {{$select_gender_ccm == "Female" ? 'selected' : ''}}>Female</option>
                                        </select>
                                        <form action="{{route('reset.ccm.sort')}}" method="post">
                                            @csrf
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-filter mr-1" aria-hidden="true"></i>Reset
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="ccm_patient_table" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient Name</th>
                                        <th>Covid Status</th>
                                        <th>Gender</th>
                                        <th>Contact No</th>
                                        <th>Enrol Date</th>
                                        <th>Care Manager</th>
                                        <th>Care Plan Created</th>
                                        <th>Last CCM Performed</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $sr_no = 1;
                                    @endphp
                                    @foreach ($ccm_patients as $item)
                                        <tr>
                                            <td>{{ $sr_no++ }}</td>
                                            @php
                                                $current = Carbon\Carbon::now()->timestamp;
                                                $ccm_enrol_timestamp = Carbon\Carbon::parse($item->ccm_enrol_date)->timestamp;
                                                $care_plan_timestamp = "-";
                                                if($item->care_plan){
                                                    $care_plan_timestamp = Carbon\Carbon::parse($item->care_plan->completed_at)->timestamp;
                                                }
                                                $last_ccm_timestamp = Carbon\Carbon::parse($item->last_ccm_performed)->timestamp;
                                            @endphp
                                            <td>
                                                <a href="{{ route('patient.show', ['patient' => $item, 'type' => 'ccm']) }}"><strong>{{ $item->first_name }} {{ $item->last_name }}</strong></a>
                                            </td>
                                            <td>{{ $item->covid_status }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->contact_no }}</td>
                                            <td data-sort="{{$ccm_enrol_timestamp}}">{{ $item->formatted_ccm_enrol_date }}</td>
                                            <td>{{ $item->care_manager ? $item->care_manager->user_name : '-' }}</td>
                                            <td data-sort="{{$care_plan_timestamp}}">{{ $item->care_plan ? $item->care_plan->formatted_completed_at : '-'}}</td>
                                            <td data-sort="{{$last_ccm_timestamp}}">{{ $item->formatted_last_ccm_performed}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu slideInUp">
                                                        <a class="dropdown-item"
                                                           href="{{ route('patient.show', ['patient' => $item, 'type' => 'ccm']) }}"><i
                                                                class="ti-eye"></i> Open</a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('patient.edit', $item) }}"><i
                                                                class="ti-pencil-alt"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                     <div class="tab-pane {{$rpm ? 'show active' : ''}}" id="rpm">

                            <div class="row mb-3">
                                <div class="col-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Rpm Record Date" value="{{$from}}" readonly>
                                        <button type="button" class="btn btn-danger">To</button>
                                        <input type="text" class="form-control" placeholder="Rpm Record Date" value="{{$to}}" readonly>
                                        @can('reset_rpm_record')
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rpm_reset_modal">Reset</button>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="button" data-toggle="modal" data-target="#filter_modal" class="btn btn-md btn-success">
                                        <i class="fas fa-filter mr-2"></i>Filters
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive" id="rpm_patient_table_wrapper">

                               <table 
        id="rpm_patient_table" 
        class="table table-striped table-bordered w-100 nowrap" 
        data-url="{{ route('patient.index') }}" 
        data-last-updated="{{ $lastUpdated ?? now()->toISOString() }}">
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

                                    @php
                                        $sr_no = 1;
                                    @endphp
                                    @foreach ($rpm_patients as $item)
                                    
                                        <tr>
                                            @php
                                                $avg_pul = floor($item->patient_data_avg_datapul);
                                                $avg_sys = floor($item->patient_data_avg_datasys);
                                                $avg_dia = floor($item->patient_data_avg_datadia);

                                                $category = get_category($avg_sys, $avg_dia);
                                                $category_order = 1;
                                                if($category == "Stage-1"){
                                                    $category_order = 2;
                                                }
                                                if($category == "Stage-2"){
                                                    $category_order = 3;
                                                }
                                                if($category == "Crisis"){
                                                    $category_order = 4;
                                                }

                                                $status = "Normal";
                                                if($item->last_patient_data){
                                                    $status = $item->last_patient_data->category;
                                                }

                                                $status_order = 1;
                                                if($status == "Stage-1"){
                                                    $status_order = 2;
                                                }
                                                if($status == "Stage-2"){
                                                    $status_order = 3;
                                                }
                                                if($status == "Crisis"){
                                                    $status_order = 4;
                                                }
                                                $current = Carbon\Carbon::now()->timestamp;

                                                $time_taken = Carbon\Carbon::now()->timestamp;
                                                if($item->last_patient_data){
                                                    $time_taken = $current - Carbon\Carbon::parse($item->last_patient_data->date_time)->timestamp;
                                                }
                                                $last_checked = Carbon\Carbon::now()->timestamp;
                                                if($item->last_checked){
                                                    $last_checked = $current - Carbon\Carbon::parse($item->last_checked)->timestamp;
                                                }
                                                $total_seconds = ($item->time_tracks_sum_minutes*60)+$item->time_tracks_sum_seconds;

                                            @endphp
                                            <td>{{ $sr_no++ }}</td>
                                            <td>
                                                <a href="{{ route('patient.show', ['patient' => $item, 'type' => 'rpm']) }}"><strong>{{ $item->first_name }} {{ $item->last_name }}</strong></a>
                                            </td>
                                            <td>
                                                <h5><span class="{{ $category }}">{{ $avg_sys }}/{{ $avg_dia }}</span></h5>
                                            </td>
                                            <td data-sort="{{$category_order}}">
                                                <h5><span class="{{ $category }}">{{ $category }}</span></h5>
                                            </td>
                                            <td>
                                                @if ($item->last_patient_data)
                                                    <span class="{{ $item->last_patient_data->category }}">
                                                            {{ data_get($item->last_patient_data, 'data.sys', '-') }}/{{ data_get($item->last_patient_data, 'data.dia', '-') }}
                                                        </span>
                                                @endif
                                            </td>
                                            <td data-sort="{{$status_order}}">
                                                @if ($item->last_patient_data)
                                                    <h5><span class="{{ $item->last_patient_data->category }}">{{ $item->last_patient_data->category }}</span></h5>
                                                @endif
                                            </td>
                                            <td>{{ $avg_pul }}</td>
                                                                                        <td>
                                                    {{ $item->last_patient_data->data['pul'] ?? '' }}
                                                </td>

                                          <td data-sort="{{ $time_taken }}">
                                                @if ($item->last_patient_data)
                                                    {{ $item->last_patient_data->formatted_date }}
                                                @endif
                                            </td>

                                            <td data-sort="{{$last_checked}}">
                                                {{ $item->formatted_last_checked}}
                                            </td>
                                            <td data-sort="{{$total_seconds}}">
                                                {{ configure_time_track($item->time_tracks_sum_minutes, $item->time_tracks_sum_seconds) }}
                                            </td>
                                            <td>{{ $item->days_with_reading->count() }}</td>
                                            <td>{{ $item->phone_call ? 'Yes' : 'No' }}</td>

                                            <td>{{ $item->covid_status }}</td>
                                            <td>{{ $item->doctor ? $item->doctor->user_name : '-' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu slideInUp">
                                                        <a class="dropdown-item"
                                                           href="{{ route('patient.show', ['patient' => $item, 'type' => 'ccm']) }}"><i
                                                                class="ti-eye"></i> Open</a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('patient.edit', $item) }}"><i
                                                                class="ti-pencil-alt"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="tab-pane {{$unenrolled ? 'show active' : ''}}" id="unenrolled">
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
                                    @php
                                        $sr_no = 1;
                                    @endphp
                                    @foreach ($unenrolled_patients as $item)
                                        <tr>
                                            <td>{{ $sr_no++ }}</td>
                                            <td>
                                                <a href="{{ route('patient.show', ['patient' => $item, 'type' => 'unenrolled_patient']) }}"><strong>{{ $item->first_name }} {{ $item->last_name }}</strong></a>
                                            </td>

                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->contact_no }}</td>
                                            <td style="width: 300px;">{{ $item->address }}</td>
                                            <td style="width: 500px;">
                                                <div style="max-width: 550px; overflow-x: auto; scrollbar-width: thin; scrollbar-color: #888 #f5f5f5; height: 40px;">
                                                    {{ $item->un_enrolled_note }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu slideInUp">
                                                        <button class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('enrol_patient').submit();"><i
                                                                class="ti-eye"></i> Enrol</button>
                                                        <form action="{{ route('patient.enrol', $item) }}"
                                                              method="post" id="enrol_patient">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
                                    <option value="None" {{$select_status_rpm == "None" ? 'selected' : ''}}> --select Category--</option>
                                    <option value="Min-Max" {{$select_category_rpm == "Min-Max" ? 'selected' : ''}}>Min-Max</option>
                                    <option value="Max-Min" {{$select_category_rpm == "Max-Min" ? 'selected' : ''}}>Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Status</label>
                                <select class="form-control" name="select_status_rpm" id="select_status_rpm">
                                    <option value="None" {{$select_status_rpm == "None" ? 'selected' : ''}}> --select Status--</option>
                                    <option value="Min-Max" {{$select_status_rpm == "Min-Max" ? 'selected' : ''}}>Min-Max</option>
                                    <option value="Max-Min" {{$select_status_rpm == "Max-Min" ? 'selected' : ''}}>Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Time Taken</label>
                                <select class="form-control" name="select_time_taken_rpm" id="select_time_taken_rpm">
                                    <option value="None" {{$select_status_rpm == "None" ? 'selected' : ''}}> --Time Taken--</option>
                                    <option value="Min-Max" {{$select_time_taken_rpm == "Min-Max" ? 'selected' : ''}}>Min-Max</option>
                                    <option value="Max-Min" {{$select_time_taken_rpm == "Max-Min" ? 'selected' : ''}}>Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Last Checked</label>
                                <select class="form-control" name="select_last_checked_rpm" id="select_last_checked_rpm">
                                    <option value="None" {{$select_status_rpm == "None" ? 'selected' : ''}}> --Last Checked--</option>
                                    <option value="Min-Max" {{$select_last_checked_rpm == "Min-Max" ? 'selected' : ''}}>Min-Max</option>
                                    <option value="Max-Min" {{$select_last_checked_rpm == "Max-Min" ? 'selected' : ''}}>Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Min This Month</label>
                                <select class="form-control" name="select_minutes_rpm" id="select_minutes_rpm">
                                    <option value="None" {{$select_minutes_rpm == "None" ? 'selected' : ''}}> --Min This Month--</option>
                                    <option value="Min-Max" {{$select_minutes_rpm == "Min-Max" ? 'selected' : ''}}>Min-Max</option>
                                    <option value="Max-Min" {{$select_minutes_rpm == "Max-Min" ? 'selected' : ''}}>Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Days With Reading</label>
                                <select class="form-control" name="select_days_with_reading_rpm" id="select_days_with_reading_rpm">
                                    <option value="None" {{$select_days_with_reading_rpm == "None" ? 'selected' : ''}}> --Days With Reading--</option>
                                    <option value="Min-Max" {{$select_days_with_reading_rpm == "Min-Max" ? 'selected' : ''}}>Min-Max</option>
                                    <option value="Max-Min" {{$select_days_with_reading_rpm == "Max-Min" ? 'selected' : ''}}>Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <form action="{{route('reset.rpm.sort')}}" method="post">
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
                    <form action="{{route('setting.rpm')}}" method="post">
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
    var rpm_table;

    $(document).ready(function () {
   
        rpm_table = $('#rpm_patient_table').DataTable({
            "dom": '<lBf<t>ip>',
            buttons: ['excel', 'print'],
            responsive: true,
            pageLength: 10,
            order: [[8, 'asc']], 
            initComplete: function () {
          
                this.api().columns('14').every(function () {
                    var target = "#select_care_manager_rpm";
                    var column = this;

                    var select = $('<select><option value="">Select Care Manager</option></select>')
                        .appendTo(target)
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                  
                    column.data().unique().sort().each(function (d, j) {
                        var val = extractContent(d);
                        select.append('<option value="' + val + '">' + val + '</option>');
                    });
                });
            }
        });

   
        function extractContent(html) {
            return $('<div>').html(html).text().trim();
        }

      
        setInterval(function () {

            $.ajax({
                url: $('#rpm_patient_table').data('url'),
                type: 'GET',
                success: function (response) {

                    const updatedTable = $(response).find('#rpm_patient_table_wrapper').html();
                    $('#rpm_patient_table_wrapper').html(updatedTable);

                    rpm_table.destroy();
                    rpm_table = $('#rpm_patient_table').DataTable({
                        "dom": '<lBf<t>ip>',
                        buttons: ['excel', 'print'],
                        responsive: true,
                        pageLength: 10,
                        order: [[8, 'asc']], 
                        initComplete: function () {

                            this.api().columns('14').every(function () {
                                var target = "#select_care_manager_rpm";
                                var column = this;

                                var select = $('<select><option value="">Select Care Manager</option></select>')
                                    .appendTo(target)
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                    });

                                column.data().unique().sort().each(function (d, j) {
                                    var val = extractContent(d);
                                    select.append('<option value="' + val + '">' + val + '</option>');
                                });
                            });
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error reloading table:", error);
                }
            });
        }, 600000);
    });
</script>



<script>
    $(document).ready(function () {
        $('#unenrolled_patient_table').DataTable({
            "dom": '<lBf<t>ip>',
            buttons: ['excel', 'print'],
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']] // order by first column (#)
        });
    });
</script>


    <script>
        var ccm_table, rpm_table;
        $(document).ready(function() {
            if (window.location.hash) {
                var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                if (hash === "rpm") {
                    $('#rpm_link').trigger('click');
                } else {
                    $('#ccm_link').trigger('click');

                }
            }
            ccm_table = $('#ccm_patient_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
                pageLength: 10,

                initComplete: function() {
                    this.api().columns('6').every(function() {
                        var target = "#select_care_manager_ccm";
                        var column = this;
                        var select = $('#select_care_manager_ccm')
                            .appendTo(target)
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            var val = extractContent(d);
                            select.append('<option value="' + val + '">' + val + '</option>');
                        });
                    });
                }
            });




            var select_covid_status_ccm = "{{$select_covid_status_ccm}}";
            if(select_covid_status_ccm != "None"){
                filter_select_covid_status_ccm(select_covid_status_ccm);
            }

            var select_gender_ccm = "{{$select_gender_ccm}}";
            if(select_gender_ccm != "None"){
                filter_select_gender_ccm(select_gender_ccm);
            }


            var select_last_ccm_performed = "{{$select_last_ccm_performed}}";
            if(select_last_ccm_performed != "None"){
                filter_select_last_ccm_performed(select_last_ccm_performed);
            }






            var select_category_rpm = "{{$select_category_rpm}}";
            if(select_category_rpm != "None"){
                filter_select_category_rpm(select_category_rpm);
            }

            var select_status_rpm = "{{$select_status_rpm}}";
            if(select_status_rpm != "None"){
                filter_select_status_rpm(select_status_rpm);
            }


            var select_time_taken_rpm = "{{$select_time_taken_rpm}}";
            if(select_time_taken_rpm != "None"){
                filter_select_time_taken_rpm(select_time_taken_rpm);
            }

            var select_last_checked_rpm = "{{$select_last_checked_rpm}}";
            if(select_last_checked_rpm != "None"){
                filter_select_last_checked_rpm(select_last_checked_rpm);
            }

            var select_minutes_rpm = "{{$select_minutes_rpm}}";
            if(select_minutes_rpm != "None"){
                filter_select_minutes_rpm(select_minutes_rpm);
            }

            var select_days_with_reading_rpm = "{{$select_days_with_reading_rpm}}";
            if(select_days_with_reading_rpm != "None"){
                filter_select_days_with_reading_rpm(select_days_with_reading_rpm);
            }

        });
        $('#rpm_patient_table thead').on('click', 'th', function () {
            var key = $(this).attr('data-id');
            if(key){
                var value = "Min-Max";
                if($(this).hasClass('sorting_desc')){
                    value = "Max-Min";
                }
                var type = "rpm";

                sort(key, value, type);
                $('#'+key).val(value);
            }


        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {

            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
        $('#ccm_link').click(function(){
            active_tab('ccm', true);

        });
        $('#rpm_link').click(function(){
            active_tab('rpm', true);

        });
        $('#unenrolled_link').click(function(){
            active_tab('unenrolled', true);

        });


        function active_tab(key, value) {
            $.ajax({
                url: "{{route('custom.sort')}}",
                type: "post",
                data: {
                    key: key,
                    value: value,
                    type: "tab",
                },
                success: function(response){
                }
            });
        }





        function sort(key, value, type){
            $.ajax({
                url: "{{route('custom.sort')}}",
                type: "post",
                data: {
                    key: key,
                    value: value,
                    type: type,
                },
                success: function(response){
                }
            });
        }


        $('#select_last_ccm_performed').on('change', function() {
            var key = "select_last_ccm_performed";
            var value = $(this).val();
            var type = "ccm";
            sort(key, value, type);
            filter_select_last_ccm_performed(value);
        });
        function filter_select_last_ccm_performed(search) {
            var date = new Date();

            var month = date.getMonth()+1;
            var day = date.getDate();

            if(search == "Yesterday"){
                day = day-1;
            }
            if(day < 9){
                day = "0"+day;
            }
            else{
                day = day;
            }



            var today = month+"-"+day;
            var yesterday = month+"-"+day;



            var pattern = "";
            if (search) {
                if(search == "Today"){
                    pattern = today;
                }
                if(search == "Yesterday"){
                    pattern = yesterday;
                }
                if(search == "This-Month"){
                    pattern = month;
                }
                if(search == "Prev-Month"){
                    pattern = month-1;
                }
                ccm_table.column(8)
                    .search(pattern, true, false)
                    .draw();

            } else {

                ccm_table.search('')
                    .columns().search('')
                    .draw();
            }
        }


        $('#select_gender_ccm').on('change', function() {
            var key = "select_gender_ccm";
            var value = $(this).val();
            var type = "ccm";
            sort(key, value, type);
            filter_select_gender_ccm(value);

        });
        function filter_select_gender_ccm(search) {
            if (search) {
                ccm_table.column(3)
                    .search("(^" + search + "$)", true, false)
                    .draw();

            } else {

                ccm_table.search('')
                    .columns().search('')
                    .draw();
            }
        }


        $('#select_covid_status_ccm').on('change', function() {
            var key = "select_covid_status_ccm";
            var value = $(this).val();
            var type = "ccm";
            sort(key, value, type);
            filter_select_covid_status_ccm(value);

        });
        function filter_select_covid_status_ccm(search) {
            if (search) {
                ccm_table.column(2)
                    .search("(^" + search + "$)", true, false)
                    .draw();

            } else {

                ccm_table.search('')
                    .columns().search('')
                    .draw();
            }
        }














        $('#select_category_rpm').change( function () {
            var key = "select_category_rpm";
            var value = $(this).val();
            var type = "rpm";
            sort(key, value, type);
            filter_select_category_rpm(value);

        });
        function filter_select_category_rpm(value){
            switch (value) {
                case "None": // first option chosen, not associated with any column, do some default
                    rpm_table.order([0, 'asc']).draw();
                    break;

                case "Min-Max":
                    rpm_table.order( [3, 'asc'] ).draw();
                    break;
                case "Max-Min":
                    rpm_table.order( [3,'desc'] ).draw();
                    break;
            }
        }


        $('#select_status_rpm').change( function () {
            var key = "select_status_rpm";
            var value = $(this).val();
            var type = "rpm";
            sort(key, value, type);
            filter_select_status_rpm(value);

        });
        function filter_select_status_rpm(value){
            switch (value) {
                case "None": // first option chosen, not associated with any column, do some default
                    rpm_table.order([0, 'asc']).draw();
                    break;

                case "Min-Max":
                    rpm_table.order( [5, 'asc' ] ).draw();
                    break;
                case "Max-Min":
                    rpm_table.order( [5,'desc'] ).draw();
                    break;
            }
        }


        $('#select_time_taken_rpm').change(function() {
            var key = "select_time_taken_rpm";
            var value = $(this).val();
            var type = "rpm";
            sort(key, value, type);
            filter_select_time_taken_rpm(value);
        });
        function filter_select_time_taken_rpm(value){
            switch (value) {
                case "None": // first option chosen, not associated with any column, do some default
                    rpm_table.order([0, 'asc']).draw();
                    break;

                case "Min-Max":
                    rpm_table.order( [8, 'asc' ] ).draw();
                    break;
                case "Max-Min":
                    rpm_table.order( [8, 'desc'] ).draw();
                    break;
            }
        }


        $('#select_last_checked_rpm').change(function() {
            var key = "select_last_checked_rpm";
            var value = $(this).val();
            var type = "rpm";
            sort(key, value, type);
            filter_select_last_checked_rpm(value);
        });
        function filter_select_last_checked_rpm(value){
            switch (value) {
                case "None": // first option chosen, not associated with any column, do some default
                    rpm_table.order([0, 'asc']).draw();
                    break;

                case "Min-Max":
                    rpm_table.order( [9, 'asc' ] ).draw();
                    break;
                case "Max-Min":
                    rpm_table.order( [9, 'desc'] ).draw();
                    break;
            }
        }


        $('#select_minutes_rpm').change(function() {
            var key = "select_minutes_rpm";
            var value = $(this).val();
            var type = "rpm";
            sort(key, value, type);
            filter_select_minutes_rpm(value);
        });
        function filter_select_minutes_rpm(value){
            switch (value) {
                case "None": // first option chosen, not associated with any column, do some default
                    rpm_table.order([0, 'asc']).draw();
                    break;

                case "Min-Max":
                    rpm_table.order( [10, 'asc' ] ).draw();
                    break;
                case "Max-Min":
                    rpm_table.order( [10, 'desc'] ).draw();
                    break;
            }
        }


        $('#select_days_with_reading_rpm').change(function() {
            var key = "select_days_with_reading_rpm";
            var value = $(this).val();
            var type = "rpm";
            sort(key, value, type);
            filter_select_days_with_reading_rpm(value);
        });
        function filter_select_days_with_reading_rpm(value){
            switch (value) {
                case "None": // first option chosen, not associated with any column, do some default
                    rpm_table.order([0, 'asc']).draw();
                    break;

                case "Min-Max":
                    rpm_table.order( [11, 'asc' ] ).draw();
                    break;
                case "Max-Min":
                    rpm_table.order( [11, 'desc'] ).draw();
                    break;
            }
        }
        

        
        
        
    </script>
@endsection
