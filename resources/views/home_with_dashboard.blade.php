@extends('layouts.header')

@section('content')

<style type="text/css">
body {

    font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 12px;
    font-weight: normal;
    color: #595e62;
    -moz-osx-font-smoothing: grayscale;
}

.card {
    background: #fff;
    margin-bottom: 5px !important;
}

select {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    appearance: none;
    outline: 0;
    box-shadow: none;
    border: 0 !important;
    background: #2c3e50;
    background-image: none;
}

/* Remove IE arrow */
select::-ms-expand {
    display: none;
}

/* Custom Select */
.select {
    position: relative;
    left: 4px;
    display: flex;
    width: 20em;
    /* height: 3em;*/
    line-height: 2.4;
    background: #2c3e50;
    overflow: hidden;
    border-radius: .25em;
}

select {
    flex: 1;
    padding: 0 .5em;
    color: #fff;
    cursor: pointer;
}

/* Arrow */
.select::after {
    content: '\25BC';
    position: absolute;
    top: 0;
    right: 0;
    padding: 0 1em;
    background: #34495e;
    cursor: pointer;
    pointer-events: none;
    -webkit-transition: .25s all ease;
    -o-transition: .25s all ease;
    transition: .25s all ease;
}

/* Transition */
.select:hover::after {
    color: #f39c12;
}

#production,
#purchase {
    display: none;
}

.table-responsive {
    min-height: .01%;
    overflow-x: auto;
}

.dashboard {
    margin: 5px;
    background-color: #fff;
    border: solid 1px #ddd;
    width: 100%;

}

.dashboard1 {
    margin: unset;
    background-color: #fff;
    border: solid 1px #ddd;

    min-height: 500px;
    max-height: 500px;
}

h2 {
    font-size: 19px;
    font-weight: 200;
    color: #000000;
    text-align: center;

}

hr {
    margin-bottom: 0;
    margin-top: 0;
}

.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    transform: translate(0, 0);
}
</style>

<link rel="stylesheet" type="text/css" href="{{asset('css/datatable.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/fullcalendar.css')}}">

<!--<link rel="stylesheet" type="text/css" href="http://ifiveapps.com/modine/public/css/fullcalendar.css">-->



<h2 class="heads">Dashboard</h2>



<!--  <div class="table-responsive dashboard " style="border-top: 4px solid rgb(21, 77, 134);box-shadow: 0 2px 1px rgba(0, 0, 0, 0.05); border-radius:15px 15px 0 0;">
    <h2><img src="{{asset('images/maintainanceicon1.png')}}" style="width: 48px;height: 48px;">BREAKDOWN MAINTENACE</h2>
    <hr>
  <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">

        <thead>
            <tr>
              <th >S No</th>
                <th >Ticket Number</th>
                <th >Issue Date</th>
                <th >Department Name</th>
                <th >Machine Name</th>
                <th >Allocate Engineer</th>
                <th >Allocate Technician</th>
                <th >Maintenance Type</th>
                <th >Breakdown Type</th>
                <th >Breakdown Severity</th>
                <th >Status</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach ($row as $key => $value): ?>
            <tr>
               <td  >{!! $key+1 !!}</td>
               <td  ><b >{!!$value->ticket_number!!}</b> </td>
               <td  >{!!$value->issue_date!!} </td>
               <td  >{!!$value->department_name!!} </td>
               <td  >{!!$value->machine_name!!} </td>
               <td  >{!!$value->eng_name!!} </td>
               <td  >{!!$value->tech_name!!} </td>
               <td  >{!!$value->maintenance_type!!} </td>
                <td  >{!!$value->breakdown_name!!} </td>
               <td >{!!$value->severity_name!!} </td>
               <td ><div class="label label-table label-success">{!!$value->request_status!!}</div> </td>
                
                  <?php endforeach; ?>
            </tr>
            
        </tbody>
    </table>
  </div> -->


<style type="text/css">
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    border-radius: 50%;
    color: #5D78FF !important;
    background: rgba(93, 120, 255, 0.1);
    border: 0 !important;
}

.card1 {
    position: relative;
    top: 5px;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border-top: 4px solid rgb(21, 77, 134);
    border-radius: 15px 15px 0 0;
}

.card1 .card-header {
    border-color: #f5f5f5;
    position: relative;
    color: #000;
    background: transparent;
    padding: 1.5rem 1.63rem;
    text-align: center;
    justify-content: space-between;
    align-items: center;
    min-height: 65px;
}

