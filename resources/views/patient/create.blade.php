@extends('master.app')

@section('css')
    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="{{ asset('assets/extra-libs/horizontal-timeline/horizontal-timeline.css') }}" rel="stylesheet">
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
    <div class="row page-titles px-0">
        <div class="col-12">
            <div class="card">
                <div class="card-body wizard-content">
                    <h4 class="card-title">Add New Patient</h4>
                    <h6 class="card-subtitle"></h6>
                    <form action="{{ route('patient.store') }}" class="validation-wizard wizard-circle mt-5"
                        id="patient_form" method="POST">
                        @csrf
                        <!-- Step 1 -->
                        <h6>Bio</h6>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg required"
                                            name="first_name" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg required" name="last_name"
                                            value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email ">Email: <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-lg required" name="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date of birth: <span class="text-danger">*</span></label>
                                        <input type="string" class="form-control bg-white form-control-lg required"
                                            id="dob" name="dob" value="{{ old('dob') }}">
                                        @error('dob')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_no">Contact no: </label>
                                        <input type="text" class="form-control form-control-lg " id="contact_no"
                                            name="contact_no" value="{{ old('contact_no') }}">
                                        @error('contact_no')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age">Age: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg required " id="age"
                                            name="age" value="{{ old('age') }}">
                                        @error('age')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Gender">Gender: <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-lg required" name="gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control form-control-lg required" name="address"
                                            value="{{ old('address') }}">
                                        @error('address')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </section>
                        <!-- Step 2 -->
                        <h6>Detail</h6>
                        <section>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">

                                        <label for="Chronic_condition">Select Chronic Condition: <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 form-control form-control-lg required" multiple
                                            style="width: 100%; height:36px;" name="chronic_condition_id[]">
                                            <option value=""></option>
                                            @foreach ($chronic_conditions as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->chronic_condition_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('chronic_condition_id')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="practice_id">Practice Name: <span class="text-danger">*</span></label>
                                        <select class="select2 form-control form-control-lg required"
                                            style="height: 36px;width: 100%;" name="practice_id" id="practice_id">
                                            <option value=""></option>
                                            @foreach ($practices as $item)
                                                <option value="{{ $item->id }}">{{ $item->practice_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('practice_id')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="care_manager">Assign Care Manager: <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 form-control form-control-lg required"
                                            style="height: 36px;width: 100%;" name="care_manager_id"
                                            id="care_manager_id">
                                            <option value=""></option>
                                        </select>
                                        @error('care_manager_id')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="care_manager">Assign Doctor: <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 form-control form-control-lg required"
                                            style="height: 36px;width: 100%;" name="doctor_id"
                                            id="doctor_id">
                                            <option value=""></option>
                                        </select>
                                        @error('doctor_id')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                {{-- <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="enrol_in_ccm">Enrol in CCM: <span class="text-danger">*</span></label>
                                        <select name="enrol_in_ccm" id="enrol_in_ccm"
                                            class="form-control form-control-lg required">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-lg-12 col-12">
                                    <div class="form-group">
                                        <label for="enrol_in_rpm">Enrol in RPM: <span class="text-danger">*</span></label>
                                        <select name="enrol_in_rpm" id="enrol_in_rpm"
                                            class="form-control form-control-lg required">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none" id="ccm_section">
                                <div class="col-12">
                                    <div class="card shadow p-3">

                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="first" role="tabpanel"
                                                aria-labelledby="list-home-list">
                                                <h3>Introduction</h3>
                                                <p>Hi, My Name is <strong>{{ auth()->user()->user_name }}</strong>.</p>
                                                <p>I am calling from <strong>{{ $doctor->user_name }}</strong> 's Office.
                                                </p>
                                                <p><strong>{{ $doctor->user_name }}</strong> would like me to call you on a
                                                    monthly basis and make sure you are feeling alright, have all your
                                                    medications, assist you in making appointments, and help you in any way
                                                    we can.</p>
                                                <p>Is this Something You Would Like To Learn More About?</p>
                                                <div class="btn-list">
                                                    <a class="btn btn-secondary switch" data-toggle="list" href="#"
                                                        role="tab" disabled>Previous</a>
                                                    <a class="btn btn-success switch" data-toggle="list" href="#second"
                                                        role="tab">Next</a>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="second" role="tabpanel"
                                                aria-labelledby="list-profile-list">
                                                <h3>That is GREAT to hear. Here are a few facts you may find useful.</h3>
                                                <p><strong>Access to Care & Care Continuity</strong></p>
                                                <ul class="list-style-none">
                                                    <li>
                                                        <span><i class="fa fa-circle font-size-2 float-left mr-2"
                                                                aria-hidden="true"></i></span>
                                                        <p class="inline-block">Provide 24-hour-a-day, 7-day-week (24/7)
                                                            access to physicians or other qualified healthcare professionals
                                                            or clinical staff, including providing patient (and caregivers
                                                            as appropriate) with a means to make contact with health care
                                                            professionals in a practice to address urgent need regardless of
                                                            the time of the day or day of week.</p>

                                                    </li>
                                                    <li>
                                                        <span><i class="fa fa-circle text-sm float-left mr-2"
                                                                aria-hidden="true"></i></span>
                                                        <p class="inline-block">Ensure continuity of care with a designated
                                                            member of the care team with whom the patient is able to
                                                            schedule successive routine appointment.</p>

                                                    </li>
                                                    <li>
                                                        <span><i class="fa fa-circle text-sm float-left mr-2"
                                                                aria-hidden="true"></i></span>
                                                        <p class="inline-block">Provide enhanced opportunities for the
                                                            patient and any caregiver to communicate with the practitioner
                                                            regarding the patient’s care plan by telephone and also through
                                                            secure messaging, secure internet, or other asynchronous
                                                            non-face-to-face consultation methods (for example, email or
                                                            secure patient portal).</p>
                                                    </li>
                                                </ul>
                                                <div class="btn-list">
                                                    <a class="btn btn-success switch" data-toggle="list" href="#first"
                                                        role="tab">Previous</a>
                                                    <a class="btn btn-success switch" data-toggle="list" href="#third"
                                                        role="tab">Next</a>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="third" role="tabpanel"
                                                aria-labelledby="list-messages-list">
                                                <p>Okay, I know that was a lot of great information, here are the last four
                                                    points.
                                                <p>You are free to stop these calls at any time.</p>
                                                <p>We can share your Care Plan with your other doctors.</p>
                                                <p>Only one doctor can perform these calls.</p>
                                                <p>Your insurance covers this program with your usual plan and copay
                                                    structure.</p>
                                                <div class="btn-list">
                                                    <a class="btn btn-success switch" data-toggle="list" href="#second"
                                                        role="tab">Previous</a>
                                                    <a class="btn btn-success switch" data-toggle="list" href="#forth"
                                                        role="tab">Next</a>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="forth" role="tabpanel"
                                                aria-labelledby="list-messages-list">
                                                <p>We will manage your care as you move between and among
                                                    health care providers and settings, including the following:
                                                    Referrals to other health care providors.
                                                    Follow-up after emergency department visit.
                                                    Follow-up after you are discharged from the hospital or other facility.
                                                    (e.g., skilled nursing facility)
                                                    Coordination with home and community-based providers of clinical
                                                    services.
                                                </p>
                                                <div class="btn-list">
                                                    <a class="btn btn-success switch" data-toggle="list" href="#third"
                                                        role="tab">Previous</a>
                                                    <a class="btn btn-secondary switch" data-toggle="list" href="#fifth"
                                                        role="tab">Next</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="ccm_enrol_date">CCM Enrol Date: <span
                                                class="text-danger">*</span></label>
                                        <input type="string" class="form-control bg-white form-control-lg"
                                            id="ccm_enrol_date" name="ccm_enrol_date"
                                            value="{{ old('ccm_enrol_date') }}">
                                        @error('ccm_enrol_date')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="ccm_type">CCM Enrol Type: </label>
                                        <select class="select2 form-control" name="ccm_type" id="ccm_type">
                                            <option value=""></option>
                                            <option value="Simple">Simple</option>
                                            <option value="Complex">Complex</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Insurance">Insurance Name: <span class="text-danger">*</span></label>
                                        <select class="select2 form-control form-control-lg" name="insurance_id">
                                            <option value=""></option>
                                            @foreach ($insurances as $item)
                                                <option value="{{ $item->id }}">{{ $item->insurance_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('insurance_id')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="policy_no">Policy Number:</label>
                                        <input type="string" class="form-control bg-white form-control-lg"
                                            id="policy_no" name="policy_no" value="{{ old('policy_no') }}">
                                        @error('policy_no')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="rpm_section">

                                <div class="col-12 ">
                                    <div class="form-group">
                                        <label for="rpm_enrol_date">RPM Enrol Date: <span
                                                class="text-danger">*</span></label>
                                        <input type="string" class="form-control bg-white form-control-lg required"
                                            id="rpm_enrol_date" name="rpm_enrol_date"
                                            value="{{ old('rpm_enrol_date') }}">
                                        @error('rpm_enrol_date')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">

                                    <div class="form-group">
                                        <label class="mb-2" for="consent">Does consent to Remote Patient Monitoring
                                            services?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="is_consent" id="radio1" value="Yes" checked>
                                            <label class="form-check-label" for="radio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="is_consent" id="radio2" value="No">
                                            <label class="form-check-label" for="radio2">No</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="is_consent" id="radio3" value="Skip">
                                            <label class="form-check-label" for="radio3">Skip For Now</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="consent">
                                    <div class="form-group">
                                        <label for="consent">Choose an option: <span class="text-danger">*</span></label>
                                        <select class="select2 form-control form-control-lg required" name="consent">
                                            <option value=""></option>
                                            <option value="Verbal Consent">Verbal Consent</option>
                                            <option value="Written Consent">Written Consent</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="device_id">Device Serial Number: <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 form-control form-control-lg required" name="device_id"
                                            id="device_id">
                                            <option value=""></option>
                                            @foreach ($devices as $item)
                                                <option value="{{ $item->id }}">SrNo: {{ $item->device_serial_no }}
                                                    IMEI: {{ $item->device_imei_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-md btn-success" id="device_btn" type="button"><i
                                                class="fas fa-plus mr-1"></i>Add New Device</button>
                                    </div>
                                </div>
                            </div>

                        </section>
                        <!-- Step 3 -->

                        <h6>Preference</h6>
                        <section>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="call_time">Best Time to call you</label>
                                        <select class="form-control form-control-lg required" name="preferred_time">
                                            <option value="Any Time">Any Time</option>
                                            <option value="Morning">Morning</option>
                                            <option value="Afternoon">Afternoon</option>
                                            <option value="Evening">Evening</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="language">Select Language</label>
                                        <select class="select2 form-control form-control-lg required"
                                            name="preferred_language" style="height: 36px;width: 100%;">
                                            @if ($setting->languages)
                                                @foreach ($setting->languages as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Preferred Communication</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="preferred_communication" id="inlineRadio3" value="text" checked>
                                            <label class="form-check-label" for="inlineRadio3">Text</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="preferred_communication" id="inlineRadio4" value="call">
                                            <label class="form-check-label" for="inlineRadio4">Call</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="preferred_communication" id="inlineRadio5" value="email">
                                            <label class="form-check-label" for="inlineRadio5">Email</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modal')
    <div class="modal fade" id="device_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add New Device</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="patient_contact_form">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="device_serial_no">Device Serial Number:</label>
                                    <input type="text" class="form-control form-control-lg" id="device_serial_no"
                                        name="device_serial_no" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="device_imei_no">Device IMEI Number:</label>
                                    <input type="text" class="form-control form-control-lg required"
                                        id="device_imei_no" name="device_imei_no">
                                    @error('device_imei_no')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-success" id="add_device_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('script')
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    {{-- <script src="{{asset('dist/js/pages/forms/select2/select2.init.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script src="{{ asset('assets/extra-libs/horizontal-timeline/horizontal-timeline.js') }}"></script>

    <script>
        //Custom design form example


        var form = $(".validation-wizard").show();

        $(document).on('click', '.switch', function() {
            $('.switch').removeClass('active');
            $(this).addClass('active');

        });

        $(".validation-wizard").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "Finish"
                },
                onStepChanging: function(event, currentIndex, newIndex) {
                    return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (
                        currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error")
                            .remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")),
                        form
                        .validate().settings.ignore = ":disabled,:hidden", form.valid())
                },
                onFinishing: function(event, currentIndex) {
                    return form.validate().settings.ignore = ":disabled", form.valid()
                },
                onFinished: function(event, currentIndex) {
                    document.getElementById("patient_form").submit();
                }
            }),
            $(".validation-wizard").validate({
                ignore: "input[type=hidden]",
                errorClass: "text-danger",
                successClass: "text-success",
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass)
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass)
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element)
                },
                rules: {
                    email: {
                        email: !0
                    }
                }
            });

        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Please select an option"
            });
            $("#contact_no").inputmask("+99999999999");

            var dob = $('#dob').flatpickr({
                dateFormat: "m-d-Y"
            });
            $('#rpm_enrol_date').flatpickr({
                dateFormat: "m-d-Y"
            });
            $('#ccm_enrol_date').flatpickr({
                dateFormat: "m-d-Y"
            });

        });


        $("#dob").on("change", function() {
            var selected = $(this).val();
            var dob = new Date(selected);
            dob = dob.getFullYear();

            var today = new Date();
            today = today.getFullYear();
            age = today - dob;
            if (age >= 18) {
                $('#age').val(age);
            } else {
                toastr.error('Age must be greater than 18', 'Error!', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 4000
                });
            }
        });

        $('.form-check-input').on('click', function() {
            if ($(this).val() === "1") {
                $('#consent').removeClass('d-none');
            } else {
                $('#consent').addClass('d-none');

            }
        });
        $(document).on('select2:select', '#practice_id', function() {
            var practice_id = $(this).val();
            $.ajax({
                url: "{{ route('selected_practice') }}",
                type: "post",
                data: {
                    practice_id: practice_id
                },
                success: function(response) {
                    if (response) {
                        $('#care_manager_id').empty();
                        $('#doctor_id').empty();

                        var option_1 = "<option></option>"
                        $.each(response.care_managers, function(index, value) {
                            option_1 += "<option value='" + value.id + "'>" + value.user_name +
                                "</option>"
                            $('#care_manager_id').html(option_1);
                        });

                        var option_2 = "<option></option>"

                        $.each(response.doctors, function(index, value) {
                            option_2 += "<option value='" + value.id + "'>" + value.user_name +
                                "</option>"
                            $('#doctor_id').html(option_2);
                        });

                    }

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


         $(document).ready(function() {
        $("#policy_no").removeClass("required").removeAttr("required");

        const policyNoInput = document.getElementById('policy_no');
        if (policyNoInput) {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.type === 'attributes') {
                        if ($("#policy_no").hasClass("required") || $("#policy_no").attr("required") !== undefined) {
                            $("#policy_no").removeClass("required").removeAttr("required");
                        }
                    }
                });
            });
            observer.observe(policyNoInput, { attributes: true });
        }

        $(document).on('change', '#enrol_in_ccm', function() {
            const isCCM = $(this).val() === '1';
            const $ccmSection = $('#ccm_section');
            const $rpmSection = $('#rpm_section');

            if (isCCM) {
                $ccmSection.find('input').not('#policy_no').addClass('required');
                $("#policy_no").removeClass("required").removeAttr("required");
                $ccmSection.find('select').addClass('required');
                $ccmSection.removeClass('d-none');
                $rpmSection.addClass('d-none');
                $rpmSection.find('input, select').removeClass('required').removeAttr('required');
            } else {
                $ccmSection.find('input, select').removeClass('required').removeAttr('required');
                $ccmSection.addClass('d-none');
                $('#enrol_in_rpm').val('1').trigger('change');
                $rpmSection.find('input, select').addClass('required');
                $rpmSection.removeClass('d-none');
            }
        });

        $(document).on('change', '#enrol_in_rpm', function() {
            const isRPM = $(this).val() === '1';
            const $ccmSection = $('#ccm_section');
            const $rpmSection = $('#rpm_section');

            if (isRPM) {
                $rpmSection.find('input, select').addClass('required');
                $rpmSection.removeClass('d-none');
                $ccmSection.addClass('d-none');
                $ccmSection.find('input, select').removeClass('required').removeAttr('required');
                $('#enrol_in_ccm').val('0').trigger('change');
            } else {
                $rpmSection.find('input, select').removeClass('required').removeAttr('required');
                $rpmSection.addClass('d-none');
                $('#enrol_in_ccm').val('1').trigger('change');
                $ccmSection.find('input').not('#policy_no').addClass('required');
                $("#policy_no").removeClass("required").removeAttr("required");
                $ccmSection.find('select').addClass('required');
                $ccmSection.removeClass('d-none');
            }

            setTimeout(function() {
                if ($("#policy_no").hasClass("required") || $("#policy_no").attr("required") !== undefined) {
                    $("#policy_no").removeClass("required").removeAttr("required");
                }
            }, 1000);
        });
    });



        $(document).on('change', '#enrol_in_rpm', function() {
            if ($(this).val() === "1") {
                $("#rpm_section").find('input').addClass("required");
                $("#rpm_section").find('select').addClass("required");
                $('#rpm_section').removeClass('d-none');

            } else {
                $("#rpm_section").find('input').removeClass("required");
                $("#rpm_section").find('select').removeClass("required");
                $('#rpm_section').addClass('d-none');
                $('#enrol_in_ccm').val('1');

                $("#ccm_section").find('input').addClass("required");
                $("#ccm_section").find('select').addClass("required");
                $('#ccm_section').removeClass('d-none');


            }
        });

        $(document).on('click', '#device_btn', function() {
            $('#device_modal').modal('show');

        });

        $(document).on('click', '#add_device_btn', function() {
            var device_serial_no = $('#device_serial_no').val();
            var device_imei_no = $('#device_imei_no').val();
            if (device_serial_no && device_imei_no) {
                $.ajax({
                    url: "{{ route('device.store') }}",
                    type: "post",
                    data: {
                        device_serial_no: device_serial_no,
                        device_imei_no: device_imei_no,
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            var option = '<option value="' + response.device.id + '">SrNo: ' + response
                                .device.device_serial_no + ' IMEI: ' + response.device.device_imei_no +
                                '</option>';
                            $('#device_id').append(option);

                            $('#device_modal').modal('show');

                            toastr.success('New Device has been Added', 'Message Sent', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.errors.device_serial_no, 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            } else {
                toastr.error("Please Fill out all fields", 'Error!', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });
    </script>
@endsection
