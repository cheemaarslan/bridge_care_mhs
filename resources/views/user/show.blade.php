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
        <!-- Column -->
        <div class="col-lg-3 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="mt-4">
                        <img src="{{ $user->user_image }}" class="rounded-circle" width="150" />
                        <h6 class="card-subtitle mt-3">{{ $user->email }}</h6>
                        <h4 class="card-title mt-2">{{ $user->first_name }} {{ $user->last_name }}</h4>
                    </center>
                </div>
                <div class="card-body">
                    <div class="btn-list text-center">
                        <a class="btn btn-sm btn-rounded mr-2 btn-outline-success"
                            href="{{ route('user.profile.edit', $user) }}"><i class="ti-pencil-alt mr-2"></i> Edit</a>
                        @can('crud_user')
                            <a class="btn btn-sm btn-rounded btn-outline-danger " href="{{ route('user.destroy', $user) }}"
                                onclick="event.preventDefault();
                                    document.getElementById('delete_user').submit();"><i
                                    class="ti-trash mr-2"></i> Delete</a>
                        @endcan
                    </div>
                    @can('crud_user')
                        <form action="{{ route('user.destroy', $user) }}" id="delete_user">
                            @csrf
                        </form>
                    @endcan
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-9 col-xlg-9 col-md-7">
            <div class="card">
               <div class="card-header">
                <h4>{{$user->user_name}}'s Profile</h4>
               </div>
               <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">First Name</label>
                                <input type="text" class="form-control form-control-lg" value="{{$user->first_name}}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control form-control-lg" value="{{$user->last_name}}" readonly>

                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" class="form-control form-control-lg" value="{{$user->user_name}}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control form-control-lg" value="{{$user->email}}" readonly>

                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" class="form-control form-control-lg" value="{{$user->user_name}}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Contact No</label>
                                <input type="text" class="form-control form-control-lg" value="{{$user->contact_no}}" readonly>

                            </div>
                        </div>
                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" class="form-control form-control-lg" value="{{$user->address}}" readonly>

                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#all_logs_table').DataTable({
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

            $('#my_logs_table').DataTable({
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
