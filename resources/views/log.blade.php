@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
    <style>
                .custom-badge {
    padding: 0.5em 1em;
    border-radius: 12px;
    color: #fff;
    font-size: 12px;
    margin-left: 25px;

}

.patients-count {
    background-color: ##1d6c9d !important; /* Green */
}
    </style>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>Activity Logs</h4>
                        </div>
                    </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="provider_table" class="table table-striped text-theme w-100">

                                <thead>
                                    <tr>
                                        <th>ID</th>

                                        <th>Performed By</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $sr_no = 1;
                                @endphp
                                    @foreach ($activityLogs as $log)
                                        <tr>
                                            <td>{{ $sr_no++ }}</td>

                                            <td>{{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : '' }}</td>
                                            <td>{{ $log->subject }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
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

            $('#provider_table').DataTable( {
                "dom": '<lBf<t>ip>',
                    buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    }
                ],
            });

        });
    </script>

@endsection
