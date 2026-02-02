@extends('layouts.header')

@section('content')

<style type="text/css">
  body {

    font-family: 'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 12px;
    font-weight: normal;
    color: #595e62;
    -moz-osx-font-smoothing: grayscale;
  }
  .card{
    background:#fff;
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
    line-height:2.4;
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
  #production ,#purchase{
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
 .dashboard1{
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
hr{
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
  transform: translate(0,0);
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
    top:5px;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border-top: 4px solid rgb(21, 77, 134);
    border-radius:15px 15px 0 0;
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
  .pb-0, .py-0 {
    padding-bottom: 0 !important;
  }
  .card1 .table-responsive{
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
  .card1 select{
    width: unset;
    background-color: #dddd;

  }
  .card1 .card-header:first-child {
    border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
  }
  .card1  th,td{
    color: unset;
    background: none;
    box-shadow: none;

  }
  table.dataTable tbody th, table.dataTable tbody td{
    font-size: 12px !important;
  }
  table.dataTable thead th, table.dataTable thead td{
    font-size: 14px !important;
  }

  .fc-grid .fc-day-number{

    width:31px !important;
  }
  .card{
    width:auto;
  }

      .fc-event.fc-event-hori.fc-event-start.fc-event-end{
        text-align:center;
       
       
    color:rgba(255,255,255,0) !important;
}
.fc-event.fc-event-hori.fc-event-start.fc-event-end>.fc-event-inner{
    position:relative;
     top:-0.5em !important;
    color:rgba(255,255,255,1) !important;
}
</style>

<div class="row">

  <div class="col-md-12">
   <div class="card card1" data-aos="fade-up">
    <div class="card-header pb-0">
  <div class="row">
  <div class="col-md-6">
        <h4 class="card-title"><img src="{{asset('images/maintainanceicon1.png')}}" style="width: 48px;height: 48px;">Breakdown Maintenance</h4>
  </div>
    <div class="col-md-6">
        <h4 class="card-title"style="padding-top: 15px;height: 48px;">Preventive Maintenance</h4>
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
    <div class="col-md-4">
      <div id="container"></div>
    </div>
    <div class="col-md-4">
      <div id="container1"></div>
    </div>
      <div class="col-md-4">
      <div id="container2"></div>
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
           <td><b><div style="color:#0e4c87">{!!$value->ticket_number!!}</b></div> </td>
           <td>{!!$value->issue_date!!} </td>
           <td>{!!$value->department_name!!} </td>
           <td>{!!$value->machine_name!!} </td>
           <td>{!!$value->eng_name!!} </td>
           <td>{!!$value->maintenance_type!!} </td>
           <td>{!!$value->breakdown_name!!} </td>
           <td>{!!$value->severity_name!!} </td>
           <td ><div class="label label-table label-default">{!!$value->request_status!!}</div> </td>
         </tr>
         @endforeach
       </tbody>

     </table>
   </div>
 </div>
</div>
</div>
</div>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>


<!--<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>-->

<script src="{{ asset('js/fullcalendar.min.js') }}"></script>

<!--<script src='http://ifiveapps.com/modine/public/js/fullcalendar.min.js'></script>-->


<script>

  var dataname='<?php echo $enchatname;?>';
  var data="{{$enchatid}}";
  var url="{{URL::to('categoryval')}}";
  var data=JSON.parse(data.replace(/&quot;/g,''));

  var result =  $.ajax({
   url: url,
   type: 'GET',
   async: false,
   data: data
 });
  var cat_data =JSON.parse(result.responseText);
  console.log(cat_data);

  $.each(cat_data,function(index,val){
    cat_data[index].y=parseInt(val.y); 
  });

  Highcharts.chart('container1', {
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
          format: '<b>{point.name}</b>: {point.percentage:.0f}'
        }
      }
    },
    series: [{
      name: 'Category',
      colorByPoint: true,
      data:cat_data
    }]
  });
  
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Average Temperature'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Temperature (°C)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Tokyo',
        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
    }, {
        name: 'London',
        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    }]
});

Highcharts.chart('container2', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Average Temperature'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Temperature (°C)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Tokyo',
        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
    }, {
        name: 'London',
        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    }]
});

  
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
                 
                  //  $('#calendar').fullCalendar('gotoDate',''+year+'-'+month+'-01');
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('removeEventSource',source);
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
                    $('#calendar1').fullCalendar('removeEventSource',source);
                    $('#calendar1').fullCalendar('refetchEvents');
                    $('#calendar1').fullCalendar('addEventSource', newSource);
                    $('#calendar1').fullCalendar('refetchEvents');
    
  /* clender1 end*/

  $('#example').DataTable();


</script>


@endsection
