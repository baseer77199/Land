<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DatewiserptController extends Controller
{

	public function __construct()
	{
		$this->data=array();
       $this->data['urlmenu']=$this->indexs(); 
       $this->data['pageMethod']=\Request::route()->getName();
       $this->data['pageFormtype']='ajax';
   }



   public function machineyearlyindex()
   {
       $loc=\Session::get('location');

       $this->data['machine_id']=$this->jcombolocation('machine_hdr_t','machine_id','machine_name','','and location_id=$loc');

       return view('machineyearlyrpt.machineyearly', $this->data);       
   } 

   public function overallmachinereportindex()
   {
      $this->data['machine_id']=$this->jcombologin('machine_hdr_t','machine_id','machine_name','');

      return view('machineyearlyrpt.overallmachinereport', $this->data);       
  }  
  
   public function monthwisemachinereportindex()
   {
      $this->data['department_id']=$this->jcombo('ma_department_t','department_id','department_name','');
      return view('machineyearlyrpt.monthwisereport', $this->data);       
  }  

  public function getoverallmachinereport(){

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   $_GET['start_date'] : '';
    $machine_id =  $_GET['machine_id'];
    $loc=\Session::get('location');

          $wh='';
if($loc != 0){
          
    $wh="and mt.location_id = ".$loc;
}
// print_r("select n.month,n.issue_month, n.no_of_bd, TIME_FORMAT(SEC_TO_TIME(n.total_hrs),'%H:%i:%s') as total_hrs, SEC_TO_TIME(n.bd_time) as bd_time,SEC_TO_TIME(n.repair_time) as repair_time,TIME_FORMAT(SEC_TO_TIME((n.total_hrs-n.bd_time)/n.no_of_bd ),'%H:%i:%s') as mtbf,TIME_FORMAT(SEC_TO_TIME(n.repair_time/n.no_of_bd),'%H:%i:%s')  as mttr from (SELECT DATE_FORMAT(mt.issue_date,'%Y-%M') as issue_month,DATE_FORMAT(mt.issue_date,'%m') as month,count(mt.id) as no_of_bd, sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.issue_date))) as bd_time,sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.start_date))) as repair_time,m.machine_name,m.day_working_hrs, (day(last_day(mt.issue_date))*m.day_working_hrs * 3600) as total_hrs FROM `b_maintenance_t` mt join machine_hdr_t m on m.machine_id=mt.machine_id where mt.machine_id='$machine_id' and year(mt.issue_date) ='$start_date' and mt.is_breakdown='Yes' and date( mt.end_date) !=0 $wh GROUP BY DATE_FORMAT(mt.issue_date,'%Y-%m')) n");die;
    $data = \DB::select("select n.month,n.issue_month, n.no_of_bd, TIME_FORMAT(SEC_TO_TIME(n.total_hrs),'%H:%i:%s') as total_hrs, SEC_TO_TIME(n.bd_time) as bd_time,SEC_TO_TIME(n.repair_time) as repair_time,TIME_FORMAT(SEC_TO_TIME((n.total_hrs-n.bd_time)/n.no_of_bd ),'%H:%i:%s') as mtbf,TIME_FORMAT(SEC_TO_TIME(n.repair_time/n.no_of_bd),'%H:%i:%s')  as mttr from (SELECT DATE_FORMAT(mt.issue_date,'%Y-%M') as issue_month,DATE_FORMAT(mt.issue_date,'%m') as month,count(mt.id) as no_of_bd, sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.issue_date))) as bd_time,sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.start_date))) as repair_time,m.machine_name,m.day_working_hrs, (day(last_day(mt.issue_date))*m.day_working_hrs * 3600) as total_hrs FROM `b_maintenance_t` mt join machine_hdr_t m on m.machine_id=mt.machine_id where mt.machine_id='$machine_id' and year(mt.issue_date) ='$start_date' and mt.is_breakdown='Yes' and date( mt.end_date) !=0 $wh GROUP BY DATE_FORMAT(mt.issue_date,'%Y-%m')) n");
    $this->data['data']     =   $data; 
    $this->data['machine_id']  =   $machine_id;   
    return $this->data;
   // return view('machineyearlyrpt.overallmachinereport',$this->data);
}

  public function getmonthwisemachinereport(){

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   $_GET['start_date'] : '';
    $department_id =  $_GET['department_id'];

         $i_year=$_GET['start_date'];
        if($i_year == "0"){
        $i_year = date("Y");
        }
		$yearmth=explode("-",$i_year);
        $year=$yearmth[0];
        $month=$yearmth[1];
        $wh='';
        $loc=\Session::get('location');
        if($loc != 0){
                  
            $wh="and mt.location_id = ".$loc;
        }          
    $data = \DB::select("select n.month,n.machine_name,n.no_of_bd, TIME_FORMAT(SEC_TO_TIME(n.total_hrs),'%H:%i:%s') as total_hrs, SEC_TO_TIME(n.bd_time) as bd_time,SEC_TO_TIME(n.repair_time) as repair_time,TIME_FORMAT(SEC_TO_TIME((n.total_hrs-n.bd_time)/n.no_of_bd ),'%H:%i:%s') as mtbf,TIME_FORMAT(SEC_TO_TIME(n.repair_time/n.no_of_bd),'%H:%i:%s')  as mttr from (SELECT DATE_FORMAT(mt.issue_date,'%Y-%M') as issue_month,DATE_FORMAT(mt.issue_date,'%m') as month,count(mt.id) as no_of_bd, sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.issue_date))) as bd_time,sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.start_date))) as repair_time,m.machine_name,m.day_working_hrs, (day(last_day(mt.issue_date))*m.day_working_hrs * 3600) as total_hrs FROM `b_maintenance_t` mt join machine_hdr_t m on m.machine_id=mt.machine_id where mt.department_id = '$department_id' and year(mt.issue_date) ='$year' and month(mt.issue_date) ='$month' and mt.is_breakdown='Yes' and date( mt.end_date) !=0 $wh GROUP BY mt.machine_id) n");
    $this->data['data']     =   $data; 
    $this->data['department_id']  =   $department_id;   
    return $this->data;
}

public function getmachineyearlydata()
{
 $wh='';

 if(isset($_GET['pq_filter']))
 {
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $wh.=$this->pqgridsearchsum('v1',$data);
}
$page = $_GET['pq_curpage'];
$limit = $_GET['pq_rpp'];     

$start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   $_GET['start_date'] : '';

//dd($start_date);
    //     $end_date =  isset($_GET['end_date']) && !empty($_GET['end_date']) ? date("Y-m-d", strtotime($_GET['end_date'])) : '';
$machine_id =  $_GET['machine_id'];

$loc=\Session::get('location');

$wh1='';
if($loc != 0){
$wh1='and  machine_hdr_t.location_id='.$loc;      
}

 //   dd($department_id);
$sidx='';
if (!$sidx)
    $sidx = 1;

$department_data=\DB::select("select * From (SELECT b_maintenance_t.ticket_number,b_maintenance_t.issue_date,b_maintenance_t.maintenance_type,b_maintenance_t.start_date,b_maintenance_t.end_date,ma_department_t.department_name,m_breakdowntype_t.breakdown_name,machine_hdr_t.machine_name,m_spares_t.spares_name,TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime  FROM `b_maintenance_t` left join ma_department_t on(ma_department_t.department_id=b_maintenance_t.department_id) left join m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) left join machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id) left join m_spares_t on(m_spares_t.department_id=b_maintenance_t.department_id)  where STR_TO_DATE(b_maintenance_t.issue_date,'%Y')=STR_TO_DATE('$start_date','%Y') and b_maintenance_t.machine_id ='$machine_id' $wh1) as v1 where 1=1 $wh  ");

$count = count($department_data);

if( $count > 0 && $limit > 0)
{
    $total_pages = ceil($count/$limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages)
    $page=$total_pages;
$start = $limit*$page - $limit;
if($start <0) $start = 0;
$loc=\Session::get('location');

$sql=\DB::select("select * From (SELECT b_maintenance_t.ticket_number,b_maintenance_t.issue_date,b_maintenance_t.maintenance_type,b_maintenance_t.start_date,b_maintenance_t.end_date,ma_department_t.department_name,m_breakdowntype_t.breakdown_name,machine_hdr_t.machine_name,machine_hdr_t.asset_code,m_spares_t.spares_name,TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime  FROM b_maintenance_t left join ma_department_t on(ma_department_t.department_id=b_maintenance_t.department_id) left join m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) left join machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id) left join m_spares_t on(m_spares_t.department_id=b_maintenance_t.department_id)  where STR_TO_DATE(b_maintenance_t.issue_date,'%Y')=STR_TO_DATE('$start_date','%Y') and b_maintenance_t.machine_id ='$machine_id' $wh1)v1 where 1=1 $wh");

$download_SQL="select * From (SELECT b_maintenance_t.ticket_number,b_maintenance_t.issue_date,b_maintenance_t.maintenance_type,b_maintenance_t.start_date,b_maintenance_t.end_date,ma_department_t.department_name,m_breakdowntype_t.breakdown_name,machine_hdr_t.machine_name,machine_hdr_t.asset_code,m_spares_t.spares_name,TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime  FROM b_maintenance_t left join ma_department_t on(ma_department_t.department_id=b_maintenance_t.department_id) left join m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) left join machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id) left join m_spares_t on(m_spares_t.department_id=b_maintenance_t.department_id)  where STR_TO_DATE(b_maintenance_t.issue_date,'%Y')=STR_TO_DATE('$start_date','%Y') and b_maintenance_t.machine_id ='$machine_id' $wh1)v1 where 1=1 $wh ";

$new_id = count($sql);
$sql[$new_id]=(object)array();
$sql[$new_id]->end_date="Format No ";
$sql[$new_id]->diftime="04.2211.71.03-1";
$new_id = count($sql);
$sql[$new_id]=(object)array();
$sql[$new_id]->end_date="REV ";
$sql[$new_id]->diftime="00/16";
if(isset($_GET['download']))
{
    $result1 = \DB::select( $download_SQL );
     $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    return $result1;
}


$responce->rows[]='';
$responce->data=$sql;
$responce->curPage = $page;
$responce->total = $total_pages;
$responce->totalRecords = $count;
echo json_encode($responce);

}  




public function index(){


    return view('datewisereport.table',$this->data);    
}

public function getdatewiserpt(){

    $wh='';

    if(isset($_GET['pq_filter']))
    {
      $data=json_decode($_GET['pq_filter']);

      $data=$data->data;
     // $table=array('b_maintenance_t','ma_department_t','m_breakdowntype_t','machine_hdr_t','m_spares_t');
      $wh.=$this->pqgridsearchsum('v1',$data);
  }

  $page = $_GET['pq_curpage'];
  $limit = $_GET['pq_rpp'];
  $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
  $end_date =  isset($_GET['end_date']) && !empty($_GET['end_date']) ? date("Y-m-d", strtotime($_GET['end_date'])) : '';

  $loc=\Session::get('location');

  $wh1='';
if($loc != 0){
  $wh1='and  machine_hdr_t.location_id='.$loc;      
}


  $sidx='';
  if (!$sidx)
    $sidx = 1;

  
$SQL ="SELECT *,
if(v1.end_date='-','-',v1.diftime1) as diftime,
if(v1.end_date='-','-',v1.actvltime1) as actvltime 
FROM (SELECT ma_department_t.department_name,
m_breakdowntype_t.breakdown_name,
machine_hdr_t.machine_name,
b_maintenance_t.start_date,
b_maintenance_t.id,
    if(b_maintenance_t.end_date='0000-00-00 00:00:00','-',b_maintenance_t.end_date) as end_date,
    if(b_maintenance_t.issue_date='0000-00-00 00:00:00','-',b_maintenance_t.issue_date) as issue_date,
b_maintenance_t.request_status,
TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime1,
TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.issue_date) as actvltime1,
b_maintenance_t.ticket_number,
concat(cb.employee_number,'-',cb.first_name) as created_by,
concat(cbb.employee_number,'-',cbb.first_name) as closed_by
FROM b_maintenance_t 
left join  ma_department_t on (ma_department_t.department_id=b_maintenance_t.department_id)
left join  m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) 
left join  machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id)
left join tb_users as cb ON cb.id=b_maintenance_t.issue_created_by
left join tb_users as cbb ON cbb.id=b_maintenance_t.closed_engineer_by
where 1=1 $wh1 and date(b_maintenance_t.issue_date) BETWEEN '$start_date' and '$end_date') as v1 where 1=1 $wh  ORDER BY $sidx";
         //  dd("df");   
         
     // print_r($SQL);die;
