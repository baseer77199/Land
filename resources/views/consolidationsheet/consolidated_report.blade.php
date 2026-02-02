<?php 
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
    
$cur_year=date("Y");
//$month = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
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
		
    <h4>CONSOLIDATED REPORT FOR {{$department_name}}-{{$years}}
<a href='' class='view_print print'><i class="fa fa-print" aria-hidden="true" titlt='Print' style="float:right;"></i></a> </h4>
</h4>	
	</div>
    <div class="sbox-content form-horizontal"> 
             <div id="table-scroll" class="table">
            <input type='hidden' value='{{$department_id}}' class='depart_id'>
            <input type='hidden' value='{{$years}}' class='year'>
           

            
            <table class="table table-bordered" id="table-scroll">
                <thead>
                    <tr>
                        <th rowspan="2">Sno</th>
                        <th rowspan="2">M/C Name</th>
                        <th rowspan="2">M/C ID No</th>
                        <th rowspan="2">Performance Measurement</th>
<!--                        <th rowspan="2">History card</th>-->
                        
                        <th align="center" colspan="12">Month - {{$years}}</th>
                        <th rowspan="2">Overall</th>
                        </tr>
                        <tr>
                            <?php foreach($month as $value){ ?>
                            <td>{{$value}}</td>
                            <?php } ?>
                            
                        </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($rowData as $value) { //dd($breakdown_details);
                        $machine_id=$value->machine_id; ?>
                    <tr>
                        <td rowspan="6">{{$i}}</td>
                        <td rowspan="6"machine name</td>
                        <td rowspan="6">machine_number</td>
                        <th>No.Of Break Downs</th>
<!--                        <td rowspan="6">His card</td>-->
                        <?php foreach($month as $key=>$value){ 	?>
                        <td width="30px">
                            {{$breakdown_details[$machine_id][$key]['no_brkdown']}}
                        </td>
                      
                        <?php } ?>
                        <td>{{$total[$machine_id]['total_brkdwn']}}</td>
                        
                        
                    </tr>
                    <tr>
                        <th>Break Down Hours</th>
                        <?php foreach($month as $key=>$value){ ?>
                        <td width="30px">
                             {{secremove($breakdown_details[$machine_id][$key]['brkdown_hrs'])}}
                        </td>
                        
                        <?php } ?>
                        <td>{{secremove($total[$machine_id]['total_brkdwn_hours'])}}</td>
                        </tr><tr>
                        <th>Availability Hours</th>
                          <?php foreach($month as $key=>$value){ ?>
                        <td width="30px">
                            {{secremove($breakdown_details[$machine_id][$key]['availability_hrs'])}}
                        </td>
                        
                        <?php } ?>
                        <td>{{secremove($total[$machine_id]['total_avail_hours'])}}</td>
                        </tr><tr>
                        <th>Repair Hours</th>
                          <?php foreach($month as $key=>$value){ ?>
                        <td width="30px">
                            {{secremove($breakdown_details[$machine_id][$key]['repair_hrs'])}}
                        </td>
                        
                        <?php } ?>
                        <td>{{secremove($total[$machine_id]['total_repair_hours'])}}</td>
                        </tr><tr>
                        <th>Mean Time To Repair</th>
                          <?php foreach($month as $key=>$value){ ?>
                        <td width="30px">
                            {{secremove($breakdown_details[$machine_id][$key]['mttr'])}}
                        </td>
                        <?php } ?>
                        <td>{{secremove($total[$machine_id]['total_mttr_hours'])}}</td>
                        </tr><tr>
                        <th>Mean Time Between Failure</th>
                          <?php foreach($month as $key=>$value){ ?>
                        <td width="30px">
                            {{secremove($breakdown_details[$machine_id][$key]['mtbf'])}}
                        </td>
                        <?php } ?>
                        <td>{{secremove($total[$machine_id]['total_mtbf_hours'])}}</td>
                    </tr>
                    <?php $i++; } ?>
                    
                    
                    <tr>
                        <td colspan="3" rowspan="7">Yearly</td>
                        <th>No.Of Break Downs</th>
                         <?php //foreach($month as $key=>$value){ 
                      
                           // echo "<td width='30px'>".$yr_total[$key]['no_brkdwn']."</td>";

                      
                         //} ?>
                        <td>{{$overall_brkdwn}}</td>
                        
                        
                    </tr>
                    <tr>
                        <th>Break Down Hours</th>
                        <?php foreach($month as $key=>$value){ if(isset($yr_total[$key]['brk_hrs'])){ ?>
                        <td width="30px">
                            {{$yr_total[$key]['brk_hrs']}}
                        </td>
                        
                        <?php } else { echo "<td></td>";} } ?>
                        <td>{{$overall_brkhrs}}</td>
                        </tr><tr>
                        <th>Availability Hours</th>
                         
                        <td>{{$overall_available_hrs}}</td>
                        </tr><tr>
                        <th>Repair Hours</th>
                         
                        <td width="30px">
                        </td>
                        
                        <td>{{$overall_rephrs}}</td>
                        </tr><tr>
                        <th>Mean Time To Repair</th>
                            <td width="30px">
                        </td>
                        <td>{{$overall_mttrhrs}}</td>
                        </tr>
                        <tr>
                        <th>Total Up Time</th>
                        <td width="30px">
                            {{$yr_total[$key]['up_time']}}
                        </td>
                        <td>{{$overall_uptime}}</td>
                        </tr>
                        <tr>
                        <th>Mean Time Between Failures</th>
                        <td width="30px">
                            {{$yr_total[$key]['mtbf_hrs']}}
                        </td>
                        <td>{{$overall_mtbfhrs}}</td>
                    </tr>
                  
                        </tr>

                       

                </tbody>
            </table>
            <script>
            $(".print").click(function(){

     var arr='';
     var department=$(".depart_id").val();
     var year='{{$years}}';
   
     var url='{{ 'report' }}/reportprintpdf/'+department+'/'+year+'/consolidationpdf';
     window.open(url,'_blank');
      return false;
   
    });	
 </script>
            </div>
     </div>
    </div>
