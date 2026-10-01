@extends('master.app')
@section('css')
<link rel="stylesheet" href="{{asset('datatable/datatables.min.css')}}">

@endsection
@section('breadcrum')
<ol class="breadcrumb p-4">
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('patient.show', ['patient' => $patient, 'type' => 'ccm']) }}" class="inactive">{{$patient->first_name}} {{$patient->last_name}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="active">History</a>
    </li>
</ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="care_plan_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Created At</th>
                                    <th>Completed At</th>
                                    <th>Reference No</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                          
                            <tbody>
                                @php
                                    $sr_no = 1;
                                @endphp
                                @foreach ($care_plans as $item)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                       <td>{{ $item->created_at->format('m-d-Y H:i:s') }}</td>
                                        <td>{{ $item->formatted_completed_at }}</td>
                                        <td>{{ $item->reference_no }}</td>
                                        <td>{{$item->minutes}}: {{$item->seconds}}</td>
                                            <td>
                                            @if($item->deleted_at)
                                            <span class="text-danger">Deleted</span>    
                                            @else
                                                {{ $item->status }}
                                            @endif
                                        </td>
                                        <td>
                                            <select class="form-control" id="set_care_plan" data-id="{{$item->id}}">
                                                <option value="1" {{$item->active ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{$item->active ? '' : 'selected'}}>InActive</option>
                                            </select>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu slideInUp">
                                                    <a class="dropdown-item" href="{{route('care-plan.show', $item)}}"><i
                                                            class="ti-pencil-alt"></i> Show Care Plan</a>
                                                    <a class="dropdown-item" href="{{route('care-plan.edit', $item)}}"><i
                                                            class="ti-pencil-alt"></i> Edit Care Plan</a>
                                                                 @if ($item->deleted_at)
                                                            <form action="{{ route('care-plan.restore', $item->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <button class="dropdown-item" type="submit">
                                                                    <i class="ti-pencil-alt"></i> Restore Care Plan
                                                                </button>
                                                            </form>
                                                        @endif

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
@section('script')
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function(){

            $('#care_plan_table').DataTable( {
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                paging: true,
                searching: true,
                autoWidth: true,
                lengthChange: true,
                columnDefs: [
                    {
                        orderable: true,
                        targets: '_all'
                    }
                ],
                pageLength: 100
            });

        });

        $(document).on('change', '#set_care_plan', function () {
            var care_plan_id = $(this).attr('data-id');
            var set = $(this).val();
            $.ajax({
                url: "{{route('care-plan.set')}}",
                type: "post",
                data: {
                    care_plan_id: care_plan_id,
                    set:set
                },
                success: function (response) {
                    if(response){
                        location.reload();
                    }
                },
                error: function () {
                    console.log('something went wrong');
                }
            })
        });
    </script>

@endsection
