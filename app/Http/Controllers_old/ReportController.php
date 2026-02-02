<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;

class ReportController extends Controller
{
  public function __construct()
  {
    $this->data=array();
    $this->data['pageMethod']=\Request::route()->getName();
    $this->data['pageFormtype']='ajax';
    $this->data['pageModule']=\Request::route()->getName();
    
    $this->middleware('auth');
    $this->data['urlmenu']=$this->indexs(); 

  }
  public function rptbdown(){
          return view('reportnew.rptbdownreport',$this->data);
  }
  public function rptbdatareport(){
      return view('reportnew.rptbdatareport',$this->data);
  }
  public function monthlybreakdownreportindex()
  {

    return view('reportnew.monthlybreakdownreport',$this->data);
    
  }
  public function monthlybreakdownreportsearch($sd=null,$ed=null)
  {
    $wh1='';
    if($sd!=0){
     
      $start_date=date('Y-m-d',strtotime($sd));
      $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
      $return_data['start_date']=date('d/m/Y',strtotime($sd));
    }else{
     $return_data['start_date']='';
   }
   if($ed!=0){
    $end_date=date('Y-m-d',strtotime($ed));
    $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
    $return_data['end_date']=date('d/m/Y',strtotime($ed));
  }else{
   $return_data['end_date']='';
 }

 $data_break=\DB::select("select * from m_breakdowntype_t");
 $data_depart=\DB::select("select * from ma_department_t");
 $select='';
 $select1='';
 $select_fr='';
 $selectfre='';
 $select_sum='';
 $select_per='';
 $select_fre_sum='';
 $select_total_per='';
 foreach($data_break as $k=>$v)
 {
   $select.="IF(
   break_type_id =".$v->breakdowntype_id.",
   SEC_TO_TIME(
 SUM(TIME_TO_SEC(TIMEDIFF(
   TIME(end_date),
   TIME(start_date)
   )))
),
   0
 ) AS type".$v->breakdowntype_id.",";
 
  $selectfre.="IF(
   break_type_id =".$v->breakdowntype_id.",
   count(b_maintenance_t.machine_id),
   0
 ) AS freq".$v->breakdowntype_id.",";
 
  $select_fr.="SUM(main.freq".$v->breakdowntype_id."
) AS freq".$v->breakdowntype_id.",";
 
 $select1.="SEC_TO_TIME(
 SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id."))
) AS typesum".$v->breakdowntype_id.",";

$select_per.=" round((SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id."))*100)/time_to_sec(sec_to_time( floor(main.day_working_hrs*(DATEDIFF('$end_date','$start_date')+1))*60*60 + ((main.day_working_hrs*1-floor(main.day_working_hrs*1))*100*(DATEDIFF('$end_date','$start_date')+1))  )),2) AS percent".$v->breakdowntype_id.",";
if($k==0){
 $select_sum.=" SEC_TO_TIME(
 SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id.")";
 $select_sum_pre=" SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id.")";
 $select_fre_sum.=" SUM(main.freq".$v->breakdowntype_id;
}else{
  $select_sum.='+TIME_TO_SEC(main.type'.$v->breakdowntype_id.')'; 
  $select_fre_sum.="+main.freq".$v->breakdowntype_id;
  $select_sum_pre.='+TIME_TO_SEC(main.type'.$v->breakdowntype_id.')';
}
}
 $select_fre_sum.=') as total_freq,';
$select_sum.='))as total,';
$select_sum_pre.=")";
 // print_r($select);
  //exit;
$select_total_per.=" round(($select_sum_pre*100)/time_to_sec(sec_to_time(floor(main.day_working_hrs*(DATEDIFF('$end_date','$start_date')+1))*60*60 + ((main.day_working_hrs*1-floor(main.day_working_hrs*1))*100*(DATEDIFF('$end_date','$start_date')+1))  )),2) AS percenttotal ,";

 $loc=\Session::get('location');

          $wh='';