$result=\DB::select($SQL);  
// print_r($result);die;
$count = count($result);
if( $count > 0 && $limit > 0)
{
  $total_pages = ceil($count/$limit);
} else {
  $total_pages = 0;
}
if ($page > $total_pages)
  $page=$total_pages;
$start = $limit*$page - $limit;
if($start <0) $start = 0;

      //  $compy=\Session::get('companyid');



// $result = \DB::select( $SQL );

$new_id = count($result);
$result[$new_id]=(object)array();
$result[$new_id]->created_by="Format No ";
$result[$new_id]->closed_by="04.2211.71.03-8";
$new_id = count($result);
$result[$new_id]=(object)array();
$result[$new_id]->created_by="REV ";
$result[$new_id]->closed_by="00/16";


if(isset($_GET['download']))
{
    

    $result1=collect($result)->map(function($x){ return (array) $x; })->toArray();
    return $result1;
}
  //dd($result);
$responce->rows[]='';
$responce->data=array_slice($result,$start , $limit);
$responce->curPage = $page;
$responce->total = $total_pages;
$responce->totalRecords = $count;
echo json_encode($responce);
}


public function availablehrs($y,$mon){ 
  
    if($mon <= '09'){
                $m=substr($mon,1);
            } else {
               $m=$mon;
            }
    
    $number = cal_days_in_month(CAL_GREGORIAN, $m, $y);
      $date = "$y-$m-01";
      $first_day = date('N',strtotime($date));
      $first_day = 7 - $first_day + 1;
      $last_day =  date('t',strtotime($date));
      $days = array();
      for($i=$first_day; $i<=$last_day; $i=$i+7 ){
          $days[] = $i;
      }
    $no_of_sun=sizeof($days);
    $total_days=$number-$no_of_sun;
    $tot_hrs=$total_days*8;
    
    return  $tot_hrs.":00:00";
    
  }
  function digit($digit){
    if($digit <= 9){
      $result="0".$digit;
      } else {
      $result=$digit;
      }
    return $result;
}
  public function total_time($time){
    //$time = array("05:00:00", "06:00:01", "10:05:00");
    $sum="00:00:00";
    $sum_new = explode(':',$sum);// print_r($time);
    foreach ($time as $t)
    {
        $time_new = explode(':',$t);
        
        $hrs=$sum_new[0]+$time_new[0];
        $min=$sum_new[1]+$time_new[1];
        $sec=$sum_new[2]+$time_new[2];
        
        $sum_new[0]=$this->digit($hrs);
        $sum_new[1]=$this->digit($min);
        $sum_new[2]=$this->digit($sec);
    }
    if($sum_new[1] >= "60"){
        $hours = floor($sum_new[1] / 60).':'.($sum_new[1] -   floor($sum_new[1] / 60) * 60);
        $hr=explode(":",$hours);
        $hr_t=$sum_new[0]+$hr[0];
        $sum=$hr_t.":".$hr[1].":".$sum_new[2];
      } else {
        $sum = implode(':',$sum_new);
      }
    return $sum;
}
public function mtbftime1($time1,$time2){
    //  $time2 = '208:00:00';
    //  $time1 = '09:00:00';

          list($hours, $minutes, $seconds) = explode(':', $time2);
          $interval2 = $hours*3600 + $minutes*60 + $seconds;

          list($hours, $minutes, $seconds) = explode(':', $time1);
          $interval1 = $hours*3600 + $minutes*60 + $seconds;

          $diff = $interval2 - $interval1;

          $mtbf_time= floor($diff / 3600) . ':' . 
               str_pad(floor($diff / 60) % 60, 2, '0') . ':' . 
               str_pad($diff % 60, 2, '0');
          
          $hrs=$this->digit(floor($diff / 3600));
          $min=str_pad(floor($diff / 60) % 60, 2, '0');
          $secs=str_pad($diff % 60, 2, '0');
          return $hrs.":".$min.":".$secs;
  }
  public function dividetime($time,$no_brkdown){
    $time_array = explode(':', $time);
    $hours = (int)$time_array[0];
    $minutes = (int)$time_array[1];
    $seconds = (int)$time_array[2];

    $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;

    $average = floor($total_seconds / $no_brkdown);
 
    $init = $average;
    $hours = floor($init / 3600);
    $minutes = floor(($init / 60) % 60);
    $seconds = $init % 60;
    
    $hrs=$this->digit($hours);
    $min=$this->digit($minutes);
    $sec=$this->digit($seconds);
    
    $time_div="$hrs:$min:$sec";
    return $time_div;
    
}
public function getCalculation(){
    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   $_GET['start_date'] : '';
    $machine_id =  $_GET['machine_id'];
    $loc=\Session::get('location');

          $wh='';
if($loc != 0){
          
    $wh="and mt.location_id = ".$loc;
}     
    $month = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
    $avail_month = ["01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec"];
    // if($years=="0"){
    // $years=date("Y");
    // }
    $breakdown_details=[];
    $brkdown_hrs=[];
    $repair_hrs=[];
    
        $this->data['machine_id']=$machine_id;
        //$this->data['year']=$years;
        $years=$_GET['start_date']; print_r($years);
         foreach ($month as $month_no=>$month_name){
             
        //$available_hrs=\DB::select("SELECT * FROM avail_hrs_tbl where machine_id='$machine_id' AND year='2017'");
        //$breakdown_details[$month_no]['availability_hrs']=$availhrs=$available_hrs[0]->$avail_month[$month_no];
        $available_hrs=$this->availablehrs($years,$month_no);
        
        $breakdown_details[$month_no]['availability_hrs']=$availhrs=$available_hrs;
        $machine_details=\DB::select("SELECT TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as repair_hours,
        TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.issue_date) as breakdown_hours
         FROM `b_maintenance_t` where MONTH(issue_date) = '$month_no' AND YEAR(issue_date) = '$start_date' AND machine_id='$machine_id'");
        
        $no_brkdown=count($machine_details);
        $breakdown_details[$month_no]['no_brkdown']=count($machine_details);
       // $breakdown_details[$month_no]['availability_hrs']="208:00:00"; //not tracked yet
        
        foreach ($machine_details as $key1=>$value1){
            if($value1->breakdown_hours != ""){
    
         $total_time=$value1->breakdown_hours;
      
        array_push($brkdown_hrs,$total_time);
        
            }
            if($value1->repair_hours != ""){
                  $total_time1=$value1->repair_hours;
                array_push($repair_hrs,$total_time1);
            }
            }
            if(!empty($brkdown_hrs)){
                 $tot_brkdown_hrs=$this->total_time($brkdown_hrs);
             
               $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,$availhrs);

                 $mtbf_hrs=$this->dividetime($total_mtbf_time,$no_brkdown);
        $breakdown_details[$month_no]['brkdown_hrs']=$this->total_time($brkdown_hrs);
         $breakdown_details[$month_no]['mtbf_act']=$mtbf_hrs; //not tracked yet
            } else {
        $breakdown_details[$month_no]['brkdown_hrs']="";  
         $breakdown_details[$month_no]['mtbf_act']=""; //not tracked yet
            } 
            if(!empty($repair_hrs)){
                $tot_rep_hrs=$this->total_time($repair_hrs);
                $rep_hrs=$this->dividetime($tot_rep_hrs,$no_brkdown);
        $breakdown_details[$month_no]['repair_hrs']=$tot_rep_hrs;        
        $breakdown_details[$month_no]['mttr_act']=$rep_hrs;
            } else {
        $breakdown_details[$month_no]['repair_hrs']="";    
        $breakdown_details[$month_no]['mttr_act']="";
            }
            
           
        $brkdown_hrs=[];
        $repair_hrs=[];
            }
        
    
    $this->data['breakdown_details']=$breakdown_details;
    print_r($breakdown_details); die;
    return view('overallmachinereport.calculation',$this->data);
}
}
