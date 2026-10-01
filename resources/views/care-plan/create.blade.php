@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/js/pages/chartist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/style.min.css" rel="stylesheet') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        #amt_chart {
            height: 100%;
            width: 100%;
            min-height: 200px;
        }

        #phq_chart {
            height: 100%;
            width: 100%;
            min-height: 200px;
        }

        .zc-ref {
            display: none;
        }
    </style>
@endsection
@section('breadcrum')
<ol class="breadcrumb p-4">
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('patient.show', ['patient' => $patient, 'type' => 'ccm']) }}" class="inactive">{{$patient->first_name}} {{$patient->last_name}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">Care Plan</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">Create</a>
    </li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body wizard-content">
                    <form class="tab-wizard wizard-circle" id="care_plan_form" action="{{ route('care-plan.store') }}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="patient_id" id="patient_id" value="{{ $patient->id }}">
                        <input type="hidden" name="care_plan_id" id="care_plan_id" value="">
                        <input type="hidden" name="minutes" id="new_minutes" value="">
                        <input type="hidden" name="seconds" id="new_seconds" value="">
                        @foreach ($schemes as $item)
                            @if ($item->id == 5)
                                <h6></h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="medication_name">Medication Name</label>
                                                <input class="form-control form-control-lg" id="medication_name">
                                                <span class="text-danger error-msg d-none"
                                                      id="medication_name_error_msg">Please Enter Medication Name</span>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="dose">Dose</label>

                                                <input class="form-control form-control-lg" id="dose">
                                                <span class="text-danger error-msg d-none" id="dose_error_msg">Please Enter
                                                    Medication Name</span>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="frequency">Frequency</label>

                                                <input class="form-control form-control-lg" id="frequency">
                                                <span class="text-danger error-msg d-none" id="frequency_error_msg">Please
                                                    Enter Medication Name</span>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="route">Route</label>

                                                <input class="form-control form-control-lg" id="route">
                                                <span class="text-danger error-msg d-none" id="route_error_msg">Please Enter
                                                    Medication Name</span>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-md btn-success text-white mt-1"
                                                    id="add_medication_btn" title="Add Medication">
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
                                            </tbody>
                                        </table>
                                    </div>

                                </section>
                            @elseif ($item->id == 7)
                                <h6></h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="full_name">Full Name</label>
                                                <input class="form-control form-control-lg" id="full_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="type">Practice Type</label>
                                                <input class="form-control form-control-lg" id="type">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="address">Practice Address</label>
                                                <input class="form-control form-control-lg" id="address">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_no">Practice Contact no</label>
                                                <input class="form-control form-control-lg" id="contact_no">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-md btn-success text-white mt-1"
                                                    id="add_contact_btn" title="Add Medication">
                                                <i class="ti-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped text-theme w-100" id="contact_table">
                                            <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Practice Type</th>
                                                <th>Practice Address</th>
                                                <th>Practice Contact no</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @elseif ($item->id == 8)
                                <h6></h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="chronic_condition_id">Chronic Condition</label>
                                                <select class="select2 form-control form-control-lg"
                                                        style="width: 100%; height:36px;" id="chronic_condition_id">
                                                    <option value=""></option>
                                                    @foreach ($patient->chronic_conditions as $item)
                                                        <option
                                                            value="{{ $item->id }}">{{ $item->chronic_condition_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="symptom">Symptom</label>
                                                <select class="select2 form-control form-control-lg"
                                                        style="width: 100%; height:36px;" id="symptom">
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="planned_intervention">Planned Intervention</label>
                                                <select class="select2 form-control form-control-lg"
                                                        style="width: 100%; height:36px;" id="planned_intervention">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="person_responsible">Person Responsible</label>
                                                <select class="select2 form-control form-control-lg"
                                                        style="width: 100%; height:36px;" id="person_responsible">
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="time">Time</label>
                                                <select class="select2 form-control form-control-lg"
                                                        style="width: 100%; height:36px;" id="time">
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="desired_outcome">Desired Outcome</label>
                                                <select class="select2 form-control form-control-lg"
                                                        style="width: 100%; height:36px;" id="desired_outcome">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="prognosis">Prognosis</label>
                                                <select class="select2 form-control form-control-lg"
                                                        style="width: 100%; height:36px;" id="prognosis">
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-md btn-success text-white mt-1"
                                                    id="add_planned_intervention_btn" title="Add">
                                                <i class="ti-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped text-theme w-100"
                                               id="planned_intervention_table">
                                            <thead>
                                            <tr>
                                                <th>Chronic Condition</th>
                                                <th>Symptom</th>
                                                <th>Planned Intervention</th>
                                                <th>Person Responsible</th>
                                                <th>Time</th>
                                                <th>Desired Outcome</th>
                                                <th>prognosis</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @elseif ($item->id == 9)
                                <h6></h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label for="full_name">Goal Name:</label>
                                                <select class="select2 form-control" id="goal_name">
                                                    <option value=""></option>
                                                    @foreach ($goals as $item)
                                                        <option value="{{ $item->id }}">{{ $item->goal_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="current">Current</label>
                                                <input class="form-control form-control-lg" id="current">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="goal">Goal:</label>
                                                <input class="form-control form-control-lg" id="goal">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label for="goal">Barrier:</label>
                                                <input class="form-control form-control-lg" id="barrier">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-md btn-success text-white mt-1"
                                                    id="add_goal_btn" title="Add Goal">
                                                <i class="ti-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped text-theme w-100" id="goal_table">
                                            <thead>
                                            <tr>
                                                <th>Goal Name</th>
                                                <th>Current</th>
                                                <th>Goal</th>
                                                <th>Barrier</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @elseif ($item->id == 10)
                                <h6></h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="button" class="btn btn-md btn-success mb-2"
                                                    id="add_screening_btn">Add Non-applicable
                                            </button>
                                            <button type="button" class="btn btn-md btn-danger mb-2 d-none"
                                                    id="remove_screening_btn">Remove Non-applicable
                                            </button>
                                        </div>
                                    </div>
                                    <div id="all_screening">
                                        @forelse ($screenings as $item)
                                            <div class="row p-3 my-4 shadow border" id="screening_{{ $item->id }}">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label for="">Screening Name</label>
                                                        <input type="hidden" name="screening_id"
                                                               value="{{ $item->id }}">
                                                        <input type="text" class="form-control" name="screening_name"
                                                               value="{{ $item->screening_name }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="">Screening Date</label>
                                                        <input type="date" name="screening_date"
                                                               class="form-control screening_date"
                                                               data-id="{{ $item->id }}">

                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <label for="">Comment</label>
                                                        <button type="button" class="btn btn-success"
                                                                onclick="toggle_screening_comment({{ $item->id }})">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="">Age</label>
                                                        @if ($item->custom_age)
                                                            <input type="text" class="form-control"
                                                                   value="{{ $item->custom_age }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control"
                                                                   value="{{ $item->min_age }}-{{ $item->max_age }}"
                                                                   disabled>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="">Duration</label>
                                                        <input type="text" class="form-control"
                                                               value="{{ $item->duration }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="">Gender</label><br>
                                                        @if ($item->gender == 'Both')
                                                            <button type="button" class="btn btn-md btn-success"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Male"><i class="fas fa-male"></i></button>
                                                            <button type="button" class="btn btn-md btn-danger"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Female"><i class="fas fa-female"></i>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                    class="btn btn-md {{ $item->gender == 'Male' ? 'btn-success' : 'btn-danger' }}"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="{{ $item->gender }}"><i
                                                                    class="fas {{ $item->gender == 'Male' ? 'fa-male' : 'fa-female' }}"></i>
                                                            </button>
                                                        @endif

                                                    </div>

                                                </div>

                                                <div class="col-12">
                                                    <input type="checkbox" class="material-inputs screening_answer" name="screening_answer" id="screening_accept_{{ $item->id }}"
                                                           data-id="{{ $item->id }}"/>
                                                    <label for="screening_accept_{{ $item->id }}">Decline</label>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <input type="text"
                                                           class="form-control d-none mt-2 screening_comment"
                                                           name="screening_comment" placeholder="Enter Comment"
                                                           data-id="{{ $item->id }}">
                                                </div>
                                            </div>
                                        @empty
                                            <div class="row p-3 my-4 shadow border">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <h4>No Screening are applicable to this patient</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </section>
                            @elseif ($item->id == 11)
                                <h6></h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="button" class="btn btn-md btn-success mb-2"
                                                    id="add_test_btn">Add Non-applicable
                                            </button>
                                            <button type="button" class="btn btn-md btn-danger mb-2 d-none"
                                                    id="remove_test_btn">Remove Non-applicable
                                            </button>
                                        </div>
                                    </div>
                                    @forelse ($tests as $item)
                                        <div class="row p-3 my-4 shadow border" id="test_{{ $item->id }}">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="">Test Name</label>
                                                    <input type="hidden" name="screening_id"
                                                           value="{{ $item->id }}">
                                                    <input type="hidden" name="test_name"
                                                           value="{{ $item->test_name }}">
                                                    <input type="text" class="form-control"
                                                           value="{{ $item->test_name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="">Test Date</label>
                                                    <input type="date" name="test_date" class="form-control test_date"
                                                           data-id="{{ $item->id }}">

                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <label for="">Comment</label>
                                                    <button type="button" class="btn btn-success"
                                                            onclick="toggle_test_comment({{ $item->id }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="">Age</label>
                                                    @if (!$item->max_age && $item->min_age)
                                                        <input type="text" class="form-control"
                                                               value="{{ $item->min_age }}" disabled>
                                                    @else
                                                        <input type="text" class="form-control"
                                                               value="{{ $item->min_age }}-{{ $item->max_age }}"
                                                               disabled>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="">Duration</label>
                                                    <input type="text" class="form-control"
                                                           value="{{ $item->duration }}" disabled>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="">Gender</label><br>
                                                    @if ($item->gender == 'Both')
                                                        <button type="button" class="btn btn-md btn-success"
                                                                data-toggle="tooltip" data-placement="top" title="Male">
                                                            <i
                                                                class="fas fa-male"></i></button>
                                                        <button type="button" class="btn btn-md btn-danger"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Female"><i
                                                                class="fas fa-female"></i></button>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-md {{ $item->gender == 'Male' ? 'btn-success' : 'btn-danger' }}"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="{{ $item->gender }}"><i
                                                                class="fas {{ $item->gender == 'Male' ? 'fa-male' : 'fa-female' }}"></i>
                                                        </button>
                                                    @endif

                                                </div>

                                            </div>

                                            <div class="col-12">
                                                <input type="checkbox" class="material-inputs test_answer"
                                                       name="test_answer" id="test_accept_{{ $item->id }}"
                                                       data-id="{{ $item->id }}"/>
                                                <label for="test_accept_{{ $item->id }}">Decline</label>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <input type="text" class="form-control d-none mt-2 test_comment"
                                                       name="test_comment" placeholder="Enter Comment"
                                                       data-id="{{ $item->id }}"/>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row p-3 my-4 shadow border">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <h4>No Tests are applicable to this patient</h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </section>
                            @elseif ($item->id == 14)
                                <h6></h6>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @else
                                <h6></h6>
                                <section>
                                    <h3 class="text-success">{{ $item->scheme_name }}</h3>
                                    <span>{{ $item->id }}</span>
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
                                                        <input class="form-control btn-success text-center"
                                                               type="text" value="{{ $sr_no++ }}" disabled>
                                                    </td>
                                                    <td class="question">
                                                        <p class="text-justify mt-2">{{ $question->question }}</p>
                                                        <input type="hidden" name="care_plan_question_id"
                                                               value="{{ $question->id }}">
                                                        <input type="hidden" name="question"
                                                               value="{{ $question->question }}">
                                                        <div class="form-group d-none">
                                                            <label for="">Comment:</label>
                                                            <input type="text" name="comment"
                                                                   class="form-control w-50 required comment"
                                                                   value="" placeholder="Enter Comment....">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($question->input_type == 'select')
                                                            <select class="select2 form-control answer required"
                                                                    name="answer"
                                                                    data-val="{{ $question->screening != null ? $question->screening : '' }}">
                                                                <option></option>
                                                                @foreach ($question->option as $opt)
                                                                    <option value="{{ $opt }}">
                                                                        {{ $opt }}</option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                        @if ($question->input_type == 'input')
                                                            <input class="form-control answer required" name="answer"
                                                                   type="text">
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
    <!-- Timer Modal -->
    <div class="modal fade" id="amt_10_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="row">
                    <div class="col-7">
                        <div class="card-body">
                            <h4>Modified Abbreviated Mental-10 Test (AMT-10)</h4>
                            <p><span class="h4" id="amt_points" class="">10 </span> Points</p>
                            <h4 id="amt_msg">Normal</h4>

                        </div>

                    </div>
                    <div class="col-5 text-right">
                        <div id='amt_chart'></div>

                    </div>
                </div>
                <div class="modal-body" style="height: 300px; overflow:scroll;">
                    <div class="row">
                        <div class="col-12">
                            <table class="table text-theme" id="amt_10_table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4" class="bg-success text-white">Ask Patient</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Patient Age ({{ $patient->age }})</td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Time (To the nearest hour)</td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="bg-success text-white">Give the patient the following
                                        address for recall at the end of test: "42 West street"
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Current Year</td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Patient Home Address</td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>What jobs these people do? (show patient two pictures )</td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Date Of Birth ({{ $patient->dob }})</p>
                                    </td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Year of World War II Started?</p>
                                    </td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Current President?</p>
                                    </td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Count Backwards form 20 to 1</p>
                                    </td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Ask to recall address given earlier? (ie, 42 west street)</p>
                                    </td>
                                    <td>
                                        <select class="form-control amt_question">
                                            <option value="1">Correct</option>
                                            <option value="0">Incorrect</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success amt_answer">1</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="save_amt_btn">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->
    <!-- Timer Modal -->
    <div class="modal fade" id="phq_9_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="row">
                    <div class="col-7">
                        <div class="card-body">
                            <h4>Patient Health Questionnaire-9 Test (PHQ-9)</h4>
                            <p><span class="h4" id="phq_points" class="">10 </span> Points</p>
                            <h4 id="phq_msg">Minimal or None</h4>

                        </div>

                    </div>
                    <div class="col-5 text-right">
                        <div id="phq_chart"></div>

                    </div>
                </div>
                <div class="modal-body" style="height: 300px; overflow:scroll;">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped text-theme" id="phq_9_table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4" class="bg-success text-white">Ask Patient</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Little interest or pleasure in doing things?</td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Feeling Down, depressed or hopeless?</td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Trouble falling or staying asleep or sleeping too much?</td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Feeling tired or having a little energy?</td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Poor appetite or overeating?</td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Feeling bad about yourself - or that you are a failure or have let yourself or
                                        your family down?
                                    </td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Trouble concentrating on things, such as reading the newspaper or watching
                                        television?
                                    </td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Moving or speaking so slowly that other people could have noticed?
                                        Or the opposite - being so fidgety or restless that you have been moving around
                                        a lot more than usual?
                                    </td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Thoughts that you would be better off dead, or of hurting yourself in some way?
                                    </td>
                                    <td>
                                        <select class="form-control phq_question">
                                            <option value="0">Not all</option>
                                            <option value="1">Several days</option>
                                            <option value="2">More than half the days</option>
                                            <option value="3">Nearly every day</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success phq_answer">0</button>
                                    </td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="save_phq_btn">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!-- End -->



    <div class="modal fade" id="edit_medication_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Update Medication</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
                                    <input type="text" class="form-control" id="edit_route">
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
    <div class="modal fade" id="edit_contact_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Update Patient Contact</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="edit_contact_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_full_name">Full Name:</label>
                                    <input type="text" class="form-control" id="edit_full_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_type">Practice Type:</label>
                                    <input type="text" class="form-control" id="edit_type">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_address">Practice Address:</label>
                                    <input type="text" class="form-control" id="edit_address">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_contact_no">Practice Contact No:</label>
                                    <input type="text" class="form-control" id="edit_contact_no">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success" id="update_contact_btn">Save</button>
                                <button type="button" class="btn btn-danger" id="delete_contact_btn">Delete</button>
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
                        <h4>Update Planned Intervention Contact</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="edit_planned_intervention_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_chronic_condition_id">Chronic Condition:</label>
                                    <select type="text" class="select2 form-control" id="edit_chronic_condition_id">
                                        @foreach ($patient->chronic_conditions as $item)
                                            <option value="{{ $item->id }}">{{ $item->chronic_condition_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_symptom">Symptom:</label>
                                    <select type="text" class="select2 form-control" id="edit_symptom">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_planned_intervention">Planned Intervention:</label>
                                    <select type="text" class="select2 form-control" id="edit_planned_intervention">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_person_responsible">Person Responsible:</label>
                                    <select type="text" class="select2 form-control" id="edit_person_responsible">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_time">Time:</label>
                                    <select type="text" class="select2 form-control" id="edit_time">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_desired_outcome">Desired Outcome:</label>
                                    <select type="text" class="select2 form-control" id="edit_desired_outcome">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_prognosis">Prognosis:</label>
                                    <select type="text" class="select2 form-control" id="edit_prognosis">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success"
                                        id="update_planned_intervention_btn">Save
                                </button>
                                <button type="button" class="btn btn-danger"
                                        id="delete_planned_intervention_btn">Delete
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_goal_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Update Treatment Goal</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="edit_treatment_goal_id">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="edit_goal_name">C:</label>
                                    <select class="select2 form-control" id="edit_goal_name">
                                        @foreach ($goals as $item)
                                            <option value="{{ $item->id }}">{{ $item->goal_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_current">Current:</label>
                                    <input type="text" class="form-control" id="edit_current">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="edit_goal">Goal:</label>
                                    <input type="text" class="form-control" id="edit_goal">
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="edit_barrier">Barrier:</label>
                                    <input type="text" class="form-control" id="edit_barrier">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success" id="update_goal_btn">Save</button>
                                <button type="button" class="btn btn-danger" id="delete_goal_btn">Delete</button>
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
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script nonce="undefined" src="https://cdn.zingchart.com/zingchart.min.js"></script>


    <script>
        var amt = 0;
        var phq = 0;
        var new_minutes = 0;
        var new_seconds = 0;
        var last_time = 0;
        var new_time = 0;

        $(document).ready(function () {
            $('#footer').removeClass('d-none');
            $('#timer_option').addClass('d-none');



            var form = $("#care_plan_form").show();

            $("#care_plan_form").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "Finish"
                },

                onStepChanging: function (event, currentIndex, newIndex) {

                    // Allways allow previous action even if the current form is not valid!
                    if (currentIndex > newIndex){
                        return true;
                    }
                    // // Forbid next action on "Warning" step if the user is to young
                    if (currentIndex == 4 && $('#medication_table tbody tr').length < 1){
                        toastr.warning('At Least 1 Medication is required', 'Warning!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        return false;
                    }
                    // Forbid next action on "Warning" step if the user is to young
                    if (currentIndex == 7 && $('#planned_intervention_table tbody tr').length < 2){

                        toastr.warning('At Least 2 Planned Interventions are required', 'Warning!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        return false;
                    }
                    if(currentIndex == 9){//9
                        var applicable_screening = "{{$screenings->count()}}";
                        applicable_screening = parseInt(applicable_screening);
                        var answered_screening = $("#care_plan_form").find("#care_plan_form-p-"+currentIndex).find('.answered').length;
                        var non_applicable_screening = $("#care_plan_form").find("#care_plan_form-p-"+currentIndex).find('.non_applicable_screening').length;
                        var total_screening = applicable_screening+non_applicable_screening;

                        if(total_screening != answered_screening){
                            toastr.warning('Please answer all avaiable screenings', 'Warning!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            return false;

                        }


                    }
                    if(currentIndex == 10){//10
                        var applicable_test = "{{$tests->count()}}";
                        applicable_test = parseInt(applicable_test);
                        var answered_test = $("#care_plan_form").find("#care_plan_form-p-"+currentIndex).find('.answered').length;
                        var non_applicable_test = $("#care_plan_form").find("#care_plan_form-p-"+currentIndex).find('.non_applicable_test').length;
                        var total_test = applicable_test+non_applicable_test;

                        if(total_test != answered_test){
                            toastr.warning('Please answer all avaiable tests', 'Warning!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            return false;

                        }

                    }
                    if (currentIndex < newIndex){
                        // To remove error styles
                        form.find(".body:eq(" + newIndex + ") label.error").remove();
                        form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                    }
                    var currentStep = $("#care_plan_form").find("#care_plan_form-p-"+currentIndex);
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
                    var content = $('#care_plan_form-p-' + priorIndex);
                    var scheme_name = $(content).find('h3').html();
                    var scheme_id = $(content).find('span').html();
                    save_current_step(scheme_id, scheme_name);

                },
                onFinishing: function (event, currentIndex) {
                    return form.validate().settings.ignore = ":disabled,:hidden", form.valid()
                },
                onFinished: function (event, currentIndex) {

                    toastr.success('Patient Care Plan has been created', 'Success!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    var content = $('#care_plan_form-p-' + currentIndex);
                    var scheme_name = $(content).find('h3').html();
                    var scheme_id = $(content).find('span').html();
                    save_current_step(scheme_id, scheme_name);
                    $('#care_plan_form').submit();

                }
            });

            $(".select2").select2({
                placeholder: "Please select an option",
                allowClear: true,
            });
            save_care_plan();

            var patient = "{{ $patient->slug }}";
            var type = "ccm";
            var url = "{{ url('patient/:id/type/:type') }}";
            url = url.replace(':id', patient).replace(':type', type);

            var input = $('<li aria-hidden="false" aria-disabled="false"><a href="' + url +'" role="menuitem">Save & Exit</a></li>');
            input.appendTo($('ul[aria-label=Pagination]'));

            $('#date').flatpickr({
                dateFormat: "m-d-Y"
            });
            $('#edit_date').flatpickr({
                dateFormat: "m-d-Y"
            });
        });


        var myConfig1 = {
            "type": "gauge",
            "scale-r": {
                "aperture": 200,
                "values": "0:10:1",
                "center": {
                    "size": 1,
                    "background-color": "#66CCFF #FFCCFF",
                    "border-color": "none"
                },
                "ring": { //Ring with Rules
                    "size": 7,
                    "rules": [{
                        "rule": "%v >= 0 && %v <= 3",
                        "background-color": "green"
                    },
                        {
                            "rule": "%v >= 4 && %v <= 6",
                            "background-color": "orange"
                        },
                        {
                            "rule": "%v >= 7 && %v <= 10",
                            "background-color": "red"
                        },
                    ]
                }
            },
            "plot": {
                "csize": "4%",
                "size": "100%",
                "background-color": "#000000"
            },
            "series": [{
                "values": [0]
            }]
        };


        zingchart.render({
            id: 'amt_chart',
            data: myConfig1,
            height: "100%",
            width: "100%"
        });

        var myConfig2 = {
            "type": "gauge",
            "scale-r": {
                "aperture": 200,
                "values": "0:27:1",
                "center": {
                    "size": 2,
                    "background-color": "#66CCFF #FFCCFF",
                    "border-color": "none"
                },
                "ring": { //Ring with Rules
                    "size": 7,
                    "rules": [{
                        "rule": "%v >= 0 && %v <= 9",
                        "background-color": "green"
                    },
                        {
                            "rule": "%v >= 10 && %v <= 14",
                            "background-color": "yellow"
                        },
                        {
                            "rule": "%v >= 15 && %v <= 19",
                            "background-color": "orange"
                        },
                        {
                            "rule": "%v >= 20",
                            "background-color": "red"
                        },
                    ]
                }
            },
            "plot": {
                "csize": "3%",
                "size": "100%",
                "background-color": "#000000"
            },
            "series": [{
                "values": [0]
            }]
        };


        zingchart.render({
            id: 'phq_chart',
            data: myConfig2,
            height: "100%",
            width: "100%"
        });

        function save_current_step(care_plan_scheme_id, care_plan_scheme_name) {
            var care_plan_id = $('#care_plan_id').val();

            new_minutes = parseInt($('#minutes').html());
            new_seconds = parseInt($('#seconds').html());
            var new_time = (new_minutes * 60) + new_seconds;

            var diff_time = new_time - last_time;
            diff_minutes = Math.floor(diff_time / 60);
            diff_seconds = diff_time % 60;


            var entry_type = "Automatic";
            var description = "Care Plan: " + care_plan_scheme_name;

            $.ajax({
                url: "{{ route('care-plan.time-track.store') }}",
                type: "post",
                data: {
                    care_plan_id: care_plan_id,
                    care_plan_scheme_id: care_plan_scheme_id,
                    minutes: diff_minutes,
                    seconds: diff_seconds,
                    entry_type: entry_type,
                    description: description,
                },
                success: function (response) {
                    last_time = new_time;
                },
                error: function (response) {
                    console.log('something went wrong');
                    toastr.error('Something went wrong', 'Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            })
        }

        function save_care_plan() {
            $.ajax({
                url: "{{ route('care-plan.store') }}",
                type: "post",
                data: {
                    patient_id: "{{ $patient->id }}"
                },
                success: function (response) {
                    if (response.status == 200) {
                        $('#care_plan_id').val(response.care_plan.id);
                        start_timer();
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

        }


        /**
         * Medication CRUD Start Here
         **/
        $(document).on('click', '#add_medication_btn', function () {
            const patient_id = "{{ $patient->id }}"
            var care_plan_id = $('#care_plan_id').val();
            const medication_name = $('#medication_name').val();
            const dose = $('#dose').val();
            const frequency = $('#frequency').val();
            const route = $('#route').val();

            if (patient_id && care_plan_id && medication_name && dose && frequency && route) {
                $.ajax({
                    url: "{{ route('medication.store') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id,
                        care_plan_id: care_plan_id,
                        medication_name: medication_name,
                        dose: dose,
                        frequency: frequency,
                        route: route
                    },
                    success: function (response) {
                        if (response) {

                            var data = '<tr id="' + response.id + '">' +
                                '<td>' +medication_name +'</td>' +
                                '<td>' +dose +'</td>' +
                                '<td>' +frequency +'</td>' +
                                '<td>' +route +'</td>' +
                                '<td>' +
                                '<button type="button" class="edit_medication_btn btn btn-sm btn-danger text-white mt-1" title="Edit" data-id="' +response.id + '">' +
                                    '<i class="fas fa-pencil-alt"></i>' +
                                '</button>' +
                                '</td>' +
                            '</tr>';
                            var table_body = $('#medication_table tbody');
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
        $(document).on('click', '.edit_medication_btn', function () {
            var element = $(this);
            var id = $(this).data('id');
            var url = "{{ route('medication.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function (response) {
                    $('#edit_medication_id').val(id);

                    $('#edit_medication_name').val(response.medication_name);
                    $('#edit_dose').val(response.dose);
                    $('#edit_frequency').val(response.frequency);
                    $('#edit_route').val(response.route);

                    $('#edit_medication_modal').modal('show');
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
        $(document).on('click', '#update_medication_btn', function () {
            const medication_name = $('#edit_medication_name').val();
            const dose = $('#edit_dose').val();
            const frequency = $('#edit_frequency').val();
            const route = $('#edit_route').val();
            const id = $('#edit_medication_id').val();

            var update_url = "{{ route('medication.update', ':id') }}";
            update_url = update_url.replace(':id', id);
            if (medication_name && dose && frequency && route) {
                $.ajax({
                    url: update_url,
                    type: "put",
                    data: {
                        medication_name: medication_name,
                        dose: dose,
                        frequency: frequency,
                        route: route
                    },
                    success: function (response) {
                        if (response) {
                            var row_no = 1;
                            $('#medication_table').find('#' + response.id).find('td:eq(0)').html(response.medication_name);
                            $('#medication_table').find('#' + response.id).find('td:eq(1)').html(response.dose);
                            $('#medication_table').find('#' + response.id).find('td:eq(2)').html(response.frequency);
                            $('#medication_table').find('#' + response.id).find('td:eq(3)').html(response.route);


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
        $(document).on('click', '#delete_medication_btn', function () {
            const id = $('#edit_medication_id').val();
            var row = $('#medication_table').find('#' + id);
            var delete_url = "{{ route('medication.destroy', ':id') }}";
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
                        $('#edit_medication_modal').modal('hide');
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
        /**
         * Medication CRUD End Here
         **/


        /**
         * Patient Contact CRUD Start Here
         **/
        $(document).on('click', '#add_contact_btn', function () {

            const full_name = $('#full_name').val();
            const type = $('#type').val();
            const address = $('#address').val();
            const contact_no = $('#contact_no').val();
            const care_plan_id = $('#care_plan_id').val();

            if (full_name && type && address && contact_no) {

                $.ajax({
                    url: "{{ route('care-plan.contact.store') }}",
                    type: "post",
                    data: {
                        care_plan_id: care_plan_id,
                        full_name: full_name,
                        type: type,
                        address: address,
                        contact_no: contact_no
                    },
                    success: function (response) {
                        if (response) {

                            var data = '<tr id="' + response.id + '">' +
                                '<td>' +full_name + '</td>' +
                                '<td>' +type + '</td>' +
                                '<td>' +address + '</td>' +
                                '<td>' +contact_no + '</td>' +
                                '<td>' +
                                '<button type="button" class="edit_contact_btn btn btn-sm btn-success text-white mt-1" title="Edit" data-id="' +response.id + '">' +
                                    '<i class="fas fa-pencil-alt"></i>' +
                                '</button>' +
                                '</td>' +
                            '</tr>';
                            var table_body = $('#contact_table tbody');
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
        $(document).on('click', '.edit_contact_btn', function () {

            var element = $(this);
            var id = $(this).data('id');
            var url = "{{ route('care-plan.contact.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function (response) {

                    $('#edit_contact_id').val(id);
                    $('#edit_full_name').val(response.full_name);
                    $('#edit_type').val(response.type);
                    $('#edit_address').val(response.address);
                    $('#edit_contact_no').val(response.contact_no);

                    $('#edit_contact_modal').modal('show');
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
        $(document).on('click', '#update_contact_btn', function () {
            const full_name = $('#edit_full_name').val();
            const type = $('#edit_type').val();
            const address = $('#edit_address').val();
            const contact_no = $('#edit_contact_no').val();
            const id = $('#edit_contact_id').val();

            var update_url = "{{ route('care-plan.contact.update', ':id') }}";
            update_url = update_url.replace(':id', id);
            if (full_name && type && address && contact_no) {
                $.ajax({
                    url: update_url,
                    type: "put",
                    data: {
                        full_name: full_name,
                        type: type,
                        address: address,
                        contact_no: contact_no
                    },
                    success: function (response) {
                        if (response) {
                            var row_no = 1;
                            $('#contact_table').find('#' + response.id).find('td:eq(0)').html(response.full_name);
                            $('#contact_table').find('#' + response.id).find('td:eq(1)').html(response.type);
                            $('#contact_table').find('#' + response.id).find('td:eq(2)').html(response.address);
                            $('#contact_table').find('#' + response.id).find('td:eq(3)').html(response.contact_no);

                            toastr.success('Data has been saved', 'Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                            $('#edit_contact_modal').modal('hide');

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
        $(document).on('click', '#delete_contact_btn', function () {
            const id = $('#edit_contact_id').val();
            var row = $('#contact_table').find('#' + id);
            var delete_url = "{{ route('care-plan.contact.destroy', ':id') }}";
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
                        $('#edit_contact_modal').modal('hide');
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
        /**
         * Patient Contact CRUD End Here
         **/


        /**
         * Chronic Condition CRUD Start Here
         **/
        $(document).on('select2:select', '#chronic_condition_id', function () {
            var chronic_condition_id = $(this).val();
            $.ajax({
                url: "{{ route('selected_chronic_condition') }}",
                type: "post",
                data: {
                    chronic_condition_id: chronic_condition_id
                },
                success: function (response) {
                    if (response) {
                        $('#symptom').empty();
                        $('#planned_intervention').empty();
                        $('#person_responsible').empty();
                        $('#time').empty();
                        $('#desired_outcome').empty();
                        $('#prognosis').empty();

                        var option = "<option></option>"
                        $.each(response, function (index, value) {
                            option += "<option value='" + value.symptom + "'>" + value.symptom +
                                "</option>"
                            $('#symptom').html(option);

                        });

                    }

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
        $(document).on('select2:select', '#symptom', function () {
            var chronic_condition_id = $('#chronic_condition_id').val();
            var symptom = $(this).val();
            $.ajax({
                url: "{{ route('selected_symptom') }}",
                type: "post",
                data: {
                    symptom: symptom,
                    chronic_condition_id: chronic_condition_id
                },
                success: function (response) {
                    if (response) {
                        $('#planned_intervention').empty();
                        $('#person_responsible').empty();
                        $('#time').empty();
                        $('#desired_outcome').empty();
                        $('#prognosis').empty();

                        var option_planned_intervention = ""
                        var option_person_responsible = ""
                        var option_time = ""
                        var option_desired_outcome = ""
                        var option_prognosis = ""
                        $.each(response, function (index, value) {
                            option_planned_intervention += "<option value='" + value
                                    .planned_intervention + "'>" + value.planned_intervention +
                                "</option>"
                            $('#planned_intervention').html(option_planned_intervention);

                            $.each(value.person_responsible, function (i, v) {

                                option_person_responsible += "<option value='" + v +
                                    "'>" + v + "</option>"
                                $('#person_responsible').html(
                                    option_person_responsible);
                            })


                            if (value.time) {
                                option_time += "<option value='" + value.time + "'>" + value
                                    .time + "</option>"
                                $('#time').html(option_time);
                            }
                            if (value.desired_outcome) {

                                option_desired_outcome += "<option value='" + value
                                        .desired_outcome + "'>" + value.desired_outcome +
                                    "</option>"
                                $('#desired_outcome').html(option_desired_outcome);
                            }


                            if (value.prognosis) {

                                option_prognosis += "<option value='" + value.prognosis + "'>" +
                                    value.prognosis + "</option>"
                                $('#prognosis').html(option_prognosis);
                            }
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
        });
        $(document).on('click', '#add_planned_intervention_btn', function () {
            const care_plan_id = $('#care_plan_id').val();
            const chronic_condition_id = $('#chronic_condition_id').val();
            const chronic_condition_name = $("#chronic_condition_id option:selected").text();
            const symptom = $("#symptom option:selected").text();
            const planned_intervention = $("#planned_intervention option:selected").text();
            const person_responsible = $("#person_responsible option:selected").text();
            const time = $("#time option:selected").text();
            const desired_outcome = $("#desired_outcome option:selected").text();
            const prognosis = $("#prognosis option:selected").text();

            if (chronic_condition_id && chronic_condition_name && symptom && planned_intervention &&
                person_responsible && time && desired_outcome && prognosis) {
                $.ajax({
                    url: "{{ route('care-plan.planned-intervention.store') }}",
                    type: "post",
                    data: {
                        care_plan_id: care_plan_id,
                        chronic_condition_id: chronic_condition_id,
                        chronic_condition_name: chronic_condition_name,
                        symptom: symptom,
                        planned_intervention: planned_intervention,
                        person_responsible: person_responsible,
                        time: time,
                        desired_outcome: desired_outcome,
                        prognosis: prognosis
                    },
                    success: function (response) {

                        var data = '<tr id="' + response.id + '">' +
                            '<td>' +chronic_condition_name +'</td>' +
                            '<td>' +symptom +'</td>' +
                            '<td>' +planned_intervention +'</td>' +
                            '<td>' +person_responsible +'</td>' +
                            '<td>' +time +'</td>' +
                            '<td>' +desired_outcome +'</td>' +
                            '<td>' +prognosis +'</td>' +
                            '<td>' +
                                '<button type="button" class="edit_planned_intervention_btn btn btn-sm btn-success text-white mt-1" title="Edit" data-id="' + response.id + '">' +
                                    '<i class="fas fa-pencil-alt"></i>' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
                        var table_body = $('#planned_intervention_table tbody');
                        table_body.append(data);

                        toastr.success('Data has been saved', 'Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });

                        $('#chronic_condition_id').val(null).trigger('change');
                        $('#symptom').empty();
                        $('#planned_intervention').empty();
                        $('#person_responsible').empty();
                        $('#time').empty();
                        $('#desired_outcome').empty();
                        $('#prognosis').empty();

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
        $(document).on('change', '#edit_chronic_condition_id', function () {
            var chronic_condition_id = $(this).val();
            $.ajax({
                url: "{{ route('selected_chronic_condition') }}",
                type: "post",
                data: {
                    chronic_condition_id: chronic_condition_id
                },
                success: function (response) {
                    if (response) {
                        $('#edit_symptom').empty();
                        $('#edit_planned_intervention').empty();
                        $('#edit_person_responsible').empty();
                        $('#edit_time').empty();
                        $('#edit_desired_outcome').empty();
                        $('#edit_prognosis').empty();

                        var option = "<option></option>"
                        $.each(response, function (index, value) {
                            option += "<option value='" + value.symptom + "'>" + value.symptom +
                                "</option>"
                            $('#edit_symptom').html(option);

                        });

                    }

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
        $(document).on('change', '#edit_symptom', function () {
            var chronic_condition_id = $('#edit_chronic_condition_id').val();
            var symptom = $(this).val();
            $.ajax({
                url: "{{ route('selected_symptom') }}",
                type: "post",
                data: {
                    symptom: symptom,
                    chronic_condition_id: chronic_condition_id
                },
                success: function (response) {
                    if (response) {
                        $('#edit_planned_intervention').empty();
                        $('#edit_person_responsible').empty();
                        $('#edit_time').empty();
                        $('#edit_desired_outcome').empty();
                        $('#edit_prognosis').empty();

                        var option_planned_intervention = ""
                        var option_person_responsible = ""
                        var option_time = ""
                        var option_desired_outcome = ""
                        var option_prognosis = ""
                        $.each(response, function (index, value) {
                            option_planned_intervention += "<option value='" + value
                                    .planned_intervention + "'>" + value.planned_intervention +
                                "</option>"
                            $('#edit_planned_intervention').html(option_planned_intervention);

                            $.each(value.person_responsible, function (i, v) {

                                option_person_responsible += "<option value='" + v +
                                    "'>" + v + "</option>"
                                $('#edit_person_responsible').html(
                                    option_person_responsible);
                            })


                            if (value.time) {
                                option_time += "<option value='" + value.time + "'>" + value
                                    .time + "</option>"
                                $('#edit_time').html(option_time);
                            }
                            if (value.desired_outcome) {

                                option_desired_outcome += "<option value='" + value
                                        .desired_outcome + "'>" + value.desired_outcome +
                                    "</option>"
                                $('#edit_desired_outcome').html(option_desired_outcome);
                            }


                            if (value.prognosis) {

                                option_prognosis += "<option value='" + value.prognosis + "'>" +
                                    value.prognosis + "</option>"
                                $('#edit_prognosis').html(option_prognosis);
                            }
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
        });
        $(document).on('click', '.edit_planned_intervention_btn', function () {

            var element = $(this);
            var id = $(this).data('id');
            var url = "{{ route('care-plan.planned-intervention.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function (response) {

                    $('#edit_planned_intervention_id').val(id);
                    $('#edit_chronic_condition_id').val(response.chronic_condition_id).trigger(
                        'change');
                    $('#edit_planned_intervention_modal').modal('show');
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
        $(document).on('click', '#update_planned_intervention_btn', function () {
            const id = $('#edit_planned_intervention_id').val();
            const chronic_condition_id = $('#edit_chronic_condition_id').val();
            const chronic_condition_name = $("#edit_chronic_condition_id option:selected").text();
            const symptom = $("#edit_symptom option:selected").text();
            const planned_intervention = $("#edit_planned_intervention option:selected").text();
            const person_responsible = $("#edit_person_responsible option:selected").text();
            const time = $("#edit_time option:selected").text();
            const desired_outcome = $("#edit_desired_outcome option:selected").text();
            const prognosis = $("#edit_prognosis option:selected").text();

            var update_url = "{{ route('care-plan.planned-intervention.update', ':id') }}";
            update_url = update_url.replace(':id', id);
            if (id && chronic_condition_id && chronic_condition_name && symptom && planned_intervention &&
                person_responsible &&
                time && desired_outcome && prognosis) {
                $.ajax({
                    url: update_url,
                    type: "put",
                    data: {
                        chronic_condition_id: chronic_condition_id,
                        chronic_condition_name: chronic_condition_name,
                        symptom: symptom,
                        planned_intervention: planned_intervention,
                        person_responsible: person_responsible,
                        time: time,
                        desired_outcome: desired_outcome,
                        prognosis: prognosis,
                    },
                    success: function (response) {
                        if (response) {
                            var row_no = 1;
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(0)')
                            .html(response.chronic_condition_name);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(1)')
                                .html(response.symptom);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(2)')
                                .html(response.planned_intervention);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(3)')
                                .html(response.person_responsible);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(4)')
                                .html(response.time);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(5)')
                                .html(response.desired_outcome);
                            $('#planned_intervention_table').find('#' + response.id).find('td:eq(6)')
                                .html(response.prognosis);

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
        $(document).on('click', '#delete_planned_intervention_btn', function () {
            const id = $('#edit_planned_intervention_id').val();
            var row = $('#planned_intervention_table').find('#' + id);
            var delete_url = "{{ route('care-plan.planned-intervention.destroy', ':id') }}";
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
                        $('#edit_contact_modal').modal('hide');
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
        /**
         * Chronic Condition CRUD End Here
         **/


        /**
         * Treatment Goals CRUD Start Here
         **/
        $(document).on('click', '#add_goal_btn', function () {

            const care_plan_id = $('#care_plan_id').val();
            const treatment_goal_id = $('#goal_name').val();
            const goal_name = $("#goal_name option:selected").text();
            const current = $('#current').val();
            const goal = $('#goal').val();
            const barrier = $('#barrier').val();

            if (treatment_goal_id && goal_name && current && goal) {

                $.ajax({
                    url: "{{ route('care-plan.goal.store') }}",
                    type: "post",
                    data: {
                        care_plan_id: care_plan_id,
                        treatment_goal_id: treatment_goal_id,
                        goal_name: goal_name,
                        current: current,
                        goal: goal,
                        barrier: barrier
                    },
                    success: function (response) {
                        if (response) {

                            var data = '<tr id="' + response.id + '">' +
                                '<td>' + goal_name + '</td>' +
                                '<td>' + current + '</td>' +
                                '<td>' + goal + '</td>' +
                                '<td>' + barrier + '</td>' +
                                '<td>' +
                                    '<button type="button" class="edit_goal_btn btn btn-sm btn-success text-white mt-1" title="Edit" data-id="' + response.id + '">' +
                                        '<i class="fas fa-pencil-alt"></i>' +
                                    '</button>' +
                                '</td>' +
                            '</tr>';
                            var table_body = $('#goal_table tbody');
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
        $(document).on('click', '.edit_goal_btn', function () {

            var element = $(this);
            var id = $(this).data('id');
            var url = "{{ route('care-plan.goal.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    "id": id,
                },
                success: function (response) {

                    $('#edit_treatment_goal_id').val(id);
                    $('#edit_goal_name').val(response.goal_name);
                    $('#edit_current').val(response.current);
                    $('#edit_goal').val(response.goal);
                    $('#edit_barrier').val(response.barrier);

                    $('#edit_goal_modal').modal('show');
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
        $(document).on('click', '#update_goal_btn', function () {
            const id = $('#edit_treatment_goal_id').val();
            const treatment_goal_id = $('#edit_goal_name').val();
            const goal_name = $("#edit_goal_name option:selected").text();
            const current = $('#edit_current').val();
            const goal = $('#edit_goal').val();
            const barrier = $('#edit_barrier').val();

            var update_url = "{{ route('care-plan.goal.update', ':id') }}";
            update_url = update_url.replace(':id', id);
            if (treatment_goal_id && goal_name && current && goal) {
                $.ajax({
                    url: update_url,
                    type: "put",
                    data: {
                        treatment_goal_id: treatment_goal_id,
                        goal_name: goal_name,
                        current: current,
                        goal: goal,
                        barrier: barrier
                    },
                    success: function (response) {
                        if (response) {
                            var row_no = 1;
                            $('#goal_table').find('#' + response.id).find('td:eq(0)').html(response.goal_name);
                            $('#goal_table').find('#' + response.id).find('td:eq(1)').html(response.current);
                            $('#goal_table').find('#' + response.id).find('td:eq(2)').html(response.goal);
                            $('#goal_table').find('#' + response.id).find('td:eq(2)').html(response.barrier);


                            toastr.success('Data has been saved', 'Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                            $('#edit_goal_modal').modal('hide');

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
        $(document).on('click', '#delete_goal_btn', function () {
            const id = $('#edit_treatment_goal_id').val();
            var row = $('#goal_table').find('#' + id);
            var delete_url = "{{ route('care-plan.goal.destroy', ':id') }}";
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
                        $('#edit_goal_modal').modal('hide');
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
        /**
         * Treatment Goals CRUD End Here
         **/


        /**
         * Screenung CRUD Start Here
         **/
        $(document).on('click', '.screening_answer', function () {
            var screening_id = $(this).attr('data-id');
            var row = $('#screening_' + screening_id);
            var comment_field = $(row).find('input[name=screening_comment]');

            if ($(this).is(':checked')) {
                $(comment_field).removeClass('d-none');
            } else {
                $(comment_field).addClass('d-none');
            }
        });
        var typingTimer; //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        $(document).on('keydown', '.screening_comment', function () {
            var element = $(this);
            clearTimeout(typingTimer);
            if ($(element).val) {
                typingTimer = setTimeout(function () {
                    //do stuff here e.g ajax call etc....
                    var care_plan_id = $('#care_plan_id').val();
                    var screening_id = $(element).attr('data-id');
                    var row = $('#screening_' + screening_id);

                    var screening_name = $(row).find('input[name=screening_name]').val();
                    var date = $(row).find('input[name=screening_date]').val();
                    var comment = $(element).val();
                    var answer = "Accept";
                    if ($(row).find('input[name=screening_answer]').is(':checked')) {
                        answer = "Decline";
                    }

                    save_screening(care_plan_id, screening_id, screening_name, date, answer, comment);

                }, doneTypingInterval);
            }
        });
        $(document).on('change', '.screening_date', function () {
            var element = $(this);
            if ($(element).val) {
                var care_plan_id = $('#care_plan_id').val();
                var screening_id = $(element).attr('data-id');
                var row = $('#screening_' + screening_id);


                var screening_name = $(row).find('input[name=screening_name]').val();
                var date = $(element).val();

                var answer = "Accept";
                var comment = $(row).find('input[name=screening_comment]').val();

                save_screening(care_plan_id, screening_id, screening_name, date, answer, comment);
            }
        });

        function toggle_screening_comment(id) {
            var row = $('#screening_' + id);
            var comment_field = $(row).find('input[name=screening_comment]');
            $(comment_field).toggleClass('d-none');
        }

        function save_screening(care_plan_id, screening_id, screening_name, date, answer, comment) {
            $.ajax({
                url: "{{ route('care-plan.screening.store') }}",
                type: "post",
                data: {
                    care_plan_id: care_plan_id,
                    screening_id: screening_id,
                    screening_name: screening_name,
                    date: date,
                    answer: answer,
                    comment: comment,

                },
                success: function (response) {
                    toastr.success('Data has been saved', 'Success!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });

                    var row = $('#screening_' + screening_id);
                    if(!$(row).hasClass('answered')){
                        $(row).addClass('answered');
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
        }

        $(document).on('click', '#add_screening_btn', function () {
            $.ajax({
                url: "{{ route('non_application_screening') }}",
                tpye: "get",
                data: {
                    id: "{{ $patient->id }}"
                },
                success: function (response) {
                    $('#add_screening_btn').addClass('d-none');
                    $('#remove_screening_btn').removeClass('d-none');
                    $.each(response, function (index, value) {
                        var age = "{{ $patient->age }}";
                        var gender = "{{ $patient->gender }}";
                        var gender_line = "";
                        var age_line = "";
                        if (!value.max_age && value.min_age) {
                            age_line = '<input type="text" class="form-control" value="' + value
                                .min_age + '" disabled>';
                        } else {
                            age_line = '<input type="text" class="form-control" value="' + value
                                .min_age + '-' + value.max_age + '" disabled>';

                        }
                        if (value.gender == gender || value.gender == "Both") {
                            if ((age >= value.min_age || value.min_age == null) && (age <= value
                                .max_age || value.max_age == null)) {
                                return;
                            }
                        }

                        if (value.gender == "Both") {
                            gender_line = '<div>' +
                                '<button type="button" class="btn btn-success mr-1" data-toggle="tooltip" data-placement="top" title="Male"><i class="fas fa-male"></i></button>' +
                                '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Female"><i class="fas fa-female"></i></button>' +
                                '</div>';
                        } else {
                            var icon = value.gender.toLowerCase();
                            var btn_class = "btn-success";
                            if (value.gender == "Female") {
                                btn_class = "btn-danger";
                            }
                            gender_line = '<div>' +
                                '<button type="button" class="btn ' + btn_class +
                                '" data-toggle="tooltip" data-placement="top" title="' + value
                                    .gender + '"><i class="fas fa-' + icon + '"></i></button>' +
                                '</div>';
                        }
                        var data =
                            '<div class="row p-3 my-4 shadow border non_applicable_screening" id="screening_' +value.id + '">' +
                                '<div class="col-3">' +
                                    '<div class="form-group">' +
                                        '<label for="">Screening Name</label>' +
                                        '<input type="hidden" name="screening_id" value="' + value.id +'">' +
                                        '<input type="text" class="form-control" name="screening_name" value="' + value.screening_name + '" disabled>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-2">' +
                                    '<div class="form-group">' +
                                        '<label for="">Screening Date</label>' +
                                        '<input type="date" name="screening_date" class="form-control screening_date" data-id="' +value.id + '" >' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-1">' +
                                    '<div class="form-group">' +
                                        '<label for="">Comment</label>' +
                                        '<button type="button" class="btn btn-success" onclick="toggle_screening_comment('+value.id+')">' +
                                            '<i class="fas fa-plus"></i>' +
                                        '</button>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-2">' +
                                    '<div class="form-group">' +
                                        '<label for="">Age</label>' +'' + age_line + '' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-2">' +
                                    '<div class="form-group">' +
                                        '<label for="">Duration</label>' +
                                        '<input type="text" class="form-control" value="' + value.duration +'" disabled>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-2">' +
                                    '<div class="form-group">' +
                                        '<label for="">Gender</label>'+
                                        gender_line+
                                    '</div>' +
                                '</div>' +
                                '<div class="col-12">' +
                                    '<input type="checkbox" class="material-inputs screening_answer" name="screening_answer" id="screening_accept_' +value.id + '" data-id="' + value.id + '"/>' +
                                    '<label for="screening_accept_' + value.id + '">Decline</label>'+
                                '</div>' +
                                '<div class="col-12 mt-2">' +
                                    '<input type="text" name="screening_comment" class="form-control d-none mt-2 screening_comment" placeholder="Enter Comment" data-id="' + value.id + '"/>' +
                                '</div>' +
                            '</div>';
                        var table_body = $('#all_screening');
                        table_body.append(data);
                    });


                },
                error: function () {

                }
            });
        });
        $(document).on('click', '#remove_screening_btn', function () {
            $(".non_applicable_screening").remove();
            $('#add_screening_btn').removeClass('d-none');
            $('#remove_screening_btn').addClass('d-none');
        });
        /**
         * Screening CRUD End Here
         **/


        /**
         * Test CRUD Start Here
         **/
        $(document).on('click', '.test_answer', function () {
            var test_id = $(this).attr('data-id');
            var row = $('#test_' + test_id);
            var comment_field = $(row).find('input[name=test_comment]');

            if ($(this).is(':checked')) {
                $(comment_field).removeClass('d-none');
            } else {
                $(comment_field).addClass('d-none');
            }

        });
        var typingTimer; //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        $(document).on('keydown', '.test_comment', function () {
            var element = $(this);
            clearTimeout(typingTimer);
            if ($(element).val) {
                typingTimer = setTimeout(function () {
                    //do stuff here e.g ajax call etc....
                    var care_plan_id = $('#care_plan_id').val();
                    var test_id = $(element).attr('data-id');
                    var row = $('#test_' + test_id);

                    var test_name = $(row).find('input[name=test_name]').val();
                    var date = $(row).find('input[name=test_date]').val();
                    var comment = $(element).val();
                    var answer = "Accept";
                    if ($(row).find('input[name=test_answer]').is(':checked')) {
                        answer = "Decline";
                    }

                    save_test(care_plan_id, test_id, test_name, date, answer, comment);

                }, doneTypingInterval);
            }
        });
        $(document).on('change', '.test_date', function () {
            var element = $(this);
            if ($(element).val) {
                var care_plan_id = $('#care_plan_id').val();
                var test_id = $(element).attr('data-id');
                var row = $('#test_' + test_id);

                var test_name = $(row).find('input[name=test_name]').val();
                var date = $(element).val();
                var answer = "Accept";
                var comment = $(row).find('input[name=test_comment]').val();

                save_test(care_plan_id, test_id, test_name, date, answer, comment);
            }
        });


        function toggle_test_comment(id) {
            var row = $('#test_' + id);
            var comment_field = $(row).find('input[name=test_comment]');
            $(comment_field).toggleClass('d-none');
        }

        function save_test(care_plan_id, test_id, test_name, date, answer, comment) {
            $.ajax({
                url: "{{ route('care-plan.test.store') }}",
                type: "post",
                data: {
                    care_plan_id: care_plan_id,
                    test_id: test_id,
                    test_name: test_name,
                    date: date,
                    answer: answer,
                    comment: comment,

                },
                success: function (response) {
                    toastr.success('Data has been saved', 'Success!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    var row = $('#test_' + test_id);
                    if(!$(row).hasClass('answered')){
                        $(row).addClass('answered');
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
        }

        $(document).on('click', '#add_test_btn', function () {
            $.ajax({
                url: "{{ route('non_application_test') }}",
                tpye: "get",
                data: {
                    id: "{{ $patient->id }}"
                },
                success: function (response) {
                    $('#add_test_btn').addClass('d-none');
                    $('#remove_test_btn').removeClass('d-none');
                    $.each(response, function (index, value) {
                        var age = "{{ $patient->age }}";
                        var gender = "{{ $patient->gender }}";
                        var gender_line = "";
                        var age_line = "";

                        if (value.gender == gender || value.gender == "Both") {
                            if ((age >= value.min_age || value.min_age == null) && (age <= value
                                .max_age || value.max_age == null)) {

                                return;
                            }
                        }

                        if (value.gender == "Both") {
                            gender_line = '<div>' +
                                '<button type="button" class="btn btn-success mr-1" data-toggle="tooltip" data-placement="top" title="Male"><i class="fas fa-male"></i></button>' +
                                '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Female"><i class="fas fa-female"></i></button>' +
                                '</div>';
                        } else {
                            var icon = value.gender.toLowerCase();
                            var btn_class = "btn-success";
                            if (value.gender == "Female") {
                                btn_class = "btn-danger";
                            }
                            gender_line = '<div>' +
                                '<button type="button" class="btn ' + btn_class +
                                '" data-toggle="tooltip" data-placement="top" title="' + value
                                    .gender + '"><i class="fas fa-' + icon + '"></i></button>' +
                                '</div>';
                        }

                        if (!value.max_age && value.min_age) {
                            var age_line = '<input type="text" class="form-control" value="' +
                                value.min_age + '" disabled>';
                        } else {
                            var age_line = '<input type="text" class="form-control" value="' +
                                value.min_age + '-' + value.max_age + '" disabled>';
                        }
                        var data ='<div class="row p-3 my-4 shadow border non_applicable_test" id="test_' +value.id + '">' +
                            '<div class="col-3">' +
                                '<div class="form-group">' +
                                    '<label for="">Test Name</label>' +
                                    '<input type="hidden" name="test_id" value="' + value.id + '">' +
                                    '<input type="text" class="form-control" name="test_name" value="' + value.test_name + '" disabled>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-2">' +
                                '<div class="form-group">' +
                                    '<label for="">Test Date</label>' +
                                    '<input type="date" name="test_date" class="form-control test_date" data-id="' + value.id + '" >' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-1">' +
                                '<div class="form-group">' +
                                    '<label for="">Comment</label>' +
                                    '<button type="button" class="btn btn-success" onclick="toggle_test_comment(' +value.id + ')">' +
                                        '<i class="fas fa-plus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-2">' +
                                '<div class="form-group">' +
                                    '<label for="">Age</label>' +'' + age_line + '' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-2">' +
                                '<div class="form-group">' +
                                    '<label for="">Duration</label>' +
                                    '<input type="text" class="form-control" value="' + value.duration +'" disabled>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-2">' +
                                '<div class="form-group">' +
                                    '<label for="">Gender</label>'+
                                    gender_line+
                                '</div>' +
                            '</div>' +
                            '<div class="col-12">' +
                                '<input type="checkbox" class="material-inputs test_answer" name="test_answer" id="test_accept_' +value.id + '" data-id="' + value.id + '" />' +
                                '<label for="test_accept_' + value.id + '">Decline</label>'
                            '</div>' +
                            '<div class="col-12 mt-2">' +
                                '<input type="text" name="test_comment" class="form-control d-none mt-2 test_comment" placeholder="Enter Comment" data-id="' + value.id + '" />' +
                            '</div>' +
                        '</div>';
                        var table_body = $('#all_test');
                        table_body.append(data);
                    });

                },
                error: function () {
                    console.log('something went wrong');

                }
            });
        });
        $(document).on('click', '#remove_test_btn', function () {
            $(".non_applicable_test").remove();
            $('#add_test_btn').removeClass('d-none');
            $('#remove_test_btn').addClass('d-none');
        });
        /**
         * Test CRUD End Here
        **/



        /**
         * Note Crud Start Here
         * */
        $(document).on('click', '#add_note_btn', function () {
            var care_plan_id = $('#care_plan_id').val();
            const date = $('#date').val();
            const note = $('#note').val();

            if (care_plan_id && date && note) {

                $.ajax({
                    url: "{{ route('note.store') }}",
                    type: "post",
                    data: {
                        care_plan_id: care_plan_id,
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


        var typingTimer; //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        $(document).on('keydown', '.answer', function () {
            var element = $(this);
            clearTimeout(typingTimer);
            if ($(element).val) {
                typingTimer = setTimeout(function () {
                    //do stuff here e.g ajax call etc....
                    var care_plan_id = $('#care_plan_id').val();
                    var care_plan_question_id = $(element).parents('tr').find('td:eq(1)').find(
                        'input[name=care_plan_question_id]').val();
                    var question = $(element).parents('tr').find('td:eq(1)').find('input[name=question]')
                        .val();
                    var comment = null;
                    var answer = $(element).val();
                    save_answer(care_plan_id, care_plan_question_id, question, comment, answer);

                }, doneTypingInterval);
            }
        });

        $(document).on('select2:select', '.answer', function () {
            var care_plan_id = $('#care_plan_id').val();
            var care_plan_question_id = $(this).parents('tr').find('td:eq(1)').find(
                'input[name=care_plan_question_id]').val();
            var question = $(this).parents('tr').find('td:eq(1)').find('input[name=question]').val();
            var comment = null;
            var answer = $(this).val();

            if ($(this).val() === "No" || $(this).val() === "Not at all") {
                $(this).parents('tr').find("td:eq(1)").find(".form-group").addClass('d-none');
                $(this).parents('tr').find("td:eq(1)").find("label").remove();
                amt = 0;
                phq = 0;
            } else {
                if ($(this).attr("data-val") == "AMT-10") {
                    amt++;
                    if (amt == 2) {
                        $('#amt_10_modal').modal('show');
                    }

                }
                if ($(this).attr('data-val') == "PHQ-9") {
                    phq++;
                    if (phq == 2) {
                        $('#phq_9_modal').modal('show');
                    }
                }
                if ($(this).val() === "Yes") {
                    $(this).parents('tr').find("td:eq(1)").find(".form-group").removeClass('d-none');
                }
            }
            if ($(this).val() != "Yes") {
                save_answer(care_plan_id, care_plan_question_id, question, comment, answer);
            }
        });
        var typingTimer; //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        $(document).on('keydown', '.comment', function () {
            var element = $(this);
            clearTimeout(typingTimer);
            if ($(element).val) {
                typingTimer = setTimeout(function () {
                    //do stuff here e.g ajax call etc....
                    var care_plan_id = $('#care_plan_id').val();
                    var care_plan_question_id = $(element).parents('tr').find('td:eq(1)').find(
                        'input[name=care_plan_question_id]').val();
                    var question = $(element).parents('tr').find('td:eq(1)').find('input[name=question]')
                        .val();
                    var comment = $(element).val();
                    var answer = $(element).parents('tr').find('td:eq(2)').find('option:selected').val();
                    save_answer(care_plan_id, care_plan_question_id, question, comment, answer);

                }, doneTypingInterval);
            }
        });

        function save_answer(care_plan_id, care_plan_question_id, question, comment = null, answer) {

            $.ajax({
                url: "{{ route('care-plan.answer.store') }}",
                type: "post",
                data: {
                    care_plan_id: care_plan_id,
                    care_plan_question_id: care_plan_question_id,
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


        $(document).on('change', '.amt_question', function () {
            var msg = "Normal";
            var chart_data = 10;
            var sum = 0;
            var point = $(this).val();
            $(this).parents('tr').find("td:eq(3)").find(".amt_answer").html(point);

            $('#amt_10_table > tbody  > tr').each(function () {
                var total = parseFloat($(this).find('.amt_answer').html() || 0, 10);
                sum += total;
            });

            if (sum >= 4 && sum < 7) {
                msg = "Moderate Cognitive Impairment";

            }
            if (sum < 4) {
                msg = "Severe Cognitive Impairment";

            }

            $('#amt_points').html(sum);
            $('#amt_msg').html(msg);
            chart_data -= sum;
            zingchart.exec('amt_chart', 'setseriesvalues', {
                plotindex: 0,
                values: [chart_data]
            });
        });
        $(document).on('change', '.phq_question', function () {
            var msg = "Minimal or None";
            var sum = 0;


            var point = $(this).val();
            $(this).parents('tr').find("td:eq(3)").find(".phq_answer").html(point);

            $('#phq_9_table > tbody  > tr').each(function () {
                var total = parseFloat($(this).find('.phq_answer').html() || 0, 10);

                sum += total;
            });

            if (sum >= 4 && sum <= 9) {
                msg = "Mild Depression";
            }
            if (sum >= 10 && sum <= 14) {
                msg = "Moderate Depression";

            }
            if (sum >= 15 && sum <= 19) {
                msg = "Moderately Severe Depression";
            }
            if (sum >= 20) {
                msg = "Severe Depression";
            }

            $('#phq_points').html(sum);
            $('#phq_msg').html(msg);
            zingchart.exec('phq_chart', 'setseriesvalues', {
                plotindex: 0,
                values: [sum]
            });
        });
        $(document).on('click', '#save_amt_btn', function () {
            var care_plan_id = $('#care_plan_id').val();
            var screening_name = "AMT-10";
            var points = $('#amt_points').html();
            var screening_description = $('#amt_msg').html();
            save_special_screening(care_plan_id, screening_name, points, screening_description);
            $('#amt_10_modal').modal('hide');

        });
        $(document).on('click', '#save_phq_btn', function () {
            var care_plan_id = $('#care_plan_id').val();
            var screening_name = "PHQ-9";
            var points = $('#phq_points').html();
            var screening_description = $('#phq_msg').html();
            save_special_screening(care_plan_id, screening_name, points, screening_description);
            $('#phq_9_modal').modal('hide');
        });

        function save_special_screening(care_plan_id, screening_name, points, screening_description) {
            $.ajax({
                url: "{{ route('care-plan.special-screening.store') }}",
                type: "post",
                data: {
                    care_plan_id: care_plan_id,
                    screening_name: screening_name,
                    points: points,
                    screening_description: screening_description,
                },
                success: function (response) {
                    if (response) {
                        toastr.success('Data has been saved', 'Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                },
                error: function () {
                    toastr.error('Something went wrong', 'Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
        }
    </script>
@endsection
