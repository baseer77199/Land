<?php

namespace App\Http\Controllers;

use App\pmreport;
use App\machinefiles;
use Illuminate\Http\Request;
use DB;
use DateTime;

class BreakdownController extends Controller
{
  public function __construct()
    {
        $this->data=array();
        $this->model    = new machinefiles();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='machine';
        $this->table=" machine_hdr_t";   
        $this->middleware('auth');
                $this->data['urlmenu']=$this->indexs(); 

    }
    
     public function groupwiseindex()
   {
      return view('report.bdgroupwise', $this->data);       
    }     
    
    public function machinewiseindex()
   {
      return view('report.bdmachinewise', $this->data);       
    }  
    
    public function bddetailsindex()
   {
      return view('report.bddetails', $this->data);       
    }  
      public function categorywisebdindex()
   {
      $this->data['breakdowntype_id']=$this->jcombologin('m_breakdowntype_t','breakdowntype_id','breakdown_name','');
      return view('report.categorywisebd', $this->data);       
    }  
    
     public function machinegroupwiseindex()
   {
      return view('report.bdmachinegroupwise', $this->data);       
    }  
       public function topbdcategorywiseindex()
   {
      return view('report.topbdcategorywise', $this->data);       
    }  
         public function topbdmachinewiseindex()
   {
      return view('report.topbdmachinewise', $this->data);       
    }  
       public function topbdtypewiseindex()
   {
      return view('report.topbdtypewise', $this->data);       
    }  
    
