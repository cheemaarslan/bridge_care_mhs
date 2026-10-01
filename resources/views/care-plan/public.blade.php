<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Care Plan</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/xtremeadmin/" />
    <link href="{{asset('dist/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/extra-libs/toastr/dist/build/toastr.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('custom/css/index.css')}}">
</head>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-lg navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand w-100" href="#">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            {{-- <img src="{{asset('images/logo_final.png')}}" alt="homepage" class="light-logo" /> --}}
                            <!-- Light Logo icon -->
                            {{-- <img src="{{asset('images/logo_final.png')}}" alt="homepage" class="light-logo" /> --}}
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->

                    </a>
                    <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i>
                    </a>
                </div>
                <div class="w-75">

                </div>
                <div class="navbar-collapse collapse float-right" id="navbarSupportedContent">
                    <ul class="navbar-nav float-right">
                        <li class="nav-item d-flex align-items-center mr-2">
                            <img src="{{ asset('assets/images/mhs-logo.webp') }}" alt="Logo" style="height: 40px; width: auto;">
                        </li>
                        <li class="nav-item dropdown">
                            <button id="print" class="btn btn-danger" type="button"> <span><i class="fa fa-print"></i> </span> </button>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="content-page">
            <div class="content">
                <div class="page-wrapper d-block">
                    <ol class="breadcrumb p-4">
                        <li class="breadcrumb-item font-weight-bold">
                            <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
                        </li>
                        <li class="breadcrumb-item font-weight-bold">
                            <a href="{{route('patient.show',$care_plan->patient)}}" class="inactive">{{$care_plan->patient->first_name}} {{$care_plan->patient->last_name}}</a>
                        </li>
                        <li class="breadcrumb-item font-weight-bold">
                            <a href="#" class="inactive">Care Plan</a>
                        </li>
                        <li class="breadcrumb-item font-weight-bold">
                            <a href="#" class="inactive">{{$care_plan->reference_no}}</a>
                        </li>
                        <li class="breadcrumb-item font-weight-bold">
                            <a href="#" class="active">Show</a>
                        </li>
                    </ol>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body printableArea mt-4">
                                        <h3><b>{{ $care_plan->patient->first_name }} CarePlan</b></h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-3 col-12">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <div class="mt-4">
                                                            <img src="{{ $care_plan->patient->patient_image }}" class="rounded-circle"
                                                                 width="150" />
                                                            <h6 class="card-subtitle mt-3 font-weight-bold text-dark">
                                                                {{ $care_plan->patient->gender }}</h6>
                                                            <h6 class="card-subtitle font-weight-bold text-dark">Age -
                                                                {{ $care_plan->patient->age }}</h6>
                                                            <h4 class="card-title mt-2">{{ $care_plan->patient->first_name }}
                                                                {{ $care_plan->patient->last_name }}</h4>
                                                            <span
                                                                class="badge {{ $care_plan->status == 'Approved' ? 'badge-success' : 'badge-danger' }}"
                                                                id="status">{{ $care_plan->status }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="mt-4">
                                                            <small class="font-weight-bold text-dark">DOB </small>
                                                            <h6>{{ $care_plan->patient->dob }}</h6>
                                                            <small class="pt-4 db font-weight-bold text-dark">Contact No</small>
                                                            <h6>{{ $care_plan->patient->contact_no }}</h6>
                                                            <small class="font-weight-bold text-dark pt-4 db">Address</small>
                                                            <h6>{{ $care_plan->patient->address }}</h6>
                                                            <small class="font-weight-bold text-dark pt-4 db">Prefered Language</small>
                                                            <h6>{{ $care_plan->patient->preferred_language }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-12">
                                                <div class="card-body">
                                                    <div class="mt-4">
                                                        <small class="font-weight-bold text-dark">Age </small>
                                                        <h6>{{ $care_plan->patient->age }}</h6>
                                                        <small class="font-weight-bold text-dark pt-4 db">Email Address</small>
                                                        <h6>{{ $care_plan->patient->email }}</h6>
                                                        <small class="font-weight-bold text-dark pt-4 db">CCM Enrolled Data</small>
                                                        <h6>{{ $care_plan->patient->formatted_ccm_enrol_date }}</h6>
                                                        <small class="font-weight-bold text-dark pt-4 db">Practice Name</small>
                                                        <h6>{{ $practice->practice_name }}</h6>
                                                        <small class="font-weight-bold text-dark  pt-4 db">Care Manager</small>
                                                        <h6>{{ $care_plan->patient->care_manager->user_name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <h6>Care Plan Created At</h6>
                                                            <p>{{ $care_plan->date }}</p>
                                                        </td>
                                                        <td>
                                                            <h6>CCM Enrol Date</h6>
                                                            <p>{{ $care_plan->patient->formatted_ccm_enrol_date }}</p>
                                                        </td>
                                                        <td>
                                                            <h6>Chronic Condition</h6>
                                                            <p>{{ $care_plan->patient->chronic_conditions->count() }}</p>
                                                        </td>
                                                        <td>
                                                            <h6>Medication</h6>
                                                            <p>{{ $care_plan->patient->medications->count() }}</p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12">
                                                <h4 class="m-3">Chronic Conditions</h4>
                                                <p class="m-3">
                                                    @if ($care_plan->patient->chronic_conditions)
                                                        @foreach ($care_plan->patient->chronic_conditions as $item)
                                                            <span>{{ $item->chronic_condition_name }}</span>,
                                                        @endforeach
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <hr>

                                        @foreach ($schemes as $item)
                                            @if ($item->id == 5)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="m-3">{{$item->scheme_name}}</h4>
                                                        <div class="table-responsive m-2">
                                                            <table class="table" id="medication_table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">Medication Name</th>
                                                                    <th scope="col">Medication Dose</th>
                                                                    <th scope="col">Medication Route</th>
                                                                    <th scope="col">Medication Doctor</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse ($care_plan->medications as $medication)
                                                                    <tr>
                                                                        <td>{{ $medication->medication_name }}</td>
                                                                        <td>{{ $medication->dose }}</td>
                                                                        <td>{{ $medication->route }}</td>
                                                                        <td>{{ $medication->frequency }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="text-center">No Record was found</td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($item->id == 7)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="m-3">{{$item->scheme_name}}</h4>
                                                        <div class="table-responsive m-2">
                                                            <table class="table" id="contact_table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">Full Name</th>
                                                                    <th scope="col">Practice Type</th>
                                                                    <th scope="col">Address</th>
                                                                    <th scope="col">Contact No</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse ($care_plan->contacts as $contact)
                                                                    <tr>
                                                                        <td>{{ $contact->full_name }}</td>
                                                                        <td>{{ $contact->type }}</td>
                                                                        <td>{{ $contact->address }}</td>
                                                                        <td>{{ $contact->contact_no }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="text-center">No Record was found</td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($item->id == 8)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="m-3">{{$item->scheme_name}}</h4>
                                                        <div class="table-responsive m-2">
                                                            <table class="table" id="Patient_intervations">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">Condition Name</th>
                                                                    <th scope="col">Symptom</th>
                                                                    <th scope="col">Planned Intervention</th>
                                                                    <th scope="col">Person Responsible</th>
                                                                    <th scope="col">Time Frame</th>
                                                                    <th scope="col">Prognosis</th>
                                                                    <th scope="col">Desired Outcome</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse ($care_plan->planned_interventions as $item)
                                                                    <tr>
                                                                        <td>{{ $item->chronic_condition_name }}</td>
                                                                        <td>{{ $item->symptom }}</td>
                                                                        <td>{{ $item->planned_intervention }}</td>
                                                                        <td>{{ $item->person_responsible }}</td>
                                                                        <td>{{ $item->time }}</td>
                                                                        <td>{{ $item->prognosis }}</td>
                                                                        <td>{{ $item->desired_outcome }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">No Record was found</td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($item->id == 9)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="m-3">{{$item->scheme_name}}</h4>
                                                        <div class="table-responsive m-2">
                                                            <table class="table" id="goal_table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Current</th>
                                                                    <th scope="col">Desired Goal</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse ($care_plan->treatment_goals as $goal)
                                                                    <tr>
                                                                        <td>{{ $goal->goal_name }}</td>
                                                                        <td>{{ $goal->current }}</td>
                                                                        <td>{{ $goal->goal }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="text-center">No Record was found
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($item->id == 10)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="m-3">{{$item->scheme_name}}</h4>
                                                        <div class="table-responsive m-2">
                                                            <table class="table" id="screening_table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">Screening Name</th>
                                                                    <th scope="col">Date</th>
                                                                    <th scope="col">Answer</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse ($care_plan->care_plan_screenings as $screening)
                                                                    <tr>
                                                                        <td>
                                                                            <p>{{ $screening->screening_name }}</p>
                                                                            <input type="" class="form-control w-50"
                                                                                   value="{{ $screening->comment }}" readonly>

                                                                        </td>
                                                                        <td>{{ $screening->date }}</td>
                                                                        <td>{{ $screening->answer }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="text-center">No Record was found</td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($item->id == 11)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="m-3">{{$item->scheme_name}}</h4>
                                                        <div class="table-responsive m-2">
                                                            <table class="table" id="test_table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col">Test Name</th>
                                                                    <th scope="col">Date</th>
                                                                    <th scope="col">Answer</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse ($care_plan->care_plan_tests as $test)
                                                                    <tr>
                                                                        <td class="w-75">
                                                                            <p>{{ $test->test_name }}</p>
                                                                            <p>{{ $test->test->consent }}</p>

                                                                            <input type="text" class="form-control w-50"
                                                                                   value="{{ $test->comment }}" readonly>

                                                                        </td>
                                                                        <td>{{ $test->date }}</td>
                                                                        <td>{{ $test->answer }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="text-center">No Record was found
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="m-3">{{$item->scheme_name}}</h4>
                                                        <div class="table-responsive m-2">
                                                            <table class="table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th>Question</th>
                                                                    <th>Answer</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($item->questions as $question)
                                                                    <tr>
                                                                        <td>
                                                                            <p class="text-justify mt-2"> {{ $question->question }}</p>
                                                                            @if ($question->answer)
                                                                                @if($question->answer->answer == "Yes")
                                                                                    <label for="comment">Comment</label>
                                                                                    <input type="text" class="form-control w-25" value="{{ $question->answer->comment }}" disabled>
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($question->answer)
                                                                                {{ $question->answer->answer }}
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="row">
                                                <div class="col-12 px-4">
                                                    <h4 style="color: #fff;
                                        background-color: #343a40;
                                        border-color: #454d55;" class="p-3 w-100 rounded">Chronic Care Management Verbal Consent -Obtained:</h4>
                                                    <p class="text-justify px-2">
                                                        We have discussed with the patient that the patient has two or more chronic conditions
                                                        which are expected to last at least 12 months or until the patient's death. These
                                                        conditions place the patient at a significant risk of death, acute exacerbation,
                                                        decompensation and or functional decline. We have discussed that our team of qualified
                                                        health care professionals will establish and revise a comprehensive care plan. In light
                                                        of the patient's multiple medical comorbidities, the patient has mild to high complex
                                                        decision making. We will be spending 20-60 minutes of clinical staff time by a physician
                                                        or other qualified clinical staff per calendar month. It was explained to the patient
                                                        that their Patient Health Information will be inputted in an Electronic Health Record.
                                                    </p>
                                                    <p class="text-justify px-2">
                                                        AGREEMENT TO RECEIVE MEDICARE CHRONIC CARE MANAGEMENT SERVICES As of
                                                        {{ $care_plan->patient->ccm_enrol_date }}, Medicare covers chronic care management
                                                        services provided by physician practices per calendar month. I understand that my
                                                        primary care physician, named below, is willing to provide such services to me,
                                                        including the following:
                                                    </p>
                                                    <p class="text-justify px-2">
                                                        Access to my care team 24-hours-a-day, 7-days-a-week, including telephone access and
                                                        other non-face-to-face means of communication (e.g., email, texts) The ability to get
                                                        successive, routine appointments with my designated primary care physician or member of
                                                        my care team, Care management of my chronic conditions, including timely scheduling of
                                                        all recommended preventive care services, medication reconciliation, and oversight of my
                                                        medication management, Creation of a comprehensive plan of care for all my health issues
                                                        that is specific to me and congruent with my choices and values
                                                    </p>
                                                    <p class="text-justify px-2">
                                                        Management of my care as I move between and among health care providers and settings,
                                                        including the following:
                                                    </p>
                                                    <ul>
                                                        <li>Referrals to other health care providers, </li>
                                                        <li>Follow-up after I visit an emergency department, </li>
                                                        <li>Follow-up after I am discharged from the hospital or other facility (e.g., skilled
                                                            nursing facility), </li>
                                                    </ul>
                                                    <p class="text-justify px-2">Coordination with home- and community-based providers of clinical
                                                        services</p>
                                                    <p class="text-justify px-2">Patient understands that as part of these services they will
                                                        receive a copy of my comprehensive plan of care and have access to it electronically.
                                                        Patient also understands that they can revoke this agreement at any time (effective at
                                                        the end of a calendar month) and can choose, instead, to receive these services from
                                                        another health care professional after the calendar month in which this agreement is
                                                        revoked. Medicare will only pay one physician or health care professional to furnish
                                                        chronic care management services within a given calendar month. The Patient understands
                                                        these chronic care management services are subject to the usual Medicare deductible and
                                                        coinsurance applied to physician services. The Patient hereby indicates by verbal
                                                        consent on this agreement that Dr. Demo Provider is designated as the primary care
                                                        physician for purposes of providing Medicare chronic care management services to the
                                                        patient and billing for them. The verbal consent also authorizes the primary care
                                                        physician to electronically communicate my medical information with other treating
                                                        providers as part of the care coordination involved in chronic care management services.
                                                        This designation is effective as of the date of this file and remains in effect until
                                                        revoked by the patient. </p>

                                                </div>
                                            </div>
                                        <div class="row">
                                                <div class="col-12 text-center">
                                                    @if ($care_plan->status === 'Approved')
                                                        <h3 class="my-3 text-danger">This Care Plan Electronically signed by
                                                            {{ $care_plan->care_plan_approved_by->user_name }}</h3>
                                                    @else
                                                        <h3 class="my-3 text-danger">This Care Plan has not yet approved</h3>
                                                    @endif
                                                </div>
                                            </div>
                                        <div class="row">
                                                <div class="col-12">
                                                    <h4 class="m-3">Activity Logs</h4>
                                                    <div class="table-responsive">
                                                        <table class="table m-2">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>User</th>
                                                                <th>Description</th>
                                                                <th>Time</th>
                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                            @foreach ($care_plan->time_tracks as $item)
                                                                <tr>
                                                                    <td>{{ $item->formatted_date }}</td>
                                                                    <td>{{ $item->formatted_time }}</td>
                                                                    <td>{{ $item->user->user_name }}</td>
                                                                    <td>{{ $item->description }}</td>
                                                                    <td>{{ $item->minutes }}:{{ $item->seconds }}</td>

                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="4" class="text-right">Total Time:</td>
                                                                <td>{{ $care_plan->minutes }}: {{ $care_plan->seconds }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="row">
                                                @foreach ($care_plan->special_screenings as $screening)
                                                    @if($screening->screening_name == "AMT-10")
                                                        <div class="col-12 mt-4">
                                                            <div class="care mx-3 px-3 py-2">
                                                                <div class="row">
                                                                    <div class="col-1">
                                                                        <img src="{{ asset('images/careplan2.png') }}" height="80" width="80">
                                                                    </div>
                                                                    <div class="col-6 text-center">
                                                                        <h3 class="mt-4 text-dark font-weight-bold">Abbreviated Mental Test - 10</h3>
                                                                    </div>
                                                                    <div class="col-4 text-center">
                                                                        <h3 class="mt-4 font-weight-bold">{{$screening->screening_description}}</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($screening->screening_name == "PHQ-9")
                                                        <div class="col-12 mt-4">
                                                            <div class="care mx-3 px-3 py-2">
                                                                <div class="row">
                                                                    <div class="col-1">
                                                                        <img src="{{ asset('images/careplan4.png') }}" height="80" width="80">
                                                                    </div>
                                                                    <div class="col-6 text-center">
                                                                        <h3 class="mt-4 text-dark font-weight-bold">Patient Health Questionnaire - 9</h3>
                                                                    </div>
                                                                    <div class="col-4 text-center">
                                                                        <h3 class="mt-4 font-weight-bold">{{$screening->screening_description}}</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <!-- content -->
        </div>
    </div>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- apps -->
    <script src="{{asset('dist/js/app.min.js')}}"></script>
    <script src="{{asset('dist/js/app.init.horizontal.js')}}"></script>
    <script src="{{asset('dist/js/app-style-switcher.horizontal.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <!--Wave Effects -->
    {{-- <script src="{{asset('dist/js/waves.js')}}"></script> --}}
    <!--Menu sidebar -->
    <script src="{{asset('dist/js/custom.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/toastr/dist/build/toastr.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/samplepages/jquery.PrintArea.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });

        });

    </script>
</body>
</html>