if($loc != 0){
    $wh='and  machine_hdr_t.location_id='.$loc;      
    $wh1.=" and b_maintenance_t.location_id = ".$loc;
}
$data=\DB::SELECT("select * from(SELECT
  main.dept,
  main.machine,
  main.machine_id,
  main.department_id,
    TIME_FORMAT(
        SEC_TO_TIME(main.total_hrs),
        '%H:%i:%s'
    ) AS total_hrs,
  $select1
  $select_sum
  $select_per
 
  $select_fr
  $select_total_per
  $select_fre_sum
  main.br_type
  FROM
  (
  SELECT
  (
  SELECT
  ma_department_t.department_name
  FROM
  ma_department_t
  WHERE
  b_maintenance_t.department_id = ma_department_t.department_id
  ) AS dept,
  (
  SELECT
  machine_hdr_t.machine_name
  FROM
  machine_hdr_t
  WHERE
  b_maintenance_t.machine_id = machine_hdr_t.machine_id $wh
) AS machine,
 (
        SELECT
            machine_lines_t.frequency_id
        FROM
            machine_lines_t
        WHERE
            b_maintenance_t.machine_id = machine_lines_t.machine_id 
    ) AS frequency,
(
SELECT
machine_hdr_t.day_working_hrs
FROM
machine_hdr_t
WHERE
b_maintenance_t.machine_id = machine_hdr_t.machine_id $wh
) AS day_working_hrs,b_maintenance_t.machine_id,b_maintenance_t.department_id,
$select
$selectfre
(
  SELECT
  m_breakdowntype_t.breakdown_name
  FROM
  m_breakdowntype_t
  WHERE
  b_maintenance_t.break_type_id = m_breakdowntype_t.breakdowntype_id
) AS br_type,
 (
 SELECT 
            (DAY(last_day(b_maintenance_t.issue_date)) * machine_hdr_t.day_working_hrs * 3600) as total_hrs
            from machine_hdr_t where b_maintenance_t.machine_id = machine_hdr_t.machine_id
        ) AS total_hrs
FROM
b_maintenance_t where 1=1  $wh1
group by
b_maintenance_t.department_id,b_maintenance_t.machine_id,b_maintenance_t.break_type_id
) AS main
GROUP BY
main.dept,main.machine_id)v1 where 1=1 and v1.machine!='' ");
$return_data['data']=$data;
$return_data['data_break']=$data_break;
$return_data['data_department']=$data_depart;

return view('reportnew.monthlybreakdownreportsearch',$return_data);

}
public function monthlybreakdownreportgroupindex()
{

  return view('reportnew.monthlybreakdownreportgroup',$this->data);
  
}
public function monthlybreakdownreportgroupsearch($sd=null,$ed=null)
{
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}

$data_break=\DB::select("select * from m_breakdowntype_t");
$data_depart=\DB::select("select * from ma_department_t");
$select='';
$select1='';
$select_sum='';
$select_per='';
$select_total_per='';
foreach($data_break as $k=>$v)
{
 $select.="IF(
 break_type_id =".$v->breakdowntype_id.",
 TIMEDIFF(
 end_date,
 start_date
 ),
 0
) AS type".$v->breakdowntype_id.",";
$select1.="SEC_TO_TIME(
SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id."))
) AS typesum".$v->breakdowntype_id.",";

$select_per.=" round((SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id."))*100)/time_to_sec(sec_to_time( floor(main.day_working_hrs*(DATEDIFF('$end_date','$start_date')+1))*60*60 + ((main.day_working_hrs*1-floor(main.day_working_hrs*1))*100*(DATEDIFF('$end_date','$start_date')+1)) )),2) AS percent".$v->breakdowntype_id.",";
if($k==0){
 $select_sum.=" SEC_TO_TIME(
 SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id.")";
 $select_sum_pre=" SUM(TIME_TO_SEC(main.type".$v->breakdowntype_id.")";
}else{
  $select_sum.='+TIME_TO_SEC(main.type'.$v->breakdowntype_id.')'; 
  $select_sum_pre.='+TIME_TO_SEC(main.type'.$v->breakdowntype_id.')';
}
}
$select_sum.='))as total,';
$select_sum_pre.=")";
 // print_r($select);
  //exit;