     public function getgroupwisebdanalysisdata()
            {
   $wh='';
           
             if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
      $page = $_GET['pq_curpage'];
        $limit = $_GET['pq_rpp'];     
   $sidx='';
   $wh1='';

         //$breakdown_id = $_GET['breakdown_id'];
         $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
         $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
        if($start_date!=0){
               $originalDate  =   new DateTime($start_date);
              $from =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
        }
        if($end_date!=0){
              $originalDate  =   new DateTime($end_date);
              $to =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
                
        }
  
        
        
 if (!$sidx)
            $sidx = 1;
 
 $department_data=DB::select("select * from(SELECT
    main.dept,
    main.machine,
    main.br_type,
    SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.electrical))
    )as electrical,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.mechanical))
    )as mechanical,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.instrumentation))
    )as instrumentation,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.facility))
    )as facility,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.mishandling))
    )as mishandling,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.toolsetting))
    )as toolsetting,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.software))
    )as software,
    SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.electrical)+TIME_TO_SEC(main.mechanical)+TIME_TO_SEC(main.instrumentation)+TIME_TO_SEC(main.facility)+TIME_TO_SEC(main.mishandling)
           +TIME_TO_SEC(main.toolsetting)+TIME_TO_SEC(main.software))
    )as total
    
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
        b_maintenance_t.machine_id = machine_hdr_t.machine_id
) AS machine,
(
    SELECT
        m_breakdowntype_t.breakdown_name
    FROM
        m_breakdowntype_t
    WHERE
        b_maintenance_t.break_type_id = m_breakdowntype_t.breakdowntype_id
) AS br_type,
IF(
    break_type_id = 1,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS electrical,
IF(
    break_type_id = 3,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS mechanical,
IF(
    break_type_id = 4,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS instrumentation,
IF(
    break_type_id = 5,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS facility,
IF(
    break_type_id = 6,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS mishandling,
IF(
    break_type_id = 7,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS toolsetting,
IF(
    break_type_id = 8,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS software
FROM
    `b_maintenance_t` where 1=1  $wh1
) AS main
GROUP BY
    main.dept)v1 where 1=1 $wh");
 
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   }   
   
    public function getmachinewisebdanalysisdata()
            {
   $wh='';
           
             if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
      $page = $_GET['pq_curpage'];
        $limit = $_GET['pq_rpp'];     
   $sidx='';
   $wh1='';

         $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
         $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
        if($start_date!=0){
               $originalDate  =   new DateTime($start_date);
              $from =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
        }
        if($end_date!=0){
              $originalDate  =   new DateTime($end_date);
              $to =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
                
        }
  
        
        
 if (!$sidx)
            $sidx = 1;
 
 $department_data=DB::select("select * from(SELECT
    main.dept,
    main.machine,
    main.br_type,
    SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.electrical))
    )as electrical,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.mechanical))
    )as mechanical,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.instrumentation))
    )as instrumentation,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.facility))
    )as facility,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.mishandling))
    )as mishandling,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.toolsetting))
    )as toolsetting,
     SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.software))
    )as software,
    SEC_TO_TIME(
        SUM(TIME_TO_SEC(main.electrical)+TIME_TO_SEC(main.mechanical)+TIME_TO_SEC(main.instrumentation)+TIME_TO_SEC(main.facility)+TIME_TO_SEC(main.mishandling)
           +TIME_TO_SEC(main.toolsetting)+TIME_TO_SEC(main.software))
    )as total
    
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
        b_maintenance_t.machine_id = machine_hdr_t.machine_id
) AS machine,
(
    SELECT
        m_breakdowntype_t.breakdown_name
    FROM
        m_breakdowntype_t
    WHERE
        b_maintenance_t.break_type_id = m_breakdowntype_t.breakdowntype_id
) AS br_type,
IF(
    break_type_id = 1,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS electrical,
IF(
    break_type_id = 3,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS mechanical,
IF(
    break_type_id = 4,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS instrumentation,
IF(
    break_type_id = 5,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS facility,
IF(
    break_type_id = 6,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS mishandling,
IF(
    break_type_id = 7,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS toolsetting,
IF(
    break_type_id = 8,
    TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ),
    0
) AS software
FROM
    `b_maintenance_t` where 1=1  $wh1
) AS main
GROUP BY
    main.dept,
    main.machine)v1 where 1=1 $wh");
 
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   }   
   
       public function getbddetailsdata()
            {
   $wh='';
           
             if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
      $page = $_GET['pq_curpage'];
        $limit = $_GET['pq_rpp'];     
   $sidx='';
   $wh1='';

         $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
         $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
        if($start_date!=0){
               $originalDate  =   new DateTime($start_date);
              $from =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
        }
        if($end_date!=0){
              $originalDate  =   new DateTime($end_date);
              $to =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
                
        }
  
        
        
 if (!$sidx)
            $sidx = 1;
 
 $department_data=DB::select("select * from(SELECT
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
        b_maintenance_t.machine_id = machine_hdr_t.machine_id
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
        TIME(end_date),
        TIME(start_date))
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
if(closed_engineer_by!='','YES','NO') as com_status
FROM
    `b_maintenance_t` where 1=1 $wh1)v1 where 1=1 $wh");
 
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   } 
   
      public function getcategorywisebddata()
            {
   $wh='';
           
             if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
      $page = $_GET['pq_curpage'];
        $limit = $_GET['pq_rpp'];     
   $sidx='';
   $wh1='';
         $bd_type = $_GET['breakdowntype_id'];
         $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
         $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
        if($start_date!=0){
               $originalDate  =   new DateTime($start_date);
              $from =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
        }
        if($end_date!=0){
              $originalDate  =   new DateTime($end_date);
              $to =  date_format($originalDate,"Y-m-d"); 
                $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
                
        }
  
        
        
 if (!$sidx)
            $sidx = 1;
     
 $department_data=DB::select("select * from(SELECT
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
            b_maintenance_t.machine_id = machine_hdr_t.machine_id
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
        TIME(end_date),
        TIME(start_date)
    ) as time_diff,preventive_action
    
FROM
    b_maintenance_t where b_maintenance_t.break_type_id='".$bd_type."' $wh1 )v1 where 1=1 $wh");
 
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   } 
   
    public function getmachinegroupwisebddata()
            {
    $wh='';
    if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];     
    $sidx='';
    $wh1='';

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
    $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
    if($start_date!=0){
    $originalDate  =   new DateTime($start_date);
    $from =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
    }
    if($end_date!=0){
    $originalDate  =   new DateTime($end_date);
    $to =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
    }
  
    if (!$sidx)
     $sidx = 1;
     $department_data=DB::select("select * from(SELECT
    ticket_number,
    DATE(issue_date) as issue_date,
    (SELECT
            machine_hdr_t.machine_name
        FROM
            machine_hdr_t
        WHERE
            b_maintenance_t.machine_id = machine_hdr_t.machine_id
    ) as machine,
    (SELECT m_breakdowntype_t.breakdown_name FROM m_breakdowntype_t WHERE m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id)as bd_type,
    b_maintenance_t.causes as causes,preventive_action,
     TIMEDIFF(
        TIME(end_date),
        TIME(start_date)
    ) as time_diff,request_remark as remarks
    
    FROM
    b_maintenance_t where 1=1 $wh1)v1 where 1=1 $wh");
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   }   
   
    public function gettopbdcategorywisebddata()
            {
    $wh='';
    if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];     
    $sidx='';
    $wh1='';

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
    $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
    if($start_date!=0){
    $originalDate  =   new DateTime($start_date);
    $from =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
    }
    if($end_date!=0){
    $originalDate  =   new DateTime($end_date);
    $to =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
    }
  
    if (!$sidx)
     $sidx = 1;
     $department_data=DB::select("select * from(SELECT
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
        TIME(end_date),
        TIME(start_date)
    ) as time_diff
