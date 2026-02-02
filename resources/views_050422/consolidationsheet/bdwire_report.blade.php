<?php
$cur_year=date("Y");
$monthwise = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
$month = ["01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
?>

<div class="sbox">
<div class="sbox-title"> 
		
    <h4>No of Breakdown Hours in {{$years}} For {!! SiteHelpers::gridDisplayView( $department_id ,'equipment_id','1:m_department_tbl:department_id:department_name') !!}</h4>	
	</div>
	
	<div class="sbox-content form-horizontal"> 
            <table class="table table-bordered">
                <thead>
                    <tr>
                    
                </thead>
                <tbody>
                     <tr>
                         <td>Month</td>
                        <?php foreach($monthwise as $k=>$v) { ?>
                  
                       
                       <td>{{$v}}</td>
                      <?php  } ?></tr>
                        <tr>
                            <td>Actual</td>
                        <?php foreach($monthwise as $k=>$v) { if(isset($yr_total[$k]['brk_hrs'])) { ?>
                  
                       
                       <td>{{$yr_total[$k]['brk_hrs']}}</td>
                        <?php } else { echo "<td></td>"; } } ?></tr>
                        <tr>
                            <td>Target</td>
                        <?php foreach($monthwise as $k=>$v) { ?>
                  
                       <?php if(isset($no_brk_hrs_target)) { ?>
                         <td><?php echo secremove($no_brk_hrs_target);?> </td>
                         <?php } else { echo "<td></td>"; } ?>
                      
                      <?php  } ?></tr>
                       
                </tbody>
            </table>
            
            </div>	

   <div id="container5" style="min-width: 400px; height: 400px; margin: 0 auto"></div>


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

//
 Highcharts.chart('container5', {
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

</script>