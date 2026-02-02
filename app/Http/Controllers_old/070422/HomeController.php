<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{

    public function index()
    {
error_reporting(0);
// print_r(\Session::all());die;
$loc=\Session::get('location');
if($loc != 0){
    $machines = \DB::table('machine_hdr_t')->where('machine_hdr_t.location_id',$loc)->get();
} else {
    $machines = \DB::table('machine_hdr_t')->get();
}
$this->data['total_no_machines'] = count($machines);
        $date=new \DateTime(date('Y-01-01')); 
       //$date->modify('-1 year');
        $date_string=(string)$date->format('Y-m-d');

        for ($i = 1; $i <= 12; $i++) {
            if($i > 1){
            $date->modify('+1 month');
            }
            $date_string=(string)$date->format('Y-m-d'); 
            $months_name[] = date("M-y", strtotime( $date_string));
            $months_number[] = date("n", strtotime( $date_string));
        }
        $date=new \DateTime(date('Y-m-01'));
        $date=(string)$date->modify('-11 month')->format('Y-m-d');
        $this->data['column']=json_encode($months_name);
        
        if($loc == 0){
        $this->data['monthwise_bd']=\DB::select("SELECT month(b_maintenance_t.issue_date) as month,CONVERT(count(b_maintenance_t.id),SIGNED INTEGER) as total FROM `b_maintenance_t` where date(b_maintenance_t.issue_date) BETWEEN '$date' and CURRENT_DATE() group by month(b_maintenance_t.issue_date);");
        } else {
            $this->data['monthwise_bd']=\DB::select("SELECT month(b_maintenance_t.issue_date) as month,CONVERT(count(b_maintenance_t.id),SIGNED INTEGER) as total FROM `b_maintenance_t` where date(b_maintenance_t.issue_date) BETWEEN '$date' and CURRENT_DATE() and (b_maintenance_t.location_id=$loc) group by month(b_maintenance_t.issue_date);");
        }
        $monthwise_bd=collect($this->data['monthwise_bd']);
        $monthwise_bd_data=array();
        foreach($months_number as $val)
        {
            $inv_data=$monthwise_bd->where('month',$val);
            $inv_data->all();
            if(count($inv_data)>0){
                foreach($inv_data as $v){
                    $monthwise_bd_data[]=floatval($v->total);
                    break;
                }
            }else{
                $monthwise_bd_data[]=0; 
            }
        }
        
        $this->data['monthwise_bd_data']=json_encode($monthwise_bd_data);

        
			$years=date("Y");
                
		
            if($loc != 0){
                $this->data['rowData']=$distinct_rec=\DB::select("SELECT distinct(machine_id) FROM `b_maintenance_t` where location_id=$loc");
            } else {
                $this->data['rowData']=$distinct_rec=\DB::select("SELECT distinct(machine_id) FROM `b_maintenance_t`");
            }
            $month = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
            $avail_month = ["01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec"];
            $breakdown_details=[];
            $brkdown_hrs=[];
            $repair_hrs=[];
            
            $total_brkdown_hrs=[];
            $total_repair_hrs=[];
            $total_mttr_hrs=[];
            $total_mtbf_hrs=[];
            $total_brkdown=[];
            
            $yr_brkdown_hrs=["01"=>"","02"=>"","03"=>"","04"=>"","05"=>"","06"=>"","07"=>"","08"=>"","09"=>"","10"=>"","11"=>"","12"=>""];
            $yr_repair_hrs=["01"=>"","02"=>"","03"=>"","04"=>"","05"=>"","06"=>"","07"=>"","08"=>"","09"=>"","10"=>"","11"=>"","12"=>""];
            $yr_mttr_hrs=["01"=>"","02"=>"","03"=>"","04"=>"","05"=>"","06"=>"","07"=>"","08"=>"","09"=>"","10"=>"","11"=>"","12"=>""];
            $yr_mtbf_hrs=["01"=>"","02"=>"","03"=>"","04"=>"","05"=>"","06"=>"","07"=>"","08"=>"","09"=>"","10"=>"","11"=>"","12"=>""];
            $yr_brkdown=["01"=>"","02"=>"","03"=>"","04"=>"","05"=>"","06"=>"","07"=>"","08"=>"","09"=>"","10"=>"","11"=>"","12"=>""];
            $yr_availability_hrs=["01"=>"","02"=>"","03"=>"","04"=>"","05"=>"","06"=>"","07"=>"","08"=>"","09"=>"","10"=>"","11"=>"","12"=>""];
            
            
            $avail_hrs=[];
            $availability_hrs=[];
            foreach ($distinct_rec as $key=>$value){
                
                $machine_id=$value->machine_id;
                $incr =0;
                 foreach ($month as $month_no=>$month_name){
                 if($loc != 0){  
                $machine_details=\DB::select("SELECT *,
                                                if(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, issue_date, end_date)) is null,'00:00:00',SEC_TO_TIME(TIMESTAMPDIFF(SECOND, issue_date, end_date)))  as breakdown_hours,
                                                if(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, start_date, end_date)) is null,'00:00:00',SEC_TO_TIME(TIMESTAMPDIFF(SECOND, start_date, end_date))) as repair_hours 
                                                FROM `b_maintenance_t` 
                                                where MONTH(issue_date) = '$month_no' AND YEAR(issue_date) = '$years' 
                                                AND machine_id='$value->machine_id' and location_id=$loc");
                 } else {
                    $machine_details=\DB::select("SELECT *,
                    if(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, issue_date, end_date)) is null,'00:00:00',SEC_TO_TIME(TIMESTAMPDIFF(SECOND, issue_date, end_date)))  as breakdown_hours,
                    if(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, start_date, end_date)) is null,'00:00:00',SEC_TO_TIME(TIMESTAMPDIFF(SECOND, start_date, end_date))) as repair_hours 
                    FROM `b_maintenance_t` 
                    where MONTH(issue_date) = '$month_no' AND YEAR(issue_date) = '$years' 
                    AND machine_id='$value->machine_id'");
                 }                   
              //  echo "SELECT * FROM `issue_tbl` where MONTH(issue_date) = '$month_no' AND YEAR(issue_date) = '$years' AND machine_id='$value->machine_id'"."<br>";
                
              $no_brkdown=count($machine_details);
                $breakdown_details[$machine_id][$month_no]['no_brkdown']=count($machine_details);
                array_push($total_brkdown,$no_brkdown);
                $yr_brkdown[$month_no] = array();
                $avail_hrs[$machine_id] = array();
                $yr_availability_hrs[$month_no] = array();
                $yr_brkdown_hrs[$month_no] = array();
                $yr_mtbf_hrs[$month_no] = array();
                $yr_repair_hrs[$month_no] = array();
                $yr_mttr_hrs[$month_no] = array();
                
                $yr_brkdown[$month_no][]=count($machine_details);
                
             //   $available_hrs=\DB::select("SELECT * FROM avail_hrs_tbl where machine_id='$machine_id' AND year='$years'"); //change 2017 to $years
                $available_hrs=$this->availablehrs($years,$month_no);
               
                $breakdown_details[$machine_id][$month_no]['availability_hrs']=$availhrs=$available_hrs;
             //   $breakdown_details[$machine_id][$month_no]['availability_hrs']=$availhrs=$available_hrs[0]->$avail_month[$month_no];
                $avail_hrs[$machine_id][]=$availhrs;  
                $yr_availability_hrs[$month_no][]=$availhrs;

                  
                foreach ($machine_details as $key1=>$value1){
                    
              if($value1->breakdown_hours != "" && $value1->breakdown_hours!=null){
         
                $total_time=$value1->breakdown_hours;
                array_push($brkdown_hrs,$total_time);
                
                    }
                    if($value1->repair_hours != ""  && $value1->repair_hours!=null){
            
                    $total_time1=$value1->repair_hours;
                    array_push($repair_hrs,$total_time1);
                   
                    }
                    }
                  
                    if(!empty($brkdown_hrs)){
                        
                         $tot_brkdown_hrs=$this->total_time($brkdown_hrs);
                         array_push($total_brkdown_hrs,$tot_brkdown_hrs);
                         
                         $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,$availhrs);
                         
                         
                         $mtbf_hrs=$this->dividetime($total_mtbf_time,$no_brkdown);
                         array_push($total_mtbf_hrs,$mtbf_hrs);
                         
                        $yr_brkdown_hrs[$month_no][]=$tot_brkdown_hrs;
                       
                        $yr_mtbf_hrs[$month_no][]=$mtbf_hrs;
                       
                        
                        $breakdown_details[$machine_id][$month_no]['brkdown_hrs']=$tot_brkdown_hrs;
                        $breakdown_details[$machine_id][$month_no]['mtbf']=$mtbf_hrs; 
                           } else {
                       $breakdown_details[$machine_id][$month_no]['brkdown_hrs']="";  
                        $breakdown_details[$machine_id][$month_no]['mtbf']=""; 
                    } 
                    if(!empty($repair_hrs)){
                        $tot_rep_hrs=$this->total_time($repair_hrs);
                       //$tot_rep_hrs=$this->total_time('01:00:00');
                        array_push($total_repair_hrs,$tot_rep_hrs);
                        $rep_hrs=$this->dividetime($tot_rep_hrs,$no_brkdown);
                        array_push($total_mttr_hrs,$rep_hrs);
                        
                        $yr_repair_hrs[$month_no][]=$tot_rep_hrs;
                        $yr_mttr_hrs[$month_no][]=$rep_hrs;
                       
                        
                        $breakdown_details[$machine_id][$month_no]['repair_hrs']=$tot_rep_hrs;        
                        $breakdown_details[$machine_id][$month_no]['mttr']=$rep_hrs;
                            } else {
                        $breakdown_details[$machine_id][$month_no]['repair_hrs']="";    
                        $breakdown_details[$machine_id][$month_no]['mttr']="";
                            }
                   
                   
                $brkdown_hrs=[];
                $repair_hrs=[];
                $incr++;
                    }
                    
                    
                    if(!empty($total_repair_hrs)){
                        $total_details[$machine_id]['total_repair_hours']=$this->total_time($total_repair_hrs);
                    } else {
                        $total_details[$machine_id]['total_repair_hours']="";
                    } if(!empty($total_brkdown_hrs)){
                        $total_details[$machine_id]['total_brkdwn_hours']=$this->total_time($total_brkdown_hrs);
                    } else {
                        $total_details[$machine_id]['total_brkdwn_hours']="";
                    } if(!empty($total_mttr_hrs)){
                        $total_details[$machine_id]['total_mttr_hours']=$this->total_time($total_mttr_hrs);
                    } else {
                        $total_details[$machine_id]['total_mttr_hours']="";
                    } if(!empty($total_mtbf_hrs)){
                        $total_details[$machine_id]['total_mtbf_hours']=$this->total_time($total_mtbf_hrs);
                    } else {
                        $total_details[$machine_id]['total_mtbf_hours']="";
                    }
                    $total_details[$machine_id]['total_brkdwn']=array_sum($total_brkdown);
                    $total_details[$machine_id]['total_avail_hours']=$this->total_time($avail_hrs[$machine_id]);
                    
                    
                    
                    $total_repair_hrs=[];
                    $total_brkdown_hrs=[];
                    $total_brkdown=[];
                    $total_mttr_hrs=[];
                    $total_mtbf_hrs=[];
            }
 
            $overall_brkdown=[];
            $overall_brk_hrs=[];
            $overall_rep_hrs=[];
            $overall_mttr_hrs=[];
            $overall_mtbf_hrs=[];
            $overall_up_time=[];
            $overall_avail_hrs=[];
            foreach($month as $no=>$name){
             
                if(!empty($yr_brkdown_hrs[$no])){
                   
                   
                $yr_total[$no]['brk_hrs']=$yr_brkhr=$this->total_time($yr_brkdown_hrs[$no]);
                array_push($overall_brk_hrs,$yr_brkhr);
                }if(!empty($yr_repair_hrs[$no])){
                $yr_total[$no]['rep_hrs']=$yr_rephr=$this->total_time($yr_repair_hrs[$no]);
                array_push($overall_rep_hrs,$yr_rephr);
                } 

                if(!empty($yr_mttr_hrs[$no])){
                $yr_total[$no]['mttr_hrs']=$yr_mttrhr=$this->total_time($yr_mttr_hrs[$no]);
                array_push($overall_mttr_hrs,$yr_mttrhr);
                }if(!empty($yr_brkdown[$no])){
                $yr_total[$no]['no_brkdwn']=$yr_brkdwn=array_sum($yr_brkdown[$no]);
                array_push($overall_brkdown,$yr_brkdwn);
                } 
                if(!empty($yr_availability_hrs[$no])){
                $yr_total[$no]['avail_hrs']=$yr_avail_hrs=$this->total_time($yr_availability_hrs[$no]);
                array_push($overall_avail_hrs,$yr_avail_hrs);
                }
               if(!empty($yr_brkdown_hrs[$no])){
                $yr_total[$no]['up_time']=$yr_uptime=$this->mtbftime1($yr_brkhr,$yr_avail_hrs);
                array_push($overall_up_time,$yr_uptime);
                }
                if($yr_brkdwn != "0"){
                $yr_total[$no]['mtbf_hrs']=$yr_mtbfhr=$this->dividetime($yr_uptime,$yr_brkdwn);
                array_push($overall_mtbf_hrs,$yr_mtbfhr);
                } else {
                    $yr_total[$no]['mtbf_hrs']=$yr_mtbfhr="00:00:00";
                array_push($overall_mtbf_hrs,$yr_mtbfhr);
                }
            }
            $this->data['overall_brkhrs']=$over_brk_hrs=$this->total_time($overall_brk_hrs);
           $this->data['overall_rephrs']=$over_rep_hrs=$this->total_time($overall_rep_hrs);
           
           
           
           $this->data['overall_brkdwn']=$over_brkdwn=array_sum($overall_brkdown);
           $this->data['overall_available_hrs']=$over_avai_hrs=$this->total_time($overall_avail_hrs);
          
           $this->data['overall_uptime']=$over_up_time=$this->mtbftime1($over_brk_hrs,$over_avai_hrs);
           $this->data['overall_mtbfhrs']=$this->dividetime($over_up_time,$over_brkdwn);
           $this->data['overall_mttrhrs']=$this->dividetime($over_rep_hrs,$over_brkdwn);
           
           $this->data['yr_avail_hrs']=$overall_avail_hrs;
        //  dd($yr_total);
            $this->data['breakdown_details']=$breakdown_details;
            $this->data['total']=$total_details;
            $this->data['yr_total']=$yr_total;
		
			$this->data['years']=$years;
			
                        
                        
                          $brkdown_hrss=[];
               $mttr=[];
               $mtbf=[];
               foreach ($month as $n=>$val){
                   
                if(isset($yr_total[$n]['brk_hrs'])){
                array_push($brkdown_hrss,$this->decimaltime($yr_total[$n]['brk_hrs']));
                } else {
                    array_push($brkdown_hrss,0.0);
                }
                if(isset($yr_total[$n]['mttr_hrs'])){
                  
                array_push($mttr,$this->decimaltime($yr_total[$n]['mttr_hrs']));
                } else {
                    array_push($mttr,0.0);
                }
                if(isset($yr_total[$n]['mttr_hrs'])){
                array_push($mtbf,$this->decimaltime($yr_total[$n]['mtbf_hrs']));
                } else {
                    array_push($mtbf,0.0);
                }
            }
          // die;
            $this->data['mttr']=json_encode($mttr);
            $this->data['brkdown_hrss']=json_encode($brkdown_hrss);
            $this->data['mtbf']=json_encode($mtbf);
            
             //  print_r($this->data);die;  

 
          
        
        if($loc == 0){
        $total_breakdown = \DB::table('b_maintenance_t')->select('b_maintenance_t.machine_id')->get();
        $open_breakdown = \DB::table('b_maintenance_t')->select('b_maintenance_t.machine_id')->where('b_maintenance_t.request_status','OPEN')->get();
        $closed_breakdown = \DB::table('b_maintenance_t')->select('b_maintenance_t.machine_id')->where('b_maintenance_t.request_status','CLOSED')->get();
        $data = \DB::table('b_maintenance_t')
        ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
        ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
        ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
        ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
        ->leftjoin('tb_users as e_name','e_name.id','=','b_maintenance_t.engineer')
        ->leftjoin('tb_users as t_name','t_name.id','=','b_maintenance_t.technician')
            ->select('b_maintenance_t.issue_date','b_maintenance_t.ticket_number','b_maintenance_t.maintenance_type','b_maintenance_t.causes','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','b_maintenance_t.active','t_name.first_name as tech_name','e_name.first_name as eng_name','b_maintenance_t.request_status')
            ->where('b_maintenance_t.request_status','OPEN')
            ->get();

    } else {
            $total_breakdown = \DB::table('b_maintenance_t')->select('b_maintenance_t.machine_id')->where('b_maintenance_t.location_id',$loc)->get();
        $open_breakdown = \DB::table('b_maintenance_t')->select('b_maintenance_t.machine_id')->where('b_maintenance_t.request_status','OPEN')->where('b_maintenance_t.location_id',$loc)->get();
        $closed_breakdown = \DB::table('b_maintenance_t')->select('b_maintenance_t.machine_id')->where('b_maintenance_t.request_status','CLOSED')->where('b_maintenance_t.location_id',$loc)->get();
        $data = \DB::table('b_maintenance_t')
        ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
        ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
        ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
        ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
        ->leftjoin('tb_users as e_name','e_name.id','=','b_maintenance_t.engineer')
        ->leftjoin('tb_users as t_name','t_name.id','=','b_maintenance_t.technician')
            ->select('b_maintenance_t.issue_date','b_maintenance_t.ticket_number','b_maintenance_t.maintenance_type','b_maintenance_t.causes','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','b_maintenance_t.active','t_name.first_name as tech_name','e_name.first_name as eng_name','b_maintenance_t.request_status')
            ->where('machine_hdr_t.location_id',$loc)->where('b_maintenance_t.request_status','OPEN')
            ->get();

    }
        $this->data['total_breakdown'] = count($total_breakdown);
        $this->data['open_breakdown'] = count($open_breakdown);
        $this->data['closed_breakdown'] = count($closed_breakdown);
         $chartdata = \DB::table('b_maintenance_t')
        ->leftjoin('machine_hdr_t','b_maintenance_t.machine_id','=','machine_hdr_t.machine_id')
        ->leftjoin('machine_group_t','machine_group_t.group_id','=','machine_hdr_t.group_id')
        ->select(DB::raw('count(b_maintenance_t.id) as idd'),'machine_group_t.group_name')
        ->groupby('machine_group_t.group_name')
        ->get();
         
      
  $break=[];
  $value2 = array();
        foreach($chartdata as $key=>$valu){
            
              array_push($break,$valu->idd);
               $value2[$key] = $valu->group_name;
         
        }
        /*breack down dashboard*/
        
         $loc=\Session::get('location');

        $wh2='';

    $wh2='and  machine_hdr_t.location_id='.$loc;      
 
