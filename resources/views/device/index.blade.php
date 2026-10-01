@extends('master.app')
@section('css')
<link rel="stylesheet" href="{{asset('datatable/datatables.min.css')}}">

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
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="ml-3">
                            <button class="btn btn-danger">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-lg-2 col-12">

                            <select class="form-control" name="select_available_device" id="select_available_device"
                                    style="width: 200px;">
                                <option value=""> --Available Devices--</option>
                                <option value="Available">Available</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="device_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Serial Number</th>
                                    <th>IMEI Number</th>
                                    <th>Patient Name</th>
                                    <th>Install Date</th>
                                    <th>Setup Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($devices as $item)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>{{ $item->device_serial_no }}</td>
                                        <td>{{ $item->device_imei_no }}</td>
                                        <td>
                                            @if ($item->patient)
                                                {{$item->patient->first_name}} {{$item->patient->last_name}}
                                            @else
                                                <span class="badge badge-success">Available</span>
                                            @endif
                                        </td>
                                        <td>{{$item->install_date}}</td>
                                        <td>{{$item->setup_date}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">
                                                    <a class="dropdown-item" href="{{route('device.show', $item)}}"><i
                                                        class="ti-eye"></i> Open</a>
                                                    <a class="dropdown-item" href="{{route('device.edit', $item)}}"><i
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
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
    <script>
        var device_table;
        $(document).ready(function(){

            device_table = $('#device_table').DataTable( {
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
        $('#select_available_device').on('change', function() {
            var val = $(this).val();
            var search = extractContent(val);

            if (search) {
                device_table.column(3)
                    .search("(^" + search + "$)", true, false)
                    .draw();

            } else {

                device_table.search('')
                    .columns().search('')
                    .draw();
            }
        });
        function extractContent(s) {
            var span = document.createElement('span');
            span.innerHTML = s;
            return span.textContent || span.innerText;
        };
    </script>

@endsection