.pb-0,
.py-0 {
    padding-bottom: 0 !important;
}

.card1 .table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;

}

.card1 .card-body {
    flex: 1 1 auto;
    padding: 1.63rem;
}

.dataTables_wrapper input[type="search"],
.dataTables_wrapper input[type="text"],
.dataTables_wrapper select {
    border: 1px solid #666666;
    padding: .3rem 1rem;
    color: #715d5d;
}

.card1 select {
    width: unset;
    background-color: #dddd;

}

.card1 .card-header:first-child {
    border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.card1 th,
td {
    color: unset;
    background: none;
    box-shadow: none;

}

table.dataTable tbody th,
table.dataTable tbody td {
    font-size: 12px !important;
}

table.dataTable thead th,
table.dataTable thead td {
    font-size: 14px !important;
}

.fc-grid .fc-day-number {

    width: 31px !important;
}

.card {
    width: auto;
}

.fc-event.fc-event-hori.fc-event-start.fc-event-end {
    text-align: center;


    color: rgba(255, 255, 255, 0) !important;
}

.fc-event.fc-event-hori.fc-event-start.fc-event-end>.fc-event-inner {
    position: relative;
    top: -0.5em !important;
    color: rgba(255, 255, 255, 1) !important;
}

.dash_wrap {
    background: url('images/dash_box_bg.png') no-repeat;
    background-size: 100%;
    position: relative;
    padding-top: 15px;
    padding-left: 35px;
    width: 273px;
    /* border: 5px solid #0070bc; */
    border-left: 8px solid #154d86;
    border-right: 8px solid #154d86;
    border-bottom: 1px solid #154d86;
    border-top: 1px solid #154d86;
    box-shadow: 5px 10px 10px rgba(0, 0, 0, 0.26);
    height: 149px;
    border-top-right-radius: 55px;
    border-bottom-left-radius: 55px;
    cursor: pointer;
}

.dash_wrap:hover {

    border-left: 1px solid #154d86;
    border-right: 1px solid #154d86;
    border-bottom: 8px solid #154d86;
    border-top: 8px solid #154d86;
    transition: border-color 10s ease-out 17.5s;

}

.dash_content {
    margin: 30px 0 30px 0;
}

.dash_box {
    margin: 15px 0;
}

.dash_ic {
    position: absolute;
    top: 5%;
    right: 10%;
    width: 50px;
    height: 64px;
}

.dash_rht {
    float: left;
    width: 65%;
    margin-left: 10%;
    margin-top: 7%;
}

.dash_ic img {
    width: 100%;
    display: block;
    padding-top: 93%;
}

.dash_wrap span {
    background: #0070bc;
    border-radius: 5px;
    height: 3px;
    width: 60px;
    display: inline-block;
    margin-bottom: 25px;
}

.dash_ic img {}

.dash_wrap h4 {
    margin-bottom: 10px;
    margin-top: 15px;
    color: #0070bc;
    font-size: 24px;
}

.dash_wrap p {
    font-size: 30px;
    font-weight: 700;
}
</style>

<div class="row">

    <div class="col-md-12">
        <div class="card card1" data-aos="fade-up">

            <div class="col-md-12 content_box">
                <div class="row" style="margin-top: 60px;">
                    <div class="col-md-3 dash_box wow fadeInUp">
                        <div class="dash_wrap">
                            <h4>Total Breakdown</h4>
                            <span></span>
                            <p>{{$total_breakdown}}</p>
                            <!--<figure class="dash_ic wow zoomIn"><img src="images/sales_ic.png" alt=" " /></figure>-->
                            <figure class="dash_ic wow zoomIn"><img src="images/technics.png" alt=" " /></figure>
                        </div>
                    </div>
                    <div class="col-md-3 dash_box wow fadeInUp">
                        <div class="dash_wrap">
                            <h4>Closed Breakdowns</h4>
                            <span></span>
                            <p>{{$closed_breakdown}}</p>
                            <!--<figure class="dash_ic wow zoomIn"><img src="images/total_purchase_ic.png" alt=" " /></figure>-->
                            <figure class="dash_ic wow zoomIn"><img src="images/close_ic.png" alt=" " /></figure>
                        </div>
                    </div>
                    <div class="col-md-3 dash_box wow fadeInUp">
                        <div class="dash_wrap">
                            <h4>Open Breakdowns</h4>
                            <span></span>
                            <p>{{$open_breakdown}}</p>
                            <!--<figure class="dash_ic wow zoomIn"><img src="images/total_order_ic.png" alt=" " /></figure>-->
                            <figure class="dash_ic wow zoomIn"><img src="images/open.png" alt=" " /></figure>
                        </div>
                    </div>
                    <div class="col-md-3 dash_box wow fadeInUp">
                        <div class="dash_wrap">
                            <h4> Total Machines</h4>
                            <span></span>
                            <p>{{$total_no_machines}}</p>
                            <!--<figure class="dash_ic wow zoomIn"><img src="images/total_order_ic.png" alt=" " /></figure>-->
                            <figure class="dash_ic wow zoomIn"><img src="images/machine-learning.png" alt=" " />
                            </figure>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title" style="padding-top: 15px;height: 48px;"><img
                                src="{{asset('images/settings.png')}}" style="width: 33px;height: 33px;">Preventive
                            Maintenance</h4>
                    </div>
                    <div class="col-md-6">
                        <h4 class="card-title"><img src="{{asset('images/maintainanceicon1.png')}}"
                                style="width: 48px;height: 48px;">Breakdown Maintenance</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id='calendar'> </div>
                </div>
                <div class="col-md-6">
                    <div id='calendar1'> </div>
                </div>
            </div>
            <div class="row" style="margin-top:30px;">
                <div class="col-md-6">
                    <div id="container"></div>
                </div>
                <div class="col-md-6">
                    <div id="container1"></div>
                </div>
                <div class="col-md-6">
                    <div id="container2"></div>
                </div>
                <div class="col-md-6">
                    <div id="container3"><canvas id=bbs-chart'></canvas></div>
                </div>


            </div>
            <div class="card-body" style="margin-top:30px;">
                <div class="table-responsive">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S No</th>
                                <th>Ticket Number</th>
                                <th>Issue Date</th>
                                <th>Department Name</th>
                                <th>Machine Name</th>
                                <th>Allocate Engineer</th>
                                <th>Maintenance Type</th>
                                <th>Breakdown Type</th>
                                <th>Breakdown Severity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($row as $key => $value)
                            <tr>
                                <td>{!! $key+1 !!}</td>
                                <td><b>
                                        <div style="color:#0e4c87">{!!$value->ticket_number!!}
                                    </b>
                </div>
                </td>
                <td>{!!$value->issue_date!!} </td>
                <td>{!!$value->department_name!!} </td>
                <td>{!!$value->machine_name!!} </td>
                <td>{!!$value->eng_name!!} </td>
                <td>{!!$value->maintenance_type!!} </td>
                <td>{!!$value->breakdown_name!!} </td>
                <td>{!!$value->severity_name!!} </td>
                <td>
                    <div class="label label-table label-default">{!!$value->request_status!!}</div>
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
<canvas id="myChart" style="width:100%;max-width:700px"></canvas>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>


<!--<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>-->

<script src="{{ asset('js/fullcalendar.min.js') }}"></script>


<!--<script src='http://ifiveapps.com/modine/public/js/fullcalendar.min.js'></script>-->


<script>
var dataname = '<?php echo $enchatname;?>';
var data = "{{$enchatid}}";
var url = "{{URL::to('categoryval')}}";
var data = JSON.parse(data.replace(/&quot;/g, ''));

var result = $.ajax({
    url: url,
    type: 'GET',
    async: false,
    data: data
});
var column = "{{$column}}";
//  var monthwiseresult =  $.ajax({
//    url: "{{URL::to('monthwisebreakdown')}}",
//    type: 'GET',
//    async: false,
//    data: data
//  });
var cat_data = JSON.parse(result.responseText);
// var monthwise_data =JSON.parse(monthwiseresult.responseText);
// console.log(monthwise_data);

$.each(cat_data, function(index, val) {
    cat_data[index].y = parseInt(val.y);
});
// console.log(monthwise_data);

Highcharts.chart('container3', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Breakdown'
    },
    subtitle: {
        text: 'CATEGORY WISE'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.0f}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: ''
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.0f}% [{point.tot_time}]'
            }
        }
    },
    series: [{
        name: 'Category',
        colorByPoint: true,
        data: cat_data
    }]
});

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Mean Time To Repair'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Hours(h.m)'
        },
        plotLines: [{
            value: 4,
            color: '#ff0000',
            width: 2,
            zIndex: 4,
            label: {
                text: 'Target(04.00)'
            }
        }]

    },
    legend: {

        reversed: false,
        enabled: true
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {

        pointFormat: '<span style="color:{point.color}">{point.name}</span> <b>{point.y}</b> Hours<br/>'
    },


    series: [{
        type: 'column',
        name: 'Month',
        data: <?php echo $mttr; ?>
    }]

});

Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Mean Time Between Failure'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Hours(h.m)'
        },
        plotLines: [{
            value: 2000,
            color: '#ff0000',
            width: 2,
            zIndex: 4,
            label: {
                text: 'Target(2000:00)'
            }
        }]

    },
    legend: {

        reversed: false,
        enabled: true
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {

        pointFormat: '<span style="color:{point.color}">{point.name}</span> <b>{point.y}</b> Hours<br/>'
    },


    series: [{
        type: 'column',
        name: 'Month',
        data: <?php echo $mtbf; ?>,
    }]

});
var inv_data = "{{$monthwise_bd_data}}";
var da = JSON.parse(inv_data.replace(/&quot;/g, '"'));
var col = JSON.parse(column.replace(/&quot;/g, '"'));


Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthwise Breakdown'
    },
    subtitle: {
        text: 'Month wise Breakdown'
    },
    xAxis: {
        categories: col,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'No.of Breakdowns'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Breakdown',
        colorByPoint: true,
        data: da
    }]
});


