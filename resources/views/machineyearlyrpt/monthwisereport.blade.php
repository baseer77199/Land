@extends('layouts.header')
@section('content')

<style type="text/css">
.ui-datepicker-calendar {
    display: none;
}

.divhide .card {
    padding: 5px;
    border: 1px solid #ccc;
}

.divhide .table {
    width: 100%;
}

.card-header {
    border-bottom: 1px solid #ccc;
}

.btn_active {
    color: #fff !important;
    background-color: #154c87 !important;
    border-color: #154c87 !important;
}

.th_width {
    width: 10%;
    vertical-align: inherit !important;
    text-align: center !important;
}

.td_bg {
    width: 10%;
    vertical-align: inherit !important;
    text-align: center !important;
    background: #07234e;
    color: #ffffff;
    font-size: small;
}
</style>

<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>
<h2 class="heads">Month Wise Machine Report</h2>
<div class="card">


    <div class="card-body card-block">
        <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate
            enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="col-md-offset-2 col-md-4">
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Month</label>
                    <div class="col-md-6">
                        <div class="input-group form_date " data-date="" data-link-format="yyyy-mm-dd">
                            <input class="form-control start_date  " id="start_date" name="start_date" required
                                type="text" value="" style="border-radius: 5px;">

                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-md-4">
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Department Name</label>
                    <div class="col-md-6">
                        <select id="department_id" name='department_id' rows='5'
                            class='form-control department_id select2' tabindex="1" data-show-subtext="true"
                            data-live-search="true" required>
                            {!! $department_id !!}
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group text-center">
                    <button type="button" class="btn save search" value="SAVE">Search</button>
                    <button type="button" class="btn print" onclick="window.print()">Print</button>
                </div>
            </div>
            <div class="row">

                <!-- <span class="float-right" style="margin-left: 1000px;"><button onclick="window.print()">Print this page</button></span> -->
            </div>


            <div class="row">
                <div class="data calculation">

                    <div id="monthchart"></div>

                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th rowspan="2" class="th_width">Machine</th>
                                <th rowspan="2" class="th_width">NO OF BD</th>
                                <th rowspan="2" class="th_width">BD HOURS</th>
                                <th rowspan="2" class="th_width">AVAILABILITY HOURS</th>
                                <th rowspan="2" class="th_width">REPAIR HOURS</th>
                                <th colspan="2" class="th_width">MTTR</th>
                                <th colspan="2" class="th_width">MTBF</th>
                                <th rowspan="2" class="th_width">Remarks</th>
                            </tr>
                            <tr>
                                <th>Target</th>
                                <th>ACTUAL</th>
                                <th>Target</th>
                                <th>ACTUAL</th>
                            </tr>

                        </thead>
                        <tbody class="month_body">


                        </tbody>


                    </table>


                </div>
            </div>

        </form>

        <div class="divhide">


        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="overallgrid"></table>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/pqselect.min.js')}}"></script>
<script src="{{ asset('js/pqgrid.min.js')}}"></script>
<script src="{{ asset('js/pq-localize-en.js')}}"></script>
<link rel="stylesheet" href="{{ asset('css/pqselect.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.ui.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.css')}}" />
<script src="{{ asset('js/filesaver.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $(".search").click(function() {
        var start_date = ($('.start_date').val() != '') ? $('.start_date').val() : '';
        var department_id = ($('.department_id').val() != '') ? $('.department_id').val() : '';


        if (start_date != '' && department_id != '') {
            var url = "{{URL::to('getmonthwisemachinereport')}}/?start_date=" + start_date +
                "&department_id=" + department_id;
            $.get(url, function(data) {
                // alert(JSON.stringify(data.data));
                var months = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11",
                    "12"
                ];
                var html = '';
                var timechart = [];
                var machine = [];

                $.each(data.data, function(index, val) {
                    machine.push(val.machine_name);
                    timechart.push(parseFloat(val.bd_time.slice(0, -3)));
                    html += "<tr><td>" + val.machine_name + "</td><td>" + val.no_of_bd +
                        "</td><td>" + val.bd_time + "</td><td>" + val.total_hrs +
                        "</td><td>" + val.repair_time + "</td><td>00:00:00</td><td>" +
                        val.mttr + "</td><td>00:00:00</td><td>" + val.mtbf +
                        "</td><td></td></tr>";
                });
                console.log(timechart);
                highchart(timechart, machine);
                $(".month_body").html(html);
            });


        } else {
            notyMsg("info", "Please Choose Feilds");
        }



    });

    $(".search_data").click(function() {
        /* $(".search_data").removeClass('btn_active');
         $(this).addClass("btn_active");
         var div=$(this).data('value');
         $(".data").css("display","none");
         $("."+div).css("display",'block');*/
    });


});




var data = "<?php echo \Session('j_date_format'); ?>";

$('.end_date').datepicker({
    changeMonth: true,
    dateFormat: data,
    changeYear: true,

});

function highchart(data, data1) {
    Highcharts.chart('monthchart', {
        title: {
            text: 'Month Wise Machine Report'
        },
        xAxis: {
            text: 'xAxis',
            categories: data1
        },

        labels: {
            items: [{
                html: '',
                style: {
                    left: '50px',
                    top: '18px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f} hrs'
                }
            }
        },
        series: [{
            type: 'column',
            name: 'Machine',
            data: data
        }]
    });
}
$(function() {
    $('.start_date').datetimepicker({
        viewMode: 'years',
        format: 'YYYY-MM'
    });
})

function myFunction() {
    window.print();
}
</script>
@include('layouts.php_js_validation')
@endsection