$select_total_per.=" round(($select_sum_pre*100)/time_to_sec(sec_to_time( floor(main.day_working_hrs*(DATEDIFF('$end_date','$start_date')+1))*60*60 + ((main.day_working_hrs*1-floor(main.day_working_hrs*1))*100*(DATEDIFF('$end_date','$start_date')+1)) )),2) AS percenttotal ,";



 $loc=\Session::get('location');

          $wh='';
  if($loc != 0){
    $wh='and  machine_hdr_t.location_id='.$loc;    
    $wh1.=" and b_maintenance_t.location_id = ".$loc;
  }
$sql="select *from(SELECT
main.group_id,
main.dept,
main.group_name,
main.machine,
main.machine_id,
main.department_id,
$select1
$select_sum
$select_per
$select_total_per
main.br_type


FROM
(
SELECT
(
SELECT
machine_hdr_t.group_id
FROM
machine_hdr_t  
WHERE
b_maintenance_t.machine_id = machine_hdr_t.machine_id limit 1
) AS group_id,
(
SELECT
machine_group_t.group_name
FROM
machine_group_t join machine_hdr_t on machine_hdr_t.group_id=machine_group_t.group_id
WHERE
b_maintenance_t.machine_id = machine_hdr_t.machine_id limit 1
) AS group_name,
(
SELECT
machine_hdr_t.machine_name
FROM
machine_hdr_t
WHERE
b_maintenance_t.machine_id = machine_hdr_t.machine_id  $wh
) AS machine,(
SELECT
machine_hdr_t.day_working_hrs
FROM
machine_hdr_t
WHERE
b_maintenance_t.machine_id = machine_hdr_t.machine_id
) AS day_working_hrs,
(
SELECT
ma_department_t.department_name
FROM
ma_department_t
WHERE
b_maintenance_t.department_id = ma_department_t.department_id
) AS dept,
b_maintenance_t.machine_id,b_maintenance_t.department_id,$select
(
SELECT
m_breakdowntype_t.breakdown_name
FROM
m_breakdowntype_t
WHERE
b_maintenance_t.break_type_id = m_breakdowntype_t.breakdowntype_id
) AS br_type
FROM
`b_maintenance_t` where 1=1  $wh1
) AS main
GROUP BY
main.group_id,main.department_id)v1 where 1=1 and machine!=''";
//print_r($sql); die;
$data=\DB::SELECT($sql);

$return_data['data']=$data;
$return_data['data_break']=$data_break;
$return_data['data_department']=$data_depart;

return view('reportnew.monthlybreakdownreportsearchgroup',$return_data);

}

public function breakdownregisterindex()
{

  return view('reportnew.bdregister',$this->data);
  
}
public function breakdownregistersearch($sd=null,$ed=null)
{
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}
$loc=\Session::get('location');

          $wh='';
