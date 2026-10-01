@extends('master.app')
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
                    <form action="{{route('screening.update', $screening)}}" method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="screening_name">Screening Name:</label>
                                    <input type="text"class="form-control form-control-lg" name="screening_name" value="{{$screening->screening_name}}">
                                    @error('screening_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="min_age">Min Age:</label>
                                    <input type="number" class="form-control form-control-lg" name="min_age" value="{{$screening->min_age}}">
                                    @error('min_age')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="max_age">Max Age:</label>
                                    <input type="number" class="form-control form-control-lg" name="max_age" value="{{$screening->max_age}}">
                                    @error('max_age')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select type="text" class="form-control form-control-lg" name="gender" >
                                        <option value="Male" {{$screening->gender == "Male" ? 'selected' : ''}}>Male</option>
                                        <option value="Female" {{$screening->gender == "Female" ? 'selected' : ''}}>Female</option>
                                        <option value="Both" {{$screening->gender == "Both" ? 'selected' : ''}}>Both</option>
                                    </select>
                                    @error('gender')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="duration">Duration:</label>
                                    <input type="text" class="form-control form-control-lg" name="duration" value="{{$screening->duration}}">
                                    @error('duration')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="consent">Consent:</label>
                                    <input type="text" class="form-control form-control-lg" name="consent" value="{{$screening->consent}}">
                                    @error('consent')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
