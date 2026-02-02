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

    </style>
<div class="sbox">
<div class="sbox-title"> 
		
    <h4>Machine Maintenance Monitoring {{$year}} For {!! SiteHelpers::gridDisplayView( $department ,'equipment_id','1:m_department_tbl:department_id:department_name') !!}</h4>	
	</div>
	
	<div class="sbox-content form-horizontal"> 
            <div id="table-scroll" class="table">
            <input type='hidden' value='{{$department}}' class='depart_id'>
            <a href='' class='view_print print'><i class="fa fa-print" aria-hidden="true" titlt='Print'></i></a>    
            <table class="table table-bordered" id="table-scroll">
                <thead>
                    <tr>
                        <th rowspan="2">Plant</th>
                        <th>Year-{{$year}}</th>
                        <th colspan="4">Preventive Maintainance Complains Score</th>
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
                    <th rowspan="13">{!! SiteHelpers::gridDisplayView( $department ,'equipment_id','1:m_department_tbl:department_id:department_name') !!}</th>
                    <?php foreach($monthwise as $k=>$v) { ?>
                   <tr>
                       
                       <th>{{$v}}</th>
                       <?php if(isset($pm_no_mac[$v])){ ?>
                         <td>  {{$pm_no_mac[$v]}}</td>
                       <?php } else { echo "<td></td>"; } ?>
                       <?php if(isset($pm_done[$v])){ ?>
                         <td>   {{$pm_done[$v]}}</td>
                       <?php } else { echo "<td></td>"; } ?>
                         <td>100%</td>
                         <td>{{$pm_rating[$v]}}</td>
                         <td>1</td>
                         <td>{{$breakdown_details[$k]['no_brkdown']}}</td>
                         <td>18:00</td>
                         <td>{{$breakdown_details[$k]['brkdown_hrs']}}</td>
                         <td>0</td>
                         <td>{{$breakdown_details[$k]['repair_hrs']}}</td>
                         <td>4:00</td>
                         <td>{{$breakdown_details[$k]['mttr']}}</td>
                         <td>2000:00</td>
                         <td>{{$breakdown_details[$k]['mtbf']}}</td>
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
<script>
    var year=<?php echo $year; ?>;
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'No Of Break Down In Jan-='+year+' To Dec-'+year
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total Number Of Break Down'
        },
           plotLines:[{
                    value:2,
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target'}
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
            y:{{$breakdown_details['01']['no_brkdown']}}
        }, {
            name: 'Feb',
            y: {{$breakdown_details['02']['no_brkdown']}}
        }, {
            name: 'March',
            y: {{$breakdown_details['03']['no_brkdown']}}
        }, {
            name: 'April',
            y:{{$breakdown_details['04']['no_brkdown']}}
        }, {
            name: 'May',
            y: {{$breakdown_details['05']['no_brkdown']}}
        },
     {
            name: 'June',
            y: {{$breakdown_details['06']['no_brkdown']}}
        },
     {
            name: 'July',
            y: {{$breakdown_details['07']['no_brkdown']}}
        },
     {
            name: 'Aug',
            y: {{$breakdown_details['08']['no_brkdown']}}
        },
     {
            name: 'Sep',
            y: {{$breakdown_details['09']['no_brkdown']}}
        },
         {
            name: 'Oct',
            y: {{$breakdown_details['10']['no_brkdown']}}
        },
     {
            name: 'Nov',
            y: {{$breakdown_details['11']['no_brkdown']}}
        },
    {
            name: 'Dec',
            y: {{$breakdown_details['12']['no_brkdown']}}
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
        data: {{$mac_count}},
         pointPadding: 0.4,
        pointPlacement: -0.2
       
    }, {
        name: 'No. Of Breakdown Machine',
        color: 'rgba(126,86,134,.9)',
        data: {{$brakdown_count}},
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
        text: 'PM COMPLAINS SCORE FOR THE YEAR'
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
                    label:{text:'Target'},
               
                    
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
        name: 'Department',
        data: [
            
            ['Jan', {{$pm_rate[0]}}],
            ['Feb', {{$pm_rate[1]}}],
            ['Mar', {{$pm_rate[2]}}],
            ['Apr', {{$pm_rate[3]}}],
            ['May', {{$pm_rate[4]}}],
            ['Jun', {{$pm_rate[5]}}],
            ['Jul', {{$pm_rate[6]}}],
            ['Aug', {{$pm_rate[7]}}],
            ['Sep', {{$pm_rate[8]}}],
            ['Oct', {{$pm_rate[9]}}],
            ['Nov', {{$pm_rate[10]}}],
            ['Dec', {{$pm_rate[11]}}]
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
                    value:18,
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target(18.00)'}
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
//Mean Time to Repair
Highcharts.chart('container3', {

    title: {
        text: 'Mean Time To Repair'
    },

   
 xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Hours'
        },
        plotLines:[{
                    value:4,
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target(04.00)'}
                }]
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

  

    series: [{
        name: 'Month',
        data: {{$mttr}}
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
//Mean Time Between Failure
Highcharts.chart('container4', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Mean Time Between Failure'
    },
   
    xAxis: {
       categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        }
    },
    yAxis: {
      title: {
            text: 'Hours'
        },
     plotLines:[{
                    value:2000,
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target(2000:00)'}
                }]
    },
    tooltip: {
        pointFormat: '<span style="color:{point.color}">{point.name}</span> <b>{point.y}</b> Hours<br/>'
        
    },
    plotOptions: {
        area: {
            stacking: 'normal',
            lineColor: '#666666',
            lineWidth: 1,
            marker: {
                lineWidth: 1,
                lineColor: '#666666'
            }
        }
    },
    series: [{
        name: 'Month',
        data: {{$mtbf}}
    }]
});
</script>

<script>
              
    $(".print").click(function(){
     var arr='';
     var department=$(".depart_id").val();
     var year={{$cur_year}};
     //alert(department);
     var url='{{ $pageUrl }}/maintainancepptpdf/'+department+'/'+year;
     window.open(url,'_blank');
      
   
    });	
 
 </script>
