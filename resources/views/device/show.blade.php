@extends('master.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        #device_spinner{
            position: absolute;
            left: 50%;
            top: 50%;
        }
    </style>
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
                    <div class="table-responsive">
                        <table id="device_data_table" class="table table-striped text-theme w-100">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Pulse Rate</th>
                                    <th>Systolic</th>
                                    <th>Diastolic</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($device->data as $item)
                                    <tr>
                                        <td>{{$item->formatted_date}}</td>
                                        <td>{{$item->data['pul']}}</td>
                                        <td>{{$item->data['sys']}}</td>
                                        <td>{{$item->data['dia']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group" style="float: right;">
                        <input type="text" name="from" id="date_from" class="form-control">
                        <button type="button" class="btn btn-success">To</button>
                        <input type="text" name="to" id="date_to" class="form-control">
                        <button type="button" class="btn btn-danger" id="filter_btn"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="spinner-border spinners text-info d-none" role="status" id="device_spinner">
                        <span class="sr-only">Loading...</span>
                     </div>
                    <div id="device_chart">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="height:512px; overflow-y:scroll;">
                <div class="card-body">
                    <h4 class="card-title">Patient Readings</h4>
                    <div class="table-responsive">
                        <table class="table table-striped" id="filter_data_table">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>Date</th>
                                    <th>Pul</th>
                                    <th>Sys</th>
                                    <th>Dia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td colspan="4">No data Found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        var device_chart;
        $(document).ready(function() {

            $('#device_data_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
            });
            $('#date_from').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"

            });
            $('#date_to').flatpickr({
                dateFormat: "m-d-Y",
                defaultDate: "today"
            });
            var options = {
                series: [
                    {
                        name: 'Heart Beat',
                        type: 'area',
                        data: []
                        // data: response.device_data_1


                    },
                    {
                        name: 'Systolic',
                        type: 'line',
                        data: []
                        // data: response.device_data_2

                    },
                    {
                        name: 'Dystolic',
                        type: 'line',
                        data: []
                        // data: response.device_data_3

                    },

                ],
                colors:['#FB254D', '#1CA3B5', '#1E88E5'],
                chart: {
                    height: 400,
                    stacked: false
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    width: [2, 2, 2],
                    curve: "smooth"
                },
                fill: {
                    opacity: [0.1,0.7,1],
                },
                title: {
                    text: 'Patient Reading',
                    align: 'left',
                },
                xaxis: {
                    categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
                },
                tooltip: {
                    fixed: {
                        enabled: true,
                        position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                        offsetY: 30,
                        offsetX: 60
                    },
                },
                legend: {
                    horizontalAlign: 'left',
                    offsetX: 40
                }
            };

            device_chart = new ApexCharts(document.querySelector("#device_chart"), options);
            device_chart.render();


            var from = $('#date_from').val();
            var to = $('#date_to').val();
            var device_id = "{{$device->id}}";
            if(from && to && device_id){
                set_graph_data(from, to, device_id);
            }

        });

        $('#filter_btn').click(function(){
            var from = $('#date_from').val();
            var to = $('#date_to').val();
            var device_id = "{{$device->id}}";
            if(from && to){
                set_graph_data(from, to, device_id);
            }
            else{
                toastr.warning('Empty Value', 'Warning!',{
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            }
        });

        function set_graph_data(from, to, device_id){
            $.ajax({
                url: "{{route('device-data.filter')}}",
                type: "post",
                data: {
                    from: from,
                    to: to,
                    device_id: device_id
                },
                beforeSend: function(){
                    $('#device_spinner').removeClass('d-none');
                },
                success: function(response){
                    var table_body = $('#filter_data_table tbody');
                    table_body.empty();
                    if(response.systolic.length > 0){
                        $.each(response.date, function (i, value) {
                            var data = '<tr>'+
                                            '<td>'+response.date[i]+'</td>'+
                                            '<td>'+response.pulse_rate[i]+'</td>'+
                                            '<td>'+response.systolic[i]+'</td>'+
                                            '<td>'+response.diastolic[i]+'</td>'+
                                        '</tr>';
                            table_body.append(data);
                        });
                        device_chart.updateOptions({
                            series: [{
                                name: 'Pulse Rate',
                                type: 'area',
                                data: response.pulse_rate

                            }, {
                                name: 'Systolic',
                                type: 'line',
                                data: response.systolic
                            }, {
                                name: 'Diastolic',
                                type: 'line',
                                data: response.diastolic
                            }],
                            xaxis: {
                                categories: response.date,
                            },
                        });
                        $('#device_spinner').addClass('d-none');

                    }
                    else{
                        $('#device_spinner').addClass('d-none');
                        var data = '<tr class="text-center">'+
                                        '<td colspan="4">No data Found</td>'+
                                    '</tr>';
                        table_body.append(data);
                    }
                },
                error: function(){
                    $('#device_spinner').addClass('d-none');

                    toastr.error('Something went wrong', 'Error!',{
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
        }

    </script>


@endsection
