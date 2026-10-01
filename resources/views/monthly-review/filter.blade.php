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
                        <table id="monthly_review_table" class="table table-striped text-theme w-100">
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
                                @foreach ($monthly_reviews as $item)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>
                                            <a href="{{ route('patient.show', ['patient' => $item, 'type' => 'ccm']) }}"><strong>{{ $item->first_name }}
                                                    {{ $item->last_name }}</strong></a>
                                        </td>
                                        <td>{{ $item->contact_no }}</td>
                                        <td>
                                            @if ($item->monthly_review)
                                                {{ $item->monthly_review->reference_no }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->monthly_review)
                                                <strong>{{ $item->monthly_review->minutes }}:{{ $item->monthly_review->seconds }}
                                                    min</strong>
                                            @endif

                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">
                                                    @if ($item->monthly_review)
                                                        <a class="dropdown-item"
                                                            href="{{ route('monthly-review.time-track.index', $item->monthly_review) }}">Add
                                                            Time</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('monthly-review.show', $item->monthly_review) }}">Show
                                                            Monthly Review</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('monthly-review.edit', $item->monthly_review) }}">Edit
                                                            Monthly Review</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ route('monthly-review.create', $item) }}">Create
                                                            Monthly Review</a>
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

            $('#monthly_review_table').DataTable({
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
