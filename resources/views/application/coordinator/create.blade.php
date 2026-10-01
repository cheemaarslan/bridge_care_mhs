@extends('master.app')

@section('css')
    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    <div id="row page-titles px-0">
        <div class="col-12">
            <div class="card">
                <div class="card-body wizard-content">
                    <h6 class="card-subtitle"></h6>
                    <form action="#"class="validation-wizard wizard-circle mt-5" id="patient_form">
                        <!-- Step 1 -->
                        <h6 id="steps-uid-5-h-0" tabindex="-1" class="title current">Registration</h6>
                        <section id="steps-uid-5-p-0" role="tabpanel" aria-labelledby="steps-uid-5-h-0" class="body current"
                            aria-hidden="false">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName1">First Name :</label>
                                        <input type="text" class="form-control" id="firstName1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="LastName1">Last Name :</label>
                                        <input type="text" class="form-control" id="firstName1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userName1">User Name :</label>
                                        <input type="text" class="form-control" id="firstName1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emailAddress1">Email Address :</label>
                                        <input type="email" class="form-control" id="emailAddress1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Password">Create Password :</label>
                                        <input type="text" class="form-control" id="Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Password">Re-Enter Password :</label>
                                        <input type="text" class="form-control" id="Password">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Step 2 -->
                        <h6 id="steps-uid-5-h-1" tabindex="-1" class="title">Contact Info</h6>
                        <section id="steps-uid-5-p-1" role="tabpanel" aria-labelledby="steps-uid-5-h-1" class="body"
                            aria-hidden="true" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Address">Address:</label>
                                        <input type="text" class="form-control" id="Designation">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Appartment">Appartment No :</label>
                                        <input type="text" class="form-control" id="Contact">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected="">City...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Select</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected="">State...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Zip">Zip Code:</label>
                                        <input type="text" class="form-control" id="Zip">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Zip">Contact No:</label>
                                        <input type="number" class="form-control" id="Contact">
                                    </div>
                                </div>

                            </div>
                        </section>




                        <h6 id="steps-uid-8-h-2" tabindex="-1" class="title">Attestation</h6>
                        <section id="steps-uid-8-p-2" role="tabpanel" aria-labelledby="steps-uid-5-h-2" class="body"
                            aria-hidden="true" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" id="md_checkbox_1" class="material-inputs chk-col-blue">
                                    <label for="md_checkbox_1">i agreed to term and Conditions</label>
                                </div>
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" id="md_checkbox_2" class="material-inputs chk-col-blue">
                                    <label for="md_checkbox_2">i agreed to term and Conditions</label>
                                </div>
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" id="md_checkbox_3" class="material-inputs chk-col-blue">
                                    <label for="md_checkbox_3">i agreed to term and Conditions</label>
                                </div>
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" id="md_checkbox_8" class="material-inputs chk-col-blue">
                                    <label for="md_checkbox_8">i agreed to term and Conditions</label>
                                </div>
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" id="md_checkbox_4" class="material-inputs chk-col-blue">
                                    <label for="md_checkbox_4">i agreed to term and Conditions</label>
                                </div>
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" id="md_checkbox_5" class="material-inputs chk-col-blue">
                                    <label for="md_checkbox_5">i agreed to term and Conditions</label>
                                </div>

                            </div>
                        </section>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('script')
    <script>
        function myFunction() {
            var checkBox = document.getElementById("checkbox2");
            var text = document.getElementById("text");
            if (checkBox.checked == true) {
                text.style.display = "flex";
            } else {
                text.style.display = "none";
            }
        }
    </script>


    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    {{-- <script src="{{asset('dist/js/pages/forms/select2/select2.init.js')}}"></script> --}}
    <script>
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

        $(document).ready(function() {
            $(".select2").select2();
            $("#contact_no").inputmask("+99999999999");
        })
    </script>
@endsection
