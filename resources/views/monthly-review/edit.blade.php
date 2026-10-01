@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endsection
@section('breadcrum')
<ol class="breadcrumb p-4">
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{route('patient.show',['patient' => $monthly_review->patient, 'type' => 'ccm'])}}" class="inactive">{{$monthly_review->patient->first_name}} {{$monthly_review->patient->last_name}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">Monthly Review</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">{{$monthly_review->reference_no}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="active">Edit</a>
    </li>
</ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body wizard-content">
                    <form  class="tab-wizard wizard-circle" id="monthly_review_form" method="POST" action="{{route('monthly-review.update', $monthly_review)}}">
                        @method('patch')
                        @csrf
                        <input type="hidden" name="patient_id" value="{{$monthly_review->patient->id}}">
                        <input type="hidden" name="monthly_review_id" id="monthly_review_id" value="{{$monthly_review->id}}">
                        <input type="hidden" name="minutes" id="monthly_review_minutes" value="">
                        <input type="hidden" name="seconds" id="monthly_review_seconds" value="">
                        <h6>Introduction</h6>
                        <section>
                            <h3 class="text-success text-center">Introduction</h3>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <p class="text-center">
                                                Hello, this is {{auth()->user()->first_name}} {{auth()->user()->last_name}}, your dedicated Care Coordinator. I am calling from {{$care_manager->first_name}} {{$care_manager->last_name}}.
                                            </p>
                                            <p class="text-center">
                                                I am calling to make sure you are doing alright.
                                            </p>
                                            <p class="text-center">
                                                {{$care_manager->first_name}} {{$care_manager->last_name}} wanted me to call you and ask you these important question about your health.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @foreach ($schemes as $item)

                            @if ($item->id == 7)
                                <h6>{{$item->scheme_name}}</h6>
                                <section>
                                    <h3 class="text-success">Medication</h3>
                                    <span>{{$item->id}}</span>

                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="medication_name">Medication Name</label>
                                                <input class="form-control form-control-lg" id="medication_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="dose">Dose</label>
                                                <input class="form-control form-control-lg" id="dose">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="frequency">Frequency</label>
                                                <input class="form-control form-control-lg" id="frequency">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="route">Route</label>
                                                <input class="form-control form-control-lg" id="route">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-md btn-success text-white mt-1" id="add_medication_btn" title="Add Medication">
                                                <i class="ti-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped text-theme w-100" id="medication_table">
                                            <thead>
                                            <tr>
                                                <th>Medication Name</th>
                                                <th>Dose</th>
                                                <th>Frequency</th>
                                                <th>Route</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($monthly_review->medications as $item)
                                                    <tr id="{{$item->id}}">
                                                        <td>{{$item->medication_name}}</td>
                                                        <td>{{$item->dose}}</td>
                                                        <td>{{$item->frequency}}</td>
                                                        <td>{{$item->route}}</td>
                                                        <td>
                                                            <button type="button" class="edit_medication_btn btn btn-sm btn-danger text-white mt-1" title="Edit" data-id="{{$item->id}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-md btn-success text-white mt-1" id="carry_forward_btn">Carry Forward</button>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </section>
                            @elseif ($item->id == 8)
                                <h6>{{ $item->scheme_name }}</h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="current">Recorded By</label>
                                                <input class="form-control form-control-lg" id="user_id" value="{{auth()->user()->user_name}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="goal">Date:</label>
                                                <input class="form-control form-control-lg bg-white" id="date">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="goal">Note:</label>
                                                <textarea name="note" class="form-control" id="note" rows="8"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-md btn-success text-white mt-1"
                                                    id="add_note_btn" title="Add Goal">
                                                <i class="ti-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped text-theme w-100" id="note_table">
                                            <thead>
                                            <tr>
                                                <th>Recorded By</th>
                                                <th>Date</th>
                                                <th>Note</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($monthly_review->notes as $item)
                                                    <tr id="{{ $item->id }}">
                                                        <td>{{ $item->user->user_name }}</td>
                                                        <td>{{ $item->formatted_date }}</td>
                                                        <td>{{ $item->note }}</td>
                                                        <td>
                                                            <button type="button" class="edit_note_btn btn btn-sm btn-danger text-white mt-1"
                                                            title="Edit" data-id="{{ $item->id }}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @else
                                <h6>{{$item->scheme_name}}</h6>
                                <section>
                                    <h3 class="text-success">{{$item->scheme_name}}</h3>
                                    <span>{{$item->id}}</span>

                                    <div class="table-responsive">
                                        <table class="table text-theme w-100">
                                            <thead>
                                            <tr>
                                                <th class="text-center" style="width: 6%;">#</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $sr_no = 1;
                                            @endphp
                                            @foreach ($item->questions as $question)
                                                <tr>
                                                    <td>
                                                        <input class="form-control btn-success text-center" type="text" value="{{ $sr_no++ }}" disabled>
                                                    </td>
                                                    <td class="question">
                                                        <p class="text-justify mt-2">{{ $question->question }}</p>
                                                        <input type="hidden" name="monthly_review_question_id" value="{{$question->id}}">
                                                        <input type="hidden" name="question" value="{{$question->question}}">
                                                        <div class="form-group {{ ($question->answer) ? (($question->answer->answer) == 'Yes' ? '' : 'd-none') : 'd-none' }}">
                                                            <label for="">Comment:</label>
                                                            <input type="text" name="comment" class="form-control w-50 required comment" value="{{ $question->answer ? $question->answer->comment : '' }}" placeholder="Enter Comment....">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($question->input_type == 'select')
                                                            <select class="select2 form-control answer required" name="answer">
                                                                <option ></option>
                                                                @foreach ($question->option as $opt)
                                                                    <option value="{{$opt}}" {{$question->answer ? (($question->answer->answer) == $opt ? 'selected' : '') : ''}}>{{$opt}}</option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                        @if ($question->input_type == 'input')
                                                            <input class="form-control answer required" name="answer" value="{{$question->answer ? $question->answer->answer : ''}}"  type="text">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @endif

                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="edit_medication_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Update Medication</h4>
                    </div>
                    <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="edit_medication_id">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_medication_name">Medication Name:</label>
                                    <input type="text" class="form-control" id="edit_medication_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_dose">Dose:</label>
                                    <input type="text" class="form-control" id="edit_dose">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_frequency">Frequency:</label>
                                    <input type="text" class="form-control" id="edit_frequency">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_route">Route:</label>
                                    <input type="text" class="form-control"  id="edit_route">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success" id="update_medication_btn">Save</button>
                                <button type="button" class="btn btn-danger" id="delete_medication_btn">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_note_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edit Note</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="">Recorded By:</label>
                                    <input type="hidden" class="form-control" id="edit_note_id">
                                    <input type="text" class="form-control" id="edit_user_name" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="">Date:</label>
                                    <input type="text" class="form-control bg-white" id="edit_date">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Add Note:</label>
                                    <textarea class="form-control" name="note" id="edit_note" rows="6" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" id="delete_note_btn" class="btn btn-danger">Delete</button>
                                <button type="button" id="update_note_btn" class="btn btn-success">Update</button>
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
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('jquery-validation/dist/jquery.validate.js') }}"></script>
    <script src="{{asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        var new_minutes= 0;
        var new_seconds = 0;
        var last_time = 0;
        var new_time = 0;
        $(document).ready(function() {
            $('#footer').removeClass('d-none');
            $('#timer_option').addClass('d-none');

            var form = $("#monthly_review_form").show();


            $("#monthly_review_form").steps({
                headerTag: "h6",
                bodyTag: "section",
                enableAllSteps: true,
                enableFinishButton: true,
                enablePagination: true,
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "Finish"
                },
                buttons: [{
                    name: "Save"
                }, {
                    name: "Save",
                    click: function() {
                        alert("Custom clicked");
                    }
                }],

                onStepChanging: function(event, currentIndex, newIndex) {
                    // Allways allow previous action even if the current form is not valid!
                    if (currentIndex > newIndex){
                        return true;
                    }
                    if (currentIndex == 7 && $('#medication_table tbody tr').length < 1){
                        toastr.warning('At Least 1 Medication is required', 'Warning!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        return false;
                    }
                    if (currentIndex < newIndex){
                        // To remove error styles
                        form.find(".body:eq(" + newIndex + ") label.error").remove();
                        form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                    }
                    var currentStep = $("#monthly_review_form").find("#monthly_review_form-p-"+currentIndex);
                    var valid = true;
                    currentStep.find(".answer").each(function() {
                        if (!$(this).valid()) {
                            valid = false;
                            return false;
                        }
                    });
                    if (!valid) {
                        toastr.warning('Please answer all questions', 'Warning!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        return false;
                    }
                    // Needed in some cases if the user went back (clean up)
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();

                },
                onStepChanged: function (event, currentIndex, priorIndex) {
                    var content = $('#monthly_review_form-p-'+priorIndex);
                    var scheme_name = $(content).find('h3').html();
                    var scheme_id = $(content).find('span').html();
                    save_current_step(scheme_id, scheme_name);

                },
                onFinishing: function(event, currentIndex) {
                    return form.validate().settings.ignore = ":disabled,:hidden", form.valid()
                },
                onFinished: function(event, currentIndex) {
                    toastr.success('Patient Monthly Review has been updated', 'Success!',{
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    var content = $('#monthly_review_form-p-'+currentIndex);
                    var scheme_name = $(content).find('h3').html();
                    var scheme_id = $(content).find('span').html();
                    save_current_step(scheme_id, scheme_name);
                    $('#monthly_review_form').submit();
                }
            });

            $(".select2").select2({
                placeholder: "Please select an option",
                allowClear: true,
            });
            start_timer();

            var patient = "{{$monthly_review->patient->slug}}";
            var type = "ccm";
            var url = "{{ url('patient/:id/type/:type') }}";
            url = url.replace(':id', patient).replace(':type', type);

            var $input = $('<li aria-hidden="false" aria-disabled="false"><a href="'+url+'" role="menuitem">Save & Exit</a></li>');
            $input.appendTo($('ul[aria-label=Pagination]'));

            $('#date').flatpickr({
                dateFormat: "m-d-Y",
            });
            $('#edit_date').flatpickr({
                dateFormat: "m-d-Y",
            });

        });

        function save_current_step(monthly_review_scheme_id, monthly_review_scheme_name){
            var monthly_review_id = $('#monthly_review_id').val();

            new_minutes= parseInt($('#minutes').html());
            new_seconds = parseInt($('#seconds').html());
            var new_time = (new_minutes*60) + new_seconds;

            var diff_time = new_time - last_time;
            diff_minutes = Math.floor(diff_time/60);
            diff_seconds = diff_time%60;



            var entry_type = "Automatic";
            var description = "Care Plan: "+monthly_review_scheme_name;

            $.ajax({
                url: "{{route('monthly-review.time-track.store')}}",
                type: "post",
                data: {
                    monthly_review_id: monthly_review_id,
                    monthly_review_scheme_id: monthly_review_scheme_id,
                    minutes:diff_minutes,
                    seconds:diff_seconds,
                    entry_type:entry_type,
                    description: description,
                },
                success: function(response){
                    last_time = new_time;
                },
                error: function(response){
                    console.log('something went wrong');
                }
            })
        }

        /**
         * Medication CRUD Start Here
        **/
        $(document).on('click', '#add_medication_btn', function() {
            const patient_id = "{{$monthly_review->patient->id}}"
            var monthly_review_id = $('#monthly_review_id').val();
            const medication_name = $('#medication_name').val();
            const dose = $('#dose').val();
            const frequency = $('#frequency').val();
            const route = $('#route').val();

            if(patient_id && monthly_review_id && medication_name && dose && frequency && route){
                $.ajax({
                    url: "{{route('medication.store')}}",
                    type: "post",
                    data:{
                        patient_id: patient_id,
                        monthly_review_id: monthly_review_id,
                        medication_name: medication_name,
                        dose: dose,
                        frequency: frequency,
                        route:route
                    },
                    success: function(response){
                        if(response){

                            var data = '<tr id="' + response.id + '">' +
                                            '<td>'+medication_name+'</td>' +
                                            '<td>'+dose+'</td>' +
                                            '<td>'+frequency+'</td>' +
                                            '<td>'+route+'</td>' +
                                            '<td>' +
                                                '<button type="button" class="edit_medication_btn btn btn-sm btn-danger text-white mt-1" title="Edit" data-id="'+response.id+'">' +
                                                    '<i class="fas fa-pencil-alt"></i>' +
                                                '</button>' +
                                            '</td>' +
                                        '</tr>';
                            var table_body = $('#medication_table tbody');
                            table_body.append(data);

                            toastr.success('Data has been saved', 'Success!',{
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                        }
                    },
                    error: function(response){
                        toastr.error('Something went wrong', 'Error!',{
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });

                    }
                });
            }
            else{
                toastr.warning('Please fill out entire form then press submit', 'warning!',{
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });
        $(document).on('click', '.edit_medication_btn', function() {
            var element = $(this);
            var id = $(this).data('id');
            var url = "{{route('medication.edit',':id')}}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function (response){
                    $('#edit_medication_id').val(id);

                    $('#edit_medication_name').val(response.medication_name);
                    $('#edit_dose').val(response.dose);
                    $('#edit_frequency').val(response.frequency);
                    $('#edit_route').val(response.route);

                    $('#edit_medication_modal').modal('show');
                },
                error: function(){
                    toastr.error('Something went wrong', 'Error!',{
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });

                }
            });

        });
        $(document).on('click', '#update_medication_btn', function() {
            const medication_name = $('#edit_medication_name').val();
            const dose = $('#edit_dose').val();
            const frequency = $('#edit_frequency').val();
            const route = $('#edit_route').val();
            const id = $('#edit_medication_id').val();

            var update_url = "{{route('medication.update', ':id')}}";
            update_url = update_url.replace(':id', id);
            if(medication_name && dose && frequency && route){
                $.ajax({
                    url: update_url,
                    type: "put",
                    data:{
                        medication_name: medication_name,
                        dose: dose,
                        frequency: frequency,
                        route:route
                    },
                    success: function(response){
                        if(response){
                            var row_no = 1;
                            $('#medication_table').find('#'+response.id).find('td:eq(0)').html(response.medication_name);
                            $('#medication_table').find('#'+response.id).find('td:eq(1)').html(response.dose);
                            $('#medication_table').find('#'+response.id).find('td:eq(2)').html(+response.frequency);
                            $('#medication_table').find('#'+response.id).find('td:eq(3)').html(response.route);


                            toastr.success('Data has been saved', 'Success!',{
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                        }
                    },
                    error: function(response){
                        toastr.error('Something went wrong', 'Error!',{
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });

                    }
                });
            }
            else{
                toastr.warning('Please fill out entire form then press submit', 'warning!',{
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }




        });
        $(document).on('click', '#delete_medication_btn', function(){
            const id = $('#edit_medication_id').val();
            var row = $('#medication_table').find('#'+id);
            var delete_url = "{{route('medication.destroy', ':id')}}";
            delete_url = delete_url.replace(':id', id);
            if(id){
                $.ajax({
                    url: delete_url,
                    type: "delete",
                    success: function(){
                        row.remove();
                        toastr.success('Data has been removed', 'Success!',{
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_medication_modal').modal('hide');
                    },
                    error: function(){
                        toastr.warning('Something went wrong', 'warning!',{
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            }
        });
        $(document).on('click', '#carry_forward_btn', function(){
            var monthly_review_id = $('#monthly_review_id').val();
            var patient_id = "{{$monthly_review->patient->id}}";
            $.ajax({
                url: "{{route('medication.carry_forward')}}",
                type: "post",
                data:{
                    patient_id: patient_id,
                    monthly_review_id: monthly_review_id,
                },
                success: function(response){
                    if(response.length > 0){
                        $.each(response, function (index, value) {
                            var data = '<tr id="' + value.id + '">' +
                                '<td>'+value.medication_name+'</td>' +
                                '<td>'+value.dose+'</td>' +
                                '<td>'+value.frequency+'</td>' +
                                '<td>'+value.route+'</td>' +
                                '<td>' +
                                '<button type="button" class="edit_medication_btn btn btn-sm btn-danger text-white mt-1" title="Edit" data-id="'+value.id+'">' +
                                '<i class="fas fa-pencil-alt"></i>' +
                                '</button>' +
                                '</td>' +
                                '</tr>';
                            var table_body = $('#medication_table tbody');
                            table_body.append(data);
                        });

                        toastr.success('Data has been saved', 'Success!',{
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });

                    }
                    else{
                        toastr.warning('No Medication Found', 'Success!',{
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                },
                error: function(response){
                    toastr.error('Something went wrong', 'Error!',{
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });

                }
            });
        });

        /**
         * Medication CRUD End Here
        **/

        /**
         * Note Crud Start Here
         * */
        $(document).on('click', '#add_note_btn', function () {
            var monthly_review_id = $('#monthly_review_id').val();
            const date = $('#date').val();
            const note = $('#note').val();

            if (monthly_review_id && date && note) {

                $.ajax({
                    url: "{{ route('note.store') }}",
                    type: "post",
                    data: {
                        monthly_review_id: monthly_review_id,
                        date: date,
                        note: note,
                    },
                    success: function (response) {
                        if (response) {

                            var data = '<tr id="' + response.id + '">' +
                                            '<td>'+ response.user.user_name + '</td>' +
                                            '<td>'+ date + '</td>' +
                                            '<td>'+ note + '</td>' +
                                            '<td>' +
                                                '<button type="button" class="edit_note_btn btn btn-sm btn-success text-white mt-1" title="Edit" data-id="' +response.id + '">' +
                                                    '<i class="fas fa-pencil-alt"></i>' +
                                                '</button>' +
                                            '</td>' +
                                        '</tr>';
                            var table_body = $('#note_table tbody');
                            table_body.append(data);
                            toastr.success('Data has been saved', 'Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                        }
                    },
                    error: function (response) {
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
        $(document).on('click', '.edit_note_btn', function () {

            var element = $(this);
            var id = $(this).data('id');
            var url = "{{ route('note.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function (response) {

                    $('#edit_note_id').val(id);
                    $('#edit_user_name').val(response.user.user_name);
                    $('#edit_date').val(response.formatted_date);
                    $('#edit_note').val(response.note);

                    $('#edit_note_modal').modal('show');
                },
                error: function () {
                    toastr.error('Something went wrong', 'Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });

                }
            });

        });
        $(document).on('click', '#update_note_btn', function () {
            const date = $('#edit_date').val();
            const note = $('#edit_note').val();
            const id = $('#edit_note_id').val();

            var update_url = "{{ route('note.update', ':id') }}";
            update_url = update_url.replace(':id', id);
            if (id && date && note) {
                $.ajax({
                    url: update_url,
                    type: "put",
                    data: {
                        date: date,
                        note: note,
                    },
                    success: function (response) {
                        if (response) {
                            var row_no = 1;
                            $('#note_table').find('#' + response.id).find('td:eq(0)').html(response.user.user_name);
                            $('#note_table').find('#' + response.id).find('td:eq(1)').html(response.formatted_date);
                            $('#note_table').find('#' + response.id).find('td:eq(2)').html(response.note);

                            toastr.success('Data has been saved', 'Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                            $('#edit_note_modal').modal('hide');

                        }
                    },
                    error: function (response) {
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
        $(document).on('click', '#delete_note_btn', function () {
            const id = $('#edit_note_id').val();
            var row = $('#note_table').find('#' + id);
            var delete_url = "{{ route('note.destroy', ':id') }}";
            delete_url = delete_url.replace(':id', id);
            if (id) {
                $.ajax({
                    url: delete_url,
                    type: "delete",
                    success: function () {
                        row.remove();
                        toastr.success('Data has been removed', 'Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_note_modal').modal('hide');
                    },
                    error: function () {
                        toastr.warning('Something went wrong', 'warning!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            }
        });



        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;   //time in ms, 5 second for example
        $(document).on('keydown', '.answer',function(){
            var element = $(this);
            clearTimeout(typingTimer);
            if ($(element).val) {
                typingTimer = setTimeout(function(){
                    //do stuff here e.g ajax call etc....
                    var monthly_review_id = $('#monthly_review_id').val();
                    var monthly_review_question_id = $(element).parents('tr').find('td:eq(1)').find('input[name=monthly_review_question_id]').val();
                    var question = $(element).parents('tr').find('td:eq(1)').find('input[name=question]').val();
                    var comment = null;
                    var answer = $(element).val();
                    save_answer(monthly_review_id, monthly_review_question_id, question, comment, answer);

                }, doneTypingInterval);
            }
        });
        $(document).on('select2:select', '.answer', function(){
            var monthly_review_id = $('#monthly_review_id').val();
            var monthly_review_question_id = $(this).parents('tr').find('td:eq(1)').find('input[name=monthly_review_question_id]').val();
            var question = $(this).parents('tr').find('td:eq(1)').find('input[name=question]').val();
            var comment = null;
            var answer = $(this).val();

            if($(this).val() === "No"){
                $(this).parents('tr').find("td:eq(1)").find(".form-group").addClass('d-none');
            }
            else{
                if($(this).val() === "Yes"){
                    $(this).parents('tr').find("td:eq(1)").find(".form-group").removeClass('d-none');
                }
            }

            if($(this).val() != "Yes"){
                save_answer(monthly_review_id, monthly_review_question_id, question, comment, answer);
            }
        });

        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;   //time in ms, 1 second for example
        $(document).on('keydown', '.comment',function(){
            var element = $(this);
            clearTimeout(typingTimer);
            if ($(element).val) {
                typingTimer = setTimeout(function(){
                    //do stuff here e.g ajax call etc....
                    var monthly_review_id = $('#monthly_review_id').val();
                    var monthly_review_question_id = $(element).parents('tr').find('td:eq(1)').find('input[name=monthly_review_question_id]').val();
                    var question = $(element).parents('tr').find('td:eq(1)').find('input[name=question]').val();
                    var comment = $(element).val();
                    var answer = $(element).parents('tr').find('td:eq(2)').find('option:selected').val();
                    save_answer(monthly_review_id, monthly_review_question_id, question, comment, answer);

                }, doneTypingInterval);
            }
        });

        function save_answer(monthly_review_id, monthly_review_question_id, question, comment = null, answer){

            $.ajax({
                url: "{{route('monthly-review.answer.store')}}",
                type: "post",
                data: {
                    monthly_review_id: monthly_review_id,
                    monthly_review_question_id: monthly_review_question_id,
                    question: question,
                    comment: comment,
                    answer: answer
                },
                success: function (response) {
                    toastr.success('Question saved', 'Success!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                },
                error: function (response) {
                    toastr.error('Question did not save', 'Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
        }


    </script>
@endsection