if($loc != 0){
    $wh='and  machine_hdr_t.location_id='.$loc; 
    $wh1.=" and b_maintenance_t.location_id = ".$loc;
}
$data=DB::select("select * from(SELECT
  CONCAT_WS(
  ' - ',
  ticket_number,
  DATE(issue_date),
  CASE WHEN shift = 1 THEN 'A' WHEN shift = 2 THEN 'B' WHEN shift = 3 THEN 'C' ELSE ''    END
  ) AS slip_no,
  (
  SELECT
  machine_hdr_t.machine_name
  FROM
  machine_hdr_t
  WHERE
  b_maintenance_t.machine_id = machine_hdr_t.machine_id $wh
  ) AS machine,
  (
  SELECT
  m_breakdowntype_t.breakdown_name
  FROM
  m_breakdowntype_t
  WHERE
  b_maintenance_t.break_type_id = m_breakdowntype_t.breakdowntype_id
  ) AS br_type,
  causes AS bd_detail,
  CONCAT_WS(
  ' - ',
  b_maintenance_t.created_at,
  (
  SELECT
  ma_department_t.department_name
  FROM
  ma_department_t
  WHERE
  b_maintenance_t.department_id = ma_department_t.department_id
  ),(
  SELECT
  tb_users.employee_number
  FROM
  tb_users
  WHERE
  tb_users.id = b_maintenance_t.issue_created_by
  )
  ) AS bd_raised,
  CONCAT_WS(
  ' - ',
  ticket_number,
  (SELECT
  tb_users.employee_number
  FROM
  tb_users
  WHERE
  tb_users.id = b_maintenance_t.engineer
  ),
  ( TIMEDIFF(
  end_date,
  start_date)
  )
  ) AS action_by,
  CONCAT_WS(
  ' - ',
  closed_engineer_on,
  (SELECT
  tb_users.employee_number
  FROM
  tb_users
  WHERE
  tb_users.id = b_maintenance_t.closed_engineer_by)
  ) AS complete,
  if(closed_engineer_by!='','YES','NO') as com_status,
  b_maintenance_t.corrective_action
  FROM
  `b_maintenance_t` where 1=1 $wh1)v1  where 1=1 and v1.machine!=''");
$return_data['data']=$data;

return view('reportnew.bdregistersearch',$return_data);

}   
public function breakdownsummaryindex()
{

  return view('reportnew.bdsummary',$this->data);
  
}
public function breakdownsummarysearch($sd=null,$ed=null)
{
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}

$loc=\Session::get('location');

         
if($loc != 0){
    
    $wh1.=" and b_maintenance_t.location_id = ".$loc;
}
$data=DB::select('SELECT count(id) as call_raised, if(request_status="CANCELLED", COUNT(id),0) AS cancelled , if(request_status="CLOSED", COUNT(id),0) AS resolved , if((request_status="OPEN" or request_status="REJECTED" ), COUNT(id),0) AS pending_resolve, if(request_status="REQUESTED", COUNT(id),0) AS pending_ackn,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(
  end_date,
  start_date
)))) AS break_down_hr FROM `b_maintenance_t` where 1=1 '.$wh1);
$return_data['data']=$data;

return view('reportnew.bdsummarysearch',$return_data);

}

public function categorywisereportindex()
{
 $this->data['breakdowntype_id']=$this->jcombologin('m_breakdowntype_t','breakdowntype_id','breakdown_name','');
 return view('reportnew.categorywise',$this->data);
 
}
public function categorywisereportsearch($sd=null,$ed=null,$breakdowntype_id=null)
{


$loc=\Session::get('location');
    $wh2='';
 
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}
if($loc != 0){
  $wh2='and  machine_hdr_t.location_id='.$loc;      
  $wh1.=" and b_maintenance_t.location_id = ".$loc;
}
$bd_type = $breakdowntype_id;
$category_name=\DB::SELECT("SELECT breakdown_name FROM m_breakdowntype_t WHERE breakdowntype_id=$bd_type");
$return_data['breakdown_name']=$category_name[0]->breakdown_name;
$data=DB::select("select * from(SELECT
  ticket_number,
  DATE(issue_date) as issue_date,
  CONCAT_WS(
  ' - ',
  (
  SELECT
  machine_hdr_t.machine_name
  FROM
  machine_hdr_t
  WHERE
  b_maintenance_t.machine_id = machine_hdr_t.machine_id $wh2
  ),
  (
  SELECT
  ma_department_t.department_name
  FROM
  ma_department_t
  WHERE
  b_maintenance_t.department_id = ma_department_t.department_id
  )
  ) as machine_dept,
  start_date,end_date,
  TIMEDIFF(
  end_date,
  start_date
  ) as time_diff,corrective_action
  
  FROM
  b_maintenance_t where b_maintenance_t.break_type_id='".$bd_type."' $wh1 )v1  where 1=1");
$return_data['data']=$data;

return view('reportnew.categorywisesearch',$return_data);

}

