@extends('master.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
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
                    <form action="{{route('user.update', $user)}}" method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="first_name">First Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="first_name" value="{{$user->first_name}}">
                                    @error('first_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="last_name">Last Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="last_name" value="{{$user->last_name}}">
                                    @error('last_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="user_name">User Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="user_name" value="{{$user->user_name}}">
                                    @error('user_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email: <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" name="email" value="{{$user->email}}">
                                    @error('email')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control form-control-lg" name="password">
                                    @error('password')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="role_name">Role Name: <span class="text-danger">*</span></label>
                                    <select type="text" class="select2 form-control form-control-lg" name="role_name">
                                        @foreach ($roles as $item)
                                            <option value="{{$item->name}}">{{$item->name}}</option>

                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="practice_id">Practice Name: <span class="text-danger">*</span></label>
                                    <select class="select2 form-control form-control-lg" name="practice_id">
                                        @foreach ($practices as $item)
                                            <option value=""></option>
                                            <option value="{{ $item->id }}" {{$user->practice_id == $item->id ? 'selected' : ''}}>{{ $item->practice_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="contact_no">Contact No:</label>
                                    <input type="text" class="form-control form-control-lg" name="contact_no" value="{{$user->contact_no}}">
                                    @error('contact_no')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="state">State Name:</label>
                                    <input type="text" class="form-control" name="state" value="{{$user->state}}">
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
                                    <input type="text" class="form-control form-control-lg" name="city" value="{{$user->city}}">
                                    @error('city')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control form-control-lg" name="address" value="{{$user->address}}">
                                    @error('address')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-12">
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

    <script>
        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Please select an option"
            });
        });
    </script>
@endsection
