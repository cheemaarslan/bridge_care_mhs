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
                    <h4 class="card-title">Practice Name: {{ $practice->practice_name }}</h4>
                    <p class="card-text mb-0">Practice Contact No: {{ $practice->contact_no }}</p>
                    <p class="card-text mb-0">Practice Address: {{ $practice->address }}</p>
                    <p class="card-text mb-0">Care Team Members: {{ $users->count() }}</p>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        @can('create_care_team')
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_user_modal">Add
                                Member</button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="care_team_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
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
                                        <td>{{ $item->contact_no }}</td>
                                        <td>

                                            <button class="btn btn-sm btn-success edit_care_team" type="button"
                                                data-id="{{ $item->id }}"><i class="fas fa-pencil-alt"></i></button>
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
@section('modal')
    <div class="modal fade" id="add_user_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add New Care Manager</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('care-team.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="user_name">User Name:</label>
                                    <input type="text" class="form-control" name="user_name"
                                        value="{{ old('user_name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password:</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="role_name">Role Name:</label>
                                    <select name="role_name" class="select2 form-control">
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Contact No:</label>
                                    <input type="text" class="form-control" name="contact_no"
                                        value="{{ old('contact_no') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="state">State Name:</label>
                                    <input type="text" class="form-control " name="state"
                                        value="{{ old('state') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="city">City Name:</label>
                                    <input type="text" class="form-control " name="city"
                                        value="{{ old('city') }}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control " name="address"
                                        value="{{ old('address') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_user_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Update Care Manager</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="edit_user_form">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" class="form-control" name="first_name" id="edit_first_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" class="form-control" name="last_name" id="edit_last_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="user_name">User Name:</label>
                                    <input type="text" class="form-control" name="user_name" id="edit_user_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" name="email" id="edit_email">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Contact No:</label>
                                    <input type="text" class="form-control" name="contact_no" id="edit_contact_no">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="state">State Name:</label>
                                    <input type="text" class="form-control " name="state" id="edit_state">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="city">City Name:</label>
                                    <input type="text" class="form-control " name="city" id="edit_city">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control " name="address" id="edit_address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        var care_team_table;
        $(document).ready(function() {
            care_team_table = $('#care_team_table').DataTable({
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
        $(document).on('click', '.edit_care_team', function() {
            var user_id = $(this).attr('data-id');
            var edit_url = "{{ route('care-team.edit', ':id') }}";
            edit_url = edit_url.replace(':id', user_id);
            var update_url = "{{ route('care-team.update', ':id') }}";
            update_url = update_url.replace(':id', user_id);

            $('#edit_user_form').attr('action', update_url);
            $.ajax({
                url: edit_url,
                type: "get",
                success: function(response){
                    $('#edit_user_modal').modal('show');
                    $('#edit_first_name').val(response.first_name);
                    $('#edit_last_name').val(response.last_name);
                    $('#edit_user_name').val(response.user_name);
                    $('#edit_email').val(response.email);
                    $('#edit_state').val(response.state);
                    $('#edit_city').val(response.city);
                    $('#edit_address').val(response.address);
                    $('#edit_contact_no').val(response.contact_no);
                },
                error: function(){

                }

            })
        });
    </script>
@endsection
