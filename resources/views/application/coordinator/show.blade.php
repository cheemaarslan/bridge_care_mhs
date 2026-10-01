@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-success mb-0">{{ env('APP_NAME') }}</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('coordinator-application.index') }}">Coordination
                        Application</a></li>
                <li class="breadcrumb-item active">{{ $coordinator_application->first_name }}
                    {{ $coordinator_application->last_name }}</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="mt-4">
                        <img src="{{ $coordinator_application->user_image }}" class="rounded-circle" width="150" />
                        <h6 class="card-subtitle mt-3">{{ $coordinator_application->email }}</h6>
                        <h4 class="card-title mt-2">{{ $coordinator_application->first_name }}
                            {{ $coordinator_application->last_name }}</h4>
                    </center>
                </div>
                {{-- {{route('coordinator-application.destroy', $coordinator_application)}} --}}
                <div class="card-body">
                    <div class="btn-list text-center">
                        <form action="{{ route('coordinator-application.destroy', $coordinator_application) }}"
                            method="post">
                            @csrf
                            <a class="btn btn-sm btn-rounded mr-1 btn-outline-success"
                                href="{{ route('coordinator-application.edit', $coordinator_application) }}"><i
                                    class="ti-pencil-alt mr-2"></i>
                                Edit
                            </a>
                            @method('delete')
                            <button class="btn btn-sm btn-rounded btn-outline-danger" type="submit">Delete
                                <i class="ti-trash mr-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-9 col-xlg-9 col-md-7">
            <div class="card">
                <!-- Tabs -->
                <ul class="nav nav-tabs nav-bordered mb-3 customtab" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month"
                            role="tab" aria-controls="pills-timeline" aria-selected="true">My Logs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab"
                            aria-controls="pills-profile" aria-selected="false">All Logs</a>
                    </li>
                </ul>
                <!-- Tabs -->
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="current-month" role="tabpanel"
                        aria-labelledby="pills-timeline-tab">
                        <div class="table-responsive">
                            <div class="card-body">
                                <table id="all_logs_table" class="table table-striped text-theme w-100">
                                    <thead>
                                        <tr>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Engagement Date</th>
                                            <th>Time Spent</th>
                                            <th>Practice</th>
                                            <th>Engagement Type</th>
                                            <th>Enrol Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>12:00:AM</td>
                                            <td>09:00:PM</td>
                                            <td>
                                                01-04-2022
                                            </td>
                                            <td>18.00</td>
                                            <td>
                                                Care Manager
                                            </td>
                                            <td>Phone Call With Patient</td>
                                            <td>
                                                10-09-2002
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12:00:AM</td>
                                            <td>09:00:PM</td>
                                            <td>
                                                01-04-2022
                                            </td>
                                            <td>18.00</td>
                                            <td>
                                                Care Manager
                                            </td>
                                            <td>Phone Call With Patient</td>
                                            <td>
                                                10-09-2002
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12:00:AM</td>
                                            <td>09:00:PM</td>
                                            <td>
                                                01-04-2022
                                            </td>
                                            <td>18.00</td>
                                            <td>
                                                Care Manager
                                            </td>
                                            <td>Phone Call With Patient</td>
                                            <td>
                                                10-09-2002
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="table-responsive">
                            <div class="card-body">
                                <table id="my_logs_table" class="table table-striped text-theme w-100">
                                    <thead>
                                        <tr>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Engagement Date</th>
                                            <th>Time Spent</th>
                                            <th>Practice</th>
                                            <th>Engagement Type</th>
                                            <th>Enrol Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>12:00:AM</td>
                                            <td>09:00:PM</td>
                                            <td>
                                                01-04-2022
                                            </td>
                                            <td>18.00</td>
                                            <td>
                                                Care Manager
                                            </td>
                                            <td>Phone Call With Patient</td>
                                            <td>
                                                10-09-2002
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12:00:AM</td>
                                            <td>09:00:PM</td>
                                            <td>
                                                01-04-2022
                                            </td>
                                            <td>18.00</td>
                                            <td>
                                                Care Manager
                                            </td>
                                            <td>Phone Call With Patient</td>
                                            <td>
                                                10-09-2002
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12:00:AM</td>
                                            <td>09:00:PM</td>
                                            <td>
                                                01-04-2022
                                            </td>
                                            <td>18.00</td>
                                            <td>
                                                Care Manager
                                            </td>
                                            <td>Phone Call With Patient</td>
                                            <td>
                                                10-09-2002
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#all_logs_table').DataTable({
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
                pageLength: 100
            });

            $('#my_logs_table').DataTable({
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
                pageLength: 100
            });
        });
    </script>
@endsection
