@extends('master.app')
@section('css')
    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
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
                    <form action="{{ route('role.update', $role->id) }}" method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Role Name:</label>
                                    <input type="text" class="form-control form-control-lg required" name="name"
                                        value="{{ $role->name }}">
                                    @error('name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <label for="permissions" class="form-label">Assign Permissions</label>
                            <table id="role_table" class="table table-striped text-theme w-100">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick='selects()' value="Select All" /></th>
                                        <th>Name</th>
                                        <th width="10%">Guard</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="checkbox"
                                                    name="permission[{{ $permission->name }}]"
                                                    value="{{ $permission->name }}" class='permission'
                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <a href="{{ route('role.index') }}" class="btn btn-default">Back</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function selects() {
            var ele = document.getElementsByName('permission');
            for (var i = 0; i < ele.length; i++) {
                if (ele[i].type == 'checkbox')
                    ele[i].checked = true;
            }
        }


        $('.all_checked').on('click', function() {
            const allCheckedCheckbox = $(this);
            $('.checkbox').each(function() {
                $(this).prop('checked', allCheckedCheckbox.prop('checked'));
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if ($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked', false);
                    });
                }

            });
        });
    </script>
@endsection
