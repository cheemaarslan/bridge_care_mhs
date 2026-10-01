@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-success alert-dismissible bg-danger text-white border-0 fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>{{ $error }}</strong>
        </div>
    @endforeach
@endif