$data1=DB::select("select * from(SELECT
  aa.machine,
  count(aa.machine_id) as count,
  aa.sdate,
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
  ) as time_diff,EXTRACT(MONTH FROM end_date) as sdate,
  b_maintenance_t.machine_id
  FROM
  `b_maintenance_t` where 1=1 )as aa GROUP BY aa.machine
  ORDER BY time_diff DESC
  LIMIT 5)v1 where 1=1 and v1.machine!='' ");
$return_data['data']=$data;

        //print_r($data1);exit();
        
        /*breakdown dashboard end*/
 
        $enchatid = json_encode($break);
        $enchatname = json_encode($value2);
        $this->data['row']= $data;
        // return view('home',$this->data)->with(compact('enchatid','enchatname'));
        
        return view('home_with_dashboard',$this->data)->with(compact('enchatid','enchatname'));
    }


public function jsondatadash(Request $request)
{
     $loc=\Session::get('location');
     $id = \Session::get('id');
     if($loc != 0){
        $sql= \DB::SELECT("SELECT machine_hdr_t.machine_name as title,machine_pm_detail_t.actual_pm_date as start from machine_pm_detail_t 
        left join machine_hdr_t on machine_hdr_t.machine_id=machine_pm_detail_t.machine_id where machine_pm_detail_t.user_clearance_by like '%".$id."%' 
        and machine_pm_detail_t.status=0 and machine_pm_detail_t.location_id=$loc");
//  $sql=\db::table('machine_pm_detail_t')
// ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','machine_pm_detail_t.machine_id')
//  ->select('machine_hdr_t.machine_name as title','machine_pm_detail_t.actual_pm_date as start')->where('status',0)->where('user_clearance_by','like',"'%".'"'.$id.'"'."%'")->where('machine_hdr_t.location_id',$loc)->get();
     } else {
         
//  $sql=\db::table('machine_pm_detail_t')
//  ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','machine_pm_detail_t.machine_id')
//   ->select('machine_hdr_t.machine_name as title','machine_pm_detail_t.actual_pm_date as start')->where('user_clearance_by','like',"'%".'"'.$id.'"'."%'")->where('status','=',0)->get();
     $sql= \DB::SELECT("SELECT machine_hdr_t.machine_name as title,machine_pm_detail_t.actual_pm_date as start from machine_pm_detail_t 
      left join machine_hdr_t on machine_hdr_t.machine_id=machine_pm_detail_t.machine_id where user_clearance_by like '%".$id."%' and status=0");
     }
    return json_encode($sql);

   
}

public function calendarjsondatadash1(){
         $loc=\Session::get('location');
         $id = \Session::get('id');
if($loc != 0){
    $data = \DB::table('b_maintenance_t')
        ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
        ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
        ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
        ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
        ->leftjoin('tb_users as e_name','e_name.id','=','b_maintenance_t.engineer')
        ->leftjoin('tb_users as t_name','t_name.id','=','b_maintenance_t.technician')
            ->select('machine_hdr_t.machine_name as title','b_maintenance_t.issue_date as start')->where('machine_hdr_t.location_id',$loc)->where('b_maintenance_t.request_status','OPEN')
            ->get();
} else {
    $data = \DB::table('b_maintenance_t')
    ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
    ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
    ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
    ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
    ->leftjoin('tb_users as e_name','e_name.id','=','b_maintenance_t.engineer')
    ->leftjoin('tb_users as t_name','t_name.id','=','b_maintenance_t.technician')
        ->select('machine_hdr_t.machine_name as title','b_maintenance_t.issue_date as start')->where('b_maintenance_t.request_status','OPEN')
        ->get();
} 
   return json_encode($data);
}

     public function categoryval(){
        $loc=\Session::get('location');
if($loc != 0){
        $category=\DB::select("select m_breakdowntype_t.breakdown_name as name,CONVERT(count(b_maintenance_t.id),SIGNED INTEGER) as y from b_maintenance_t left join m_breakdowntype_t on m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id where 1=1 and b_maintenance_t.location_id=$loc group by m_breakdowntype_t.breakdown_name");
} else {
    $category=\DB::select("select m_breakdowntype_t.breakdown_name as name,CONVERT(count(b_maintenance_t.id),SIGNED INTEGER) as y from b_maintenance_t left join m_breakdowntype_t on m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id where 1=1 group by m_breakdowntype_t.breakdown_name");
}
        // print_r($category);exit;
         $category = $category;
         return $category;
     }
     
    public function monthwisebreakdown(){
        if(isset($_GET['year'])){
            $year = $_GET['year'];
        }else{
            $year = date('Y');
        }

$column="";
       $year1 = $year;
       for($i=1;$i<=12;$i++){
           $month = $i ;
           $labelrr[] = date("F", mktime(0, 0, 0, $month, 10)).'-'.$year1;
           $column.=",count(case when (month(b_maintenance_t.issue_date)=$month and year(b_maintenance_t.issue_date)='$year1') THEN 1 END) as plan_month$month";
           if($month==12){$year1=$year1+1;}
        }
                     
         $sql="SELECT count(b_maintenance_t.id) as count $column
                     FROM `b_maintenance_t` 
                     
                     ";

 $emp=\DB::SELECT($sql);

 foreach($emp as $key=>$value){
    for($i=1;$i<=12;$i++){
			          
         $m = 'plan_month'.($i);
        //  $m1 = 'actual_month'.($i+3);
         
        //  $plan_tot = $plan_tot+$value->$m;
        //  $actual_tot = $actual_tot+$value->$m1;
         
         $planrr[] = $value->$m;
        //  $actualrr[] = $value->$m1;
     }
     
 }

 $cdata=array();
 $cdata['label']=json_encode($labelrr);
 $cdata['plan']=json_encode($planrr);
 $cdata['actual']=json_encode(['','','','','','','','','','','','']);

 return $cdata;

 //MTTR
               
        // $category=\DB::select("select v1.name, sum(if(v1.month=1,v1.y,0)) as m1,sum(if(v1.month=2,v1.y,0)) as m2,sum(if(v1.month=3,v1.y,0)) as m3,sum(if(v1.month=4,v1.y,0)) as m4,sum(if(v1.month=5,v1.y,0)) as m5,sum(if(v1.month=6,v1.y,0)) as m6,sum(if(v1.month=7,v1.y,0)) as m7,sum(if(v1.month=8,v1.y,0)) as m8,sum(if(v1.month=9,v1.y,0)) as m9,sum(if(v1.month=10,v1.y,0)) as m10,sum(if(v1.month=11,v1.y,0)) as m11,sum(if(v1.month=12,v1.y,0)) as m12 from 
        // (select m_breakdowntype_t.breakdown_name as name,month(b_maintenance_t.issue_date)as month,CONVERT(count(b_maintenance_t.id),SIGNED INTEGER) as y 
        // from b_maintenance_t left join m_breakdowntype_t on m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id where 1=1 and year(b_maintenance_t.issue_date)='".$year."' group by m_breakdowntype_t.breakdown_name,month(b_maintenance_t.issue_date)) as v1 group by v1.name");
        
        // $month_data = $category; 
        // foreach($category as $ck=>$cv){
        //     for($i=1;$i<=12;$i++){
        //         $month_data[$i]->{$i} = $cv->{'m'.$i};
        //         $month_data[$i]->name = $cv->name;
        //     }
        // }
       //print_r($month_data);exit;
        // $category = $month_data;
        // return $category;
    }
     public function getData()
    {
$headerdata = \DB::table('b_maintenance_t')
 ->leftjoin('m_breakdowntype_t ', 'm_breakdowntype_t.breakdowntype_id', '=', 'b_maintenance_t.break_type_id')
->leftjoin('ma_department_t ', 'ma_department_t.department_id', '=', 'b_maintenance_t.department_id')
       ->select('b_maintenance_t.*', 'ma_department_t.department_name','m_breakdowntype_t.breakdown_name')
          ->where('qh.quote_hdr_id',$id)
            ->get();
$this->data['linesdata']=$headerdata;
foreach($headerdata as $key=>$value)
            {
            $this->data['linedata'][$key]->machine_id = $value->machine_id;
            }
   return view('home',$this->data);
    }   
    

    function availablehrs($y,$mon){ 
  
        if($mon<='09'){
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
      function total_time($time){
        //$time = array("05:00:00", "06:00:01", "10:05:00");
 //print_r($time);
        $sum="00:00:00";
        $sum_new = explode(':',$sum);
        foreach ($time as $t)
        {
            //echo $t;
            $time_new = explode(':',$t);
            
            $hrs=$sum_new[0]+$time_new[0];
            $min=$sum_new[1]+$time_new[1];
            $sec=$sum_new[2]+$time_new[2];
            //print_r($time_new);
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

    function dividetime($time,$no_brkdown){
        $time_array = explode(':', $time);
        $hours = (int)$time_array[0];
        $minutes = (int)$time_array[1];
        $seconds = (int)$time_array[2];
        
        $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
        if($no_brkdown != 0){
        $average = floor($total_seconds / $no_brkdown);
           
        $init = $average;
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;
        
        $hrs=$this->digit($hours);
        $min=$this->digit($minutes);
        $sec=$this->digit($seconds);
        
        $time_div="$hrs:$min:$sec";
        } else {
           $time_div="00:00:00" ;
        }
        return $time_div;
        
    }
    function mtbftime($time1,$time2){
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
        return $mtbf_time;
    }
    
    function digit($digit){
        if($digit <= 9){
          $result="0".$digit;
          } else {
          $result=$digit;
          }
        return $result;
}
function timedifference($date1,$date2){
                
                $init = strtotime($date2) - strtotime($date1);
               
                $hours = floor($init / 3600);
                $minutes = floor(($init / 60) % 60);
                $seconds = $init % 60;
                
                $hrs=$this->digit($hours);
                $min=$this->digit($minutes);
                $sec=$this->digit($seconds);
                
                
                $time_diff="$hrs:$min:$sec";
                return $time_diff;
}
function mtbftime1($time1,$time2){
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
  function decimaltime($time){
    $rep_hrss=explode(':',$time);
    
        $rep_hrss=$rep_hrss[0].'.'.$rep_hrss[1];
        $time1= floatval($rep_hrss);
        // print_r($time1);
        return $time1;
}
}
