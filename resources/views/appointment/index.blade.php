@extends('master.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="{{ asset('calendar/lib/main.css') }}" rel="stylesheet" type="text/css" />
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
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success">
                    <div class="row">
                        <div class="col-lg-7 d-none d-lg-block">
                            <h4 class="text-white">Appointments</h4>
                        </div>
                        <div class="col-lg-2 col-12 mt-lg-0 mt-2 px-0">
                            <select id="filter_doctor_id" class="w-100 select2 form-control">
                                <option value=""></option>
                                @foreach ($doctors as $item)
                                    <option value="{{ $item->id }}">{{ $item->user_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-12 mt-lg-0 mt-2 px-0 px-lg-2">
                            <select id="filter_patient_id" class="w-100 select2 form-control">
                                <option value=""></option>
                                @foreach ($patients as $item)
                                    <option value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-1 col-12 px-0">
                            <button class="mt-lg-0 mt-2 btn btn-danger mx-1" id="filter_btn"><i class="fa fa-filter"
                                    aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- end col-->
                        <div class="col-12">
                            <div id="calendar"></div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
        <!-- end col-12 -->
        <div class="col-12 my-3">

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="#all_appointment_tab" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">All Appointments</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#today_appointment_tab" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Today's Appointments</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="all_appointment_tab">
                            <div class="table-responsive">
                                <table id="all_appointment_table" class="table table-striped text-theme w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sr_no = 1;
                                        @endphp
                                        @foreach ($appointments as $item)
                                            <tr>
                                                <td>{{ $sr_no++ }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->start_date }}</td>
                                                <td>{{ $item->end_date }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($item->description, 20, '...') }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu slideInUp">
                                                            <button type="button" class="dropdown-item"
                                                                onclick="open_edit_modal({{ $item->id }})"><i
                                                                    class="ti-eye"></i> Edit</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="today_appointment_tab">
                            <div class="table-responsive">
                                <table id="today_appointment_table" class="table table-striped text-theme w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sr_no = 1;
                                        @endphp
                                        @foreach ($today_appointments as $item)
                                            <tr>
                                                <td>{{ $sr_no++ }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->start_date }}</td>
                                                <td>{{ $item->end_date }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($item->description, 20, '...') }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="ti-settings"></i>
                                                            </button>
                                                            <div class="dropdown-menu slideInUp">
                                                                <button type="button" class="dropdown-item"
                                                                    onclick="open_edit_modal({{ $item->id }})"><i
                                                                        class="ti-eye"></i> Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div> <!-- end .table-responsive-->
                        </div>
                    </div>
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('modal')
    <!-- Add New Appointmetn MODAL -->
    <div class="modal fade" id="appointment_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-3 px-4 border-bottom-0 d-block">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="modal-title">Add New Appointment</h5>
                </div>
                <div class="modal-body p-4">
                    <form id="appointment_form" action="{{ route('appointment.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input class="form-control " placeholder="Insert Title" type="text"
                                        name="title" id="title" required />
                                    @error('title')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label for="patient_id">Patient Name:</label>
                                    <select class="select2 form-control " name="patient_id" id="patient_id2"
                                        style="width: 100%; height:30px;" required>
                                        @foreach ($patients as $item)
                                            <option value="{{ $item->id }}">{{ $item->first_name }}
                                                {{ $item->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label for="doctor_id">Doctor Name: </label>
                                    <select class="select2 form-control " name="doctor_id" id="doctor_id2"
                                        style="width: 100%; height:30px;" required>
                                        @foreach ($doctors as $item)
                                            <option value="{{ $item->id }}">{{ $item->user_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 ">
                                <div class="form-group">
                                    <label class="control-label">Start Date:</label>
                                    <input type="date" class="form-control " placeholder="Event Date"
                                        name="start_date" id="start_date" required />
                                    @error('start_date')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 ">
                                <div class="form-group">
                                    <label class="control-label">End Date:</label>
                                    <input type="date" class="form-control " placeholder="Event Date" name="end_date"
                                        id="end_date" required />
                                    @error('end_date')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 ">
                                <div class="form-group">
                                    <label class="control-label">Start Time:</label>
                                    <input class="form-control " placeholder="Event End Time" type="time"
                                        name="start_time" id="start_time" required />
                                    @error('start_time')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label class="control-label">End Time:</label>
                                    <input class="form-control " placeholder="Enter End Time" type="time"
                                        name="end_time" id="end_time" required>
                                    @error('end_time')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-12">
                                <h6>Recurring Appointment: <span class="badge badge-info" data-toggle="tooltip"
                                        data-placement="top"
                                        title="Appointment will repeat after desired number of days/weeks/months or years, or you can stop it after desired number of cycles">?</span>
                                </h6>
                                <input type="checkbox" id="is_recurring" class="material-inputs chk-col-pink"
                                    name="is_recurring">
                                <label for="is_recurring">Is Recurring</label>
                            </div>



                        </div>
                        <div class="row mt-2 d-none" id="recurring_section">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="">Repeat After</label><br>
                                    <input type="number" name="repeat_after" id="repeat_after" class="form-control"
                                        placeholder="Repeat After..">
                                    @error('repeat_after')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="">Option</label>
                                    <select name="repeat_option" id="repeat_option" class="form-control ">
                                        <option value="Days">Days</option>
                                        <option value="Week">Week</option>
                                        <option value="Month">Month</option>
                                        <option value="Year">Year</option>
                                    </select>
                                    @error('repeat_option')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="">Cycle</label><br>
                                    <input type="number" name="cycles" id="cycles" class="form-control "
                                        placeholder="cycle">
                                    @error('cycles')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                                    @error('description')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="category">Select Category</label>
                                    <br>
                                    <div class="list-item">
                                        <button type="button" class="category btn btn-md p-3 btn-primary mr-2"
                                            data-val="bg-primary"></button>
                                        <button type="button" class="category btn btn-md p-3 btn-secondary mr-2"
                                            data-val="bg-secondary"></button>
                                        <button type="button" class="category btn btn-md p-3 btn-success mr-2"
                                            data-val="bg-success"></button>
                                        <button type="button" class="category btn btn-md p-3 btn-danger mr-2"
                                            data-val="bg-danger"></button>
                                        <button type="button" class="category btn btn-md p-3 btn-info mr-2"
                                            data-val="bg-info"> </button>
                                        <button type="button" class="category btn btn-md p-3 btn-light mr-2"
                                            data-val="bg-light"></button>
                                        <button type="button" class="category btn btn-md p-3 btn-dark mr-2"
                                            data-val="bg-dark"></button>
                                    </div>
                                    <input type="text" class="d-none" name="category" id="category" value="">
                                    @error('category')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-danger mr-1" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal-content-->
        </div> <!-- end modal dialog-->
    </div>
    <!-- end modal-->

    <!-- Edit Appointment MODAL -->
    <div class="modal fade" id="edit_appointment_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-3 px-4 border-bottom-0 d-block">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="modal-title">Add New Appointment</h5>
                </div>
                <div class="modal-body p-4">
                    <form id="edit_appointment_form" action="" method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input class="form-control " placeholder="Insert Title" type="text"
                                        name="title" id="edit_title" required />
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label for="patient_id">Patient Name:</label>
                                    <select class="select2 form-control " name="patient_id" id="edit_patient_id"
                                        style="width: 100%; height:30px;" required>
                                        @foreach ($patients as $item)
                                            <option value="{{ $item->id }}">{{ $item->first_name }}
                                                {{ $item->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label for="doctor_id">Doctor Name: </label>
                                    <select class="select2 form-control " name="doctor_id" id="edit_doctor_id"
                                        style="width: 100%; height:30px;" required>
                                        @foreach ($doctors as $item)
                                            <option value="{{ $item->id }}">{{ $item->user_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 ">
                                <div class="form-group">
                                    <label class="control-label">Start Date:</label>
                                    <input type="date" class="form-control " placeholder="Event Date"
                                        name="start_date" id="edit_start_date" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 ">
                                <div class="form-group">
                                    <label class="control-label">End Date:</label>
                                    <input type="date" class="form-control " placeholder="Event Date" name="end_date"
                                        id="edit_end_date" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 ">
                                <div class="form-group">
                                    <label class="control-label">Start Time:</label>
                                    <input class="form-control " placeholder="Event End Time" type="time"
                                        name="start_time" id="edit_start_time" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label class="control-label">End Time:</label>
                                    <input class="form-control " placeholder="Enter End Time" type="time"
                                        name="end_time" id="edit_end_time" required>

                                </div>
                            </div>

                            <div class="col-12">
                                <h6>Recurring Appointment: <span class="badge badge-info" data-toggle="tooltip"
                                        data-placement="top"
                                        title="Appointment will repeat after desired number of days/weeks/months or years, or you can stop it after desired number of cycles">?</span>
                                </h6>
                                <input type="checkbox" id="edit_is_recurring" class="material-inputs chk-col-pink"
                                    name="is_recurring">
                                <label for="is_recurring">Is Recurring</label>
                            </div>



                        </div>
                        <div class="row mt-2 d-none" id="recurring_section">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="">Repeat After</label><br>
                                    <input type="number" name="repeat_after" id="edit_repeat_after"
                                        class="form-control" placeholder="Repeat After..">
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="">Option</label>
                                    <select name="repeat_option" id="edit_repeat_option" class="form-control ">
                                        <option value="Days">Days</option>
                                        <option value="Week">Week</option>
                                        <option value="Month">Month</option>
                                        <option value="Year">Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="">Cycle</label><br>
                                    <input type="number" name="cycles" id="edit_cycles" class="form-control "
                                        placeholder="cycle">

                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea class="form-control" name="description" id="edit_description" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="category">Select Category</label>
                                    <br>
                                    <div class="list-item">
                                        <button type="button" class="edit_category btn btn-md p-3 btn-primary mr-2"
                                            data-val="bg-primary"></button>
                                        <button type="button" class="edit_category btn btn-md p-3 btn-secondary mr-2"
                                            data-val="bg-secondary"></button>
                                        <button type="button" class="edit_category btn btn-md p-3 btn-success mr-2"
                                            data-val="bg-success"></button>
                                        <button type="button" class="edit_category btn btn-md p-3 btn-danger mr-2"
                                            data-val="bg-danger"></button>
                                        <button type="button" class="edit_category btn btn-md p-3 btn-info mr-2"
                                            data-val="bg-info"> </button>
                                        <button type="button" class="edit_category btn btn-md p-3 btn-light mr-2"
                                            data-val="bg-light"></button>
                                        <button type="button" class="edit_category btn btn-md p-3 btn-dark mr-2"
                                            data-val="bg-dark"></button>
                                    </div>
                                    <input type="text" class="d-none" name="category" id="edit_category"
                                        value="">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-danger mr-1"
                                    onclick="event.preventDefault();
                                document.getElementById('delete_appointment').submit();">Delete</button>

                                <button type="submit" class="btn btn-success" id="edit_appointment_btn">Save</button>
                            </div>
                        </div>
                    </form>
                    <form action="" method="post" id="delete_appointment">
                        @method('delete')
                        @csrf
                    </form>
                </div>
            </div> <!-- end modal-content-->
        </div> <!-- end modal dialog-->
    </div>
    <!-- end modal-->
@endsection
@section('script')
    {{-- <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script> --}}

    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('calendar/lib/main.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.5.0/main.global.min.js'></script> --}}
    <!-- Page js-->
    <script>
        var all_appointment_table, today_appointment_table;
        $('#start_date').flatpickr({
            dateFormat: "m-d-Y"
        });
        $('#end_date').flatpickr({
            dateFormat: "m-d-Y"
        });

        $('#edit_start_date').flatpickr({
            dateFormat: "m-d-Y"
        });
        $('#edit_end_date').flatpickr({
            dateFormat: "m-d-Y"
        });


        $(document).ready(function() {
            all_appointment_table = $('#all_appointment_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                paging: true,
                searching: true,
                autoWidth: true,
                lengthChange: true,
                columnDefs: [{
                    orderable: true,
                    targets: '_all'
                }],

            });
            today_appointment_table = $('#today_appointment_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                paging: true,
                searching: true,
                autoWidth: true,
                lengthChange: true,
                columnDefs: [{
                    orderable: true,
                    targets: '_all'
                }],

            });

            $('#patient_id').select2({
                placeholder: "Select Doctor",
            });

            $('#doctor_id').select2({
                placeholder: "Select Patient",
            });
            $('#filter_patient_id').select2({
                placeholder: "Select Patient",
            });

            $('#filter_doctor_id').select2({
                placeholder: "Select Doctor",
            });

            $('#edit_patient_id').select2({
                placeholder: "Select Patient",
            });

            $('#edit_doctor_id').select2({
                placeholder: "Select Patient",
            });

            $('#patient_id2').select2({
                placeholder: "Select Doctor",
            });

            $('#doctor_id2').select2({
                placeholder: "Select Patient",
            });

        });

        $(document).on('click', '.category', function() {
            $(".category").removeClass("btn-rounded"); // remove active class from all
            var categroy = $(this).attr('data-val');
            $(this).addClass('btn-rounded');
            $('#category').val(categroy);
        });

        $(document).on('click', '.edit_category', function() {
            $(".edit_category").removeClass("btn-rounded"); // remove active class from all
            var categroy = $(this).attr('data-val');
            $(this).addClass('btn-rounded');
            $('#edit_category').val(categroy);
        });

        var calendar;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap',
                timeZone: 'UTC',
                editable: true,
                selectable: true,
                dayMaxEventRows: true, // for all non-TimeGrid views
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: [
                    @foreach ($appointments as $item)
                        {
                            id: '{{ $item->id }}',
                            title: '{{ $item->title }}',
                            start: '{{ $item->start }}',
                            end: '{{ $item->end }}',
                            className: '{{ $item->category }}'
                        },
                    @endforeach
                ],

                select: function(info) {
                    // alert('selected ' + info.startStr + ' to ' + info.endStr);

                    var start = info.start.toISOString();
                    var end = info.end.toISOString();
                    var all_day = info.allDay;
                    var date = info.startStr;
                    var full_date = date.split('-', 3);
                    var year = full_date[0];
                    var month = full_date[1];
                    var day = full_date[2];
                    var date = month + '-' + day + '-' + year;
                    var start_time = '';
                    var end_time = '';
                    var h1, h2, m1, m2;





                    if (all_day) {
                        all_day = 1;
                        var d1 = new Date();
                        h1 = d1.getHours();
                        m1 = d1.getMinutes();
                        if (h1 < 10) h1 = '0' + h1;
                        if (m1 < 10) m1 = '0' + m1;
                        var d2 = AddMinutesToDate(d1, 30);
                        h2 = d2.getHours(),
                            m2 = d2.getMinutes();
                        if (h2 < 10) h2 = '0' + h2;
                        if (m2 < 10) m2 = '0' + m2;

                    } else {

                        all_day = 0;

                        var full_date_array = date.split('T', 2);
                        var date = full_date_array[0];
                        var time_split = full_date_array[1];
                        var time = time_split.split('.', 2);
                        h1 = time[0].split(':', 3)[0];
                        m1 = time[0].split(':', 3)[1];


                        h2 = h1;
                        m2 = m1;
                    }

                    $('#start_date').val(date);
                    $('#end_date').val(date);
                    $('#start_time').attr({
                        'value': h1 + ':' + m1
                    });
                    $('#end_time').attr({
                        'value': h2 + ':' + m2
                    });



                    $('#appointment_modal').modal();
                },

                eventClick: function(info) {
                    open_edit_modal(info.event.id);



                },

            });

            calendar.render();
        });

        function AddMinutesToDate(date, minutes) {
            return new Date(date.getTime() + minutes * 60000);
        }

        function open_edit_modal(id) {
            var url = "{{ route('appointment.edit', ':id') }}";
            url = url.replace(':id', id);

            var update_url = "{{ route('appointment.update', ':id') }}";
            update_url = update_url.replace(':id', id);

            var delet_url = "{{ route('appointment.destroy', ':id') }}";
            delet_url = delet_url.replace(':id', id);

            $('#delete_appointment').attr('action', delet_url);

            $('#edit_appointment_form').attr('action', update_url);
            $('#edit_id').val(id);


            $.ajax({
                url: url,
                type: "get",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#edit_appointment_modal').modal();

                    $('#edit_title').val(response.title);
                    $('#edit_patient_id').val(response.patient_id);
                    $('#edit_doctor_id').val(response.doctor_id);
                    $('#edit_category').val(response.category);

                    $('#edit_start_date').val(response.start_date);
                    $('#edit_end_date').val(response.end_date);
                    $('#edit_start_time').val(response.start_time);
                    $('#edit_end_time').val(response.end_time);

                    $('#edit_description').val(response.description);
                    $(".edit_category").removeClass("btn-rounded"); // remove active class from all

                    $('.edit_category').each(function(i, obj) {
                        if ($(obj).attr('data-val') === response.category) {
                            $(obj).addClass('btn-rounded');
                        }
                    });
                },
                error: function() {
                    console.log('something went wrong');
                }
            });

        }

        $('#is_recurring').on('click', function() {
            if ($(this).is(':checked')) {
                $('#recurring_section').removeClass('d-none');
                $('#recurring_btn').prop('disabled', false);
            } else {
                $('#recurring_section').addClass('d-none');
                $('#recurring_btn').prop('disabled', true);

            }
        });

        $('#recurring_type_option').on('change', function() {
            if ($(this).val() == "weekly") {
                $('#week_section').removeClass('d-none');
                $('#month_section').addClass('d-none');

            } else {
                $('#month_section').removeClass('d-none');
                $('#week_section').addClass('d-none');
                $('#custom_range').addClass('d-none');

            }
        });
        $('#weekly_duration').on('change', function() {
            if ($(this).val() == "custom") {
                $('#custom_range').removeClass('d-none');

            } else {
                $('#custom_range').addClass('d-none');

            }
        });


        $('#filter_btn').click(function() {
            var patient_id = $('#filter_patient_id').val();
            var doctor_id = $('#filter_doctor_id').val();
            calendar.removeAllEvents();

            $.ajax({
                url: "{{ route('filter_appointment') }}",
                type: "post",
                data: {
                    patient_id: patient_id,
                    doctor_id: doctor_id
                },
                success: function(response) {
                    filter_table(response);
                    calendar.setOption('selectable', true);
                    if (response.appointments.length > 0) {

                        var data = [];
                        $.each(response.appointments, function(index, value) {
                            data.push({
                                id: value.id,
                                title: value.title,
                                start: value.start,
                                end: value.end,
                                className: value.category
                            });



                        });
                        $.each(response.today_appointments, function(index, value) {
                            var html = '<div class="external-event ' + value.category
                                .class_name + '" data-class="' + value.category.class_name +
                                '">' + value.title +
                                '<span style="font-size:11px;" class="float-right text-white font-weight-normal">' +
                                value.start_time + '</span>' +
                                '</div>';
                            $('#today_appointment').removeClass('d-none');
                            $('#today_appointment').append(html);
                        });
                        calendar.addEventSource(data);
                    }
                },
                error: function() {
                    console.log('something went wrong');
                }
            });
        });



        function filter_table(response) {
            var table_body = $('#all_appointment_table tbody');
            var table_body2 = $('#today_appointment_table tbody');
            if (response) {
                all_appointment_table.clear().draw();

                if (response.appointments.length > 0) {
                    table_body.empty();
                    var sr_no = 1;
                    $.each(response.appointments, function(index, value) {
                        var edit_url = "{{ route('appointment.edit', ':id') }}";
                        edit_url = edit_url.replace(':id', value.id);
                        var delete_url = "{{ route('patient.destroy', ':id') }}";
                        delete_url = delete_url.replace(':id', value.id);

                        var row = all_appointment_table.row.add([
                            sr_no,
                            value.title,
                            value.start_date,
                            value.end_date,
                            value.description,
                            '<div class="btn-group">' +
                            '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="ti-settings"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu slideInUp">' +
                            '<button type="button" class="dropdown-item" onclick="open_edit_modal(' + value
                            .id + ')"><i class="ti-eye"></i> Edit</a>' +
                            '</div>' +
                            '</div>'

                        ]).draw();
                        sr_no++;


                    });


                }

                if (response.today_appointments.length > 0) {
                    table_body2.empty();
                    var sr_no = 1;
                    $.each(response.today_appointments, function(index, value) {
                        var edit_url = "{{ route('appointment.edit', ':id') }}";
                        edit_url = edit_url.replace(':id', value.id);
                        var delete_url = "{{ route('patient.destroy', ':id') }}";
                        delete_url = delete_url.replace(':id', value.id);

                        var row = today_appointment_table.row.add([
                            sr_no,
                            value.title,
                            value.start_date,
                            value.end_date,
                            value.description,
                            '<div class="btn-group">' +
                            '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="ti-settings"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu slideInUp">' +
                            '<button type="button" class="dropdown-item" onclick="open_edit_modal(' + value
                            .id + ')"><i class="ti-eye"></i> Edit</a>' +
                            '</div>' +
                            '</div>'

                        ]).draw();
                        sr_no++;


                    });


                }

            }
        }
    </script>
@endsection
