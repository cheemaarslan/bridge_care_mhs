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
                <div class="card-header">
                    <a href="{{route('practice.create')}}" class="btn btn-success">Creat New Practice</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="practice_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Practice Name</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th>Total Patients</th>
                                    <th>Default</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($practices as $item)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>{{ $item->practice_name }}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{$item->contact_no}}</td>
                                        <td>
                                            <a href="{{route('practice.show', $item)}}">{{$item->patients_count}}</a>
                                        </td>
                                        <td>
                                            @if ($item->default)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-warning">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">
                                                    <a class="dropdown-item" href="{{route('practice.show', $item)}}"><i
                                                        class="ti-eye"></i> Open</a>
                                                    <a class="dropdown-item" href="{{route('practice.edit', $item)}}"><i
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
        $(document).ready(function(){

            $('#practice_table').DataTable( {
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
            });

        });
    </script>

@endsection
