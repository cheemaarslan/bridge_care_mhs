<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>{{ env('APP_NAME') }}</title>
    @yield('css')
    <link rel="canonical" href="https://www.wrappixel.com/templates/xtremeadmin/" />
    <link href="{{ asset('dist/css/style.css') }}?v={{ filemtime(public_path('dist/css/style.css')) }}" rel="stylesheet">
    <link href="{{ asset('assets/extra-libs/toastr/dist/build/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('custom/css/index.css') }}">
    <style>
        .breadcrumb {
            background-color: white;
        }

        * {
            font-weight: 400;
        }
    </style>
    @livewireStyles
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        @auth

            @include('master.header')
            @include('master.navbar')
        @endauth
        <div class="content-page">
            <div class="content">
                <div class="page-wrapper d-block">
                    @yield('breadcrum')
                    <div class="container-fluid">
                        @include('master.error')
                        @include('master.status')
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- content -->
            @include('master.footer')
        </div>

    </div>
    <!-- Vendor js -->
    @yield('modal')

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.horizontal.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.horizontal.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    {{-- <script src="{{asset('dist/js/waves.js')}}"></script> --}}
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/toastr/dist/build/toastr.min.js') }}"></script>


    {{-- <script src="{{asset('dist/js/pages/dashboards/dashboard2.js')}}"></script> --}}

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @auth
        <script>
            var hours = 0;
            var minutes = 0;
            var seconds = 0;
            var is_timer_started = false;

            $('#start_timer_btn').click(function() {
                if (!is_timer_started) {
                    start_timer();
                }
            });

            $('#pause_timer_btn').click(function() {
                clearTimeout(timex);
                is_timer_started = false;

                $('#start_timer_btn').removeClass('d-none');
                $('#pause_timer_btn').addClass('d-none');

                $("#seconds").removeAttr('disabled');
                $("#minutes").removeAttr('disabled');
                $("#seconds").removeClass('font-weight-bold');
                $("#minutes").removeClass('font-weight-bold');

            });

            $('#reset_timer_btn').click(function() {
                $("#seconds").html('00');
                $("#minutes").html('00');
                $('#pause_timer_btn').addClass('d-none');
                $('#start_timer_btn').removeClass('d-none');
                clearTimeout(timex);
                is_timer_started = false;
                minutes = 0;
                seconds = 0;


            });

            function start_timer() {

                is_timer_started = true;
                $('#start_timer_btn').addClass('d-none');
                $('#pause_timer_btn').removeClass('d-none');


                timex = setTimeout(function() {
                    seconds++;
                    if (seconds > 59) {
                        seconds = 0;
                        minutes++;

                        if (minutes < 10) {
                            $("#minutes").html('0' + minutes);
                        } else {
                            $("#minutes").html(minutes);
                        }
                    }
                    if (seconds < 10) {
                        $("#seconds").html('0' + seconds);
                    } else {
                        $("#seconds").html(seconds);
                    }
                    start_timer();
                }, 1000);
            }

            function save_time_track(patient_id, engagement_type, entry_type, min, sec, note) {
                return $.ajax({
                    url: "{{ route('time-track.store') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id,
                        engagement_type: engagement_type,
                        entry_type: entry_type,
                        minutes: min,
                        seconds: sec,
                        note: note,
                    }
                });

            }

            function mark_as_read(id) {
                $.ajax({
                    url: "{{ route('notification.mark') }}",
                    type: "post",
                    data: {
                        id: id
                    }
                })
            }

            function delete_notification(id) {
                $.ajax({
                    url: "{{ route('notification.delete') }}",
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response == 200) {
                            location.reload();
                        }
                    }
                })
            }
        </script>
    @endauth

    @yield('script')
    @livewireScripts


</body>

</html>
