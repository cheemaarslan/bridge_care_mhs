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
        <a href="{{route('patient.show', ['patient' => $care_plan->patient, 'type' => 'ccm'])}}" class="inactive">{{$care_plan->patient->first_name}} {{$care_plan->patient->last_name}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">Care Plan </a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="active">Time Track</a>
    </li>
</ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="text-danger">{{$care_plan->minutes}}:{{$care_plan->seconds}}</h4>
                        </div>

                        <div class="col-6 text-right">
                            <button class="btn btn-success" data-toggle="modal" data-target="#care_plan_time_track_modal"><i
                                    class="fas fa-plus"></i></button>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="care_plan_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Minute</th>
                                    <th>Second</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($time_tracks as $item)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->minutes }}</td>
                                        <td>{{ $item->seconds }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" type="button"
                                                onclick="edit_time_track({{ $item->id }})"><i
                                                    class="fas fa-pencil-alt"></i></button>
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
@section('modal')
    <div class="modal fade" id="care_plan_time_track_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Care Plan Time Track</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{ route('care-plan.time-track.store') }}" method="POST" id="care_plan_time_track_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="user_id">User Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->user_name }}" readonly>
                                <input type="hidden" class="form-control" name="care_plan_id" value="{{ $care_plan->id }}">
                                <input type="hidden" class="form-control" name="entry_type" value="Manual">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="minutes">Minutes</label>
                                <input type="number" class="form-control" name="minutes">

                            </div>
                            <div class="col-6 mt-3">
                                <label for="seconds">Seconds</label>
                                <input type="number" class="form-control" name="seconds">

                            </div>
                            <div class="col-12 mt-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" rows="6" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_care_plan_time_track_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Care Plan Time Track</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{ route('care-plan.time-track.store') }}" method="POST" id="edit_care_plan_time_track_form">
                    @method('patch')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="user_id">User Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->user_name }}"
                                    readonly>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="minutes">Minutes</label>
                                <input type="number" class="form-control" name="minutes" id="edit_minutes">

                            </div>
                            <div class="col-6 mt-3">
                                <label for="seconds">Seconds</label>
                                <input type="number" class="form-control" name="seconds" id="edit_seconds">

                            </div>
                            <div class="col-12 mt-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="6" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#care_plan_table').DataTable({
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

        function edit_time_track(id) {
            var edit_url = "{{ route('care-plan.time-track.edit', ':id') }}";
            edit_url = edit_url.replace(':id', id);
            var update_url = "{{ route('care-plan.time-track.update', ':id') }}";
            update_url = update_url.replace(':id', id);
            $('#edit_care_plan_time_track_form').attr('action', update_url);
            $.ajax({
                url: edit_url,
                type: "get",
                success: function(response) {
                    if (response) {
                        $('#description').val(response.description);
                        $('#edit_minutes').val(response.minutes);
                        $('#edit_seconds').val(response.seconds);
                        $('#edit_care_plan_time_track_modal').modal('show');
                    }
                },
                error: function(response) {
                    console.log('something went wrong');
                }
            })
        }
    </script>
@endsection
