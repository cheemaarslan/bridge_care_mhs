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
    <div class="row">
        <div class="col-12 text-right">
            <div class="card shadow bg-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group m-auto w-75">
                                <select name="care_manager_id" id="care_manager_id" class="form-control">
                                    <option value="All">-- Select Care Manager --</option>
                                    @foreach ($care_managers as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $care_manager_id == $item->id ? 'selected' : '' }}>{{ $item->user_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="date" id="date" class="form-control w-50">
                                    <option value="Current" {{ $date == 'Current' ? 'selected' : '' }}>Current Month
                                    </option>
                                    <option value="Last" {{ $date == 'Last' ? 'selected' : '' }}>Last Month</option>
                                    <option value="Custom" {{ $date == 'Custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                                <div class="btn-group d-none" id="custom_section">
                                    <input type="text" name="start" id="from" class="form-control bg-white"
                                        placeholder="Start">
                                    <input type="text" name="end" id="to" class="form-control bg-white"
                                        placeholder="End">
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-md btn-danger" id="filter_btn">
                                        <i class="ti-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-user"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">CCM Patient</h4>
                            <span>Patients</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $ccm_patient }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-user"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">Simple Patient</h4>
                            <span>Patients</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $simple_patient }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-user"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">Complex Patient</h4>
                            <span>Patients</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $complex_patient }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">

            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-check"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">CCM Completed</h4>
                            <span>Patients</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $total_completed_patient }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-check"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">Simple Completed</h4>
                            <span>Patients</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $simple_completed_patient }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-check"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">Complex Completed</h4>
                            <span>Patients</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $complex_completed_patient }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            @php
                
            @endphp
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-time"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">Total Time</h4>
                            <span>Hours</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $total_hours }}:{{ $total_minutes }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-time"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">Simple Time</h4>
                            <span>Hours</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $simple_hours }}:{{ $simple_minutes }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="display-6 align-self-center"><i class="ti-time"></i></div>
                        <div class="p-2 align-self-center">
                            <h4 class="mb-0">Complex Time</h4>
                            <span>Hours</span>
                        </div>
                        <div class="ml-auto align-self-center">
                            <h2 class="font-weight-medium mb-0">{{ $complex_hours }}:{{ $complex_minutes }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            $('#to').flatpickr()
            $('#from').flatpickr()
        });

        $('#date').on('change', function() {
            if ($(this).val() == "Custom") {
                $('#custom_section').removeClass('d-none');
                $('#monthly_section').addClass('d-none');
            } else {
                $('#custom_section').addClass('d-none');
                $('#monthly_section').removeClass('d-none');
            }
        });

        $('#filter_btn').click(function() {
            var url = "{{ route('report.index') }}";

            var care_manager_id = $('#care_manager_id').val();
            var date = $('#date').val();
            var from = $('#from').val();
            var to = $('#to').val();

            url = url + "/" + care_manager_id + "/" + date + "/" + from + "/" + to;


            location.href = url;
        });
    </script>
@endsection
