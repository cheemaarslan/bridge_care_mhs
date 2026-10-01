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
                    <form action="{{route('insurance.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="insurance_name">Insurance Name:</label>
                                    <input type="text" id="insurance_name" class="form-control form-control-lg required" name="insurance_name">
                                    @error('insurance_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="address_line">Address Line:</label>
                                    <input type="text" class="form-control form-control-lg required" name="address_line">
                                    @error('address_line')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="city">City Name:</label>
                                    <input type="text" class="form-control form-control-lg required" name="city">
                                    @error('city')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="state">State Name:</label>
                                    <input type="text" class="form-control form-control-lg required" name="state">
                                    @error('state')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="zip">Zip:</label>
                                    <input type="text" class="form-control form-control-lg required" name="zip">
                                    @error('zip')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="contact_no">Contact No:</label>
                                    <input type="text" class="form-control form-control-lg required" name="contact_no">
                                    @error('contact_no')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="alternate_no">Alternate No:</label>
                                    <input type="text" class="form-control form-control-lg required" name="alternate_no">
                                    @error('alternate_no')
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
