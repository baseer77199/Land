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
<style type="text/css" media="print">
@media print {
    .Image {
        opacity: 1;
        border-top: 1px solid #fff !important;
    }

    @page {
        size: A3;
        margin: 0 !important;
    }

    /*.header1{*/
    /*    visibility: visible !important;*/
    /*}*/
    .headerdata,
    .footer,
    .heads {
        display: none !important;
    }
}

#table-scroll {
    overflow-x: hidden !important;
}

.table .table {
    page-break-after: always !important;
}

#reportTable>tbody {
    page-break-inside: always !important;
    display: table-footer-group !important;
}

#table-scroll {
    float: none !important;
    position: static !important;
    display: inline;
    box-sizing: content-box !important;
}

#table-scroll>#reportTable>thead {
    page-break-before: always !important;
}

thead {
    display: table-header-group !important;
}

tfoot {
    display: table-row-group !important
}

tr {
    page-break-inside: avoid !important
}

.table-bordered>thead>tr:nth-child(1)>td,
.table-bordered>thead>tr:nth-child(2)>td,
.table-bordered>thead>tr:nth-child(3)>td,
.table-bordered>thead>tr:nth-child(4)>td,
.table-bordered>thead>tr:nth-child(5)>td {
    border: 0px solid #fff !important;
}

.table>thead>tr:nth-child(1)>td,
.table>thead>tr:nth-child(2)>td,
.table>thead>tr:nth-child(3)>td,
.table>thead>tr:nth-child(4)>td,
.table>thead>tr:nth-child(5)>td {
    border-left: 1px solid #fff !important;
    border-right: 1px solid #fff !important;
    border-top: 1px solid #fff !important;
}

