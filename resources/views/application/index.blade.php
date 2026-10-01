@extends('master.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="#practice_application" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Practice Application</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#coordinator_application" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Care Manager Application</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="practice_application">
                            <div class="table-responsive">
                                <table id="practice_application_table" class="table table-striped text-theme w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>State</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sr_no = 1;
                                        @endphp
                                        @foreach ($practice_applications as $item)
                                            <tr>
                                                <td>{{ $sr_no++ }}</td>
                                                {{-- <td><a
                                                            href="{{ route('practice-application.show', $item->slug) }}"><strong>{{ $item->first_name }}</strong></a>
                                                    </td> --}}
                                                <td>{{ $item->first_name }}</td>
                                                <td>{{ $item->last_name }}</td>

                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->city }}</td>
                                                <td>{{ $item->state }}</td>

                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu slideInUp">
                                                            <button href="#" class="dropdown-item approve"
                                                                data-val="{{ $item->id }}"><i class="ti-eye"></i>
                                                                Approve</button>
                                                            {{-- <a class="dropdown-item" href="{{route('practice-application.edit', $item)}}"><i
                                                                        class="ti-pencil-alt"></i> Edit</a> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="coordinator_application">
                            <div class="table-responsive">
                                <table id="coordinator_application_table" class="table table-striped text-theme w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>State</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sr_no = 1;
                                        @endphp
                                        @foreach ($coordinator_applications as $item)
                                            <tr>
                                                <td>{{ $sr_no++ }}</td>
                                                {{-- <td><a
                                                            href="{{ route('coordinator-application.show', $item->slug) }}"><strong>{{ $item->first_name }}</strong></a>
                                                    </td> --}}
                                                <td>{{ $item->first_name }}</td>
                                                <td>{{ $item->last_name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->city }}</td>
                                                <td>{{ $item->state }}</td>



                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-dark dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu slideInUp">
                                                            {{-- <a class="dropdown-item" href="{{route('coordinator-application.show', $item)}}"><i
                                                                        class="ti-eye"></i> Open</a>
                                                                <a class="dropdown-item" href="{{route('coordinator-application.edit', $item)}}"><i
                                                                        class="ti-pencil-alt"></i> Edit</a> --}}
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

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#practice_application_table').DataTable({
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

            $('#coordinator_application_table').DataTable({
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
                pageLength: 25
            });

        });
        $(document).on('click', '.approve', function() {
            var element = $(this);
            var id = $(this).attr('data-val');
            var url = "{{ route('practice-application.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "put",
                success: function(response) {
                    // element.closest('tr').remove()
                    // element.parent().parent().parent().parent().remove();
                },
                error: function() {

                }
            });
        });
    </script>
@endsection
