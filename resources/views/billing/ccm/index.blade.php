@extends('master.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
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
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="btn-group my-1">
                                <select name="option" id="option" class="form-control">
                                    <option value="Monthly" selected>Monthly</option>
                                    <option value="Custom">Custom Search</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="btn-group my-1" id="monthly_section">
                                <input type="text" name="month_date" id="month_date" class="form-control"
                                    value="{{ $start_of_month }}" placeholder="Select a month">
                            </div>
                            <div class="btn-group d-none my-1" id="custom_section">
                                <input type="text" name="start_date" id="start_date" class="form-control"
                                    placeholder="Start">
                                <button type="button" class="btn btn-danger">To</button>
                                <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End">
                            </div>
                            <button type="button" class="btn btn-danger" id="filter_btn">
                                <i class="fas fa-search"></i>
                            </button>
                            <span class="spinner-border spinner-border-sm text-success d-none" id="billing_spinner"
                                role="status" aria-hidden="true"></span>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>Billing Report <span id="billing_duration">{{ $start_of_month }}</span></h4>
                        </div>
                        <div class="col-lg-6 col-12 text-center">
                            Practice Name: {{ $practice->practice_name }}
                        </div>
                        <div class="col-lg-6 col-12 text-center">
                            Doctor Name: {{ $doctor->user_name }}
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped display nowrap w-100" id="billing_table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Insurance Name</th>
                                    <th>Patient Type</th>
                                    <th>Completed At</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/samplepages/jquery.PrintArea.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>

    <script>
        var billing_table, start_date, end_date, month_date;
        $(document).ready(function() {
            $('#start_date').flatpickr({
                dateFormat: "M-Y",
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "M-Y",
                        altFormat: "F Y",
                        theme: "material_blue"
                    })
                ]
            });
            $('#month_date').flatpickr({
                dateFormat: "M-Y",
                defaultDate: "today",
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "M-Y",
                        altFormat: "F Y",
                        theme: "material_blue"
                    })
                ]
            });
            $('#end_date').flatpickr({
                dateFormat: "M-Y",
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "M-Y",
                        altFormat: "F Y",
                        theme: "material_blue"
                    })
                ]
            });
            billing_table = $('#billing_table').DataTable({
                columnDefs: [{
                        orderable: false,
                        targets: '_all'
                    },
                    {
                        targets: 0,
                        render: function(data, type) {
                            if (type === 'myExport') {
                                var s = '';
                                data.split('<p>').forEach(function(a) {
                                    var b = a.split('</p>')[0].trim();
                                    s += s === '' ? b : '\n' + b
                                });
                                return s;
                            }

                            return data;
                        }
                    }
                ],
                dom: '<lBf<t>ip>',
                ordering: false,
                buttons: ['excel', {
                    extend: 'pdfHtml5',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    extension: '.pdf',
                    text: ' PDF',
                    header: true,
                    footer: true,
                    exportOptions: {
                        stripNewlines: false,
                        orthogonal: 'myExport'
                    },
                    customize: function(doc) {}

                }, ],
                pageLength: 100,

            });

            get_billing();
        });

        $('#option').on('change', function() {
            if ($(this).val() == "Custom") {
                $('#custom_section').removeClass('d-none');
                $('#monthly_section').addClass('d-none');
            } else {
                $('#custom_section').addClass('d-none');
                $('#monthly_section').removeClass('d-none');
            }
            $('#start_date').val("");
            $('#end_date').val("");
            $('#month_date').val("");

        });
        $('#filter_btn').click(function() {
            get_billing();
        });

        function get_billing() {
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();
            month_date = $('#month_date').val();

            if (start_date && end_date) {
                $.ajax({
                    url: "{{ route('billing.ccm.filter') }}",
                    type: "post",
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                    beforeSend: function() {
                        $('#billing_spinner').removeClass('d-none');

                    },
                    success: function(response) {
                        filter_table(response);
                        $('#billing_spinner').addClass('d-none');


                    },
                    error: function(response) {
                        $('#billing_spinner').addClass('d-none');
                        toastr.error('Something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                })
            } else {
                $('#billing_duration').text(month_date);
                $.ajax({
                    url: "{{ route('billing.ccm.filter') }}",
                    type: "post",
                    data: {
                        month_date: month_date
                    },
                    beforeSend: function() {
                        $('#billing_spinner').removeClass('d-none');

                    },
                    success: function(response) {
                        filter_table(response);
                        $('#billing_spinner').addClass('d-none');


                    },
                    error: function(response) {
                        $('#billing_spinner').addClass('d-none');
                        toastr.error('Something went wrong', 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                })
            }
        }

        function filter_table(response) {
            var total_patient = 0;
            var simple_patient = 0;
            var complex_patient = 0;

            var total_time = 0;
            var simple_time = 0;
            var complex_time = 0;
            var simple_seconds = 0;
            var complex_seconds = 0;
            if (response.length > 0) {
                billing_table.clear().draw();
                $.each(response, function(index, value) {
                    if (value.ccm_codes.length > 0) {

                        var dob = value.dob;
                        dob = dob.replaceAll('-', '/');

                        var col_1 = '<h4>' + value.last_name + ', ' + value.first_name + '</h4>';
                        col_1 += '<p>' + dob + '</p>';
                        if (value.care_plan.status == "Approved") {
                            $.each(value.chronic_conditions, function(i, condition) {
                                col_1 += '<p>' + condition.chronic_condition_name + '-<strong>' + condition
                                    .code + '</strong></p>';
                            });
                        }
                        var col_2 = value.insurance.insurance_name + ' - ' + value.policy_no;
                        var col_3 = '<h4>' + value.ccm_type + '</h4>';
                        $.each(value.ccm_codes, function(i, code) {
                            col_3 += '<p>' + code.code + '</p>';
                        });
                        var completed_at = value.latest_ccm_code.last_ccm_performed;
                        if(completed_at){
                            completed_at = completed_at.replaceAll('-', '/');
                        }

                        var col_4 = completed_at;


                        if (value.ccm_type == "Simple") {
                            simple_patient++;
                        }
                        if (value.ccm_type == "Complex") {
                            complex_patient++;
                        }
                        total_patient = simple_patient + complex_patient;

                        simple_time = configure_time(simple_seconds);
                        complex_time = configure_time(complex_seconds);
                        total_time = configure_time(simple_seconds + complex_seconds);

                        if (value.care_plan.status != "Approved") {
                            var row = billing_table.row.add([
                                col_1,
                                "<p class='text-danger mt-3'>Care Plan has not yet Approved to show billing info</p>",
                                null,
                                null,
                            ]).draw(false);
                        } else {

                            var row = billing_table.row.add([
                                col_1,
                                col_2,
                                col_3,
                                col_4,
                            ]).draw(false);
                        }

                        if (value.ccm_type == "Simple") {
                            if (response.monthly_review) {
                                var sec = parseInt(value.care_plan.minutes * 60) + parseInt(value.care_plan
                                .seconds);
                                simple_seconds = simple_seconds + sec;
                            } else {
                                var sec = parseInt(value.care_plan.minutes * 60) + parseInt(value.care_plan
                                .seconds);
                                simple_seconds = simple_seconds + sec;
                            }
                        } else {
                            if (response.monthly_review) {
                                var sec = parseInt(value.care_plan.minutes * 60) + parseInt(value.care_plan
                                .seconds);
                                complex_seconds = complex_seconds + sec;
                            } else {
                                var sec = parseInt(value.care_plan.minutes * 60) + parseInt(value.care_plan
                                .seconds);
                                complex_seconds = complex_seconds + sec;
                            }

                        }

                    }
                });
            } 
            var row = billing_table.row.add([
                "Total Patient: " + total_patient,
                "Simple Patient: " + simple_patient,
                "Complex Patient: " + complex_patient,
                null,
            ]).draw(false);
            var row = billing_table.row.add([
                "Total Time: " + total_time,
                "Simple Time: " + simple_time,
                "Complex Time: " + complex_time,
                null,
            ]).draw(false);
        }

        function configure_time(time) {
            var minutes = Math.floor(time / 60);
            var seconds = time % 60;
            return minutes + ':' + seconds;
        }
    </script>
@endsection
