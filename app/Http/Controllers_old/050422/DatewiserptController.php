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

    $data = \DB::select("select n.month,n.issue_month, n.no_of_bd, TIME_FORMAT(SEC_TO_TIME(n.total_hrs),'%H:%i:%s') as total_hrs, SEC_TO_TIME(n.bd_time) as bd_time,SEC_TO_TIME(n.repair_time) as repair_time,TIME_FORMAT(SEC_TO_TIME((n.total_hrs-n.bd_time)/n.no_of_bd ),'%H:%i:%s') as mtbf,TIME_FORMAT(SEC_TO_TIME(n.repair_time/n.no_of_bd),'%H:%i:%s')  as mttr from (SELECT DATE_FORMAT(mt.issue_date,'%Y-%M') as issue_month,DATE_FORMAT(mt.issue_date,'%m') as month,count(mt.id) as no_of_bd, sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.issue_date))) as bd_time,sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.start_date))) as repair_time,m.machine_name,m.day_working_hrs, (day(last_day(mt.issue_date))*m.day_working_hrs * 3600) as total_hrs FROM `b_maintenance_t` mt join machine_hdr_t m on m.machine_id=mt.machine_id where mt.machine_id='$machine_id' and year(mt.issue_date) ='$start_date' and mt.is_breakdown='Yes' and date( mt.end_date) !=0 GROUP BY DATE_FORMAT(mt.issue_date,'%Y-%m')) n");
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
                
    $data = \DB::select("select n.month,n.machine_name,n.no_of_bd, TIME_FORMAT(SEC_TO_TIME(n.total_hrs),'%H:%i:%s') as total_hrs, SEC_TO_TIME(n.bd_time) as bd_time,SEC_TO_TIME(n.repair_time) as repair_time,TIME_FORMAT(SEC_TO_TIME((n.total_hrs-n.bd_time)/n.no_of_bd ),'%H:%i:%s') as mtbf,TIME_FORMAT(SEC_TO_TIME(n.repair_time/n.no_of_bd),'%H:%i:%s')  as mttr from (SELECT DATE_FORMAT(mt.issue_date,'%Y-%M') as issue_month,DATE_FORMAT(mt.issue_date,'%m') as month,count(mt.id) as no_of_bd, sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.issue_date))) as bd_time,sum(TIME_TO_SEC(TIMEDIFF ( mt.end_date,mt.start_date))) as repair_time,m.machine_name,m.day_working_hrs, (day(last_day(mt.issue_date))*m.day_working_hrs * 3600) as total_hrs FROM `b_maintenance_t` mt join machine_hdr_t m on m.machine_id=mt.machine_id where mt.department_id = '$department_id' and year(mt.issue_date) ='$year' and month(mt.issue_date) ='$month' and mt.is_breakdown='Yes' and date( mt.end_date) !=0 GROUP BY mt.machine_id) n");
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
$wh1='and  machine_hdr_t.location_id='.$loc;      


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

$download_SQL="select * From (SELECT b_maintenance_t.ticket_number,b_maintenance_t.issue_date,b_maintenance_t.maintenance_type,b_maintenance_t.start_date,b_maintenance_t.end_date,ma_department_t.department_name,m_breakdowntype_t.breakdown_name,machine_hdr_t.machine_name,machine_hdr_t.asset_code,m_spares_t.spares_name,TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime  FROM b_maintenance_t left join ma_department_t on(ma_department_t.department_id=b_maintenance_t.department_id) left join m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) left join machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id) left join m_spares_t on(m_spares_t.department_id=b_maintenance_t.department_id)  where STR_TO_DATE(b_maintenance_t.issue_date,'%Y')=STR_TO_DATE('$start_date','%Y') and b_maintenance_t.machine_id ='$machine_id' )v1 where 1=1 $wh ";

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

  $wh1='and  machine_hdr_t.location_id='.$loc;      



  $sidx='';
  if (!$sidx)
    $sidx = 1;
         //  dd("df");         
