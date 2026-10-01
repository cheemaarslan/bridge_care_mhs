{{-- @extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
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
                    <a class="active"> My Notes</a>
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
                    <div class="card-actions">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_user_modal">Add
                            Note</button>

                    </div>
                </div>
                <div class="card-body">


                    <div class="table-responsive">
                        <table id="device_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th style="width: 120px">#</th>
                                    <th style="width: 250px">Created At</th>
                                    <th style="width: 250px">Created By</th>
                                    <th>Notes</th>
                                    <th style="width: 190px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($my_notes as $item)
                                    <tr>
                                        <td style="width: 120px">{{ $sr_no++ }}</td>
                                        <td style="width: 250px">{{ $item->created_at }}</td>
                                        <td style="width: 250px">{{ $item->user->first_name }} {{ $item->user->last_name }}
                                        </td>

                                        <td>{!! strip_tags($item->my_notes) !!}</td>
                                        <td style="width: 190px">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">

                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#show_user_modal" data-note-id="{{ $item->id }}"
                                                        data-note-username="{{ $item->user->first_name }} {{ $item->user->last_name }}"
                                                        data-note-content="{{ strip_tags($item->my_notes) }}"
                                                        href=""><i class="ti-eye"></i> Show</a>

                                                    <a class="dropdown-item edit-note" data-toggle="modal"
                                                        data-target="#edit_note_modal" data-note-id="{{ $item->id }}"
                                                        data-note-slug="{{ $item->slug }}"

                                                        data-note-content="{{ strip_tags($item->my_notes) }}"
                                                        href="#"><i class="ti-pencil-alt"></i> Edit</a>



                                                </div>
                                            </div>
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
    <div class="modal fade" id="add_user_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add New Note</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('my_notes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="first_name">Note:</label>
                                    <textarea name="my_notes" id="default" cols="50" rows="10" class="form-control" required>
                                    {{ old('my_notes') }}
                                </textarea>


                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="show_user_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>View Note</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <label for="first_name">Created By:</label>
                                <input type="text" class="form-control" readonly id="user-name">
                            </div>
                        </div>
                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <label for="first_name">Note:</label>
                                <textarea name="my_notes" cols="50" rows="10" class="form-control" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_note_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- ... modal header ... -->
                <div class="modal-body">
                    <form id="edit-note-form" action="{{ route('my_notes.update', ['my_notes' => 'my_notes']) }}"
                        method="POST">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="edit_note">Note:</label>
                                    <textarea  name="edit_note"  cols="50" rows="10" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('tinymce/new.js') }}"></script>
    <script>
        var device_table;
        $(document).ready(function() {

            device_table = $('#device_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                paging: true,
                searching: true,
                autoWidth: true,
                lengthChange: true,
                columnDefs: [{
                    orderable: true,
                    targets: '_all'
                }],
                pageLength: 100
            });

        });
    </script>
    <script>
        $('#show_user_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var noteContent = button.data('note-content'); // Corrected attribute name
            var userName = button.data('note-username'); // Corrected attribute name
            var modal = $(this);
            modal.find('textarea[name="my_notes"]').val(noteContent);
            modal.find('#user-name').val(userName);
        });
    </script>
<script>
    $('.edit-note').on('click', function() {
        var noteId = $(this).data('note-id');
        var noteSlug = $(this).data('note-slug');
        var noteContent = $(this).data('note-content');
        
        // Destroy the previous TinyMCE instance
        tinymce.remove('#edit-note-form textarea[name="edit_note"]');
    
        $('#edit-note-form').attr('action', '/my_notes/' + noteSlug);
        $('#edit-note-form textarea[name="edit_note"]').val(noteContent);
    
        // Initialize TinyMCE for the textarea
        tinymce.init({
            selector: '#edit-note-form textarea[name="edit_note"]',
            height: 300, // Set the height of the editor
            // Add any other configuration options you need
        });
    });
    </script>
    
    
@endsection --}}
