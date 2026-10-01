@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        #device_spinner {
            position: absolute;
            left: 50%;
            top: 50%;
        }

        .dataTables_scroll {
            overflow: auto;
        }
    </style>
@endsection
@section('breadcrum')
    <ol class="breadcrumb p-4">
        <li class="breadcrumb-item font-weight-bold">
            <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
        </li>
        <li class="breadcrumb-item font-weight-bold">
            <a href="#" class="inactive">Patient</a>
        </li>
        <li class="breadcrumb-item font-weight-bold">
            <a href="#" class="inactive">{{ $patient->first_name }} {{ $patient->last_name }}</a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3 col-xlg-3 col-md-5">
            <div class="card" style="height:700px;overflow-y:scroll;">
                <div class="card-body">
                    <center class="mt-4">
                        <img src="{{ $patient->patient_image }}" class="rounded-circle" width="150" />
                        <h4 class="card-title">{{ $patient->first_name }} {{ $patient->last_name }}</h4>
                        <h6 class="card-subtitle">{{ $patient->gender }}</h6>
                        <h6 class="card-subtitle">Age - {{ $patient->age }}</h6>
                    </center>
                </div>

                <div class="card-body">
                    @if ($type !== 'unenrolled_patient')
                    <div class="btn-list text-center">
                        @can('update_patient')
                            <a class="btn btn-sm btn-outline-success" href="{{ route('patient.edit', $patient) }}"
                                data-toggle="tooltip" data-placement="top" title="Edit Patient"><i
                                    class="fa fa-pencil-alt"></i></a>
                        @endcan
                       @can('unenrolled_patient')
                                <!-- CCM Un-Enrollment -->
                                @if ($patient->enrol_in_ccm)
                                    <button class="btn btn-sm btn-outline-warning" type="button" data-toggle="modal"
                                        data-target="#unenrollPatientModal" data-toggle="tooltip" data-placement="top"
                                        title="Un-Enroll CCM Patient" data-enrollment-type="ccm">
                                        <i class="ti-trash"></i>
                                    </button>
                                @endif

                                <!-- RPM Un-Enrollment -->
                                @if ($patient->enrol_in_rpm)
                                    <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal"
                                        data-target="#unenrollPatientModal" data-toggle="tooltip" data-placement="top"
                                        title="Un-Enroll RPM Patient" data-enrollment-type="rpm">
                                        <i class="ti-trash"></i>
                                    </button>
                                @endif

                                <!-- Both CCM and RPM Un-Enrollment -->
                                @if ($patient->enrol_in_ccm && $patient->enrol_in_rpm)
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="modal"
                                        data-target="#unenrollPatientModal" data-toggle="tooltip" data-placement="top"
                                        title="Un-Enroll from Both CCM and RPM" data-enrollment-type="both">
                                        <i class="ti-trash"></i>
                                    </button>
                                @endif
                            @endcan
                        @can('delete_patient')
                            <button class="btn btn-sm btn-outline-danger" type="button"
                                onclick="event.preventDefault();
                                document.getElementById('delete_patient_form').submit();"
                                data-toggle="tooltip" data-placement="top" title="Delete Patient">
                                <i class="ti-trash"></i>
                            </button>
                        @endcan
                            @can('unenrolled_patient')
                                {{-- <form action="{{ route('patient.unenrolled', $patient) }}" method="post"
                                    id="unenrolled_patient_form">
                                    @csrf
                                </form> --}}
                                <!-- Modal -->
                              <div class="modal fade" id="unenrollPatientModal" tabindex="-1" role="dialog"
                                    aria-labelledby="unenrollPatientModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="unenrollPatientModalLabel">Un-Enroll Patient</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('patient.unenrolled', $patient) }}" method="post"
                                                    id="unenrolled_patient_form">
                                                    @csrf
                                                    <input type="hidden" name="enrollment_type" id="enrollment_type">
                                                    <div class="form-group">
                                                        <label for="un_enrolled_note"
                                                            style="display: block; text-align: left; margin-bottom: 0.5rem;">Note:</label>
                                                        <textarea class="form-control" name="un_enrolled_note" id="un_enrolled_note" rows="3"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer" style="display: block; text-align: right;">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger"
                                                    form="unenrolled_patient_form">Un-Enroll</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        @can('delete_patient')
                            <form action="{{ route('patient.destroy', $patient) }}" method="post" id="delete_patient_form">
                                @csrf
                                @method('delete')
                            </form>
                        @endcan
                    </div>
                    @if ($patient->enrol_in_ccm && $patient->enrol_in_rpm)
                        <div class="text-center mt-2">
                            @if ($type == 'ccm')
                                <a href="{{ route('patient.show', ['patient' => $patient, 'type' => 'rpm']) }}"
                                    class="btn btn-sm btn-danger ">Switch To RPM</a>
                            @else
                                <a href="{{ route('patient.show', ['patient' => $patient, 'type' => 'ccm']) }}"
                                    class="btn btn-sm btn-danger ">Switch To CCM</a>
                            @endif

                        </div>
                    @endif
                    @else
                        <div class="btn-list text-center">
                            <strong>Un-Enrolled Patient</strong>
                        </div>
                    @endif
                    <div>
                        <hr>
                    </div>
                    <small class="text-muted">Email address </small>
                    <h6>{{ $patient->email }}</h6>
                    <small class="text-muted">Contact No</small>
                    <h6>{{ $patient->contact_no }}</h6>
                    <small class="text-muted">Address</small>
                    <h6>{{ $patient->address }}</h6>
                    <small>Prefered Communication</small>
                    <h6>{{ $patient->preferred_communication }}</h6>
                    <small>Prefered Language</small>
                    <h6>{{ $patient->preferred_language }}</h6>
                    <small>Prefered Time</small>
                    <h6>{{ $patient->preferred_time }}</h6>
                    @if ($type == 'ccm')
                        <small>Enrol In CCM</small><span class="badge badge-danger ml-2">{{ $patient->ccm_type }}</span>
                        <h6>
                            {{ $patient->formatted_ccm_enrol_date }}
                        </h6>
                        <small>CPT Codes</small>
                        <h6>
                            @foreach ($patient->current_ccm_codes as $item)
                                <span class="badge badge-danger mb-1">{{ $item->code }}</span>
                            @endforeach
                        </h6>
                    @else
                        <small>Enrol In RPM</small>
                        <h6>
                            {{ $patient->formatted_rpm_enrol_date }}
                        </h6>
                        <small>Total Time (current month)</small>
                        <h6>
                            {{ current_month_time($patient->id) }} Min
                        </h6>
                    @endif



                </div>
            </div>
        </div>
        <div class="col-lg-9 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    @if ($type == 'ccm')
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="height:635px;overflow-y:scroll;">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                                            @can('crud_care_plan')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#care_plan_tab"
                                                        role="tab">Care Plan</a>
                                                </li>
                                            @endcan
                                            @can('crud_monthly_review')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#monthly_review_tab"
                                                        role="tab">Monthly Review</a>
                                                </li>
                                            @endcan
                                            @can('create_message')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#message_tab"
                                                        role="tab">Message</a>
                                                </li>
                                            @endcan
                                            @can('read_medication')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#medication_tab"
                                                        role="tab">Medication</a>
                                                </li>
                                            @endcan
                                            @can('read_patient_data')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#note_tab"
                                                        role="tab">Notes</a>
                                                </li>
                                            @endcan
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            @can('crud_care_plan')
                                                <div class="tab-pane fade" id="care_plan_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    <div class="row">
                                                        <div class="col-6">

                                                        </div>
                                                        <div></div>
                                                        <div class="col-12">
                                                            <h3>Patient Care Plan</h3>
                                                            @if ($patient->care_plan)
                                                                <small
                                                                    class="badge badge-danger p-2">{{ $patient->care_plan->status }}</small>
                                                                <small class="badge badge-danger p-2">
                                                                    {{ $patient->care_plan->minutes }} :
                                                                    {{ $patient->care_plan->seconds }} minutes
                                                                </small>
                                                                @if ($patient->care_plan->status == 'Complete' || $patient->care_plan->status == 'Awaiting Approval')
                                                                    @can('approve_care_plan')
                                                                        <form action="{{ route('care-plan.approve') }}"
                                                                            method="post" class="mt-2">
                                                                            @csrf
                                                                            <input type="hidden" name="care_plan_id"
                                                                                value="{{ $patient->care_plan->id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-md btn-danger">Approve</button>
                                                                        </form>
                                                                    @endcan
                                                                    <button type="button" class="btn btn-success mt-3"
                                                                        id="care_plan_notes">Send For
                                                                        Approval</button>

                                                                @endif
                                                                <div class="mt-3">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Completed At</th>
                                                                                <th>Created By</th>
                                                                                <th>Approved At</th>
                                                                                <th>Approved By</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>{{ $patient->care_plan->formatted_completed_at }}
                                                                                </td>
                                                                                <td>{{ $patient->care_plan->care_plan_created_by->user_name }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($patient->care_plan->status == 'Approved')
                                                                                        {{ $patient->care_plan->formatted_approved_at }}
                                                                                    @else
                                                                                        -
                                                                                    @endif
                                                                                </td>

                                                                                <td>
                                                                                    @if ($patient->care_plan->status == 'Approved')
                                                                                        {{ $patient->care_plan->care_plan_approved_by->user_name }}
                                                                                    @else
                                                                                        -
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                                <a class="btn btn-success mr-1 " type="button"
                                                                    href="{{ route('care-plan.time-track.index', $patient->care_plan) }}">View
                                                                    Logs</a>
                                                                <a class="btn btn-success mr-1" type="button"
                                                                    href="{{ route('care-plan.edit', $patient->care_plan) }}">Edit
                                                                    Care Plan</a>
                                                                <a class="btn btn-success mr-1" type="button"
                                                                    href="{{ route('care-plan.show', $patient->care_plan) }}">Show
                                                                    Care Plan</a>
                                                            @else
                                                                <p><span class="badge badge-danger">Patient Care Plan Does Not
                                                                        Exist</span></p>
                                                                <hr>
                                                                <a class="btn btn-success"
                                                                    href="{{ route('care-plan.create', ['patient' => $patient]) }}"
                                                                    type="button">Create New Care Plan</a>
                                                            @endif
                                                            <a class="btn btn-success mr-1" type="button"
                                                                href="{{ route('care-plan.history', $patient) }}">History</a>

                                                        </div>

                                                    </div>
                                                </div>
                                            @endcan
                                            @can('crud_monthly_review')
                                                <div class="tab-pane fade" id="monthly_review_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h3>Monthly Review</h3>
                                                            @if ($patient->care_plan)
                                                                @if ($patient->care_plan->status == 'Approved')
                                                                    @if ($patient->monthly_review)
                                                                        <small
                                                                            class="badge badge-danger p-2">{{ $patient->monthly_review->status }}</small>
                                                                        <small
                                                                            class="badge badge-danger p-2">{{ $patient->monthly_review->minutes }}
                                                                            : {{ $patient->monthly_review->seconds }}
                                                                            minutes</small>
                                                                        <div class="mt-3">
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Completed At</th>
                                                                                        <th>Created By</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>{{ $patient->monthly_review->formatted_completed_at }}
                                                                                        </td>
                                                                                        <td>{{ $patient->monthly_review->monthly_review_created_by->user_name }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                        <a class="btn btn-success mr-1 " type="button"
                                                                            href="{{ route('monthly-review.time-track.index', $patient->monthly_review) }}">View
                                                                            Logs</a>
                                                                        <a class="btn btn-success mr-1" type="button"
                                                                            href="{{ route('monthly-review.edit', $patient->monthly_review) }}">Edit
                                                                            Monthly Review</a>
                                                                        <a class="btn btn-success mr-1" type="button"
                                                                            href="{{ route('monthly-review.show', $patient->monthly_review) }}">Show
                                                                            Monthly Review</a>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                            <a class="btn btn-success mr-1" type="button"
                                                                href="{{ route('monthly-review.create', $patient) }}">Create
                                                                Monthly Review</a>
                                                            <a class="btn btn-success mr-1" type="button"
                                                                href="{{ route('monthly-review.history', $patient) }}">History</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('create_message')
                                                <div class="tab-pane fade" id="message_tab" role="tabpanel"
                                                    aria-labelledby="pills-profile-tab">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">Ph No#</label>
                                                                <input type="text" class="form-control py-4 w-lg-50 w-100"
                                                                    value="{{ $patient->contact_no }}" id="to">
                                                                <label class="mt-3 font-weight-bold">Text Message</label>
                                                                <textarea rows="5" class="form-control" id="msg" placeholder="Please type your message" required=""></textarea>
                                                                <div class="btn-group mt-3">
                                                                    <button class="btn btn-success mr-1" id="send_msg_btn">
                                                                        <i class="fa fa-comment d-lg-none d-display"></i>
                                                                        <span class="d-lg-block d-none">Send Message</span>
                                                                    </button>
                                                                    <button class="btn btn-success mx-1" id="send_voice_btn">
                                                                        <i class="fa fa-microphone d-lg-none d-display"></i>
                                                                        <span class="d-lg-block d-none">Voice Message</span>
                                                                    </button>
                                                                    <button class="btn btn-success mx-1" id="send_both_btn">
                                                                        <span>Both</span>
                                                                    </button>
                                                                    <div class="ml-2 spinner-border text-success d-none"
                                                                        role="status" style="width: 2rem; height: 2rem;"
                                                                        id="message_spinner">
                                                                        <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('read_medication')
                                                <div class="tab-pane fade" id="medication_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    @can('crud_medication')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_medication_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan
                                                    <div class="table-responsive">
                                                        <table id="medication_table"
                                                            class="table table-striped table-bordered nowrap"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <td>#</td>
                                                                    <th>Medication Name</th>
                                                                    <th>Dose</th>
                                                                    <th>Frequency</th>
                                                                    <th>Route</th>
                                                                    @can('update_medication')
                                                                        <th>Action</th>
                                                                    @endcan
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($patient->medications as $item)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>{{ $item->medication_name }}</td>
                                                                        <td>{{ $item->dose }}</td>
                                                                        <td>{{ $item->frequency }}</td>
                                                                        <td>{{ $item->route }}</td>
                                                                        @can('update_medication')
                                                                            <td>
                                                                                <button class="btn btn-sm btn-success"
                                                                                    type="button"
                                                                                    data-id="{{ $item->id }})"><i
                                                                                        class="fas fa-pencil-alt"></i></button>
                                                                            </td>
                                                                        @endcan
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('read_patient_data')
                                                <div class="tab-pane fade" id="note_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    @can('crud_patient_data')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_note_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan
                                                    <div class="table-responsive">
                                                        <table id="note_table"
                                                            class="table table-striped table-bordered nowrap"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 100.933px;">#</th>
                                                                    <th style="width: 150.933px;">Date</th>
                                                                    <th>Note</th>
                                                                    @can('update_patient_data')
                                                                        <th style="width: 100.933px;">Action</th>
                                                                    @endcan
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($patient_notes as $item)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('m-d-Y') }}
                                                                        </td>
                                                                        <td>{{ $item->note }}</td>
                                                                        @can('update_patient_data')
                                                                            <td>
                                                                                <button class="btn btn-sm btn-success"
                                                                                    type="button" data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-pencil-alt"></i>
                                                                                </button>

                                                                            </td>
                                                                        @endcan
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($type == 'unenrolled_patient')
                        <div class="row">

                            <div class="col-12">
                                <div class="card" style="height:635px;overflow-y:scroll;">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                                            @can('read_patient_data')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#patient_data_tab"
                                                       role="tab">Patient Record</a>
                                                </li>
                                            @endcan
                                            @can('read_time_track')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#time_track_tab"
                                                       role="tab">Time Track</a>
                                                </li>
                                            @endcan
                                            {{-- @can('create_message')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#message_tab"
                                                        role="tab">Message</a>
                                                </li>
                                            @endcan --}}
                                            @can('read_medication')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#medication_tab"
                                                       role="tab">Medication</a>
                                                </li>
                                            @endcan
                                            @can('read_patient_data')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#note_tab"
                                                       role="tab">Notes</a>
                                                </li>
                                            @endcan

                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            @can('read_patient_data')
                                                <div class="tab-pane fade" id="patient_data_tab" role="tabpanel"
                                                     aria-labelledby="pills-timeline-tab">
                                                    {{-- @can('crud_patient_data')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_patient_data_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan --}}
                                                    <div class="table-responsive">
                                                        <table id="patient_data_table"
                                                               class="table table-striped table-bordered nowrap"
                                                               style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Date</th>
                                                                <th>Pulse Rate</th>
                                                                <th>Blood Pressure</th>
                                                                <th>Category</th>
                                                                {{-- @can('update_patient_data')
                                                                    <th>Action</th>
                                                                @endcan --}}
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($patient->patient_data as $item)
                                                                <tr>
                                                                    <td></td>
                                                                    <td>{{ $item->formatted_actual_date }}</td>
                                                                    <td>{{ $item->data['pul'] }}</td>
                                                                    <td>
                                                                        <h5><span
                                                                                    class="{{ $item->category }}">{{ $item->data['sys'] }}/{{ $item->data['dia'] }}</span>
                                                                        </h5>
                                                                    </td>
                                                                    <td>
                                                                        <h5><span
                                                                                    class="{{ $item->category }}">{{ $item->category }}</span>
                                                                        </h5>
                                                                    </td>
                                                                    {{-- @can('update_patient_data')
                                                                        <td>
                                                                            <button class="btn btn-sm btn-success"
                                                                                type="button"
                                                                                data-id="{{ $item->id }}"><i
                                                                                    class="fas fa-pencil-alt"></i></button>
                                                                        </td>
                                                                    @endcan --}}
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            @endcan
                                            @can('read_time_track')
                                                <div class="tab-pane fade" id="time_track_tab" role="tabpanel"
                                                     aria-labelledby="pills-timeline-tab">
                                                    {{-- @can('crud_time_track')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">

                                                                <button type="button" id="add_time_track_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    @endcan --}}
                                                    <div class="table-responsive">
                                                        <table id="time_track_table"
                                                               class="table table-striped table-bordered nowrap"
                                                               style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Engagement Date</th>
                                                                <th>Entry Type</th>
                                                                <th>Engagement Type</th>
                                                                <th>Time</th>
                                                                <th>Note</th>
                                                                {{-- @can('update_time_track')
                                                                    <th>Action</th>
                                                                @endcan --}}
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($patient->time_tracks->whereNotNull('minutes') as $item)
                                                                <tr>
                                                                    <td></td>
                                                                    <td>{{ $item->formatted_engagement_date }}</td>
                                                                    <td>{{ $item->entry_type }}</td>
                                                                    <td>{{ $item->engagement_type }}</td>
                                                                    <td>{{ $item->minutes }}:{{ $item->seconds }}</td>
                                                                    <td>{{ \Illuminate\Support\Str::limit($item->note, 40, '...') }}
                                                                    </td>
                                                                    {{-- @can('update_time_track')
                                                                        <td>
                                                                            <button class="btn btn-sm btn-success"
                                                                                type="button"
                                                                                data-id="{{ $item->id }}"><i
                                                                                    class="fas fa-pencil-alt"></i></button>
                                                                        </td>
                                                                    @endcan --}}
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                            {{-- @can('create_message')
                                                <div class="tab-pane fade" id="message_tab" role="tabpanel"
                                                    aria-labelledby="pills-profile-tab">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">Ph No#</label>
                                                                <input type="text" class="form-control py-4 w-lg-50 w-100"
                                                                    value="{{ $patient->contact_no }}" id="to">
                                                                <label class="mt-3 font-weight-bold">Text Message</label>
                                                                <textarea rows="5" class="form-control" id="msg" placeholder="Please type your message" required=""></textarea>
                                                                <div class="btn-group mt-3">
                                                                    <button class="btn btn-success mr-1" id="send_msg_btn">
                                                                        <i class="fa fa-comment d-lg-none d-display"></i>
                                                                        <span class="d-lg-block d-none">Send Message</span>
                                                                    </button>
                                                                    <button class="btn btn-success mx-1" id="send_voice_btn">
                                                                        <i class="fa fa-microphone d-lg-none d-display"></i>
                                                                        <span class="d-lg-block d-none">Voice Message</span>
                                                                    </button>
                                                                    <button class="btn btn-success mx-1" id="send_both_btn">
                                                                        <span>Both</span>
                                                                    </button>
                                                                    <div class="ml-2 spinner-border text-success d-none"
                                                                        role="status" style="width: 2rem; height: 2rem;"
                                                                        id="message_spinner">
                                                                        <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan --}}
                                            @can('read_medication')
                                                <div class="tab-pane fade" id="medication_tab" role="tabpanel"
                                                     aria-labelledby="pills-timeline-tab">
                                                    {{-- @can('crud_medication')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_medication_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan --}}
                                                    <div class="table-responsive">
                                                        <table id="medication_table"
                                                               class="table table-striped table-bordered nowrap"
                                                               style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <th>Medication Name</th>
                                                                <th>Dose</th>
                                                                <th>Frequency</th>
                                                                <th>Route</th>
                                                                {{-- @can('update_medication')
                                                                    <th>Action</th>
                                                                @endcan --}}
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($patient->medications as $item)
                                                                <tr>
                                                                    <td></td>
                                                                    <td>{{ $item->medication_name }}</td>
                                                                    <td>{{ $item->dose }}</td>
                                                                    <td>{{ $item->frequency }}</td>
                                                                    <td>{{ $item->route }}</td>
                                                                    {{-- @can('update_medication')
                                                                        <td>
                                                                            <button class="btn btn-sm btn-success"
                                                                                type="button"
                                                                                data-id="{{ $item->id }})"><i
                                                                                    class="fas fa-pencil-alt"></i></button>
                                                                        </td>
                                                                    @endcan --}}
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('read_patient_data')
                                                <div class="tab-pane fade" id="note_tab" role="tabpanel"
                                                     aria-labelledby="pills-timeline-tab">
                                                    {{-- @can('crud_patient_data')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_note_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan --}}
                                                    <div class="table-responsive">
                                                        <table id="note_table"
                                                               class="table table-striped table-bordered nowrap"
                                                               style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th style="width: 100.933px;">#</th>
                                                                <th style="width: 150.933px;">Date</th>
                                                                <th>Note</th>
                                                                {{-- @can('update_patient_data')
                                                                    <th style="width: 100.933px;">Action</th>
                                                                @endcan --}}
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($patient_notes as $item)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('m-d-Y') }}
                                                                    </td>
                                                                    <td>{{ $item->note }}</td>
                                                                    {{-- @can('update_patient_data')
                                                                        <td>
                                                                            <button class="btn btn-sm btn-success"
                                                                                type="button" data-id="{{ $item->id }}">
                                                                                <i class="fas fa-pencil-alt"></i>
                                                                            </button>

                                                                        </td>
                                                                    @endcan --}}
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="height:635px;overflow-y:scroll;">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                                            @can('read_patient_data')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#patient_data_tab"
                                                        role="tab">Patient Record</a>
                                                </li>
                                            @endcan
                                            @can('read_time_track')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#time_track_tab"
                                                        role="tab">Time Track</a>
                                                </li>
                                            @endcan
                                            @can('create_message')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#message_tab"
                                                        role="tab">Message</a>
                                                </li>
                                            @endcan
                                            @can('read_medication')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#medication_tab"
                                                        role="tab">Medication</a>
                                                </li>
                                            @endcan
                                            @can('read_patient_data')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#note_tab"
                                                        role="tab">Notes</a>
                                                </li>
                                            @endcan
                                            @can('update_patient')
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#device_tab"
                                                        role="tab">Device</a>
                                                </li>
                                            @endcan

                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            @can('read_patient_data')
                                                <div class="tab-pane fade" id="patient_data_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    @can('crud_patient_data')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_patient_data_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan
                                                    {{-- @dd($patient->patient_data->sortByDesc('id')->take(5)); --}}

                                                    <div class="table-responsive">
                                                        <table id="patient_data_table"
                                                            class="table table-striped table-bordered nowrap"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Date</th>
                                                                    <th>Pulse Rate</th>
                                                                    <th>Blood Pressure</th>
                                                                    <th>Category</th>
                                                                    @can('update_patient_data')
                                                                        <th>Action</th>
                                                                    @endcan
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                @foreach ($patient->patient_data as $item)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>{{ $item->formatted_actual_date }}</td>
                                                                         <td>{{ $item->data['pul'] ?? '-' }}</td>
                                                                        <td>
                                                                            <h5>
                                                                            
                                                                            <span class="{{ $item->category }}">
                                                                                    {{ data_get($item->data ?? [], 'sys', '-') }}/{{ data_get($item->data ?? [], 'dia', '-') }}
                                                                                </span>
                                                                                </h5>
                                                                        </td>
                                                                        <td>
                                                                            <h5><span
                                                                                    class="{{ $item->category }}">{{ $item->category }}</span>
                                                                            </h5>
                                                                        </td>
                                                                        @can('update_patient_data')
                                                                            <td>
                                                                                <button class="btn btn-sm btn-success"
                                                                                    type="button"
                                                                                    data-id="{{ $item->id }}"><i
                                                                                        class="fas fa-pencil-alt"></i></button>
                                                                            </td>
                                                                        @endcan
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            @endcan
                                            @can('read_time_track')
                                                <div class="tab-pane fade" id="time_track_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    @can('crud_time_track')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">

                                                                <button type="button" id="add_time_track_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    @endcan
                                                    <div class="table-responsive">
                                                        <table id="time_track_table"
                                                            class="table table-striped table-bordered nowrap"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Engagement Date</th>
                                                                    <th>Entry Type</th>
                                                                    <th>Engagement Type</th>
                                                                    <th>Time</th>
                                                                    <th>Note</th>
                                                                    @can('update_time_track')
                                                                        <th>Action</th>
                                                                    @endcan
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($patient->time_tracks->whereNotNull('minutes') as $item)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>{{ $item->formatted_engagement_date }}</td>
                                                                        <td>{{ $item->entry_type }}</td>
                                                                        <td>{{ $item->engagement_type }}</td>
                                                                        <td>{{ $item->minutes }}:{{ $item->seconds }}</td>
                                                                        <td>{{ \Illuminate\Support\Str::limit($item->note, 40, '...') }}
                                                                        </td>
                                                                        @can('update_time_track')
                                                                            <td>
                                                                                <button class="btn btn-sm btn-success"
                                                                                    type="button"
                                                                                    data-id="{{ $item->id }}"><i
                                                                                        class="fas fa-pencil-alt"></i></button>
                                                                            </td>
                                                                        @endcan
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('create_message')
                                                <div class="tab-pane fade" id="message_tab" role="tabpanel"
                                                    aria-labelledby="pills-profile-tab">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold">Ph No#</label>
                                                                <input type="text" class="form-control py-4 w-lg-50 w-100"
                                                                    value="{{ $patient->contact_no }}" id="to">
                                                                <label class="mt-3 font-weight-bold">Text Message</label>
                                                                <textarea rows="5" class="form-control" id="msg" placeholder="Please type your message" required=""></textarea>
                                                                <div class="btn-group mt-3">
                                                                    <button class="btn btn-success mr-1" id="send_msg_btn">
                                                                        <i class="fa fa-comment d-lg-none d-display"></i>
                                                                        <span class="d-lg-block d-none">Send Message</span>
                                                                    </button>
                                                                    <button class="btn btn-success mx-1" id="send_voice_btn">
                                                                        <i class="fa fa-microphone d-lg-none d-display"></i>
                                                                        <span class="d-lg-block d-none">Voice Message</span>
                                                                    </button>
                                                                    <button class="btn btn-success mx-1" id="send_both_btn">
                                                                        <span>Both</span>
                                                                    </button>
                                                                    <div class="ml-2 spinner-border text-success d-none"
                                                                        role="status" style="width: 2rem; height: 2rem;"
                                                                        id="message_spinner">
                                                                        <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('read_medication')
                                                <div class="tab-pane fade" id="medication_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    @can('crud_medication')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_medication_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan
                                                    <div class="table-responsive">
                                                        <table id="medication_table"
                                                            class="table table-striped table-bordered nowrap"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <td>#</td>
                                                                    <th>Medication Name</th>
                                                                    <th>Dose</th>
                                                                    <th>Frequency</th>
                                                                    <th>Route</th>
                                                                    @can('update_medication')
                                                                        <th>Action</th>
                                                                    @endcan
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($patient->medications as $item)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>{{ $item->medication_name }}</td>
                                                                        <td>{{ $item->dose }}</td>
                                                                        <td>{{ $item->frequency }}</td>
                                                                        <td>{{ $item->route }}</td>
                                                                        @can('update_medication')
                                                                            <td>
                                                                                <button class="btn btn-sm btn-success"
                                                                                    type="button"
                                                                                    data-id="{{ $item->id }})"><i
                                                                                        class="fas fa-pencil-alt"></i></button>
                                                                            </td>
                                                                        @endcan
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                            @can('read_patient_data')
                                                <div class="tab-pane fade" id="note_tab" role="tabpanel"
                                                    aria-labelledby="pills-timeline-tab">
                                                    @can('crud_patient_data')
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <button type="button" id="add_note_btn"
                                                                    class="btn btn-success"><i class="fas fa-plus"></i></button>

                                                            </div>
                                                        </div>
                                                    @endcan
                                                    <div class="table-responsive">
                                                        <table id="note_table"
                                                            class="table table-striped table-bordered nowrap"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 100.933px;">#</th>
                                                                    <th style="width: 150.933px;">Date</th>
                                                                    <th>Note</th>
                                                                    @can('update_patient_data')
                                                                        <th style="width: 100.933px;">Action</th>
                                                                    @endcan
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($patient_notes as $item)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('m-d-Y') }}
                                                                        </td>
                                                                        <td>{{ $item->note }}</td>
                                                                        @can('update_patient_data')
                                                                            <td>
                                                                                <button class="btn btn-sm btn-success"
                                                                                    type="button" data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-pencil-alt"></i>
                                                                                </button>

                                                                            </td>
                                                                        @endcan
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endcan
                                            
                                               @can('update_patient')
                                                <div class="tab-pane fade" id="device_tab" role="tabpanel"
                                                    aria-labelledby="pills-device-tab">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            @if ($patient->device)
                                                                <div class="card mb-3">
                                                                    <div class="card-header bg-success text-white">
                                                                        <h5 class="mb-0">Device Information</h5>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <p><strong>Device Serial No:</strong>
                                                                                    {{ $patient->device->device_serial_no }}
                                                                                </p>
                                                                                <p><strong>Install Date:</strong>
                                                                                    {{ $patient->device->install_date ?? 'N/A' }}
                                                                                </p>
                                                                                <p><strong>Status:</strong>
                                                                                    <span
                                                                                        class="badge badge-{{ $patient->device->status == 'Active' ? 'success' : 'danger' }}">
                                                                                        {{ $patient->device->status ?? 'N/A' }}
                                                                                    </span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p><strong>Device IMEI No:</strong>
                                                                                    {{ $patient->device->device_imei_no ?? 'N/A' }}
                                                                                </p>
                                                                                <p><strong>Setup Date:</strong>
                                                                                    {{ $patient->device->setup_date ?? 'N/A' }}
                                                                                </p>

                                                                                <p>
                                                                                    <strong>Last Sync:</strong>
                                                                                    {{ optional($patient->patient_data->sortByDesc('created_at')->first()?->created_at)->format('m-d-Y h:i A') ?? 'N/A' }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-3">
                                                                            <button type="button" class="btn btn-success"
                                                                                id="edit_device_btn"
                                                                                data-id="{{ $patient->device->id }}"
                                                                                data-toggle="modal"
                                                                                data-target="#edit_device_modal">
                                                                                <i class="fas fa-edit"></i> Update Device
                                                                            </button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="alert alert-warning">
                                                                    <strong>No Device Assigned</strong><br>
                                                                    This patient does not have a device assigned yet.
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif



                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>

    </div>
    @if ($type == 'rpm')
        <div class="row">
            @if ($patient->device)
                <div class="col-12">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            Device Serial Number:
                            <div class="card-actions">
                                <a href="{{ route('device.show', $patient->device) }}"
                                    class="text-white">{{ $patient->device->device_serial_no }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="btn-group" style="float: right;">
                                <input type="text" name="from" id="date_from" class="form-control"
                                    value="{{ $from }}">
                                <button type="button" class="btn btn-success">To</button>
                                <input type="text" name="to" id="date_to" class="form-control">
                                <button type="button" class="btn btn-danger" id="filter_btn"><i
                                        class="fas fa-filter"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="spinner-border spinners text-info d-none" role="status" id="device_spinner">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div id="device_chart">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="height:513px; overflow-y:scroll;">
                        <div class="card-body">
                            <h4 class="card-title">Patient Readings</h4>
                            <div class="table-responsive">
                                <table class="table table-striped" id="filter_data_table">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Date</th>
                                            <th>Pul</th>
                                            <th>Sys</th>
                                            <th>Dia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td colspan="4">No Record Found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Row -->
@endsection
@section('modal')
   <div class="modal fade" id="edit_device_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Update Patient Device</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('patient.update_device') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="patient_id" id="patient_id" value="{{ $patient->id }}">
                            <input type="hidden" name="device_id" id="device_id" value=""> {{-- store found device id --}}

                            <div class="col-6">
                                <div class="form-group position-relative">
                                    <label for="device_serial_no">Device Serial No:</label>
                                    <input type="text" class="form-control form-control-lg" name="device_serial_no"
                                        id="device_serial_no" autocomplete="off" placeholder="Type to search...">

                                    {{-- Dropdown suggestions --}}
                                    <ul id="device_suggestions" class="list-group position-absolute w-100"
                                        style="z-index:999; display:none; top:100%;">
                                    </ul>

                                    @error('device_serial_no')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="device_imei_no">Device IMEI No:</label>
                                    <input type="text" class="form-control form-control-lg" name="device_imei_no"
                                        id="device_imei_no">
                                    @error('device_imei_no')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="install_date">Install Date:</label>
                                    <input type="text" class="form-control bg-white form-control-lg" id="install_date"
                                        name="install_date">
                                    @error('install_date')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="setup_date">Setup Date:</label>
                                    <input type="text" class="form-control bg-white form-control-lg" id="setup_date"
                                        name="setup_date">
                                    @error('setup_date')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <button class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="patient_data_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add Patient Data</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="pul">Pulse Rate:</label>
                                    <input type="number" class="form-control" id="pul" name="pul"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="sys">Systolic:</label>
                                    <input type="number" class="form-control" id="sys" name="sys"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="dia">Diastolic:</label>
                                    <input type="number" class="form-control" id="dia" name="dia"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="ihb">Irregular Heartbeat:</label>
                                    <select class="form-control" id="ihb" name="ihb">
                                        <option value="false" selected>False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="dia">Hand Tremor:</label>
                                    <select class="form-control" id="hand" name="hand">
                                        <option value="false" selected>False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="date_time">Date:</label>
                                    <input type="text" class="form-control bg-white" id="date_time" name="date_time"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success" id="save_patient_data_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_patient_data_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edit Patient Data</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="pul">Pulse Rate:</label>
                                    <input type="hidden" id="edit_patient_data_id">
                                    <input type="number" class="form-control" id="edit_pul" name="pul"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="sys">Systolic:</label>
                                    <input type="number" class="form-control" id="edit_sys" name="sys"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="dia">Diastolic:</label>
                                    <input type="number" class="form-control" id="edit_dia" name="dia"
                                        value="" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="ihb">Irregular Heartbeat:</label>
                                    <select class="form-control" id="edit_ihb" name="ihb">
                                        <option value="false">False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="dia">Hand Tremor:</label>
                                    <select class="form-control" id="edit_hand" name="hand">
                                        <option value="false" selected>False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_date_time">Date:</label>
                                    <input type="text" class="form-control bg-white" id="edit_date_time"
                                        name="date_time" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                @can('delete_patient_data')
                                    <button type="button" id="delete_patient_data_btn"
                                        class="btn btn-danger">Delete</button>
                                @endcan
                                <button type="button" id="update_patient_data_btn"
                                    class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="time_track_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add Time Track</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="patient_id">Patient Name:</label>
                                    <input type="text" class="form-control"
                                        value="{{ $patient->first_name }} {{ $patient->last_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="user_id">Recorded By:</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->user_name }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="engagement_type">Engagement Type:</label>
                                    <select class="form-control" name="engagement_type" id="engagement_type" required>
                                        @if ($engagement_types)
                                            @foreach ($engagement_types as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="date">Engagement Date:</label>
                                    <input type="text" class="form-control" name="engagement_date"
                                        id="engagement_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="minutes">Minutes:</label>
                                    <input type="number" class="form-control" name="minutes" id="add_minutes" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="seconds">Seconds:</label>
                                    <input type="number" class="form-control" name="seconds" id="add_seconds"
                                        min="0" max="59" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" id="note" rows="4" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success" id="save_time_track_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_time_track_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edit Time Track</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="engagement_type">Engagement Type:</label>
                                    <input type="hidden" id="edit_time_track_id">
                                    <select class="form-control" name="engagement_type" id="edit_engagement_type"
                                        required>
                                        @if ($engagement_types)
                                            @foreach ($engagement_types as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="date">Engagement Date:</label>
                                    <input type="text" class="form-control" name="engagement_date"
                                        id="edit_engagement_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="minutes">Minutes:</label>
                                    <input type="number" class="form-control" name="minutes" id="edit_minutes"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="seconds">Seconds:</label>
                                    <input type="number" class="form-control" name="seconds" id="edit_seconds"
                                        min="0" max="59" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" rows="4" class="form-control" id="edit_note" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                @can('delete_time_track')
                                    <button type="button" id="delete_time_track_btn" class="btn btn-danger">Delete</button>
                                @endcan
                                <button type="button" id="update_time_track_btn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="medication_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add Medication</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="medication_name">Medication Name:</label>
                                    <input type="text" class="form-control" name="medication_name"
                                        id="medication_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="dose">Dose:</label>
                                    <input type="text" class="form-control" name="dose" id="dose">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="frequency">Frequency:</label>
                                    <input type="text" class="form-control" name="frequency" id="frequency">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="route">Route:</label>
                                    <input type="text" class="form-control" name="route" id="route">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" id="save_medication_btn" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_medication_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edit Medication</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="medication_name">Medication Name:</label>
                                    <input type="hidden" class="form-control" id="medication_id">
                                    <input type="text" class="form-control" name="medication_name"
                                        id="edit_medication_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="dose">Dose:</label>
                                    <input type="text" class="form-control" name="dose" id="edit_dose">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="frequency">Frequency:</label>
                                    <input type="text" class="form-control" name="frequency" id="edit_frequency">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="route">Route:</label>
                                    <input type="text" class="form-control" name="route" id="edit_route">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                @can('delete_medication')
                                    <button type="button" id="delete_medication_btn" class="btn btn-danger">Delete</button>
                                @endcan
                                <button type="button" id="update_medication_btn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- notes modal --}}
    <div class="modal fade" id="note_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add Patient Note</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="date_time">Date:</label>
                                    <input type="text" class="form-control bg-white" id="date" name="date"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Note:</label>
                                    <textarea class="form-control" name="patient_note" id="patient_note" cols="30" rows="7" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success" id="save_note_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- edit notes modal --}}

    <div class="modal fade" id="edit_note_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edit Patient Note</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="edit_note_id">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_date_time">Date:</label>
                                    <input type="text" class="form-control bg-white note_date" id="date_edit"
                                        name="date" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_note">Note:</label>
                                    <textarea name="note" class="form-control" id="note_edit" cols="30" rows="7"></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                @can('delete_patient_data')
                                    <button type="button" id="delete_note_btn" class="btn btn-danger">Delete</button>
                                @endcan
                                <button type="button" id="update_note_btn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- care plan comment  --}}
    <div class="modal" tabindex="-1" role="dialog" id="care_plan_comment">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Care Plan Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('care-plan.approval') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                            <input type="hidden" name="care_plan_id" value="{{  $patient->care_plan ? $patient->care_plan->id : '' }}">
                        <label for="care_plan_not" class="mb-2">Care Plan Comment</label>
                        <textarea class="form-control" name="care_plan_comment" required placeholder="please write your care plan comment here....."  cols="68" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Send For
                            Approval</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('jquery-validation/dist/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        document.getElementById("care_plan_notes").addEventListener("click", function() {
            $('#care_plan_comment').modal('show');
        });
    </script>
    
    
    
    <script>
        const serialInput = document.getElementById('device_serial_no');
        const imeiInput = document.getElementById('device_imei_no');
        const suggestionsList = document.getElementById('device_suggestions');
        const deviceIdInput = document.getElementById('device_id');

        let searchTimeout = null;

        serialInput.addEventListener('input', function() {
            const query = this.value.trim();
            deviceIdInput.value = ''; // reset selected device

            // If cleared, hide suggestions and unlock imei
            if (query.length < 2) {
                suggestionsList.style.display = 'none';
                imeiInput.readOnly = false;
                imeiInput.value = '';
                return;
            }

            // Debounce — wait 400ms after user stops typing
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetch(`/device/search?query=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(devices => {
                        suggestionsList.innerHTML = '';

                        if (devices.length === 0) {
                            // No device found — user is entering a new device
                            suggestionsList.style.display = 'none';
                            imeiInput.readOnly = false;
                            imeiInput.value = '';
                            return;
                        }

                        // Show matched devices in dropdown
                        devices.forEach(device => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item list-group-item-action';
                            li.style.cursor = 'pointer';
                            li.textContent =
                                `${device.device_serial_no} — IMEI: ${device.device_imei_no}`;

                            li.addEventListener('click', function() {
                                // Fill in the fields and lock imei (existing device)
                                serialInput.value = device.device_serial_no;
                                imeiInput.value = device.device_imei_no;
                                imeiInput.readOnly = true;
                                deviceIdInput.value = device.id;
                                suggestionsList.style.display = 'none';
                            });

                            suggestionsList.appendChild(li);
                        });

                        suggestionsList.style.display = 'block';
                    })
                    .catch(err => console.error('Search error:', err));
            }, 400);
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!serialInput.contains(e.target) && !suggestionsList.contains(e.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    </script>

    <script>
        $('#install_date').flatpickr({
            dateFormat: "m-d-Y",
            defaultDate: "today"
        });
        $('#setup_date').flatpickr({
            dateFormat: "m-d-Y",
        });
    </script>
    
    
    
    

    <script>
        var device_chart, patient_data_table, time_track_table, medication_table, note_table;

        var enrol_in_rpm = {{ $patient->enrol_in_rpm }};
        $(document).ready(function() {
            var type = "{{ $type }}";
            if (type == "rpm") {
                start_timer();
                $('#footer').removeClass('d-none');
            }

            $('#pills-tabContent .tab-pane').first().addClass('show');
            $('#pills-tabContent .tab-pane').first().addClass('active');

            $('#pills-tab .nav-item .nav-link').first().addClass('active');
            $('#pills-tab .nav-item .nav-link').first().addClass('show');
            $('#pills-tab .nav-item .nav-link').first().attr('aria-selected', true);

            $('#timer_option').removeClass('d-none');
            $('#date_from').flatpickr({
                dateFormat: "m-d-Y",
            });

            $('#date_to').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"
            });
            $('#date_time').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"
            });
            $('#edit_date_time').flatpickr({
                dateFormat: "m-d-Y",
            });
            $('#date').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"
            });
            $('.note_date').flatpickr({
                defaultDate: "today"
            });
            $('#edit_date').flatpickr({
                dateFormat: "m-d-Y",
            });

            $('#engagement_date').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"

            });
            $('#edit_engagement_date').flatpickr({
                dateFormat: "m-d-Y",
            });
            var options = {
                series: [{
                        name: 'Heart Beat',
                        type: 'area',
                        data: []
                        // data: response.patient_data_1


                    },
                    {
                        name: 'Systolic',
                        type: 'line',
                        data: []
                        // data: response.patient_data_2

                    },
                    {
                        name: 'Dystolic',
                        type: 'line',
                        data: []
                        // data: response.patient_data_3

                    },

                ],
                colors: ['#FB254D', '#1CA3B5', '#1E88E5'],
                chart: {
                    height: 400,
                    stacked: false
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    width: [2, 2, 2],
                    curve: "smooth"
                },
                fill: {
                    opacity: [0.1, 0.7, 1],
                },
                title: {
                    text: 'Patient Reading',
                    align: 'left',
                },
                xaxis: {
                    categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
                },
                tooltip: {
                    fixed: {
                        enabled: true,
                        position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                        offsetY: 30,
                        offsetX: 60
                    },
                },
                legend: {
                    horizontalAlign: 'left',
                    offsetX: 40
                }
            };
            if (enrol_in_rpm) {
                device_chart = new ApexCharts(document.querySelector("#device_chart"), options);
                device_chart.render();

            }


            $(".select2").select2({
                placeholder: "Please select an option"
            });
            last_checked();

            var from = $('#date_from').val();
            var to = $('#date_to').val();
            var patient_id = "{{ $patient->id }}";
            if (from && to && patient_id) {
                set_graph_data(from, to, patient_id);
            }




            patient_data_table = $('#patient_data_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
            });
            patient_data_table.on('order.dt search.dt', function() {
                let i = 1;

                patient_data_table.cells(null, 0).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
            time_track_table = $('#time_track_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
            });
            time_track_table.on('order.dt search.dt', function() {
                let i = 1;

                time_track_table.cells(null, 0).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
            note_table = $('#note_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
                "columnDefs": [{
                        "width": "50px",
                        "targets": 0
                    }, // Adjust the width for the first column (#)
                    {
                        "width": "150px",
                        "targets": 1
                    }, // Adjust the width for the second column (Date)
                    {
                        "width": "auto",
                        "targets": 2
                    }, // Let DataTables decide the width for the third column (Note)
                    {
                        "width": "100px",
                        "targets": 3
                    } // Adjust the width for the fourth column (Action)
                ],
            });
            note_table.on('order.dt search.dt', function() {
                let i = 1;

                note_table.cells(null, 0).every(function(cell) {
                    this.data(i++);
                });
            }).draw();

            medication_table = $('#medication_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
            });
            medication_table.on('order.dt search.dt', function() {
                let i = 1;

                medication_table.cells(null, 0).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {

            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
                .responsive.recalc();
        });

        function last_checked() {
            $.ajax({
                url: "{{ route('patient.last_checked') }}",
                type: "post",
                data: {
                    patient_id: "{{ $patient->id }}"
                },
                success: function(response) {},
                error: function(response) {
                    toastr.error('Something went wrong', 'Error', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            })
        }

        //Patient Data related javascript

        $(document).on('click', '#add_patient_data_btn', function() {
            $('#patient_data_modal').modal('show');
        });
        $('#save_patient_data_btn').click(function() {
            var patient_id = "{{ $patient->id }}";
            var pul = $('#pul').val();
            var sys = $('#sys').val();
            var dia = $('#dia').val();
            var ihb = $('#ihb').val();
            var hand = $('#hand').val();
            var date_time = $('#date_time').val();

            if (patient_id && pul && sys && dia && ihb && hand && hand && date_time) {
                $.ajax({
                    url: "{{ route('patient-data.store') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id,
                        pul: pul,
                        sys: sys,
                        dia: dia,
                        ihb: ihb,
                        hand: hand,
                        date_time: date_time,
                    },
                    success: function(response) {
                        if (response) {
                            var sys = response.data.sys;
                            var dia = response.data.dia;



                            var row = patient_data_table.row.add([
                                -1,
                                response.formatted_actual_date,
                                response.data.pul,
                                '<h5><span class="' + response.category + '">' + sys + '/' +
                                dia + '</span></h5>',
                                '<h5><span class="' + response.category + '">' + response
                                .category + '</span></h5>',
                                '<button class="btn btn-sm btn-success" type="button" data-id="' +
                                response.id + '"><i class="fas fa-pencil-alt"></i></button>'
                            ]).draw();


                            toastr.success('Data has been saved', 'Success', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#patient_data_modal').modal('hide');
                        }
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }

        });
        var patient_data_table_row;
        $('#patient_data_table tbody').on('click', 'button', function() {
            var id = $(this).data('id');
            var edit_url = "{{ route('patient-data.edit', ':id') }}";
            edit_url = edit_url.replace(":id", id);

            patient_data_table_row = patient_data_table.row($(this).parents('tr'));
            if (id) {
                $.ajax({
                    url: edit_url,
                    type: "get",
                    success: function(response) {
                        $('#edit_patient_data_modal').modal('show');
                        $('#edit_patient_data_id').val(response.id);
                        $('#edit_pul').val(response.data.pul);
                        $('#edit_sys').val(response.data.sys);
                        $('#edit_dia').val(response.data.dia);
                        $('#edit_ihb').val(response.data.ihb.toString());
                        $('#edit_hand').val(response.data.hand.toString());
                        $('#edit_date_time').val(response.formatted_actual_date);

                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            }
        });
        $('#update_patient_data_btn').click(function() {
            var patient_data_id = $('#edit_patient_data_id').val();
            var patient_id = "{{ $patient->id }}";
            var pul = $('#edit_pul').val();
            var sys = $('#edit_sys').val();
            var dia = $('#edit_dia').val();
            var ihb = $('#edit_ihb').val();
            var hand = $('#edit_hand').val();
            var date_time = $('#edit_date_time').val();

            var update_url = "{{ route('patient-data.update', ':id') }}";
            update_url = update_url.replace(':id', patient_data_id);

            if (patient_data_id && patient_id && pul && sys && dia && ihb && hand && date_time) {
                $.ajax({
                    url: update_url,
                    type: "post",
                    data: {
                        _method: "PATCH",
                        patient_id: patient_id,
                        pul: pul,
                        sys: sys,
                        dia: dia,
                        ihb: ihb,
                        hand: hand,
                        date_time: date_time,
                    },
                    success: function(response) {
                        var sys = response.data.sys;
                        var dia = response.data.dia;
                        new_data = [
                            -1,
                            response.formatted_actual_date,
                            response.data.pul,
                            '<h5><span class="' + response.category + '">' + sys + '/' + dia +
                            '</span></h5>',
                            '<h5><span class="' + response.category + '">' + response.category +
                            '</span></h5>',
                            '<button class="btn btn-sm btn-success" type="button" data-id="' +
                            response.id + '"><i class="fas fa-pencil-alt"></i></button>'
                        ];
                        patient_data_table.row(patient_data_table_row).data(new_data).draw();

                        toastr.success('Data has been saved', 'Success', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_patient_data_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });
        $('#delete_patient_data_btn').click(function() {
            var patient_data_id = $('#edit_patient_data_id').val();
            var delete_url = "{{ route('patient-data.destroy', ':id') }}";
            delete_url = delete_url.replace(':id', patient_data_id);
            if (patient_data_id) {
                $.ajax({
                    url: delete_url,
                    type: "post",
                    data: {
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        patient_data_table.row(patient_data_table_row).remove().draw();
                        toastr.success('Data has been removed', 'Success', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_patient_data_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                })
            }
        });
        //End Patient Data related javascript


        //Time Track related Javascript

        $(document).on('click', '#add_time_track_btn', function() {
            $('#time_track_modal').modal('show');
        });
        $('#save_time_track_btn').click(function() {
            var patient_id = "{{ $patient->id }}";
            var entry_type = "Manual";
            var engagement_date = $('#engagement_date').val();
            var engagement_type = $('#engagement_type').val();
            var minutes = $('#add_minutes').val();
            var seconds = $('#add_seconds').val();
            var note = $('#note').val();

            if (patient_id && entry_type && engagement_date && engagement_type && minutes && seconds && note) {
                $.ajax({
                    url: "{{ route('time-track.store') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id,
                        engagement_date: engagement_date,
                        entry_type: entry_type,
                        engagement_type: engagement_type,
                        minutes: minutes,
                        seconds: seconds,
                        note: note,
                    },
                    success: function(response) {
                        if (response.current_month_time) {
                            $('#current_month_time').html(response.current_month_time + " Min");
                        }
                        if (response.time_track) {
                            var row = time_track_table.row.add([
                                -1,
                                response.time_track.engagement_date,
                                response.time_track.entry_type,
                                response.time_track.engagement_type,
                                response.time_track.minutes + ":" + response.time_track.seconds,
                                response.time_track.note,
                                '<button class="btn btn-sm btn-success" type="button" data-id="' +
                                response.time_track.id +
                                '"><i class="fas fa-pencil-alt"></i></button>'

                            ]).draw();



                            toastr.success('Data has been saved', 'Success', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#time_track_modal').modal('hide');
                        }
                        window.location.href = "{{ URL::to('home') }}";

                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }

        });
        var time_track_table_row;
        $('#time_track_table tbody').on('click', 'button', function() {
            var id = $(this).data('id');
            var edit_url = "{{ route('time-track.edit', ':id') }}";
            edit_url = edit_url.replace(":id", id);

            time_track_table_row = time_track_table.row($(this).parents('tr'));
            if (id) {
                $.ajax({
                    url: edit_url,
                    type: "get",
                    success: function(response) {
                        if (response) {
                            $('#edit_time_track_modal').modal('show');
                            $('#edit_time_track_id').val(response.id);
                            $('#edit_engagement_type').val(response.engagement_type);
                            $('#edit_engagement_date').val(response.formatted_engagement_date);
                            $('#edit_minutes').val(response.minutes);
                            $('#edit_seconds').val(response.seconds);
                            $('#edit_note').val(response.note);

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
            }
        });
        $('#update_time_track_btn').click(function() {
            var time_track_id = $('#edit_time_track_id').val();
            var patient_id = "{{ $patient->id }}";
            var entry_type = "Manual";
            var engagement_date = $('#edit_engagement_date').val();
            var engagement_type = $('#edit_engagement_type').val();
            var minutes = $('#edit_minutes').val();
            var seconds = $('#edit_seconds').val();
            var note = $('#edit_note').val();


            var update_url = "{{ route('time-track.update', ':id') }}";
            update_url = update_url.replace(':id', time_track_id);

            if (time_track_id && patient_id && entry_type && engagement_date && engagement_type && minutes &&
                seconds && note) {
                $.ajax({
                    url: update_url,
                    type: "post",
                    data: {
                        _method: "PATCH",
                        patient_id: patient_id,
                        engagement_date: engagement_date,
                        entry_type: entry_type,
                        engagement_type: engagement_type,
                        minutes: minutes,
                        seconds: seconds,
                        note: note,
                    },
                    success: function(response) {
                        new_data = [
                            -1,
                            response.formatted_engagement_date,
                            response.entry_type,
                            response.engagement_type,
                            response.minutes + ":" + response.seconds,
                            response.note,
                            '<button class="btn btn-sm btn-success" type="button" data-id="' +
                            response.id + '"><i class="fas fa-pencil-alt"></i></button>'
                        ];
                        time_track_table.row(time_track_table_row).data(new_data).draw();
                        toastr.success('Data has been saved', 'Success', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_time_track_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });
        $('#delete_time_track_btn').click(function() {
            var time_track_id = $('#edit_time_track_id').val();
            var delete_url = "{{ route('time-track.destroy', ':id') }}";
            delete_url = delete_url.replace(':id', time_track_id);
            if (time_track_id) {
                $.ajax({
                    url: delete_url,
                    type: "post",
                    data: {
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        time_track_table.row(time_track_table_row).remove().draw();
                        toastr.success('Data has been removed', 'Success', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_time_track_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                })
            }
        });

        //End Time Track related javascript


        $('#send_msg_btn').click(function() {
            var to = $('#to').val();
            var msg = $('textarea#msg').val();
            var type = "msg";
            send_message(to, msg, type);

        });

        $('#send_voice_btn').click(function() {
            var to = $('#to').val();
            var msg = $('textarea#msg').val();
            var type = "voice";
            send_message(to, msg, type);

        });

        $('#send_both_btn').click(function() {
            var to = $('#to').val();
            var msg = $('textarea#msg').val();
            var type = "both";
            send_message(to, msg, type);
        });


        function send_message(to, msg, type) {
            var patient_id = "{{ $patient->id }}";

            $.ajax({
                url: "{{ route('message.store') }}",
                type: "post",
                data: {
                    to: to,
                    msg: msg,
                    type: type,
                    patient_id: patient_id
                },
                beforeSend: function() {
                    $('#message_spinner').removeClass('d-none');
                },
                success: function(response) {
                    if (response == 200) {
                        $('#message_spinner').addClass('d-none');
                        // Fade In / Fade Out
                        toastr.success('Your message is on its way', 'Message Sent', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    } else {
                        $('#message_spinner').addClass('d-none');

                        toastr.error('something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                },
                error: function(response) {
                    $('#message_spinner').addClass('d-none');
                    toastr.error(response.responseJSON.message, 'Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 4000
                    });

                }
            });
        }


        $('#filter_btn').click(function() {
            var from = $('#date_from').val();
            var to = $('#date_to').val();
            var patient_id = "{{ $patient->id }}";
            if (from && to && patient_id) {
                set_graph_data(from, to, patient_id);
            } else {
                toastr.warning('Empty Value', 'Warning!', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });

        function set_graph_data(from, to, patient_id) {
            $.ajax({
                url: "{{ route('patient-data.filter') }}",
                type: "post",
                data: {
                    from: from,
                    to: to,
                    patient_id: patient_id
                },
                beforeSend: function() {
                    $('#device_spinner').removeClass('d-none');
                },
                success: function(response) {
                    var table_body = $('#filter_data_table tbody');
                    table_body.empty();

                    if (response.systolic.length > 0) {
                        $.each(response.date, function(i, value) {
                            var data = '<tr>' +
                                '<td>' + response.date[i] + '</td>' +
                                '<td>' + response.pulse_rate[i] + '</td>' +
                                '<td>' + response.systolic[i] + '</td>' +
                                '<td>' + response.diastolic[i] + '</td>' +
                                '</tr>';
                            table_body.append(data);
                        });
                        device_chart.updateOptions({
                            series: [{
                                name: 'Pulse Rate',
                                type: 'area',
                                data: response.pulse_rate

                            }, {
                                name: 'Systolic',
                                type: 'line',
                                data: response.systolic
                            }, {
                                name: 'Diastolic',
                                type: 'line',
                                data: response.diastolic
                            }],
                            xaxis: {
                                categories: response.date,
                            },
                        });
                        $('#device_spinner').addClass('d-none');

                    } else {
                        $('#device_spinner').addClass('d-none');
                        var data = '<tr class="text-center">' +
                            '<td colspan="4">No Record Found</td>' +
                            '</tr>';
                        table_body.append(data);
                    }
                },
                error: function() {
                    $('#device_spinner').addClass('d-none');

                    toastr.error('Something went wrong', 'Error!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
        }

        $(document).on('click', '#save_with_automated_note_btn', function() {
            var patient_id = "{{ $patient->id }}";
            var min = $('#minutes').html();
            var sec = $('#seconds').html();
            var entry_type = "Automatic";
            var engagement_type = "Asynchronous";
            var note = "Viewed and Interpreted Patient Data";
            save_time_track(patient_id, engagement_type, entry_type, min, sec, note).done(function(response) {
                if (response) {
                    toastr.success('Your Time has been saved', 'Success!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    window.location.href = "{{ URL::to('home') }}";
                }
            });
        });
        $(document).on('click', '#save_with_custom_note_btn', function() {
            $('#time_track_modal').modal('show');
        });


        //Note related javascript

        $(document).on('click', '#add_note_btn', function() {
            $('#note_modal').modal('show');
        });
        $('#save_note_btn').click(function() {
            var patient_id = "{{ $patient->id }}";
            var notes = $('#patient_note').val();
            var noteDate = $('#date').val();
            if (patient_id && notes && noteDate) {
                $.ajax({
                    url: "{{ route('my-notes.store') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id,
                        patient_note: notes,
                        date: noteDate,
                    },
                    success: function(response) {
                        if (response) {
                            var formattedDate = moment(response.date).format('MM-DD-YYYY');
                            var row = note_table.row.add([
                                '',
                                formattedDate,
                                response.note,
                                '<button class="btn btn-sm btn-success" type="button" data-id="' +
                                response.id + '"><i class="fas fa-pencil-alt"></i></button>'
                            ]).draw();

                            toastr.success('Data has been saved', 'Success', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#note_modal').modal('hide');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }

        });
        var note_table_row;

        $('#note_table tbody').on('click', 'button', function() {
            var id = $(this).data('id');
            var edit_url = "{{ route('my-notes.edit', ':id') }}";
            edit_url = edit_url.replace(":id", id);

            note_table_row = note_table.row($(this).parents('tr'));

            if (id) {
                $.ajax({
                    url: edit_url,
                    type: "get",
                    success: function(response) {
                        if (response) {

                            $('#edit_note_modal').modal('show');
                            $('#edit_note_id').val(response.id);
                            $('#note_edit').val(response.note);
                            $('#date_edit').val(response.date);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        toastr.error('Something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            }
        });





        $('#update_note_btn').click(function() {
            var note_id = $('#edit_note_id').val();
            var note = $('#note_edit').val();
            var date = $('#date_edit').val();

            var update_url = "{{ route('my-notes.update', ':id') }}";
            update_url = update_url.replace(':id', note_id);

            if (note) {
                $.ajax({
                    url: update_url,
                    type: "post",
                    data: {
                        _method: "PATCH",
                        note_id: note_id,
                        note: note,
                        date: date,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response) {
                            var formattedDate = moment(response.date).format('MM-DD-YYYY');
                            var row = note_table.row($('button[data-id="' + response.id + '"]').closest(
                                'tr'));
                            row.data([
                                '',
                                formattedDate,
                                response.note,
                                '<button class="btn btn-sm btn-success" type="button" data-id="' +
                                response.id + '"><i class="fas fa-pencil-alt"></i></button>'
                            ]).draw();


                            toastr.success('Data has been saved', 'Success', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });

                            $('#edit_note_modal').modal('hide');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Log the error details
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });


        $('#delete_note_btn').click(function() {
            var note_id = $('#edit_note_id').val();
            console.log(note_id);

            if (note_id) {
                $.ajax({
                    url: "{{ route('my-notes.destroy', ':id') }}".replace(':id', note_id),
                    type: "post",
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        note_table.row(note_table_row).remove().draw();

                        toastr.success('Data has been removed', 'Success', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_note_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            }
        });


        //End Note related javascript


        //Medication related javascript

        $(document).on('click', '#add_medication_btn', function() {
            $('#medication_modal').modal('show');
        });
        $('#save_medication_btn').click(function() {
            var patient_id = "{{ $patient->id }}";
            var medication_name = $('#medication_name').val();
            var dose = $('#dose').val();
            var frequency = $('#frequency').val();
            var route = $('#route').val();

            if (patient_id && medication_name && dose && frequency && route) {
                $.ajax({
                    url: "{{ route('medication.store') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id,
                        medication_name: medication_name,
                        dose: dose,
                        frequency: frequency,
                        route: route,

                    },
                    success: function(response) {
                        if (response) {

                            var row = medication_table.row.add([
                                -1,
                                response.medication_name,
                                response.dose,
                                response.frequency,
                                response.route,
                                '<button class="btn btn-sm btn-success" type="button" data-id="' +
                                response.id + '"><i class="fas fa-pencil-alt"></i></button>'

                            ]).draw();



                            toastr.success('Data has been saved', 'Success', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#medication_modal').modal('hide');
                        }
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }

        });
        var medication_table_row;
        $('#medication_table tbody').on('click', 'button', function() {
            var id = $(this).data('id');
            var edit_url = "{{ route('medication.edit', ':id') }}";
            edit_url = edit_url.replace(":id", id);

            medication_table_row = medication_table.row($(this).parents('tr'));
            if (id) {
                $.ajax({
                    url: edit_url,
                    type: "get",
                    success: function(response) {
                        $('#edit_medication_modal').modal('show');
                        $('#medication_id').val(response.id);
                        $('#edit_medication_name').val(response.medication_name);
                        $('#edit_dose').val(response.dose);
                        $('#edit_frequency').val(response.frequency);
                        $('#edit_route').val(response.route);
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            }
        });
        $('#update_medication_btn').click(function() {
            var medication_name = $('#edit_medication_name').val();
            var dose = $('#edit_dose').val();
            var frequency = $('#edit_frequency').val();
            var route = $('#edit_route').val();
            var medication_id = $('#medication_id').val();

            var update_url = "{{ route('medication.update', ':id') }}";
            update_url = update_url.replace(':id', medication_id);

            if (medication_name && dose && frequency && route) {
                $.ajax({
                    url: update_url,
                    type: "post",
                    data: {
                        _method: "PATCH",
                        medication_name: medication_name,
                        dose: dose,
                        frequency: frequency,
                        route: route,
                    },
                    success: function(response) {
                        var new_data = [
                            -1,
                            response.medication_name,
                            response.dose,
                            response.frequency,
                            response.route,
                            '<button class="btn btn-sm btn-success" type="button" data-id="' +
                            response.id + '"><i class="fas fa-pencil-alt"></i></button>'
                        ];
                        medication_table.row(medication_table_row).data(new_data).draw();
                        toastr.success('Data has been saved', 'Success', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_medication_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.warning(' Please fill all fields then press submit', 'Empty Fields', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });
        $('#delete_medication_btn').click(function() {
            var medication_id = $('#medication_id').val();
            var delete_url = "{{ route('medication.destroy', ':id') }}";
            delete_url = delete_url.replace(':id', medication_id);
            if (medication_id) {
                $.ajax({
                    url: delete_url,
                    type: "post",
                    data: {
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        medication_table.row(medication_table_row).remove().draw();;
                        toastr.success('Data has been removed', 'Success', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#edit_medication_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error('Something went wrong', 'Error', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                })
            }
        });

        //End Medication related javascript
    </script>

   <script>
    $('#unenrollPatientModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var enrollmentType = button.data('enrollment-type');
        var modal = $(this);


        modal.find('#enrollment_type').val(enrollmentType);


        if (enrollmentType === 'ccm') {
            modal.find('.modal-title').text('Un-Enroll Patient from CCM');
        } else if (enrollmentType === 'rpm') {
            modal.find('.modal-title').text('Un-Enroll Patient from RPM');
        } else if (enrollmentType === 'both') {
            modal.find('.modal-title').text('Un-Enroll Patient from Both CCM and RPM');
        }
    });
</script>
@endsection
