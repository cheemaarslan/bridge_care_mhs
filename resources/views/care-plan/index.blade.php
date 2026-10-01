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
            <a href="#" class="inactive">Care Plan</a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="#ccm" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Awaiting Approval</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#rpm" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Apporoved</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="ccm">
                            <table id="awaiting_approval_table" class="table table-striped text-theme w-100 display nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;">Patient Name</th>
                                        <th style="width: 170px;">Reference No</th>
                                        <th style="width: 145px;">Created At</th>
                                        <th style="width: 160px;">Status</th>
                                        <th style="width: 550px;">Comment</th>
                                        <th style="width: 90px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($awaiting_approval as $item)
                                        @if ($item->patient)
                                            <tr>
                                                <td style="width: 200px;">
                                                    <a
                                                        href="{{ route('patient.show', ['patient' => $item->patient, 'type' => 'ccm']) }}">
                                                        <strong>{{ $item->patient->first_name }}
                                                            {{ $item->patient->last_name }}</strong>
                                                    </a>
                                                </td>
                                                <td style="width: 170px;">{{ $item->reference_no }}</td>
                                                <td style="width: 145px;">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                                <td style="width: 85px;"><span
                                                        class="badge badge-success">{{ $item->status }}</span></td>
                                                        <td style="width: 400px;">
                                                            <div style="max-width: 550px; overflow-x: auto; scrollbar-width: thin; scrollbar-color: #888 #f5f5f5; height: 40px;">
                                                                {{ $item->care_plan_comment }}
                                                            </div>
                                                        </td>
                                                        

                                                <td style="width: 90px;">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu slideInUp">
                                                            <a class="dropdown-item"
                                                                href="{{ route('care-plan.show', $item) }}">
                                                                <i class="ti-eye mr-2"></i>Show
                                                            </a>
                                                              <button class="dropdown-item"
                                                                   onclick="submitApproveForm('{{ $item->id }}')">
                                                                    <i class="ti-check mr-2"></i> Approve
                                                                </button>
                                                                <form id="approve_form_{{ $item->id }}"
                                                                    action="{{ route('care-plan.approve') }}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    <input type="hidden" name="care_plan_id" value="{{ $item->id }}">
                                                                    <input type="hidden" name="patient_id" value="{{ $item->patient->id }}">
                                                                </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane" id="rpm">
                            <table id="approved_table" class="table table-striped text-theme w-100 display nowrap">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Care Plan ID</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approved as $item)
                                        @if ($item->patient)
                                            <tr>
                                                <td>
                                                    <a href="#"><strong>{{ $item->patient->first_name }}
                                                            {{ $item->patient->last_name }}</strong></a>
                                                </td>
                                                <td>{{ $item->reference_no }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                                                <td><span class="badge badge-success">{{ $item->status }}</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu slideInUp">
                                                            <a class="dropdown-item"
                                                                href="{{ route('care-plan.show', $item) }}"><i
                                                                    class="ti-eye mr-2"></i>Show</a>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        var awaiting_approval_table, approved_table;
        $(document).ready(function() {

            awaiting_approval_table = $('#awaiting_approval_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                paging: true,
                processing: true,
                searching: true,
                autoWidth: true,
                lengthChange: true,
                columnDefs: [{
                    orderable: true,
                    targets: '_all'
                }],
                pageLength: 100
            });

            approved_table = $('#approved_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                paging: true,
                processing: true,
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
    <script>
    function submitApproveForm(id) {
        document.getElementById('approve_form_' + id).submit();
    }
</script>
@endsection
