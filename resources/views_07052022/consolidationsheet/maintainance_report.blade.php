<?php

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
		
    <h4>KEY PERFORMANCE INDICATORS {{$year}} FOR department
<a href='' class='view_print print'><i class="fa fa-print" aria-hidden="true" titlt='Print' style="float:right;">PRINT</i></a> </h4>

	</div>
	
	<div class="sbox-content form-horizontal"> 
            <div id="table-scroll" class="table">
             <input type='hidden' value='{{$department_id}}' class='depart_id'>
             <input type='hidden' value='{{$year}}' class='years'>
            
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>Sno</td>
						
                        <td>Product</td>
                        <td>Performance Measurement</td>
                        <td >Prior Year's Actual</td>
                        <td >Target Current Year</td>
                        <?php foreach($month as $k=>$v){ ?>
                        <td>{{$v}}</td>
						<?php } ?>
                        </tr>
                        
                        
                </thead>
                <tbody>
                    <tr>
					<td rowspan="4" style="PADDING-TOP: 78PX;">1</td>
					<td rowspan="4" style="PADDING-TOP: 78PX;">Machine Maintenance</td>
					
					</tr>
					<tr>
					<td>No Of Breakdown Hours</td>
					 <?php if(isset($no_brk_target)) { ?>
                         <td>
                             {{$no_brk_target}}</td>
                         <?php } else { echo "<td></td>"; } ?>
					<td><?php  //echo secremove($brk_hrs); ?></td>

					<?php foreach($monthwise as $k=>$v) { if(isset($yr_total[$k]['brk_hrs'])) { //dd($yr_total);?>
                  
                       <td><?php $sec=$yr_total[$k]['brk_hrs']; echo secremove($sec); ?></td>
                                        <?php } else { echo "<td></td>"; } } ?>
					</tr>
					<tr>
					<td>Mean Time to Repair</td>
					  <?php if(isset($mttr_target)) { ?>
                         <td><?php echo secremove($mttr_target);?>
                           </td>
                         <?php } else { echo "<td></td>"; } ?>
					<td><?php  //echo secremove($mttr_hrs); ?></td>
					<?php foreach($monthwise as $k=>$v) { if(isset($yr_total[$k]['mttr_hrs'])) { ?>
					<td><?php $sec=$yr_total[$k]['mttr_hrs']; echo secremove($sec); ?></td>
                                        <?php } else { echo "<td></td>"; } } ?>
					</tr>
					<tr>
					<td>Mean Time Between Failures</td>
					<?php if(isset($mtbf_target)) { ?>
                         <td><?php //echo secremove($mtbf_target);?>
                           </td>
                         <?php } else { echo "<td></td>"; } ?>
					<td><?php  //echo secremove($mtbf_hrs); ?></td>
                    <?php foreach($monthwise as $k=>$v) { if(isset($yr_total[$k]['mtbf_hrs'])) { ?>
                   
                      
					   <td><?php $sec=$yr_total[$k]['mtbf_hrs']; echo secremove($sec); ?></td>
                       
                    <?php } else { echo "<td></td>"; } } ?>
					   </tr>
					   <tr>
					<td>2</td>
					<td>Die Maintenance</td>
					<td></td>
					<td></td>
					<td></td>
					<?php foreach($monthwise as $k=>$v) { ?>
                   
                      
					   <td></td>
                       
                       <?php } ?>
					</tr>
                </tbody>
            </table>
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
              
    $(".print").click(function(){
     var arr='';
     var department=$(".depart_id").val();
     var year=$(".years").val();
     //alert(department);
     /maintainancepdf';
     //window.open(url,'_blank');
      return false;
   
    });	
 
 </script>
        </div>
            </div>	
    </div>
