<?php

$year=$year;
$yr=substr($year, -2);
$month=array("1"=>"JAN-".$yr,"2"=>"Feb-".$yr,"3"=>"Mar-".$yr,"4"=>"Apr-".$yr,"5"=>"May-".$yr,"6"=>"Jun-".$yr,"7"=>"Jul-".$yr,"8"=>"Aug-".$yr,"9"=>"Sept-".$yr,"10"=>"Oct-".$yr,"11"=>"Nov-".$yr,"12"=>"Dec-".$yr);
$month1=array("01"=>"JAN-".$yr,"02"=>"Feb-".$yr,"03"=>"Mar-".$yr,"04"=>"Apr-".$yr,"05"=>"May-".$yr,"06"=>"Jun-".$yr,"07"=>"Jul-".$yr,"08"=>"Aug-".$yr,"09"=>"Sept-".$yr,"10"=>"Oct-".$yr,"11"=>"Nov-".$yr,"12"=>"Dec-".$yr);
//$month_wise = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
 // $month_wise = [$month=>$monthName]; 
?>

<html>
<head>
  <style>


    .tooltip1 {
      position: relative;
      display: inline-block;
      border-bottom: 1px dotted black;
    }

    .tooltip1 .tooltiptext1 {
      visibility: hidden;
      width: 75px;
      background-color: #555;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      position: absolute;
      z-index: 1;
      bottom: 125%;

      margin-left: -30px;
      opacity: 0;
      transition: opacity 1s;
    }

    .tooltip1 .tooltiptext1::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: #555 transparent transparent transparent;
    }

    .tooltip1:hover .tooltiptext1 {
      visibility: visible;
      opacity: 1;
    }

    .thcolor{
     background: #ffff00;  
   }
   th{
    font-size: 11px;
    height:50px;
    text-align: center;
  }
  tr{
    height:50px;
  }
  .weekcolor{
   background: #00b0f0;  
 }
 
 .txtcenter
 {
  text-align: center;
  font-weight: bold;
  font-size: 14px;
  width:50%;
}

hr {
  margin-top: 0px;
  margin-bottom: 0px;
  border: 0;
  border-top: 1px solid #eee;
}
.view_print{
  background-color: #fff;
  text-align: center;
  margin:0px;
  padding:5px;
  border:1px solid #ccc;
  font-size:20px;
  line-height:24px;
  font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  color:#555;
}
.JAN1{
 background: #b3c6e7;  
}   

.JAN2{
 background: #349a6b;  
}   

.JAN3{
 background: #3f0e75;  
 color:white;
}   

.JAN4{
 background: #a7afe4;  
}   

.JAN5{
 background: #dfe7b3;  
}   

.JAN6{
 background: #b3e7e0;  
}   

.JAN7{
 background: #b3c6e7;  
}   

.JAN8{
 background: #349a6b;  
}   

.JAN9{
 background: #3f0e75;
 color:white;
}   

.JAN10{
 background: #a7afe4;  
}   

.JAN11{
 background: #dfe7b3;  
}   

.JAN12{
 background: #b3e7e0;  
}   


</style>
</head>
<body>




  
  <input type="hidden" class="department_id" value="{{$dept_id}}">
  <table width="100%"  border="1" class="sbox-content">
   <tr>
    <td  width="50%"><img src='../public/images/logo.jpg' width="200" height="50">
      <h4>L&T Construction<br> POWER TRANSMISSION & DISTRIBUTION <br> TLT-PONDICHERRY,PITHAMPUR & KANCHIPURAM UNITS<br>QUALITY,ENVIRONMENT,HEALTH & SAFETY MANAGEMENT SYSTEM</h4>
    </td>
    
    <th width="50%" class="txtcenter">PREVENTIVE MAINTENANCE SCHEDULE </th>
  </tr>  
</table>
<table width="100%" border="1" class="sbox-content">
  
  <thead>
   
    <tr>
      <th rowspan="3">SNO</th>
      <th rowspan="3">Machine Number</th>
      <th rowspan="2">{{$year}}</th>
    </tr>
    <tr>

      <div class="tooltip">Hover over me
        <span class="tooltiptext">Tooltip text</span>
      </div>



      <th colspan="4">Planned Week</th>



    </tr>
    <tr>
     
      <th class="weekcolor">Weeks</th>
      <?php $week_no="0"; 
      $no=0;
      $no_of_weeks=4; 
      
//$no=$no+$i;	
      for($i=1;$i<=4;$i++){
        $no=$no+1;
        echo "<th class=''>W".$i."</th>";
      }
      
      ?>
    </tr>
  </thead>
  <tbody>
    
    <?php $sno=1; foreach($machine_details as $key=>$value){ $machine_id=$value->machine_id; ?>
      <tr>
        <td rowspan="2">{{$sno}}</td>
        <td rowspan="2">{{$value->asset_code}}-{{$value->machine_name}}</td>
        <td>Plan</td>
        <?php
//$no_of_weeks=$weeks[$key]; 
          $no_of_weeks=4; 
//$no=$no+$i;	
          for($i=1;$i<=$no_of_weeks;$i++){

            if(isset($data[$machine_id][$sele_mon][$i])) {
                
              if(!empty($data[$machine_id][$sele_mon][$i]['date'])) {
                echo"
                <td class='tooltip1'><img src='../public/images/plan.png'>
                <span class='tooltiptext1'>".$data[$machine_id][$sele_mon][$i]['date']."</span>
                </td>";
              } else { echo "<td></td>"; }
            } else {
              echo "<td></td>";
            }  
          }
          
       
        ?>
      </tr>
      <tr>
        <td>Actual Done On</td>
        <?php  
//$no_of_weeks=$weeks[$key]; 
          $no_of_weeks=4; 
//$no=$no+$i;	
          for($i=1;$i<=$no_of_weeks;$i++){

            if(isset($data[$machine_id][$sele_mon][$i])) {
             if(!empty($data[$machine_id][$sele_mon][$i]['done_date'])) {
               echo"<td>".$data[$machine_id][$sele_mon][$i]['done_date']."</td>";
             } else { echo "<td></td>"; }
           } else {
            echo "<td></td>";
          }  
//echo "<td>".$data[$machine_id][$no]['date']."</td>";
  //echo  "<td>".$data[$machine_id][$week_no]['date']."</td>";    
        }
        
     
      ?>
    </tr> 
    <?php $sno++;}  ?>
    
    
  </tbody>
</table>


<script>

</script>

</body>
</html>
