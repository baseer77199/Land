<?php

$pm_rate=json_decode($pmratings);

$cur_year=date("Y");
$monthwise = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
$month = ["01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
?>
<style>
      #table-scroll {
  
    overflow-x: scroll; 
    overflow-y: visible;
    width: 1500px;
    height: 1000px;
    
    
  margin-top:20px;
  
}
.table {
  
  
  
  margin-top:20px;
}
.print{
    color: #fff;
}
    </style>
<div class="sbox">
<div class="sbox-title"> 
		
    <h4>Machine Maintenance Monitoring {{$years}} For {{$department_name}}
<a href='' class='view_print print'><i class="fa fa-print" aria-hidden="true" titlt='Print' style="float:right;">PRINT</i></a> </h4>		
	</div>
	
	<div class="sbox-content form-horizontal"> 
            <div id="table-scroll" class="table">
            <input type='hidden' value='{{$department_id}}' class='depart_id'>
            <input type='hidden' value='{{$years}}' class='years'>
               
            <table class="table table-bordered" id="table-scroll">
                <thead>
                    <tr>
                        <th rowspan="2">Plant</th>
                        <th>Year-{{$years}}</th>
                        <th colspan="4">Preventive Maintenance Compliance Score</th>
                        <th colspan="2">Breakdown</th>
                        <th colspan="2">Breakdown Hours</th>
                        <th colspan="2" >Repair Time</th>
                        <th colspan="2">Mean Time To Repair</th>
                        <th colspan="2">Mean Time Between Failures</th>
                        
                        </tr>
                        <tr>
                            <th>Month</th>
                            <th>No Of MAchine</th>
                            <th>Actual PM Done</th>
                            <th>Target</th>
                            <th>Rating</th>
                            <th>Target</th>
                            <th>No Of BD</th>
                            <th>Target</th>
                            <th>BD Hrs</th>
                            <th>Target</th>
                            <th>RT</th>
                            <th>Target</th>
                            <th>MTTR In Hrs</th>
                            <th>Target</th>
                            <th>MTBF In Hrs</th>
                            
                        </tr>
                        
                </thead>
                <tbody>
                    <th rowspan="13">{{$department_name}}</th>
                    <?php  foreach($monthwise as $k=>$v) { ?>
                   <tr>
                       
                       <th>{{$v}}</th>
                       <?php if(isset($pm_no_mac)){ ?>
                         <td>  {{$pm_no_mac}}</td>
                       <?php } else { echo "<td></td>"; } ?>
                       <?php if(isset($pm_done[$v])){ ?>
                         <td>   {{$pm_done[$v]}}</td>
                       <?php } else { echo "<td></td>"; } ?>
                         <td>100%</td>
                         <td>{{$pm_rating[$v]}}%</td>
                        <?php if(isset($no_brk_target)) { ?>
                         <td>
                             {{$no_brk_target}}</td>
                         <?php } else { echo "<td></td>"; } ?>
                         <?php if(isset($yr_total[$k]['no_brkdwn'])) { ?>
                         <td>
                             {{$yr_total[$k]['no_brkdwn']}}</td>
                         <?php } else { echo "<td></td>"; } ?>
                          <?php if(isset($no_brk_hrs_target)) { ?>
                         <td><?php echo secremove($no_brk_hrs_target);?> </td>
                         <?php } else { echo "<td></td>"; } ?>
                         <?php if(isset($yr_total[$k]['brk_hrs'])) { ?>
                         <td><?php $sec=$yr_total[$k]['brk_hrs']; echo secremove($sec); ?></td>
                          <?php } else { echo "<td></td>"; } ?>
                         <?php if(isset($no_repair_hrs_target)) { ?>
                         <td><?php echo secremove($no_repair_hrs_target);?> 
                             </td>
                         <?php } else { echo "<td></td>"; } ?>
                         <?php if(isset($yr_total[$k]['rep_hrs'])) { ?>
                         <td><?php $sec=$yr_total[$k]['rep_hrs']; echo secremove($sec); ?></td>
                          <?php } else { echo "<td></td>"; } ?>
                             <?php if(isset($mttr_target)) { ?>
                         <td><?php echo secremove($mttr_target);?>
                           </td>
                         <?php } else { echo "<td></td>"; } ?>
                         <?php if(isset($yr_total[$k]['mttr_hrs'])) { ?>
                         <td><?php $sec=$yr_total[$k]['mttr_hrs']; echo secremove($sec); ?></td>
                          <?php } else { echo "<td></td>"; } ?>
                           <?php if(isset($mtbf_target)) { ?>
                         <td><?php echo secremove($mtbf_target);?>
                           </td>
                         <?php } else { echo "<td></td>"; } ?>
                         <?php if(isset($yr_total[$k]['mtbf_hrs'])) { ?>
                         <td><?php $sec=$yr_total[$k]['mtbf_hrs']; echo secremove($sec); ?></td>
                          <?php } else { echo "<td></td>"; } ?>
                       </tr>
                       <?php } ?>
                </tbody>
            </table>
           </div> 	
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto;"></div>
   <div id="count_report" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
   <div id="complains_report" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
   <div id="container2" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
   <div id="container3" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
   <div id="container4" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

            </div>
    </div>
    <?php 
    function secremove($time){
        
            $time_array = explode(':', $time);
            $hours = (int)$time_array[0];
            $minutes = (int)$time_array[1];
            $seconds = (int)$time_array[2];
             $time_div="$hours:$minutes";
            
            return $time_div;
            
    }
    
    ?>
