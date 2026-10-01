@extends('master.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                <div class="card-body py-0">
                    <form action="{{ route('patient.update', $patient) }}" class="mt-5" id="patient_form" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h2>Patient's Bio</h2>
                                <hr>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg required" name="first_name"
                                        value="{{ $patient->first_name }}">
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
                                    <input type="text" class="form-control form-control-lg required"
                                        name="last_name"value="{{ $patient->last_name }}">
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
                                        value="{{ $patient->email }}">
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
                                        name="dob" value="{{ $patient->dob }}" id="dob">
                                    @error('dob')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_no">Contact no: <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-lg required" name="contact_no" id="contact_no"
                                        value="{{ $patient->contact_no }}">
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
                                        name="age" value="{{ $patient->age }}">
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
                                        <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female
                                        </option>
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
                                    <label for="address">Address: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg " name="address"
                                        value="{{ $patient->address }}">
                                    @error('address')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 mt-3">
                                <h2>Patient's Detail</h2>
                                <hr>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="chronic_condition_id">Select Chronic Condition: <span
                                            class="text-danger">*</span></label>
                                    <select class="select2 form-control form-control-lg required" multiple="multiple"
                                        style="width: 100%; height:36px;" name="chronic_condition_id[]">
                                        @foreach ($chronic_conditions as $item)
                                            <option value="{{ $item->id }}"
                                                @foreach ($patient->chronic_conditions as $condition)
                                                        {{ $condition->id == $item->id ? 'selected' : '' }} @endforeach>
                                                {{ $item->chronic_condition_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('chronic_condition_id')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="practice_id">Practice Name: <span class="text-danger">*</span></label>
                                    <select class="select2 form-control form-control-lg required"
                                        style="height: 36px;width: 100%;" name="practice_id" id="practice_id">
                                        @foreach ($practices as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $patient->practice_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->practice_name }}</option>
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
                                        style="height: 36px;width: 100%;" name="care_manager_id" id="care_manager_id">
                                        @foreach ($care_managers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $patient->care_manager_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->user_name }}</option>
                                        @endforeach
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
                                    <label for="care_manager">Assign Doctor: <span class="text-danger">*</span></label>
                                    <select class="select2 form-control form-control-lg required"
                                        style="height: 36px;width: 100%;" name="doctor_id" id="doctor_id">
                                        @foreach ($doctors as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $patient->doctor_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->user_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="enrol_in_ccm">Enrol in CCM: <span class="text-danger">*</span></label>
                                    <select name="enrol_in_ccm" id="enrol_in_ccm" class="form-control form-control-lg">
                                        <option value="1" {{ $patient->enrol_in_ccm ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $patient->enrol_in_ccm ? '' : 'selected' }}>No</option>
                                    </select>
                                    @error('enrol_in_ccm')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="enrol_in_rpm">Enrol in RPM: <span class="text-danger">*</span></label>
                                    <select name="enrol_in_rpm" id="enrol_in_rpm" class="form-control form-control-lg">
                                        <option value="1" {{ $patient->enrol_in_rpm ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $patient->enrol_in_rpm ? '' : 'selected' }}>No</option>
                                    </select>
                                    @error('enrol_in_rpm')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row {{ $patient->enrol_in_ccm ? '' : 'd-none' }}" id="ccm_section">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="ccm_enrol_date">CCM Enrol Date: <span class="text-danger">*</span></label>
                                    <input type="string" class="form-control bg-white form-control-lg required"
                                        id="ccm_enrol_date" name="ccm_enrol_date"
                                        value="{{ $patient->formatted_ccm_enrol_date }}">
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
                                        <option value="Simple" {{ $patient->ccm_type == 'Simple' ? 'selected' : '' }}>
                                            Simple</option>
                                        <option value="Complex" {{ $patient->ccm_type == 'Complex' ? 'selected' : '' }}>
                                            Complex</option>
                                    </select>
                                    @error('ccm_type')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insurance_id">Insurance Name: <span class="text-danger">*</span></label>
                                    <select class="select2 form-control p-3" style="width: 100%; height:46px;"
                                        name="insurance_id">
                                        <option value=""></option>
                                        @foreach ($insurances as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $patient->insurance_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->insurance_name }}</option>
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
                                    <input type="string" class="form-control bg-white form-control-lg" id="policy_no"
                                        name="policy_no" value="{{ $patient->policy_no }}">
                                    @error('policy_no')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row {{ $patient->enrol_in_rpm ? '' : 'd-none' }}" id="rpm_section">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="rpm_enrol_date">RPM Enrol Date: <span class="text-danger">*</span></label>
                                    <input type="string" class="form-control bg-white form-control-lg"
                                        id="rpm_enrol_date" name="rpm_enrol_date"
                                        value="{{ $patient->formatted_rpm_enrol_date }}">
                                    @error('rpm_enrol_date')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">

                                <div class="form-group">
                                    <label class="mb-2" for="consent">Does consent to Remote Patient Monitoring
                                        services?</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input material-inputs" type="radio" name="is_consent"
                                            id="radio1" value="Yes" checked>
                                        <label class="form-check-label" for="radio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input material-inputs" type="radio" name="is_consent"
                                            id="radio2" value="No">
                                        <label class="form-check-label" for="radio2">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input material-inputs" type="radio" name="is_consent"
                                            id="radio3" value="Skip">
                                        <label class="form-check-label" for="radio3">Skip For Now</label>
                                    </div>
                                    @error('consent')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="consent">Choose an option: <span class="text-danger">*</span></label>
                                    <select class="select2 form-control form-control-lg" name="consent">
                                        <option value="Verbal Consent"
                                            {{ $patient->consent == 'Verbal Consent' ? 'selected' : '' }}>Verbal Consent
                                        </option>
                                        <option value="Written Consent"
                                            {{ $patient->consent == 'Written Consent' ? 'selected' : '' }}>Written Consent
                                        </option>
                                        <option value="Other" {{ $patient->consent == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('consent')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="device_id">Device Serial Number: <span
                                            class="text-danger">*</span></label>
                                    <select class="select2 form-control form-control-lg" name="device_id" id="device_id">
                                        @if ($patient->device)
                                            <option value="{{ $patient->device->id }}" selected>
                                                {{ $patient->device->device_serial_no }}</option>
                                        @endif
                                        @foreach ($devices as $item)
                                            <option value="{{ $item->id }}">{{ $item->device_serial_no }}</option>
                                        @endforeach
                                    </select>
                                    @error('device_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-md btn-success" id="device_btn" type="button"><i
                                            class="fas fa-plus mr-1"></i>Add New Device</button>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-12 mt-3">
                                <h2>Patient's Prefrence</h2>
                                <hr>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="call_time">Best Time to call you</label>
                                    <select class="form-control form-control-lg" name="preferred_time">
                                        <option value="Any Time"
                                            {{ $patient->preferred_time == 'Any Time' ? 'selected' : '' }}>Any Time
                                        </option>
                                        <option value="Morning"
                                            {{ $patient->preferred_time == 'Morning' ? 'selected' : '' }}>Morning</option>
                                        <option value="Afternoon"
                                            {{ $patient->preferred_time == 'Afternoon' ? 'selected' : '' }}>Afternoon
                                        </option>
                                        <option value="Evening"
                                            {{ $patient->preferred_time == 'Evening' ? 'selected' : '' }}>Evening</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="language">Select Language: <span class="text-danger">*</span></label>
                                    <select class="select2 form-control form-control-lg" name="preferred_language"
                                        style="height: 36px;width: 100%;">
                                        @if ($languages)
                                            @foreach ($languages as $item)
                                                <option value="{{ $item }}"
                                                    {{ $patient->preferred_language == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('preferred_language')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="communication_preference d-block">Communication Preference:</label>
                                    <br>
                                    <div class="mt-2">

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="preferred_communication" id="inlineRadio3" value="text"
                                                {{ $patient->preferred_communication == 'text' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio3">Text</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="preferred_communication" id="inlineRadio4" value="call"
                                                {{ $patient->preferred_communication == 'call' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio4">Call</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input material-inputs" type="radio"
                                                name="preferred_communication" id="inlineRadio5" value="email"
                                                {{ $patient->preferred_communication == 'email' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio5">Email</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-12 my-3">
                                <button class="btn btn-success">Submit</button>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Please select an option"
            });
            $("#contact_no").inputmask("+99999999999");

            $('#dob').flatpickr({
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
           $(document).on('change', '#enrol_in_ccm', function() {
            const isCCM = $(this).val() === '1';
            const $ccmSection = $('#ccm_section');
            const $rpmSection = $('#rpm_section');
        
            if (isCCM) {
                $ccmSection.find('input').not('#policy_no').addClass('required');
                $('#policy_no').removeClass('required').removeAttr('required');
                $ccmSection.find('select').addClass('required');
                $ccmSection.removeClass('d-none');
                $rpmSection.addClass('d-none');
            } else {
                $ccmSection.find('input, select').removeClass('required').removeAttr('required');
                $ccmSection.addClass('d-none');
                $('#enrol_in_rpm').val('1');
                $rpmSection.find('input, select').addClass('required');
                $rpmSection.removeClass('d-none');
            }
        
            // Mutation observer to prevent unexpected required changes to policy_no
            const policyNoInput = document.getElementById('policy_no');
            if (policyNoInput) {
                const observer = new MutationObserver(mutations => {
                    mutations.forEach(mutation => {
                        if (mutation.type === 'attributes' && ($('#policy_no').hasClass('required') || $('#policy_no').attr('required') !== undefined)) {
                            $('#policy_no').removeClass('required').removeAttr('required');
                        }
                    });
                });
                observer.observe(policyNoInput, { attributes: true });
            }
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
    </script>
@endsection