$result=\DB::select("SELECT * FROM (SELECT ma_department_t.department_name,
   m_breakdowntype_t.breakdown_name,
   machine_hdr_t.machine_name,
   b_maintenance_t.start_date,
   b_maintenance_t.id,
   b_maintenance_t.end_date,
   b_maintenance_t.issue_date,
   b_maintenance_t.request_status,
   TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime,
   TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.issue_date) as actvltime,
   b_maintenance_t.ticket_number,
   cb.employee_number as created_by,
   cbb.employee_number as closed_by
   FROM b_maintenance_t 
   left join  ma_department_t on (ma_department_t.department_id=b_maintenance_t.department_id)
   left join  m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) 
   left join  machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id)
   left join tb_users as cb ON cb.id=b_maintenance_t.issue_created_by
   left join tb_users as cbb ON cbb.id=b_maintenance_t.closed_engineer_by
   where 1=1 $wh1 and b_maintenance_t.issue_date BETWEEN '$start_date' and '$end_date') as v1 where 1=1 $wh ");  

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

$SQL ="SELECT * FROM (SELECT ma_department_t.department_name,
m_breakdowntype_t.breakdown_name,
machine_hdr_t.machine_name,
b_maintenance_t.start_date,
b_maintenance_t.id,
b_maintenance_t.end_date,
b_maintenance_t.issue_date,
b_maintenance_t.request_status,
TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime,
TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.issue_date) as actvltime,
b_maintenance_t.ticket_number,
cb.employee_number as created_by,
cbb.employee_number as closed_by
FROM b_maintenance_t 
left join  ma_department_t on (ma_department_t.department_id=b_maintenance_t.department_id)
left join  m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) 
left join  machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id)
left join tb_users as cb ON cb.id=b_maintenance_t.issue_created_by
left join tb_users as cbb ON cbb.id=b_maintenance_t.closed_engineer_by
where 1=1 $wh1 and b_maintenance_t.issue_date BETWEEN '$start_date' and '$end_date') as v1 where 1=1 $wh  ORDER BY $sidx LIMIT $start , $limit";


$result = \DB::select( $SQL );

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
    
$download_SQL = "SELECT * FROM (SELECT ma_department_t.department_name,
m_breakdowntype_t.breakdown_name,
machine_hdr_t.machine_name,
b_maintenance_t.start_date,
b_maintenance_t.id,
b_maintenance_t.end_date,
b_maintenance_t.issue_date,
b_maintenance_t.request_status,
TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.start_date) as diftime,
TIMEDIFF(b_maintenance_t.end_date,b_maintenance_t.issue_date) as actvltime,
b_maintenance_t.ticket_number,
cb.employee_number as created_by,
cbb.employee_number as closed_by
FROM b_maintenance_t 
left join  ma_department_t on (ma_department_t.department_id=b_maintenance_t.department_id)
left join  m_breakdowntype_t on(m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) 
left join  machine_hdr_t on(machine_hdr_t.machine_id=b_maintenance_t.machine_id) 
left join tb_users as cb ON cb.id=b_maintenance_t.issue_created_by
left join tb_users as cbb ON cbb.id=b_maintenance_t.closed_engineer_by
where 1=1 $wh1 and b_maintenance_t.issue_date BETWEEN '$start_date' and '$end_date')as v1 where 1=1 $wh ";
$result1 = \DB::select( $download_SQL );
$new_id = count($result1);
$result1[$new_id]=(object)array();
$result1[$new_id]->created_by="Format No ";
$result1[$new_id]->closed_by="04.2211.71.03-8";
$new_id = count($result1);
$result1[$new_id]=(object)array();
$result1[$new_id]->created_by="REV ";
$result1[$new_id]->closed_by="00/16"; 
    $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    return $result1;
}
  //dd($result);
$responce->rows[]='';
$responce->data=$result;
$responce->curPage = $page;
$responce->total = $total_pages;
$responce->totalRecords = $count;
echo json_encode($responce);
} 
}