public function groupwisereportindex()
{
 $this->data['group_id']=$this->jcombologin('machine_group_t','group_id','group_name','');
 return view('reportnew.groupwise',$this->data);
 
}
public function groupwisereportsearch($sd=null,$ed=null,$breakdowntype_id=null)
{
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}
$loc=\Session::get('location');
$wh='';    
if($loc != 0){
  $wh='and  machine_hdr_t.location_id='.$loc;      
  $wh1.=" and b_maintenance_t.location_id = ".$loc;
}

$category_name=\DB::SELECT("SELECT group_name FROM machine_group_t WHERE group_id=$breakdowntype_id");
$return_data['group_name']=$category_name[0]->group_name;
$data=DB::select("select * from(SELECT
  ticket_number,
  DATE(issue_date) as issue_date,
  (SELECT
  machine_hdr_t.machine_name
  FROM
  machine_hdr_t
  WHERE
  b_maintenance_t.machine_id = machine_hdr_t.machine_id $wh1
  ) as machine,
  (SELECT m_breakdowntype_t.breakdown_name FROM m_breakdowntype_t WHERE m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id)as bd_type,
  b_maintenance_t.causes as causes,corrective_action,
  TIMEDIFF(
  end_date,
  start_date
  ) as time_diff,request_remark as remarks
  
  FROM
  b_maintenance_t LEFT JOIN machine_hdr_t ON machine_hdr_t.machine_id=b_maintenance_t.machine_id where 1=1 $wh1  AND machine_hdr_t.group_id=$breakdowntype_id)v1  where 1=1 and v1.machine!=''");
$return_data['data']=$data;

return view('reportnew.groupwisesearch',$return_data);

}

public function topcategorywisereportindex()
{

  return view('reportnew.topcategory',$this->data);
  
}
public function topcategorywisereportsearch($sd=null,$ed=null)
{

  $loc=\Session::get('location');
    $wh2='';
 $wh2='and  machine_hdr_t.location_id='.$loc;      
 
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}

if($loc != 0){
$wh1.=' and  b_maintenance_t.location_id='.$loc;  
}
$data=DB::select("select * from(SELECT
  aa.category,
  COUNT(aa.id) as bids,
  SEC_TO_TIME(
  SUM(TIME_TO_SEC(aa.time_diff))
  )as time_diff
  FROM
  (SELECT
  (
  SELECT
  m_breakdowntype_t.breakdown_name
  FROM
  m_breakdowntype_t
  WHERE
  m_breakdowntype_t.breakdowntype_id = b_maintenance_t.break_type_id
  )as category,
  b_maintenance_t.id as id,
  TIMEDIFF(
  end_date,
  start_date
  ) as time_diff
  FROM
  `b_maintenance_t` where 1=1 $wh1)as aa GROUP BY aa.category
  ORDER BY time_diff DESC
  LIMIT 5)v1 where 1=1 ");
$return_data['data']=$data;

return view('reportnew.topcategorysearch',$return_data);

}
public function topmachinewisereportindex()
{

  return view('reportnew.topmachine',$this->data);
  
}
public function topmachinewisereportsearch($sd=null,$ed=null)
{
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}

    $loc=\Session::get('location');

        $wh2='';
  if($loc != 0){
    //$wh2='and  machine_hdr_t.location_id='.$loc;
    $wh1.=' and  b_maintenance_t.location_id='.$loc;      
  }
$data=DB::select("select * from(SELECT
  aa.machine,
  aa.dept,
  COUNT(aa.id) as bids,
  SEC_TO_TIME(
  SUM(TIME_TO_SEC(aa.time_diff))
  )as time_diff
  FROM
  (SELECT
  (
  SELECT
  machine_hdr_t.machine_name
  FROM
  machine_hdr_t
  WHERE
  machine_hdr_t.machine_id = b_maintenance_t.machine_id $wh2
  )as machine,
  (
  SELECT
  ma_department_t.department_name

  FROM
  ma_department_t

  WHERE
  ma_department_t.department_id = b_maintenance_t.department_id 
  )as dept,
  b_maintenance_t.id as id,
  TIMEDIFF(
  end_date,
  start_date
  ) as time_diff
  FROM
  `b_maintenance_t` where 1=1 $wh1)as aa GROUP BY aa.machine
  ORDER BY time_diff DESC
  LIMIT 5)v1 where 1=1 and v1.machine!='' ");