FROM
    `b_maintenance_t` where 1=1 $wh1)as aa GROUP BY aa.category
    ORDER BY time_diff DESC
    LIMIT 5)v1 where 1=1 $wh");
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   }  
   
     public function gettopbdmachinewisebddata()
            {
    $wh='';
    if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];     
    $sidx='';
    $wh1='';

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
    $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
    if($start_date!=0){
    $originalDate  =   new DateTime($start_date);
    $from =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
    }
    if($end_date!=0){
    $originalDate  =   new DateTime($end_date);
    $to =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
    }
  
    if (!$sidx)
     $sidx = 1;
     $department_data=DB::select("select * from(SELECT
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
        machine_hdr_t.machine_id = b_maintenance_t.machine_id
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
        TIME(end_date),
        TIME(start_date)
    ) as time_diff
FROM
    `b_maintenance_t` where 1=1 $wh1)as aa GROUP BY aa.machine
    ORDER BY time_diff DESC
    LIMIT 5)v1 where 1=1 $wh");
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   } 
   
    public function gettopbdtypewisebddata()
            {
    $wh='';
    if(isset($_GET['pq_filter'])){
    $data=json_decode($_GET['pq_filter']);
    $data=$data->data;
    $table=array('b_maintenance_t','machine_hdr_t');
    $wh.=$this->pqgridsearch('v1',$data);
    }
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];     
    $sidx='';
    $wh1='';

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ?   date("Y-m-d", strtotime($_GET['start_date'])) : '';
    $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ?   date("Y-m-d", strtotime($_GET['end_date'])) : '';
         
    if($start_date!=0){
    $originalDate  =   new DateTime($start_date);
    $from =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)>='".$from."'"; 
    }
    if($end_date!=0){
    $originalDate  =   new DateTime($end_date);
    $to =  date_format($originalDate,"Y-m-d"); 
    $wh1.=" and date(b_maintenance_t.issue_date)<='".$to."'"; 
    }
  
    if (!$sidx)
     $sidx = 1;
     $department_data=DB::select("select * from(SELECT
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
    LIMIT 5)v1 where 1=1 $wh");
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

    if(isset($_GET['download']))
    {
         $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
           
    $result=array_slice($department_data,$start,$limit);
    $responce->rows[]='';
    $responce->data=$result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
   
   } 
}