th,
td {
    padding: 1.8px !important;
    font-size: 9.8px !important;
    font-weight: bolder !important;
    page-break-inside: avoid !important;
}
</style>
<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>
<h2 class="heads">Overall Machine Report</h2>
<div class="card">


    <div class="card-body card-block">
        <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate
            enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="row headerdata">
                <div class="col-md-offset-2 col-md-4">
                    <div class="form-group row">
                        <label for="inputIsValid" class="form-control-label col-md-4">Year</label>
                        <div class="col-md-6">
                            <div class="input-group form_date " data-date="" data-link-format="yyyy-mm-dd">
                                <input class="form-control start_date  " id="start_date" name="start_date" required
                                    type="text" value="" style="border-radius: 5px;">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-offset-2 col-md-4">
                    <div class="form-group row">
                        <label for="inputIsValid" class="form-control-label col-md-4">Machine Name</label>
                        <div class="col-md-6">
                            <select id="machine_id" name='machine_id' rows='5' class='form-control machine_id select2'
                                tabindex="1" data-show-subtext="true" data-live-search="true" required>
                                {!! $machine_id !!}
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12 col-md-12">
                    <div class="form-group text-center">
                        <button type="button" class="btn search" value="SAVE">Search</button>
                    </div>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-default search_data btn_active"
                        data-value="calculation">Calculation</button>
                    <button type="button" class="btn btn-default search_data" data-value="mttr">MTTR</button>
                    <button type="button" class="btn btn-default search_data" data-value="mtbf">MTBF</button>
                    <!--<span ><button onclick="myFunction()">Print this page</button></span>-->
                    <input class="float-right" style="margin-left: 900px;" type="button" onclick="window.print()"
                        value="Print this page" />
                </div>
            </div>


            <div class="row">
                <div class="data calculation">


                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th rowspan="2" class="th_width">Month</th>
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
                        <tbody class="cal_body">


                        </tbody>


                    </table>


                </div>
                <div class="data mttr" style="display: none;">
                    <div id="chartContainer"></div>


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="1" class="th_width">MONTH(2019) </th>
                                <th rowspan="1" class="th_width">JANUARY</th>
                                <th rowspan="1" class="th_width">FEBRUARY</th>
                                <th rowspan="1" class="th_width">MARCH</th>
                                <th rowspan="1" class="th_width">APRIL</th>
                                <th rowspan="1" class="th_width">MAY</th>
                                <th rowspan="1" class="th_width">JUNE</th>
                                <th rowspan="1" class="th_width">JULY</th>
                                <th rowspan="1" class="th_width">AUGUST</th>
                                <th rowspan="1" class="th_width">SEPTEMBER</th>
                                <th rowspan="1" class="th_width">OCTOBER</th>
                                <th rowspan="1" class="th_width">NOVEMBER</th>
                                <th rowspan="1" class="th_width">DECEMBER</th>
                            </tr>
                        </thead>
                        <tbody class="mttr_cal">

                        </tbody>
                    </table>

                </div>
                <div class="data mtbf" style="display: none;">
                    <div id="mtbfchart"></div>


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="1" class="th_width">MONTH(2019) </th>
                                <th rowspan="1" class="th_width">JANUARY</th>
                                <th rowspan="1" class="th_width">FEBRUARY</th>
                                <th rowspan="1" class="th_width">MARCH</th>
                                <th rowspan="1" class="th_width">APRIL</th>
                                <th rowspan="1" class="th_width">MAY</th>
                                <th rowspan="1" class="th_width">JUNE</th>
                                <th rowspan="1" class="th_width">JULY</th>
                                <th rowspan="1" class="th_width">AUGUST</th>
                                <th rowspan="1" class="th_width">SEPTEMBER</th>
                                <th rowspan="1" class="th_width">OCTOBER</th>
                                <th rowspan="1" class="th_width">NOVEMBER</th>
                                <th rowspan="1" class="th_width">DECEMBER</th>
                            </tr>
                        </thead>
                        <tbody class="mtbf_cal">

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
        var machine_id = ($('.machine_id').val() != '') ? $('.machine_id').val() : '';

        if (start_date != '' && machine_id != '') {
            var url = "{{URL::to('getoverallmachinereport')}}/?start_date=" + start_date +
                "&machine_id=" + machine_id;
            // var url="{{URL::to('getcalculation')}}/?start_date="+start_date+"&machine_id="+machine_id;
            $.get(url, function(data) {

                var months = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11",
                    "12"
                ];
                var mttr_chart = [];
                var mtbf_chart = [];

                var html = '';
                $.each(data.data, function(index, val) {


                    html += "<tr><td>" + val.issue_month + "</td><td>" + val.no_of_bd +
                        "</td><td>" + val.bd_time + "</td><td>" + val.total_hrs +
                        "</td><td>" + val.repair_time + "</td><td>00:00:00</td><td>" +
                        val.mttr + "</td><td>00:00:00</td><td>" + val.mtbf +
                        "</td><td></td></tr>";


                });

                var mttr1 = '<tr><td class="td_bg">NO OF BD</td>';
                var mttr2 = '<tr><td class="td_bg">REPAIR HOURS</td>';
                var mttr3 = '<tr><td class="td_bg">MTTR HOURS</td>';
                var mtbf1 = '<tr><td class="td_bg">NO OF BD</td>';
                var mtbf2 = '<tr><td class="td_bg">BREAKDOWN HOURS</td>';
                var mtbf3 = '<tr><td class="td_bg">AVAILABLE HOURS</td>';
                var mtbf4 = '<tr><td class="td_bg">MTBF HOURS</td>';

                $.each(months, function(index, val) {

                    var check = 0;

                    $.each(data.data, function(index1, val1) {

                        if (val1.month == val) {
                            mttr_chart.push(parseFloat(val1.mttr.slice(0, -3)
                                .replace(':', '.')));
                            mtbf_chart.push(parseFloat(val1.mtbf.slice(0, -3)
                                .replace(':', '.')));

                            check = 1;
                            mttr1 += '<td>' + val1.no_of_bd + '</td>';
                            mttr2 += '<td>' + val1.repair_time + '</td>';
                            mttr3 += '<td>' + val1.mttr + '</td>';
                            mtbf1 += '<td>' + val1.no_of_bd + '</td>';
                            mtbf2 += '<td>' + val1.bd_time + '</td>';
                            mtbf3 += '<td>' + val1.total_hrs + '</td>';
                            mtbf4 += '<td>' + val1.mtbf + '</td>';
                        }

                    });

                    if (check == 0) {
                        mttr1 += '<td></td>';
                        mttr2 += '<td></td>';
                        mttr3 += '<td></td>';
                        mtbf1 += '<td></td>';
                        mtbf2 += '<td></td>';
                        mtbf3 += '<td></td>';
                        mtbf4 += '<td></td>';

                        mttr_chart.push(0.00);
                        mtbf_chart.push(0.00);
                    }


                });

                console.log(mttr_chart);

                highchart(mttr_chart, mtbf_chart);

                var mttr = mttr1 + "</tr>" + mttr2 + "</tr>" + mttr3 + "</tr>";
                var mtbf = mtbf1 + "</tr>" + mtbf2 + "</tr>" + mtbf3 + "</tr>" + mtbf4 +
                "</tr>";


                $(".cal_body").html(html);
                $(".mttr_cal").html(mttr);
                $(".mtbf_cal").html(mtbf);
            });


        } else {
            notyMsg("info", "Please Choose Feilds");
        }



    });

    $(".search_data").click(function() {
        $(".search_data").removeClass('btn_active');
        $(this).addClass("btn_active");
        var div = $(this).data('value');
        $(".data").css("display", "none");
        $("." + div).css("display", 'block');
    });


});




var data = "<?php echo \Session('j_date_format'); ?>";

//
//   // changeMonth: true,
//      dateFormat: 'yy',
//      changeYear: true,   
//      onClose: function(dateText, inst) { 
//                $(this).datepicker('setDate',{dateFormat: 'yy'}, new Date(inst.selectedYear, 1));
//            } 
//  });
$('.end_date').datepicker({
    changeMonth: true,
    dateFormat: data,
    changeYear: true,

});


function highchart(data, data1) {
    Highcharts.chart('chartContainer', {
        title: {
            text: 'MEAN TIME TO REPAIR'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
            name: 'MTTR in Hours',
            data: data
        }]
    });



    Highcharts.chart('mtbfchart', {
        title: {
            text: 'MEAN TIME BETWEEN FAILURES'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
            name: 'MTBF in Hours',
            data: data1
        }]

    });

}
$(function() {
    $('.start_date').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });
})

// function myFunction() {
//   window.print();
// }
</script>

@include('layouts.php_js_validation')
@endsection