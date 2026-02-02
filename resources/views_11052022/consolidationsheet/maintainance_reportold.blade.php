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

    </style>
<div class="sbox">
<div class="sbox-title"> 
		
    <h4>KEY PERFORMANCE INDICATORS {{$years}} FOR {!! SiteHelpers::gridDisplayView( $department ,'equipment_id','1:m_department_tbl:department_id:department_name') !!}</h4>	
	</div>
	
	<div class="sbox-content form-horizontal"> 
            <div id="table-scroll" class="table">
             <input type='hidden' value='{{$department}}' class='depart_id'>
            
            <a href='' class='view_print print'><i class="fa fa-print" aria-hidden="true" titlt='Print'></i></a>    
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
					<td rowspan="4" style="PADDING-TOP: 78PX;">Machine Maintainance</td>
					
					</tr>
					<tr>
					<td>No Of Breakdown Hours</td>
					<td></td>
					<td>{{$brk_hrs}}</td>

					<?php foreach($monthwise as $k=>$v) { ?>
                   
                       <td>{{$breakdown_details[$k]['brkdown_hrs']}}</td>
					<?php } ?>
					</tr>
					<tr>
					<td>Mean Time to Repair</td>
					<td></td>
					<td>{{$mttr_hrs}}</td>
					<?php foreach($monthwise as $k=>$v) { ?>
					<td>{{$breakdown_details[$k]['mttr']}}</td>
					<?php } ?>
					</tr>
					<tr>
					<td>Mean Time Between Failures</td>
					<td></td>
					<td>{{$mtbf_hrs}}</td>
                    <?php foreach($monthwise as $k=>$v) { ?>
                   
                      
					   <td>{{$breakdown_details[$k]['mtbf']}}</td>
                       
                       <?php } ?>
					   </tr>
					   <tr>
					<td>2</td>
					<td>Die Maintainance</td>
					<td></td>
					<td></td>
					<td></td>
					<?php foreach($monthwise as $k=>$v) { ?>
                   
                      
					   <td></td>
                       
                       <?php } ?>
					</tr>
                </tbody>
            </table>
            <script>
              
    $(".print").click(function(){
     var arr='';
     var department=$(".depart_id").val();
     var year={{$cur_year}};
     //alert(department);
     var url='{{ $pageUrl }}/maintainancepdf/'+department+'/'+year;
     window.open(url,'_blank');
      
   
    });	
 
 </script>
        </div>
            </div>	
    </div>
