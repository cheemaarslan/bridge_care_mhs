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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>General Setting</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <form action="{{ route('setting.general') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="app_name">Application Name</label>
                                            <input type="text" class="form-control form-control-lg" name="app_name"
                                                value="{{ $setting->app_name }}" required>
                                        </div>
                                        @error('app_name')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <img src="{{$setting->app_logo}}" alt="{{ $setting->app_name }}" style="width: 100px;">
                                        <div class="form-group">
                                            <label for="app_logo">Application Logo</label>
                                            <input type="file" class="form-control form-control-lg" name="app_logo">
                                        </div>
                                        @error('app_logo')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="languages">All Lauguage</label>
                                            <select class="form-control form-control-lg" id="languages" name="languages[]"
                                                multiple>
                                                @if ($setting->languages)
                                                    @foreach ($setting->languages as $item)
                                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('languages')
                                                <div class="alert alert-danger" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="languages">All Engagement Type</label>
                                            <select class="form-control form-control-lg" id="engagement_types"
                                                name="engagement_types[]" multiple>
                                                @if ($setting->engagement_types)
                                                    @foreach ($setting->engagement_types as $item)
                                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('engagement_types')
                                                <div class="alert alert-danger" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Save Setting</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @can('reset_rpm_record')
            
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>RPM Setting</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <form action="{{ route('setting.rpm') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="rpm_record_from">RPM Record From: <span class="text-danger">Date</span></label>
                                            <input type="hidden" name="setting_rpm" value="1">
                                            <input type="text" class="form-control form-control-lg bg-white" name="rpm_record_from" id="rpm_record_from"
                                                value="{{ $setting->formatted_rpm_record_from }}" required>
                                        </div>
                                        @error('rpm_record_from')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endcan
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Other Navigation</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @can('create_user')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        User
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('user.create') }}">Add New User</a>
                                        <a class="dropdown-item" href="{{ route('user.index') }}">View All Users</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_practice')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Practice
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('practice.create') }}">Add New Practice</a>
                                        <a class="dropdown-item" href="{{ route('practice.index') }}">View All Practices</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_insurance')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Insurance
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('insurance.create') }}">Add New Insurance</a>
                                        <a class="dropdown-item" href="{{ route('insurance.index') }}">View All
                                            Insurances</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_chronic_condition')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Chronic-Condition
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('chronic-condition.create') }}">Add New
                                            Chronic-Condition</a>
                                        <a class="dropdown-item" href="{{ route('chronic-condition.index') }}">View All
                                            Chronic-Conditions</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_test')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Test
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('test.create') }}">Add New Test</a>
                                        <a class="dropdown-item" href="{{ route('test.index') }}">View All Tests</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_screening')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Screening
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('screening.create') }}">Add New Screening</a>
                                        <a class="dropdown-item" href="{{ route('screening.index') }}">View All
                                            Screenings</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_care_plan_scheme')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Care Plan
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('care-plan-scheme.index') }}">Care Plan Schemes</a>
                                        <a class="dropdown-item" href="{{ route('care-plan-scheme.create') }}">Add Care Plan Scheme</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_monthly_review_scheme')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Monthly Review
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('monthly-review-scheme.create') }}">Add Monthly Review Scheme</a>
                                        <a class="dropdown-item" href="{{ route('monthly-review-scheme.index') }}">Monthly Review Schemes</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_role')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Role
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('role.create') }}">Add New Role</a>
                                        <a class="dropdown-item" href="{{ route('role.index') }}">View All Roles</a>
                                    </div>
                                </div>
                            @endcan
                            @can('crud_permission')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Permission
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('permission.create') }}">Add New
                                            Permission</a>
                                        <a class="dropdown-item" href="{{ route('permission.index') }}">View All
                                            Permission</a>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>Email Settings</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('setting.smtp') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Site Name">MAIL MAILER</label>
                                    <input type="text" class="form-control form-control-lg" name="mail_mailer"
                                        value="{{ env('MAIL_MAILER') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Site Name">MAIL HOST</label>
                                    <input type="text" class="form-control form-control-lg" name="mail_host"
                                        value="{{ env('MAIL_HOST') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Site Name">MAIL PORT</label>
                                    <input type="text" class="form-control form-control-lg" name="mail_port"
                                        value="{{ env('MAIL_PORT') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Site Name">MAIL USERNAME</label>
                                    <input type="text" class="form-control form-control-lg" name="mail_username"
                                        value="{{ env('MAIL_USERNAME') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Site Name">MAIL PASSWORD</label>
                                    <input type="password" class="form-control form-control-lg" name="mail_password"
                                        value="{{ env('MAIL_PASSWORD') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Site Name">MAIL ENCRYPTION</label>
                                    <input type="text" class="form-control form-control-lg" name="mail_encryption"
                                        value="{{ env('MAIL_ENCRYPTION') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Site Name">MAIL FROM ADDRESS</label>
                                    <input type="text" class="form-control form-control-lg" name="mail_from_address"
                                        value="{{ env('MAIL_FROM_ADDRESS') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Save Setting</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>Twilio Integration</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('setting.twilio') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="account_sid">Account SID</label>
                                    <input class="form-control form-control-lg" type="text" name="account_sid"
                                        id="account_sid" value="{{ env('TWILIO_SID') }}" required>
                                    @if ($errors->has('account_sid'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_sid') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="auth_token">Auth Token</label>
                                    <input class="form-control form-control-lg" type="text" name="auth_token"
                                        id="auth_token" value="{{ env('TWILIO_AUTH_TOKEN') }}" required>
                                    @if ($errors->has('auth_token'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('auth_token') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="ph_no">My Twilio phone number</label>
                                    <input class="form-control form-control-lg" type="text" name="ph_no"
                                        id="ph_no" value="{{ env('TWILIO_NUMBER') }}" required>
                                    @if ($errors->has('ph_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ph_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Save Setting</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('setting.test') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">SEND TEST MAIL</label>
                                    <input type="email" class="form-control form-control-lg" name="email"
                                        id="email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Save Setting</button>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $("#languages").select2({
            tags: true
        });
        $("#engagement_types").select2({
            tags: true
        });
        $('#rpm_record_from').flatpickr({
                dateFormat: "m-d-Y",
                maxDate: "today"
            });
    </script>
@endsection