// var year = 2022;
//    $('.loader').show();
//       var url1="{{URL::to('monthwisebreakdown')}}?year="+year+"&chart=chart";
// 			$.get(url1,function(data){
// 						    console.log(data['label']);
// 						    label=data['label'];
// 						    plan=data['plan'];
// 						    actual=data['actual'];

// 						   		 new Chart(document.getElementById("bbs-chart"), {
//     type: 'line',
//     data: {
//      labels: JSON.parse(label.replace(/&quot;/g,'"')),
//       datasets: [
//         {
//           label: "plan",
//           borderColor: "green",
//          data: JSON.parse(plan.replace(/&quot;/g,'"')),

//         },
//          {
//           label: "actual",
//           borderColor: "red",
//          data: JSON.parse(actual.replace(/&quot;/g,'"')),

//         },
//       ]
//     },
//       yAxis: {

//         title: {
//             text: 'No of Observation'
//         }},
//     options: {
//          scales: {
//       y: {
//         beginAtZero: true
//       }
//     },
//         "animation": {
//       "duration": 1,
//       "onComplete": function() {
//         var chartInstance = this.chart,
//           ctx = chartInstance.ctx;

//         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
//         ctx.textAlign = 'center';
//         ctx.textBaseline = 'bottom';

//         this.data.datasets.forEach(function(dataset, i) {
//           var meta = chartInstance.controller.getDatasetMeta(i);
//           meta.data.forEach(function(bar, index) {
//             var data = dataset.data[index];
//             ctx.fillText(data, bar._model.x, bar._model.y - 5);
//           });
//         });
//       }
//     },
//       title: {
//         display: true,
//         text: 'Value Strem Wise - Safe Vs Unsafe'
//       }
//     }
// });   
// 						});  




/* claender start*/
$('#calendar').fullCalendar({
    height: 400,

    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month'
    },

});
var newSource = "{{URL::to('calendarjsondatadash')}}";
var source = newSource;
console.log(source);
//  $('#calendar').fullCalendar('gotoDate',''+year+'-'+month+'-01');
$('#calendar').fullCalendar('removeEvents');
$('#calendar').fullCalendar('removeEventSource', source);
$('#calendar').fullCalendar('refetchEvents');
$('#calendar').fullCalendar('addEventSource', newSource);
$('#calendar').fullCalendar('refetchEvents');


/* clender end*/


/* claender1 start*/
$('#calendar1').fullCalendar({
    height: 400,

    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month'
    },

});
var newSource = "{{URL::to('calendarjsondatadash1')}}";
var source = newSource;

//  $('#calendar').fullCalendar('gotoDate',''+year+'-'+month+'-01');
$('#calendar1').fullCalendar('removeEvents');
$('#calendar1').fullCalendar('removeEventSource', source);
$('#calendar1').fullCalendar('refetchEvents');
$('#calendar1').fullCalendar('addEventSource', newSource);
$('#calendar1').fullCalendar('refetchEvents');

/* clender1 end*/

$('#example').DataTable();
</script>


@endsection