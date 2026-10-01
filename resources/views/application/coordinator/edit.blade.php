@extends('master.app')

@section('css')
    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-success mb-0">{{ env('APP_NAME') }}</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('coordinator-application.index') }}">Coordinatior
                        Application</a></li>
                <li class="breadcrumb-item active">{{ $coordinator_application->first_name }}</li>
            </ol>
        </div>

    </div>
    <div class="row page-titles">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Coordinatior</h4>
                    <h6 class="card-subtitle"></h6>
                    <form action="{{ route('coordinator-application.update', $coordinator_application) }}" class="mt-5"
                        id="patient_form" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" id="first_name" class="form-control form-control-lg required"
                                        name="first_name" value="{{ $coordinator_application->first_name }}">
                                    @error('first_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" id="last_name" class="form-control form-control-lg required"
                                        name="last_name" value="{{ $coordinator_application->last_name }}">
                                    @error('last_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="user_name">User Name:</label>
                                    <input type="text" id="user_name" class="form-control form-control-lg required"
                                        name="user_name" value="{{ $coordinator_application->user_name }}">
                                    @error('user_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control form-control-lg required" name="email"
                                        value="{{ $coordinator_application->email }}">
                                    @error('email')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="state">State Name:</label>
                                    <input type="text" class="form-control form-control-lg" name="state"
                                        value="{{ $coordinator_application->state }}">
                                    @error('state')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="city">City Name:</label>
                                    <input type="text" class="form-control form-control-lg" name="city"
                                        value="{{ $coordinator_application->city }}">
                                    @error('city')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control form-control-lg" name="address"
                                        value="{{ $coordinator_application->address }}">
                                    @error('address')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
    {{-- check box script --}}


    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    {{-- <script>
        //Custom design form example


        var form = $(".validation-wizard").show();


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
        })

    </script> --}}
@endsection
