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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="ml-3">
                                <button class="btn btn-danger">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-lg-2 col-12">

                                <select class="form-control" name="select_role" id="select_role" style="width: 200px;">
                                    <option value=""> --select practice--</option>
                                    @foreach ($practices as $item)
                                        <option value="{{ $item->practice_name }}">{{ $item->practice_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <table id="user_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Practice Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            @foreach ($item->roles as $role)
                                                @if ($loop->first)
                                                    <span class="badge badge-success">{{ $role->name }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $item->contact_no }}</td>
                                        <td>{{ $item->practice->practice_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">
                                                    <a class="dropdown-item" href="{{ route('user.show', $item) }}"><i
                                                            class="ti-eye"></i> Open</a>
                                                    <a class="dropdown-item" href="{{ route('user.edit', $item) }}"><i
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
                <!-- end card-body-->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        var user_table;
        $(document).ready(function() {
            user_table = $('#user_table').DataTable({
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
        $('#select_role').on('change', function() {
            var search = $(this).val();
            if (search) {
                user_table.column(5)
                    .search("(^" + search + "$)", true, false)
                    .draw();

            } else {

                user_table.search('')
                    .columns().search('')
                    .draw();
            }
        });
    </script>
@endsection
