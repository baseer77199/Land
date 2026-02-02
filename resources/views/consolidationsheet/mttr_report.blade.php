<?php
$cur_year=date("Y");
$monthwise = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
$month = ["01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec"];
function secremove($time){
            if($time != ""){
            $time_array = explode(':', $time);
            $hours = (int)$time_array[0];
            $minutes = (int)$time_array[1];
            $seconds = (int)$time_array[2];
             $time_div="$hours:$minutes";
            } else { $time_div=""; }
            return $time_div;
            
    }
?>

<div class="sbox">
<div class="sbox-title"> 
		
    <h4>Mean Time to Repair in {{$years}} For {{$department_name}}</h4>	
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
                        <?php foreach($monthwise as $k=>$v) { ?>
                  
                       

                            <?php if(isset($yr_total[$k]["mttr_hrs"])) { ?> 
                            <td>{{secremove($yr_total[$k]["mttr_hrs"])}}</td>
                            <?php } else { echo "<td></td>"; }  } ?></tr>
                        <tr>
                            <td>Target</td>
                        <?php foreach($monthwise as $k=>$v) { ?>
                  
                       
                       <?php if(isset($mttr_target)) { ?>
                         <td><?php echo secremove($mttr_target);?>
                           </td>
                         <?php } else { echo "<td></td>"; } ?>
                      <?php  } ?></tr>
                       
                </tbody>
            </table>
            
            </div>	

   <div id="container7" style="min-width: 400px; height: 400px; margin: 0 auto"></div>


    </div>
       <?php 
    function secremove11($time){
        
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
Highcharts.chart('container7', {
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
                    value:"",
                   //  value:$mttr_target_g,
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
       
        pointFormat: '<span style="color:{point.color}">{point.name}</span> <b>{point.y}</b> Hours<br/>'
    },

   
    series: [{
        type: 'column',
        name:'Month',
        data: {{$mttr}},
    }]
    
});
Highcharts.chart('container711', {

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
                    value:,
                    color: '#ff0000',
                    width:2,
                    zIndex:4,
                    label:{text:'Target'}
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

</script>