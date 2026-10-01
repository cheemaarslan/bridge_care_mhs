@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
@endsection
@section('breadcrum')
<ol class="breadcrumb p-4">
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">Filter</a>
    </li>
</ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="care_plan_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Contact No</th>
                                    <th>Reference No</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($care_plans as $item)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>
                                            <a href="{{ route('patient.show', ['patient' => $item, 'type' => 'ccm']) }}"><strong>{{ $item->first_name }}
                                                    {{ $item->last_name }}</strong></a>
                                        </td>
                                        <td>{{ $item->contact_no }}</td>
                                        <td>
                                            @if ($item->care_plan)
                                                {{ $item->care_plan->reference_no }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->care_plan)
                                                <strong>{{ $item->care_plan->minutes }}:{{ $item->care_plan->seconds }}
                                                    min</strong>
                                            @endif

                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">
                                                    @if ($item->care_plan)
                                                        <a class="dropdown-item"
                                                            href="{{ route('care-plan.time-track.index', $item->care_plan) }}">Add
                                                            Time</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('care-plan.show', $item->care_plan) }}">Show
                                                            Care Plan</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('care-plan.edit', $item->care_plan) }}">Edit
                                                            Care Plan</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ route('care-plan.create', $item) }}">Create Care
                                                            Plan</a>
                                                    @endif
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

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#care_plan_table').DataTable({
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
