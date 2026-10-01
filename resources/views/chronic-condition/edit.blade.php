@extends('master.app')
@section('css')
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
                    <form action="{{ route('chronic-condition.update', $chronic_condition) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="chronic_condition_name">Chronic Condition Name:</label>
                                    <input type="text" class="form-control form-control-lg" name="chronic_condition_name"
                                        value="{{ $chronic_condition->chronic_condition_name }}">
                                    @error('chronic_condition_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="code">Code:</label>
                                    <input type="text" class="form-control form-control-lg" name="code"
                                        value="{{ $chronic_condition->code }}">
                                    @error('code')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-md btn-success mt-1" data-toggle="modal"
                                        data-target="#add_planned_intervention_modal">Add Planned Intervention</button>

                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table id="planned_intervention_table" class="table table-striped text-theme w-100">
                                <thead>
                                    <tr>
                                        <th>Symptom</th>
                                        <th>Time</th>
                                        <th>Planned Intervention</th>
                                        <th>Person Responsible</th>
                                        <th>Desired OutCome</th>
                                        <th>Prognosis</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chronic_condition->planned_interventions as $item)
                                        <tr id="{{ $item->id }}">
                                            <td>{{ $item->symptom }}</td>
                                            <td>{{ $item->time }}</td>
                                            <td>{{ $item->planned_intervention }}</td>
                                            <td>{{ implode(',', $item->person_responsible) }}</td>
                                            <td>{{ $item->desired_outcome }}</td>
                                            <td>{{ $item->prognosis }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success edit_planned_intervention_btn"
                                                    type="button" data-id="{{ $item->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="add_planned_intervention_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add Planned Intervention</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="symptom">Symptom:</label>
                                    <input type="text" class="form-control" id="symptom">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="time">Time:</label>
                                    <input type="text" class="form-control" id="time">
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="person_responsible">Person Responsible:</label>
                                    <div class="form-group">
                                        <select class="select2 form-control" multiple="multiple" id="person_responsible">'+
                                            <option value="Self">Self</option>
                                            <option value="Home Health">Home Health</option>
                                            <option value="Care Manager">Care Manager</option>
                                            <option value="Aid">Aid</option>
                                            <option value="Son/Daughter">Son/Daughter</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="planned_intervention">Planned Intervention:</label>
                                    <textarea class="form-control" id="planned_intervention" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="desired_outcome">Desired outcome:</label>
                                    <input type="text" class="form-control " id="desired_outcome">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="prognosis">Prognosis:</label>
                                    <input type="text" class="form-control " id="prognosis">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success"
                                    id="add_planned_intervention_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_planned_intervention_modal" role="dialog" aria-labelledby="large"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Update Planned Intervention</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="symptom">Symptom:</label>
                                    <input type="hidden" id="edit_id">
                                    <input type="text" class="form-control" id="edit_symptom">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="time">Time:</label>
                                    <input type="text" class="form-control" id="edit_time">
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="person_responsible">Person Responsible:</label>
                                    <div class="form-group">
                                        <select class="select2 form-control" multiple="multiple"
                                            id="edit_person_responsible">'+
                                            <option value="Self">Self</option>
                                            <option value="Home Health">Home Health</option>
                                            <option value="Care Manager">Care Manager</option>
                                            <option value="Aid">Aid</option>
                                            <option value="Son/Daughter">Son/Daughter</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="planned_intervention">Planned Intervention:</label>
                                    <textarea class="form-control" id="edit_planned_intervention" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="desired_outcome">Desired outcome:</label>
                                    <input type="text" class="form-control " id="edit_desired_outcome">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="prognosis">Prognosis:</label>
                                    <input type="text" class="form-control " id="edit_prognosis">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success"
                                    id="update_planned_intervention_btn">Save</button>
                                <button type="button" class="btn btn-danger"
                                    id="delete_planned_intervention_btn">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    {{-- <script src="{{asset('dist/js/pages/forms/select2/select2.init.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            $(".select2").select2();

        })
        $(document).on('click', '#add_planned_intervention_btn', function() {
            const chronic_condition_id = "{{ $chronic_condition->id }}";
            const symptom = $('#symptom').val();
            const time = $('#time').val();
            const planned_intervention = $('#planned_intervention').val();
            const person_responsible = $('#person_responsible').val();
            const desired_outcome = $('#desired_outcome').val();
            const prognosis = $('#prognosis').val();

            if (chronic_condition_id && symptom && planned_intervention && person_responsible && time &&
                desired_outcome && prognosis) {

                $.ajax({
                    url: "{{ route('planned-intervention.store') }}",
                    type: "post",
                    data: {
                        chronic_condition_id: chronic_condition_id,
                        symptom: symptom,
                        time: time,
                        planned_intervention: planned_intervention,
                        person_responsible: person_responsible,
                        desired_outcome: desired_outcome,
                        prognosis: prognosis
                    },
                    success: function(response) {
                        if (response) {

                            var data = '<tr id="' + response.id + '">' +
                                '<td>' + symptom + '</td>' +
                                '<td>' + time + '</td>' +
                                '<td>' + planned_intervention + '</td>' +
                                '<td>' + person_responsible + '</td>' +
                                '<td>' + desired_outcome + '</td>' +
                                '<td>' + prognosis + '</td>' +
                                '<td>' +
                                '<a type="button" class="edit_planned_intervention_btn btn btn-sm btn-success text-white mt-1" title="Edit" data-id="' +
                                response.id + '">' +
                                '<i class="fas fa-pencil-alt"></i>' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                            var table_body = $('#planned_intervention_table tbody');
                            table_body.append(data);
                            toastr.success('Data has been saved', 'Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#add_planned_intervention_modal').modal('hide');

                        } else {

                            toastr.error('Something went wrong', 'Error!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });

                    }
                });
            } else {
                toastr.warning('Please fill out entire form then press submit', 'warning!', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }

        });

        $(document).on('click', '.edit_planned_intervention_btn', function() {

            var element = $(this);
            var id = $(this).data('id');
            var url = "{{ route('planned-intervention.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function(response) {

                    $('#edit_id').val(response.id);
                    $('#edit_symptom').val(response.symptom);
                    $('#edit_time').val(response.time);
                    $('#edit_planned_intervention').val(response.planned_intervention);
                    $('#edit_person_responsible').val(response.person_responsible).change();
                    $('#edit_desired_outcome').val(response.desired_outcome);
                    $('#edit_prognosis').val(response.prognosis);

                    $('#edit_planned_intervention_modal').modal('show');
                },
                error: function() {
                    toastr.error('Something went wrong', 'Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });

                }
            });

        });
        $(document).on('click', '#update_planned_intervention_btn', function() {
            const id = $('#edit_id').val();
            const chronic_condition_id = "{{ $chronic_condition->id }}";
            const symptom = $('#edit_symptom').val();
            const time = $('#edit_time').val();
            const planned_intervention = $('#edit_planned_intervention').val();
            const person_responsible = $('#edit_person_responsible').val();
            const desired_outcome = $('#edit_desired_outcome').val();
            const prognosis = $('#edit_prognosis').val();

            var update_url = "{{ route('planned-intervention.update', ':id') }}";
            update_url = update_url.replace(':id', id);
            if (chronic_condition_id && symptom && time && planned_intervention && person_responsible &&
                desired_outcome && prognosis) {
                $.ajax({
                    url: update_url,
                    type: "post",
                    data: {
                        _method: "patch",
                        chronic_condition_id: chronic_condition_id,
                        symptom: symptom,
                        time: time,
                        planned_intervention: planned_intervention,
                        person_responsible: person_responsible,
                        desired_outcome: desired_outcome,
                        prognosis: prognosis,
                    },
                    success: function(response) {
                        if (response) {
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(0)')
                                .text(response.symptom);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(1)')
                                .text(response.time);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(2)')
                                .text(response.planned_intervention);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(3)')
                                .text(response.person_responsible);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(4)')
                                .text(response.desired_outcome);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(5)')
                                .text(response.prognosis);


                            toastr.success('Data has been saved', 'Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                            $('#edit_planned_intervention_modal').modal('hide');

                        }
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });

                    }
                });
            } else {
                toastr.warning('Please fill out entire form then press submit', 'warning!', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }




        });
        $(document).on('click', '#delete_planned_intervention_btn', function() {
            const id = $('#edit_id').val();
            var row = $('#planned_intervention_table').find('#' + id);
            var delete_url = "{{ route('planned-intervention.destroy', ':id') }}";
            delete_url = delete_url.replace(':id', id);
            if (id) {
                $.ajax({
                    url: delete_url,
                    type: "post",
                    data: {
                        _method: 'DELETE'
                    },
                    success: function() {
                        row.remove();
                        toastr.success('Data has been removed', 'Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_planned_intervention_modal').modal('hide');
                    },
                    error: function() {
                        toastr.warning('Something went wrong', 'warning!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            }
        });
    </script>
@endsection
