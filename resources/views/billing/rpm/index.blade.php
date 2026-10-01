@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="btn-group">
                                <input type="text" name="start_date" id="start_date" class="form-control"
                                    value="{{ $start_of_month }}">
                                <button type="button" class="btn btn-danger">To</button>
                                <input type="text" name="end_date" id="end_date" class="form-control">
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
                    <div class="table-responsive">

                        <table id="billing_table" class="table table-striped text-theme display nowrap">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Provider Name</th>
                                    <th>DOB</th>
                                    <th>Code</th>
                                    <th>Covid Status</th>
                                    <th>Completed Phone/Video</th>
                                    <th>Engagement Minutes</th>
                                    <th>Install Date</th>
                                    <th>Setup Date</th>
                                    <th>Days With Reading</th>
                                    <th>Care Manager</th>
                                    <!--<th>Consent</th>-->
                                    <th>Note</th>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- <script>
        var billing_table, start_date, end_date;
        $(document).ready(function() {
            $('#start_date').flatpickr({
                dateFormat: "m-d-Y",
            });
            $('#end_date').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"
            });
            billing_table = $('#billing_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                scrollX: true,

            });


            get_billing();

        });

        $('#filter_btn').click(function() {
            get_billing();
        });

        function get_billing() {
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();

            if (start_date && end_date) {
                $.ajax({
                    url: "{{ route('billing.rpm.filter') }}",
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
            }
        }


        function filter_table(response) {
            if (response.length > 0) {
                billing_table.clear().draw();
                $.each(response, function(index, item) {
                    var minutes = parseInt(item.rpm_codes_sum_minutes);
                    var seconds = parseInt(item.rpm_codes_sum_seconds);
                    var total_time = (minutes * 60) + seconds;
                    var dob = item.dob;
                    dob = dob.replaceAll('-', '/');

                    var days_with_reading = 0;
                    var install_date = null;
                    var setup_date = null;
                    if (item.device) {
                        install_date = item.device.install_date;
                        setup_date = item.device.setup_date;
                        if (install_date.includes('-')) {
                            setup_date = install_date.replaceAll('-', '/');
                        }
                        if (setup_date.includes('-')) {
                            setup_date = setup_date.replaceAll('-', '/');
                        }
                    }
                    if (item.days_with_reading) {
                        days_with_reading = parseInt(item.days_with_reading.length);
                    }
                    var care_manager = "";
                    if (item.care_manager) {
                        care_manager = item.care_manager.user_name;
                    }
                    var doctor_first_name = "";
                    if (item.doctor) {
                        doctor_first_name = item.doctor.user_name || "";
                    }
                    $.each(item.rpm_codes, function(i, time) {
                        var engagement_time = configure_time(time.code, total_time);
                        var note = configure_note(time.code, engagement_time, days_with_reading);
                        var type = "rpm";
                        var url = "{{ url('patient/:id/type/:type') }}";
                        url = url.replace(':id', item.slug).replace(':type', type);
                        var row = billing_table.row.add([
                            '<a href="' + url + '">' + item.last_name + ', ' + item.first_name +
                            '</a>',
                            doctor_first_name,
                            dob,
                            time.code,
                            item.covid_status,
                            (item.phone_call) ? "Yes" : "No",
                            engagement_time,
                            install_date,
                            setup_date,
                            days_with_reading,
                            care_manager,

                            note,

                        ]).draw();
                    });

                });

                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            }
        }

        function configure_time(code, time) {
            var minutes = Math.floor(time / 60);
            var seconds = time % 60;
            if (code == "99457") {
                if (minutes >= 20) {
                    return "20:0";
                } else {
                    return minutes + ":" + seconds;
                }
            }
            if (code == "99458") {
                if (minutes >= 20) {
                    time = ((minutes * 60) + seconds) - 1200;
                    minutes = Math.floor(time / 60);
                    seconds = time % 60;
                    return minutes + ":" + seconds;
                } else {
                    return minutes + ":" + seconds;
                }
            } else {
                return "-";

            }
        }

        function configure_note(code, time, days_with_reading) {
            start_date = start_date.replaceAll('-', '/');
            end_date = end_date.replaceAll('-', '/');
            var note = "Setup Patient with Blood Pressure Monitoring Equipment";
            if (code == "99457") {
                note = "Spent " + time + " minutes viewing and interpreting patient data";
            }
            if (code == "99458") {
                note = "Spent " + time + " minutes viewing and interpreting patient data";

            }
            if (code == "99454") {
                note = "Patient has " + days_with_reading + " days with measurement(s) between " + start_date + " to " +
                    end_date + " Measurements include " + days_with_reading + " blood pressure reading(s).";
            }
            return note;
        }
    </script> --}}



    {{-- new code with code columns --}}

    <script>
        var billing_table, start_date, end_date;
        $(document).ready(function() {
            $('#start_date').flatpickr({
                dateFormat: "m-d-Y",
            });
            $('#end_date').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"
            });
            billing_table = $('#billing_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: [{
                        extend: 'excel',
                        title: 'RPM Billing Report',
                        customizeData: function(data) {

                            var excelBody = [];
                            var patientMap = {};

                            for (var i = 0; i < data.body.length; i++) {
                                var row = data.body[i];
                                var patientName = row[0].replace(/<[^>]+>/g, '');
                                var code = row[3];
                                var note = row[11];
                                var patientKey = patientName + '|' + row[2];

                                if (!patientMap[patientKey]) {
                                    patientMap[patientKey] = {
                                        patientName: patientName,
                                        doctor: row[1],
                                        dob: row[2],
                                        codes: {
                                            '99453': '',
                                            '99454': '',
                                            '99457': '',
                                            '99458': ''
                                        },
                                        notes: {
                                            '99453': '',
                                            '99454': '',
                                            '99457': '',
                                            '99458': ''
                                        },
                                        covidStatus: row[4],
                                        phoneCall: row[5],
                                        engagementTime: row[6],
                                        installDate: row[7],
                                        setupDate: row[8],
                                        daysWithReading: row[9],
                                        careManager: row[10]
                                    };
                                }
                                patientMap[patientKey].codes[code] = code;
                                patientMap[patientKey].notes[code] = note;
                            }

                            for (var key in patientMap) {
                                var patient = patientMap[key];
                                excelBody.push([
                                    patient.patientName,
                                    patient.doctor,
                                    patient.dob,
                                    patient.codes['99453'],
                                    patient.notes['99453'],
                                    patient.codes['99454'],
                                    patient.notes['99454'],
                                    patient.codes['99457'],
                                    patient.notes['99457'],
                                    patient.codes['99458'],
                                    patient.notes['99458'],
                                    patient.covidStatus,
                                    patient.phoneCall,
                                    patient.engagementTime,
                                    patient.installDate,
                                    patient.setupDate,
                                    patient.daysWithReading,
                                    patient.careManager
                                ]);
                            }


                            data.header = [
                                'Patient Name', 'Doctor', 'DOB',
                                'Code 1', 'Code 1 Note',
                                'Code 2', 'Code 2 Note',
                                'Code 3', 'Code 3 Note',
                                'Code 4', 'Code 4 Note',
                                'COVID Status', 'Phone Call', 'Engagement Time',
                                'Install Date', 'Setup Date', 'Days with Reading',
                                'Care Manager'
                            ];
                            data.body = excelBody;
                        }
                    },
                    'print'
                ],
                scrollX: true
            });

            get_billing();
        });

        $('#filter_btn').click(function() {
            get_billing();
        });

        function get_billing() {
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();

            if (start_date && end_date) {
                $.ajax({
                    url: "{{ route('billing.rpm.filter') }}",
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
                });
            }
        }

        function filter_table(response) {
            if (response.length > 0) {
                billing_table.clear().draw();
                $.each(response, function(index, item) {
                    var minutes = parseInt(item.rpm_codes_sum_minutes);
                    var seconds = parseInt(item.rpm_codes_sum_seconds);
                    var total_time = (minutes * 60) + seconds;
                    var dob = item.dob;
                    dob = dob.replaceAll('-', '/');

                    var days_with_reading = 0;
                    var install_date = null;
                    var setup_date = null;
                    if (item.device) {
                        install_date = item.device.install_date;
                        setup_date = item.device.setup_date;
                        if (install_date.includes('-')) {
                            setup_date = install_date.replaceAll('-', '/');
                        }
                        if (setup_date.includes('-')) {
                            setup_date = setup_date.replaceAll('-', '/');
                        }
                    }
                    if (item.days_with_reading) {
                        days_with_reading = parseInt(item.days_with_reading.length);
                    }
                    var care_manager = item.care_manager ? item.care_manager.user_name : '';
                    var doctor_first_name = item.doctor ? item.doctor.user_name || '' : '';

                    $.each(item.rpm_codes, function(i, time) {
                        var engagement_time = configure_time(time.code, total_time);
                        var note = configure_note(time.code, engagement_time, days_with_reading);
                        var type = "rpm";
                        var url = "{{ url('patient/:id/type/:type') }}";
                        url = url.replace(':id', item.slug).replace(':type', type);
                        var row = billing_table.row.add([
                            '<a href="' + url + '">' + item.last_name + ', ' + item.first_name +
                            '</a>',
                            doctor_first_name,
                            dob,
                            time.code,
                            item.covid_status,
                            item.phone_call ? "Yes" : "No",
                            engagement_time,
                            install_date,
                            setup_date,
                            days_with_reading,
                            care_manager,
                            note
                        ]).draw();
                    });

                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
            }
        }

        function configure_time(code, time) {
            var minutes = Math.floor(time / 60);
            var seconds = time % 60;
            if (code == "99457") {
                if (minutes >= 20) {
                    return "20:0";
                } else {
                    return minutes + ":" + seconds;
                }
            }
            if (code == "99458") {
                if (minutes >= 20) {
                    time = ((minutes * 60) + seconds) - 1200;
                    minutes = Math.floor(time / 60);
                    seconds = time % 60;
                    return minutes + ":" + seconds;
                } else {
                    return minutes + ":" + seconds;
                }
            }
            return "-";
        }

        function configure_note(code, time, days_with_reading) {
            start_date = start_date.replaceAll('-', '/');
            end_date = end_date.replaceAll('-', '/');
            var note = "Setup Patient with Blood Pressure Monitoring Equipment";
            if (code == "99457") {
                note = "Spent " + time + " minutes viewing and interpreting patient data";
            }
            if (code == "99458") {
                note = "Spent " + time + " minutes viewing and interpreting patient data";

            }
            if (code == "99454") {
                note = "Patient has " + days_with_reading + " days with measurement(s) between " + start_date + " to " +
                    end_date + " Measurements include " + days_with_reading + " blood pressure reading(s).";
            }
            return note;
        }
    </script>
@endsection
