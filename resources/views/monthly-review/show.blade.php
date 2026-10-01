@extends('master.app')
@section('breadcrum')
<ol class="breadcrumb p-4">
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{route('patient.show', ['patient' => $monthly_review->patient, 'type' => 'ccm'])}}" class="inactive">{{$monthly_review->patient->first_name}} {{$monthly_review->patient->last_name}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">Monthly Review</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="inactive">{{$monthly_review->reference_no}}</a>
    </li>
    <li class="breadcrumb-item font-weight-bold">
        <a href="#" class="active">Show</a>
    </li>
</ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body printableArea mt-4">
                    <h3><b>{{ $monthly_review->patient->first_name }} Monthly Review</b></h3>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="mt-4">
                                        <img src="{{ $monthly_review->patient->patient_image }}" class="rounded-circle"
                                            width="150" />
                                        <h6 class="card-subtitle mt-3 font-weight-bold text-dark">
                                            {{ $monthly_review->patient->gender }}</h6>
                                        <h6 class="card-subtitle font-weight-bold text-dark">Age -
                                            {{ $monthly_review->patient->age }}</h6>
                                        <h4 class="card-title mt-2">{{ $monthly_review->patient->first_name }}
                                            {{ $monthly_review->patient->last_name }}</h4>
                                        <span
                                            class="badge {{ $monthly_review->status == 'Approved' ? 'badge-success' : 'badge-danger' }}"
                                            id="status">{{ $monthly_review->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mt-4">
                                        <small class="font-weight-bold text-dark">DOB </small>
                                        <h6>{{ $monthly_review->patient->dob }}</h6>
                                        <small class="pt-4 db font-weight-bold text-dark">Contact No</small>
                                        <h6>{{ $monthly_review->patient->contact_no }}</h6>
                                        <small class="font-weight-bold text-dark pt-4 db">Address</small>
                                        <h6>{{ $monthly_review->patient->address }}</h6>
                                        <small class="font-weight-bold text-dark pt-4 db">Preferred Language</small>
                                        <h6>{{ $monthly_review->patient->preferred_language }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="card-body">
                                <div class="mt-4">
                                    <small class="font-weight-bold text-dark">Age </small>
                                    <h6>{{ $monthly_review->patient->age }}</h6>
                                    <small class="font-weight-bold text-dark pt-4 db">Email Address</small>
                                    <h6>{{ $monthly_review->patient->email }}</h6>
                                    <small class="font-weight-bold text-dark pt-4 db">CCM Enrolled Data</small>
                                    <h6>{{ $monthly_review->patient->formatted_ccm_enrol_date }}</h6>
                                    <small class="font-weight-bold text-dark pt-4 db">Practice Name</small>
                                    <h6>{{ $practice->practice_name }}</h6>
                                    <small class="font-weight-bold text-dark pt-4 db">Care Manger</small>
                                    <h6>
                                        @if ($monthly_review->patient->care_manager)
                                            {{ $monthly_review->patient->care_manager->user_name }}
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h6>Monthly Review Created At</h6>
                                            <p>{{ $monthly_review->date }}</p>
                                        </td>
                                        <td>
                                            <h6>CCM Enrol Date</h6>
                                            <p>{{ $monthly_review->patient->formatted_ccm_enrol_date }}</p>
                                        </td>
                                        <td>
                                            <h6>Chronic Condition</h6>
                                            <p>{{ $monthly_review->patient->chronic_conditions->count() }}</p>
                                        </td>
                                        <td>
                                            <h6>Medication</h6>
                                            <p>{{ $monthly_review->medications->count() }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <h4 class="m-3">Chronic Conditions</h4>
                            <p class="m-3">
                                @if ($monthly_review->patient->chronic_conditions)
                                    @foreach ($monthly_review->patient->chronic_conditions as $item)
                                        <span>{{ $item->chronic_condition_name }}</span>,
                                    @endforeach
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr>

                    @foreach ($schemes as $item)
                        @if ($item->id === 7)
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="m-3">{{$item->scheme_name}}</h4>
                                    <div class="table-responsive m-2">
                                        <table class="table" id="appointment_table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Medication Name</th>
                                                    <th scope="col">Medication Dose</th>
                                                    <th scope="col">Medication Route</th>
                                                    <th scope="col">Medication Doctor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($monthly_review->medications as $medication)
                                                    <tr>
                                                        <td>{{ $medication->medication_name }}</td>
                                                        <td>{{ $medication->dose }}</td>
                                                        <td>{{ $medication->route }}</td>
                                                        <td>{{ $medication->frequency }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No Record was found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @elseif($item->id == 8)
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="m-3">{{$item->scheme_name}}</h4>
                                    <div class="table-responsive m-2">
                                        <table class="table" id="appointment_table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Added By</th>
                                                    <th scope="col">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($monthly_review->notes as $note)
                                                    <tr>
                                                        <td>{{ $note->formatted_date }}</td>
                                                        <td>{{ $note->user->user_name }}</td>
                                                        <td>{{ $note->note }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No Record was found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="m-3">Medication
                                </h4>
                                <div class="table-responsive m-2">
                                    <table class="table" id="appointment_table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Medication Name</th>
                                                <th scope="col">Medication Dose</th>
                                                <th scope="col">Medication Route</th>
                                                <th scope="col">Medication Doctor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($monthly_review->medications as $medication)
                                                <tr>
                                                    <td>{{ $medication->medication_name }}</td>
                                                    <td>{{ $medication->dose }}</td>
                                                    <td>{{ $medication->route }}</td>
                                                    <td>{{ $medication->frequency }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No Record was found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="m-3">{{ $item->scheme_name }}</h4>

                                    <div class="table-responsive m-2">
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item->questions as $question)
                                                    <tr>
                                                        <td>
                                                            <p class="text-justify mt-2"> {{ $question->question }}</p>
                                                            @if ($question->answer)
                                                                @if ($question->answer->answer == 'Yes')
                                                                    <label for="comment">Comment</label>
                                                                    <textarea class="form-control w-50" rows="4" readonly>{{ $question->answer->comment }}</textarea>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($question->answer)
                                                                {{ $question->answer->answer }}
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="card-body">
                    <div class="text-right">
                        <button id="print" class="btn btn-md btn-success" type="button"> <span><i
                                    class="fa fa-print"></i> Print</span> </button>
                        <a class="btn btn-md btn-success"
                            href="{{ route('monthly-review.edit', $monthly_review) }}"><span><i class="fa fa-pancil"></i>
                                Edit Monthly Review</span> </a>
                            <a href="{{route('patient.show', ['patient' => $monthly_review->patient, 'type' => 'ccm'])}}" class="btn btn-md btn-success">Go Back</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('dist/js/pages/samplepages/jquery.PrintArea.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });

        });
    </script>
@endsection
