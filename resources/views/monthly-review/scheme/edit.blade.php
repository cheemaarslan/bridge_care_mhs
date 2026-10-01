@extends('master.app')
@section('css')
<link rel="stylesheet" href="{{asset('datatable/datatables.min.css')}}">
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
                    <form action="{{route('monthly-review-scheme.update', $monthly_review_scheme)}}" method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="scheme_name">Scheme Name:</label>
                                    <input type="text"class="form-control form-control-lg" name="scheme_name" value="{{$monthly_review_scheme->scheme_name}}">
                                    @error('scheme_name')
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="question_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Input Type</th>
                                    <th>Choice</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($monthly_review_scheme->questions as $item)
                                    <tr>
                                        <td>{{$sr_no++}}</td>
                                        <td>{{$item->question}}</td>
                                        <td>{{$item->input_type}}</td>
                                        <td>
                                            @if ($item->input_type == "select")
                                                @foreach ($item->option as $opt)
                                                    <span class="badge badge-success">{{$opt}}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success edit_question_btn" data-id="{{ $item->id }}">
                                                <i class="ti-pencil"></i>
                                            </button>
                                        </td>
    
                                    </tr>
                                @endforeach
                            </tbody>
    
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="edit_question_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edit Note</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="" id="edit_question_form" method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Question:</label>
                                    <input type="text" name="question" class="form-control" id="edit_question">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Option:</label>
                                    <select name="option[]" class="form-control" id="edit_option" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                @can('delete_care_plan_question')
                                    <button type="button" id="delete_question_btn" class="btn btn-danger">Delete</button>
                                @endcan
                                <button type="submit" id="update_note_btn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('#question_table').DataTable( {
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
            });
            $('#edit_option').select2({
                tags: true,
            });

        });
        $('.edit_question_btn').on('click', function(){
            var id = $(this).attr('data-id');
            var edit_url = "{{route('monthly-review.question.edit', ':id')}}";
            edit_url = edit_url.replace(':id', id);

            var update_url = "{{route('monthly-review.question.update', ':id')}}";
            update_url = update_url.replace(':id', id);
            $('#edit_question_form').attr('action', update_url);

            var delete_url = "{{route('monthly-review.question.destroy', ':id')}}";
            delete_url = delete_url.replace(':id', id);

            $.ajax({
                url: edit_url,
                type: "get",
                success: function(response){
                    $('#edit_question_modal').modal('show');
                    $('#edit_question').val(response.question);

                    var option = "<option></option>"
                    $.each(response.option, function (index, value) {
                        option += "<option value='" + value + "' selected>" + value +
                            "</option>"
                        $('#edit_option').html(option);

                    });
                },
                error: function(){

                }
            });
        });
    </script>

@endsection
