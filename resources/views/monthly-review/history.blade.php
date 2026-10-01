@extends('master.app')
@section('css')
<link rel="stylesheet" href="{{asset('datatable/datatables.min.css')}}">

@endsection
@section('breadcrum')
<ol class="breadcrumb p-4">
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('patient.show', ['patient' => $patient, 'type' => 'ccm']) }}" class="inactive">{{$patient->first_name}} {{$patient->last_name}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="active">History</a>
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
                                    <th>Date</th>
                                    <th>Reference No</th>
                                    <th>Status</th>
                                    <th>Active</th>
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
                                        <td>{{ $item->formatted_completed_at }}</td>
                                        <td>{{ $item->reference_no }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td><span class="badge {{$item->active ? 'badge-success' : 'badge-danger'}}">{{$item->active ? 'Yes' : 'No '}}</span></td>

                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">
                                                    <a class="dropdown-item" href="{{route('monthly-review.show', $item)}}"><i
                                                            class="ti-pencil-alt"></i> Show Monthly Review</a>
                                                    <a class="dropdown-item" href="{{route('monthly-review.edit', $item)}}"><i
                                                            class="ti-pencil-alt"></i> Edit Monthly Review</a>

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
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function(){

            $('#monthly_review_table').DataTable( {
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                paging: true,
                searching: true,
                autoWidth: true,
                lengthChange: true,
                columnDefs: [
                    {
                        orderable: true,
                        targets: '_all'
                    }
                ],
                pageLength: 100
            });

        });
    </script>

@endsection
