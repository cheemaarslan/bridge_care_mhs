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
                    <form action="{{route('practice.update', $practice)}}" method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="practice_name">Practice Name:</label>
                                    <input type="text"class="form-control form-control-lg" name="practice_name" value="{{$practice->practice_name}}">
                                    @error('practice_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="type">Practice Type:</label>
                                    <input type="text"class="form-control form-control-lg" name="type" value="{{$practice->type}}">
                                    @error('type')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="address">Practice Address:</label>
                                    <input type="text" class="form-control form-control-lg" name="address" value="{{$practice->address}}">
                                    @error('address')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="contact_no">Contact No:</label>
                                    <input type="text" class="form-control form-control-lg" name="contact_no" value="{{$practice->contact_no}}">
                                    @error('contact_no')
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