<script>
    var year=<?php echo $years; ?>;
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'No Of Break Down In Jan-'+year+' To Dec-'+year
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total Number Of Break Down'
        },
           plotLines:[{
                    value:{{$no_brk_target}},
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target({{$no_brk_target}})'}
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
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
    },

    series: [{
        name: 'Month',
        colorByPoint: true,
        data: [ {
            name: 'Jan',
            y:{{$yr_total['01']['no_brkdwn']}}
        }, {
            name: 'Feb',
            y: {{$yr_total['02']['no_brkdwn']}}
        }, {
            name: 'March',
            y: {{$yr_total['03']['no_brkdwn']}}
        }, {
            name: 'April',
            y:{{$yr_total['04']['no_brkdwn']}}
        }, {
            name: 'May',
            y: {{$yr_total['05']['no_brkdwn']}}
        },
     {
            name: 'June',
            y: {{$yr_total['06']['no_brkdwn']}}
        },
     {
            name: 'July',
            y: {{$yr_total['07']['no_brkdwn']}}
        },
     {
            name: 'Aug',
            y: {{$yr_total['08']['no_brkdwn']}}
        },
     {
            name: 'Sep',
            y: {{$yr_total['09']['no_brkdwn']}}
        },
         {
            name: 'Oct',
            y: {{$yr_total['10']['no_brkdwn']}}
        },
     {
            name: 'Nov',
            y: {{$yr_total['11']['no_brkdwn']}}
        },
    {
            name: 'Dec',
            y: {{$yr_total['12']['no_brkdwn']}}
        }]
    }]
    
});
//Break Down Count
Highcharts.chart('count_report', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Available Machine VS Breakdown Occurred Machine'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'March',
            'April',
            'May',
            'June',
            'July',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ]
    },
    yAxis: [{
        min: 0,
        title: {
            text: 'Total Number Of Machine'
        }
    }],
    legend: {
        shadow: true,
         enabled: true
    },
    tooltip: {
        shared: true
    },
    plotOptions: {
        column: {
            grouping: false,
            shadow: false,
            borderWidth: 0,
               dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },
    series: [{
        name: 'No. Of Machine',
        color: 'rgba(165,170,217,1)',
        
        data: [{{$pm_no_mac}},{{$pm_no_mac}},{{$pm_no_mac}},{{$pm_no_mac}},{{$pm_no_mac}},
                {{$pm_no_mac}},{{$pm_no_mac}},{{$pm_no_mac}},{{$pm_no_mac}},{{$pm_no_mac}},
            {{$pm_no_mac}},{{$pm_no_mac}}],
         pointPadding: 0.4,
        pointPlacement: -0.2
       
    }, {
        name: 'No. Of Breakdown Machine',
        color: 'rgba(126,86,134,.9)',
      
       data: [{{$yr_total['01']['no_brkdwn']}},{{$yr_total['02']['no_brkdwn']}},{{$yr_total['03']['no_brkdwn']}},{{$yr_total['04']['no_brkdwn']}},
                {{$yr_total['05']['no_brkdwn']}},{{$yr_total['06']['no_brkdwn']}},{{$yr_total['07']['no_brkdwn']}},{{$yr_total['08']['no_brkdwn']}},
            {{$yr_total['09']['no_brkdwn']}},{{$yr_total['10']['no_brkdwn']}},{{$yr_total['11']['no_brkdwn']}},{{$yr_total['12']['no_brkdwn']}}],
        pointPadding: 0.3,
        pointPlacement: -0.2
    }]
});
//PM Complains Report
Highcharts.chart('complains_report', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'PM COMPLIANCE SCORE FOR THE YEAR'
    },
    subtitle: {
      //  text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
    },
    xAxis: {
        type: 'category',
        labels: {
           // rotation: -45,
            style: {
                fontSize: '15px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
     yAxis: {
   max:100,
        title: {
            text: 'Rating'
        },
       
          plotLines:[{
                    value:100,
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target(100)'},
               
                    
                }]
    },
//  yAxis: {
//        title: {
//            text: 'Total Number Of Break Down'
//        },
//           plotLines:[{
//                    value:100,
//                    color: '#ff0000',
//                    width:2,
//                    zIndex:4,
//                    label:{text:'Target'}
//                }]
//
//    },
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
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>%<br/>'
    },
    series: [{
        name: 'Month',
        data: [
            
            ['Jan', {{$pm_rating['January']}}],
            ['Feb', {{$pm_rating['February']}}],
            ['Mar', {{$pm_rating['March']}}],
            ['Apr', {{$pm_rating['April']}}],
            ['May', {{$pm_rating['May']}}],
            ['Jun', {{$pm_rating['June']}}],
            ['Jul', {{$pm_rating['July']}}],
            ['Aug', {{$pm_rating['August']}}],
            ['Sep', {{$pm_rating['September']}}],
            ['Oct', {{$pm_rating['October']}}],
            ['Nov', {{$pm_rating['November']}}],
            ['Dec', {{$pm_rating['December']}}]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#800000',
            align: 'right',
            format: '{point.y:.1f}%', // one decimal
            y: -5, // 10 pixels down from the top
            style: {
                
                fontSize: '10px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
//
 Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'BreakDown Hours'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Hours(h.m)'
        },
           plotLines:[{
                    value:{{$no_brk_hrs_target_g}},
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target({{$no_brk_hrs_target_g}})'}
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
        name:'Month',
        data: {{$brkdown_hrss}},
    }]
    
});


Highcharts.chart('container3', {
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
           plotLines:[{
                    value:{{$mttr_target_g}},
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target({{$mttr_target_g}})'}
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
        name:'Month',
        data: {{$mttr}},
    }]
    
});
Highcharts.chart('container4', {
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
           plotLines:[{
                    value:{{$mtbf_target_g}},
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target({{$mtbf_target_g}})'}
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
        name:'Month',
        data: {{$mtbf}},
    }]
    
});
</script>

<script>
              
    $(".print").click(function(){
     var arr='';
     var department=$(".depart_id").val();
        var year=<?php echo $years; ?>;
    // var year={{$cur_year}};
     //alert(department);
     //var url='{{ $pageUrl }}/maintainancepptpdf/'+department+'/'+year;
     var url='{{ $pageUrl }}/reportprintpdf/'+department+'/'+year+'/maintainancepptpdf';
     window.open(url,'_blank');
      
   return false;
    });	
 
 </script>