$return_data['data']=$data;

return view('reportnew.topmachinesearch',$return_data);

}
public function toptypewisereportindex()
{

  return view('reportnew.topbreak',$this->data);
  
}
public function toptypewisereportsearch($sd=null,$ed=null)
{
  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}


$data=DB::select("select * from(SELECT
  aa.bd_type,
  COUNT(aa.id) as bids,
  SEC_TO_TIME(
  SUM(TIME_TO_SEC(aa.time_diff))
  )as time_diff
  FROM
  (SELECT
  (
  SELECT
  m_breakdowntype_t.breakdown_name
  FROM
  m_breakdowntype_t
  WHERE
  m_breakdowntype_t.breakdowntype_id = b_maintenance_t.break_type_id
  )as bd_type,
  b_maintenance_t.id as id,
  TIMEDIFF(
  TIME(end_date),
  TIME(start_date)
  ) as time_diff
  FROM
  `b_maintenance_t` where 1=1 $wh1)as aa GROUP BY aa.bd_type
  ORDER BY time_diff DESC
  LIMIT 5)v1 where 1=1");
$return_data['data']=$data;

return view('reportnew.topbreaksearch',$return_data);

}


public function historycardindex()
{
  $loc=\Session::get('location');
 $this->data['machine_id']=$this->jcombolocation('machine_hdr_t','machine_id','machine_name','','and location_id=$loc');
 return view('reportnew.history',$this->data);
 
}
public function historycardsearch($sd=null,$ed=null,$machine_id=null)
{

    $loc=\Session::get('location');

        $wh='';

      


  $wh1='';
  if($sd!=0){
   
    $start_date=date('Y-m-d',strtotime($sd));
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$start_date."'"; 
    $return_data['start_date']=date('d/m/Y',strtotime($sd));
  }else{
   $return_data['start_date']='';
 }
 if($ed!=0){
  $end_date=date('Y-m-d',strtotime($ed));
  $wh1.=" and date(b_maintenance_t.issue_date)<='".$end_date."'"; 
  $return_data['end_date']=date('d/m/Y',strtotime($ed));
}else{
 $return_data['end_date']='';
}



        
if($loc != 0){
  $wh='and  machine_hdr_t.location_id='.$loc;
    $wh1.=" and b_maintenance_t.location_id = ".$loc;
}
$category_name=\DB::SELECT("SELECT machine_name FROM machine_hdr_t WHERE machine_id=$machine_id ");
$return_data['machine_name']=$category_name[0]->machine_name;
$data=DB::select("select * from(SELECT
  ticket_number,
  DATE(issue_date) as issue_date,(
  CASE WHEN shift = 1 THEN 'A' WHEN shift = 2 THEN 'B' WHEN shift = 3 THEN 'C' ELSE ''    END
  ) AS shift,
  (SELECT
  machine_hdr_t.machine_name
  FROM
  machine_hdr_t
  WHERE
  b_maintenance_t.machine_id = machine_hdr_t.machine_id
  ) as machine,
  (SELECT m_breakdowntype_t.breakdown_name FROM m_breakdowntype_t WHERE m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id)as bd_type,
  b_maintenance_t.causes as causes,corrective_action,
  TIMEDIFF(
  end_date,
  start_date
  ) as time_diff,request_remark as remarks
  
  FROM
  b_maintenance_t  JOIN machine_hdr_t ON machine_hdr_t.machine_id=b_maintenance_t.machine_id where 1=1 $wh1  AND machine_hdr_t.machine_id=$machine_id)v1 where 1=1");
$return_data['data']=$data;

return view('reportnew.hitorysearch',$return_data);

}
}
