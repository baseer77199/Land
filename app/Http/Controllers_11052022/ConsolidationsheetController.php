<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use DateTime;
class ConsolidationsheetController extends Controller {

    public function __construct() 
    {
      $this->data=array();
      $this->pageModule="Consolidationsheet";
        $this->data['pageModule']=$this->pageModule;
    $this->data['pageMethod']=\Request::route()->getName();
    $this->data['pageFormtype']='ajax';
    $this->data['pageTitle']="Consolidationsheet";
    $this->data['pageNote']="Consolidationsheet";
    } 
  
    public function index($value='')
    {
       return view('consolidationsheet.index',$this->data);
    }
public function reportindex($id=null)
    {
          $this->data['department_id']=$_GET['department_id'];
            $this->data['year']=$_GET['year'];
          $dep=\DB::select('select concat(department_no,"-",department_name) as depname from ma_department_t where department_id='.$_GET['department_id']);
          $this->data['department_name']=$dep[0]->depname;
       return view('consolidationsheet.report',$this->data);
    }
         function getReporttab($department_id=null,$years=null,$tab=null){
              $dep=\DB::select('select concat(department_no,"-",department_name) as depname from ma_department_t where department_id='.$department_id);
          $this->data['department_name']=$dep[0]->depname;
       $this->data['department_id']=$department_id;
       $this->data['year']=$years;
       
             // $rev=\DB::select("SELECT * FROM `revision_tbl` ORDER BY `revision_id` DESC");
                   // $this->data['revision_no']=$rev[0]->revision_no;
                   // $this->data['revision_date']=date("d/m/Y",strtotime($rev[0]->revision_date));
                    $this->data['revision_no']="";
                    $this->data['revision_date']="";
            //$this->data['rowData']=$distinct_rec=\DB::select("SELECT distinct(machine_id) FROM `issue_tbl` where department_id='$department_id'");
             $this->data['rowData']=$distinct_rec=array();
            $month = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
            $avail_month = ["01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec"];
         //  $avail_hrs=["208:00:00","200:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00"];
            if($years == "0"){
			$years=date("Y");
			}
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
                 foreach ($month as $month_no=>$month_name){
                     
                $machine_details=\DB::select("SELECT * FROM `issue_tbl` where MONTH(issue_date) = '$month_no' AND YEAR(issue_date) = '$years' AND machine_id='$value->machine_id'");
                
                $no_brkdown=count($machine_details);
                $breakdown_details[$machine_id][$month_no]['no_brkdown']=count($machine_details);
                array_push($total_brkdown,$no_brkdown);
               
               
                
                $yr_brkdown[$month_no][]=count($machine_details);
                
                $available_hrs=\DB::select("SELECT * FROM avail_hrs_tbl where machine_id='$machine_id' AND year='$years'");
                $breakdown_details[$machine_id][$month_no]['availability_hrs']=$availhrs=$available_hrs[0]->$avail_month[$month_no];
                $avail_hrs[$machine_id][]=$availhrs;  
                $yr_availability_hrs[$month_no][]=$availhrs;
//                if($month_no != "02"){
//                $breakdown_details[$machine_id][$month_no]['availability_hrs']="208:00:00"; 
//                } else {
//                    $breakdown_details[$machine_id][$month_no]['availability_hrs']="200:00:00"; 
//                }
                
                foreach ($machine_details as $key1=>$value1){
                    
                    
                    
                    if($value1->issue_doneat != "0000-00-00 00:00:00"){
                //array_push($brkdown_hrs,$this->timedifference($value1->issue_datetime,$value1->issue_doneat));
                
                
                $time_diff=$this->timedifference($value1->issue_datetime,$value1->issue_doneat);
                $down_brk_hr=$value1->down_brk_hr.":00";
                $total_time=$this->mtbftime1($down_brk_hr,$time_diff);
                array_push($brkdown_hrs,$total_time);
                
             
                
                    }
                    if($value1->approved_on != "0000-00-00 00:00:00" && $value1->repaired_on != "0000-00-00 00:00:00"){
                
                    //array_push($repair_hrs,$this->timedifference($value1->approved_on,$value1->repaired_on));
                        $repair_brk_hr=$value1->repair_brk_hr.":00";
                    $time_diff1=$this->timedifference($value1->approved_on,$value1->repaired_on);
                    $total_time1=$this->mtbftime1($repair_brk_hr,$time_diff1);
                    array_push($repair_hrs,$total_time1);
                   
                        
                    }
                    }
                    if(!empty($brkdown_hrs)){
                         $tot_brkdown_hrs=$this->total_time($brkdown_hrs);
                         array_push($total_brkdown_hrs,$tot_brkdown_hrs);
//                          if($month_no != "02"){
//                         $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,"208:00:00");
//                         } else {
//                             $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,"200:00:00");
//                         }
                         $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,$availhrs);
                        // $total_mtbf_time=$this->mtbftime($tot_brkdown_hrs,"208:00:00");
                        //$mtbf_hrs=$this->dividetime($tot_brkdown_hrs,$no_brkdown);
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
          //  dd($avail_hrs);
          //  dd($total_details);
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
//                if(!empty($yr_mtbf_hrs[$no])){
//                $yr_total[$no]['mtbf_hrs']=$yr_mtbfhr=$this->total_time($yr_mtbf_hrs[$no]);
//                array_push($overall_mtbf_hrs,$yr_mtbfhr);
//                }
                if(!empty($yr_mttr_hrs[$no])){
                $yr_total[$no]['mttr_hrs']=$yr_mttrhr=$this->total_time($yr_mttr_hrs[$no]);
                array_push($overall_mttr_hrs,$yr_mttrhr);
                }if(!empty($yr_brkdown[$no])){
                $yr_total[$no]['no_brkdwn']=$yr_brkdwn=array_sum($yr_brkdown[$no]);
                array_push($overall_brkdown,$yr_brkdwn);
                } if(!empty($yr_availability_hrs[$no])){
                $yr_total[$no]['avail_hrs']=$yr_avail_hrs=$this->total_time($yr_availability_hrs[$no]);
                array_push($overall_avail_hrs,$yr_avail_hrs);
                }
                $yr_brkhr="00:00:00";
                $yr_avail_hrs="00:00:00";
                $yr_brkdwn="0";
                $yr_total[$no]['up_time']=$yr_uptime=$this->mtbftime1($yr_brkhr,$yr_avail_hrs);
                array_push($overall_up_time,$yr_uptime);
               
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
            $total_details="0";
            $this->data['total']=$total_details;
            $this->data['yr_total']=$yr_total;
		
			$this->data['years']=$years;
			$this->data['department_id']=$department_id;
                        
                        
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
               //dd($brkdown_hrss);
               $this->data['mttr']=json_encode($mttr);
               $this->data['brkdown_hrss']=json_encode($brkdown_hrss);
               $this->data['mtbf']=json_encode($mtbf);
               
              
                        if($tab=="consolidation"){
            return view('consolidationsheet.consolidated_report',$this->data);
                        } else if($tab=="maintainance"){
                            
                            $this->data['brk_hrs']=$this->dividetime($over_brk_hrs,12);
                            $main_ovr_mttr_hrs=$this->total_time($overall_mttr_hrs);
                            $this->data['mttr_hrs']=$this->dividetime($main_ovr_mttr_hrs,12);
                            $main_ovr_mtbf_hrs=$this->total_time($overall_mtbf_hrs);
                            $this->data['mtbf_hrs']=$this->dividetime($main_ovr_mtbf_hrs,12);
            return view('consolidationsheet.maintainance_report',$this->data);
                        } else if($tab=="maintainanceppt"){
                            $monthwise = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
           $monthwise1 = ["01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec"];
          
          //start Of PM Data
         $pm_no_mac = ["January"=>0,"February"=>0,"March"=>0,"April"=>0,"May"=>0,"June"=>0,"July"=>0,"August"=>0,"September"=>0,"October"=>0,"November"=>0,"December"=>0]; 
         $pm_done = ["January"=>0,"February"=>0,"March"=>0,"April"=>0,"May"=>0,"June"=>0,"July"=>0,"August"=>0,"September"=>0,"October"=>0,"November"=>0,"December"=>0]; 
         $this->data['machine_details']=$machine_details=\DB::select("SELECT distinct(machine_id),department_id,'0' as pm_year from machine_pm_detail_t where department_id='$department_id'");
                if($years=="0"){
                    $years=date("Y");
                }
               foreach($machine_details as $key1=>$value1){
                    $details=\DB::select("SELECT machine_id,frequency_id,actual_pm_date,'0' as pm_month,'0' as pm_year from machine_pm_detail_t where machine_id='$value1->machine_id'");
                    foreach($details as $key2=>$value2){
                        $frequency=$value2->frequency_id;
                        $pm_date1=$value2->actual_pm_date;
                        $pm_month=$value2->pm_month;
                        $pm_year=$value2->pm_year;
                        $machine_id=$value2->machine_id;
                         $month=3;
                        if($frequency == '4'){
                     $month=3;
                     $fre='Q';
                     }
                     elseif($frequency=='3')
                     {
                         $month=1;
                         $fre='M';
                     }
                     elseif($frequency=='5')
                     {
                         $month=6;
                         $fre='H';
                     }
                     elseif($frequency=='6')
                     {
                         $month=12;
                         $fre='A';
                     }
                     
                     $pm_date=$pm_year."-".$pm_month."-".$pm_date1;
                        
                      $date = new DateTime($pm_date);
                       $year=$date->format('Y');
                      $pm_dates=$date->format('d');
                      $pm_month=  (string)$date->format('F');
                      $current_year=$years;
                     if($year==$current_year)
                      { 
                      $pm_no_mac[$pm_month]=$pm_no_mac[$pm_month]+1;
                  
                      foreach($monthwise as $no=>$val){
                      $pm_details=\DB::select("SELECT machine_id,done_on_date,department_id,done_on_time,initiate_date from machine_pm_detail_t where machine_id='$machine_id' AND MONTH(done_on_date)='$no' AND YEAR(done_on_date)='$current_year'");
                      
                     if(count($pm_details)!= "0"){
                      $pm_done[$val]=$pm_done[$val]+1;
                      } else {
                          $pm_done[$val]=$pm_done[$val];
                      }
                      }
                      }
                      $i=0;
                      
                       while($i<1)
                       {
                          
                      $date = new DateTime($pm_date);
                     
                      $date->modify('+'.$month.' month');
                     
                       
                      $year=$date->format('Y');
                      $pm_dates=$date->format('d');
                      $pm_month=  (string)$date->format('F');
                      $current_year=$years;
                      $pm_date=(string)$date->format('Y-m-d');
                   
                      
                      if($year==$current_year)
                      {
                          $i=0;
                       $pm_no_mac[$pm_month]=$pm_no_mac[$pm_month]+1;
                      foreach($monthwise as $no=>$val){
                      $pm_details=\DB::select("SELECT machine_id,done_on_date,department_id,done_on_time,pm_initiated_date from machine_pm_detail_tbl where machine_id='$machine_id' AND MONTH(done_on_date)='$no' AND YEAR(done_on_date)='$current_year'");
                     if(count($pm_details)!= "0"){
                      $pm_done[$val]=$pm_done[$val]+1;
                      } else {
                          $pm_done[$val]=$pm_done[$val];
                      }
                      }
                      } else
                      { $i=1; }
                         
                       }
                    }
                }
                $pmrating=[];
                foreach ($monthwise as $no=>$val){
                    if($pm_no_mac[$val] != "0"){
                 $pm_dones= \DB::select("SELECT count(*) as total FROM `machine_pm_detail_t` WHERE MONTH(done_on_date)='$no' and YEAR(done_on_date)='$current_year' and department_id='$department_id'");      
                 $pm_dones=$pm_dones[0]->total;
                 $pm_done[$val]=$pm_dones;
                 $pm_rating=  number_format(($pm_dones/$pm_no_mac[$val])*100,2);
                 $pmrating[$val]=$pm_rating;
                 $pmratings[]=(float)$pm_rating;
                    } else {
                        $pmrating[$val]="0";
                         $pmratings[]=0.0;
                    }
                }
                
                //end of PM Data
                 $this->data['pm_no_mac']=$pm_no_mac;
                $this->data['pm_done']=$pm_done;
                $this->data['pm_rating']=$pmrating;
              
             //   $this->data['brakdown_count']=  json_encode($break_count);
                foreach($pm_no_mac as $val)
                {
                    $mac_count[]=(int)$val;
                }
               $this->data['mac_count']=  json_encode($mac_count);
               $this->data['pmratings']=  json_encode($pmratings);
               
             
                return view('consolidationsheet.ppt_report',$this->data);
                        } else if($tab == "mttr"){
                             return view('consolidationsheet.mttr_report',$this->data);
                        } else if($tab == "mtbf"){
                             return view('consolidationsheet.mtbf_report',$this->data);
                        } 
        }
    
     function weeks_in_month($year, $month, $start_day_of_week)
    {

    $num_of_days = date("t", mktime(0,0,0,$month,1,$year));

   
    $num_of_weeks = 0;
    for($i=1; $i<=$num_of_days; $i++)
    {
      $day_of_week = date('w', mktime(0,0,0,$month,$i,$year));
      if($day_of_week==$start_day_of_week)
        $num_of_weeks++;
    }
 
    return $num_of_weeks;
  }

  function week_no($date_string)
        {
        
        $date=explode("-",$date_string);
        if($date[1]=='01')
        {
            $week_number =(int) date('W', strtotime("$date[0]-$date[1]-$date[2]"));
            if($week_number>5)
                $week_number=1;
        }
        else 
        {
            $firstOfMonth = date("$date[0]-$date[1]-01");
            $week_number=intval(date("W", strtotime("$date[0]-$date[1]-$date[2]")) )- intval(date("W", strtotime($firstOfMonth))) + 1;
        }
          
        
        return $week_number;
        }

public function breakdownreportsearch(Request $request)
{
    $this->data['row']=[];
       $dept_id=$_GET['department_id'];
       $i_year=$_GET['year'];
                if($i_year == "0"){
                $i_year = date("Y");
                } 
                $this->data['year']=$i_year;
                $week=[];
                $month_wise = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
                for($i="1"; $i<="12"; $i++) 
                {
                    
                    
                    $noweek=$this->weeks_in_month($i_year, $i,1);
                    if($i<=9){
                        $i="0".$i;
                    }
                    $week[$i]=$noweek;
                    
                }
                
                $this->data['weeks']=$week;
                $this->data['machine_details']=$machine_details=\DB::select("SELECT b_maintenance_t.*,machine_lines_t.frequency_date from b_maintenance_t left join machine_hdr_t on (machine_hdr_t.machine_id = b_maintenance_t.machine_id) left join machine_lines_t on(machine_lines_t.machine_id=machine_hdr_t.machine_id)  where b_maintenance_t.department_id='$dept_id'");
              
                $data=[];
                $equip_name=[];
                $equip_no=[];
         
            foreach($machine_details as $key=>$value){
        $week_no=$this->week_no($value->frequency_date);
                $machine_id=$value->machine_id;
                $pm_date=$i_year."-01-01";
                
                $pm_actual_month=explode("-",$pm_date);
                $month_no1=$pm_actual_month[1];
                $data[$machine_id][$month_no1][$week_no]['date']=date("d",strtotime($pm_date));
                
                  foreach($month_wise as $no=>$no_val){
                        $result_data2 = \DB::select("select end_date from b_maintenance_t where MONTH(end_date) = '$no' and YEAR(end_date) = '$i_year' and machine_id='$machine_id'");
                        if(count($result_data2) != "0"){
                        $done_date2      =   $result_data2[0]->end_date;  
                        $done_pm_date2   =   date("d",strtotime($done_date2));
                        
                        $data[$machine_id][$no][$week_no]['done_date'] = date("d", strtotime($done_date2));
                    }
                    }
                    
                $i=0;
                while($i<1) {
                    
                        $date = new DateTime($pm_date);
                        $date->modify('+1'.' month');
                        
                        $year=$date->format('Y');
                        $pm_dates=$date->format('d');
                        $pm_month=  (string)$date->format('F');
                        $current_year=date('Y');
                        $pm_date=(string)$date->format('Y-m-d');
                        
                        $years1=(string)$date->format('Y');
                        
                        $months1=(string)$date->format('m');
                        $month_no=(int)$months1;
                        if($month_no <= "9"){
                            $month_no="0".$month_no;
                        } 
                       
                        
                        if($years1 == $i_year){
                             $i=0; 
                      $data[$machine_id][$month_no][$week_no]['date']=date("d",strtotime($pm_date));
                        } else
                            {
                                $i=1; 
                            }
                      
                }
               
            }
        
                    $this->data['data']     =   $data;
                    
                    $this->data['dept_id']  =   $dept_id;
                 
                    return view('consolidationsheet.maintainance_report',$this->data); 
}


    public function breakdownreportsearch_old(Request $request)
    {
         $this->data['row']=[];
       $dept_id=$_GET['department_id'];
       $years=$_GET['year'];
                if($years == "0"){
                $years = date("Y");
                } 
                $this->data['years']=$years;

      $breakdown_details=[];
            $brkdown_hrs=[];
            $repair_hrs=[];
            $this->data['rowData']=$distinct_rec=\DB::select("SELECT distinct(machine_id) FROM `b_maintenance_t` where department_id='$dept_id'");
                $month = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
            $avail_month = ["01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec"];
         //  $avail_hrs=["208:00:00","200:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00","208:00:00"];
            if($years == "0"){
      $years=date("Y");
      }
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
                 foreach ($month as $month_no=>$month_name){
                     
                $machine_details=\DB::select("SELECT * FROM `b_maintenance_t` where MONTH(issue_date) = '$month_no' AND YEAR(issue_date) = '$years' AND machine_id='$value->machine_id'");
                
                $no_brkdown=count($machine_details);
                $breakdown_details[$machine_id][$month_no]['no_brkdown']=count($machine_details);
                array_push($total_brkdown,$no_brkdown);
               
                
                $yr_brkdown[$month_no]=count($machine_details);
                $month_no = '01';
               $available_hrs=\DB::select("SELECT * FROM avail_hrs_tbl where machine_id='$machine_id' AND year='$years'");
        //print_r($avail_month[$month]);
                $breakdown_details[$machine_id][$month_no]['availability_hrs']=$availhrs=$available_hrs[0]->jan;
                $month_no++;
                $avail_hrs[$machine_id][]=$availhrs;  
              /*  $yr_availability_hrs[$month_no][]=$availhrs;*/
//                if($month_no != "02"){
//                $breakdown_details[$machine_id][$month_no]['availability_hrs']="208:00:00"; 
//                } else {
//                    $breakdown_details[$machine_id][$month_no]['availability_hrs']="200:00:00"; 
//                }
                
                foreach ($machine_details as $key1=>$value1){
                    
                    
                    
                    if($value1->end_date != "0000-00-00 00:00:00"){
                //array_push($brkdown_hrs,$this->timedifference($value1->issue_datetime,$value1->issue_doneat));
                
                
                $time_diff=$this->timedifference($value1->issue_date,$value1->end_date);
                $down_brk_hr=$value1->start_date;
                $total_time=$this->mtbftime1($down_brk_hr,$time_diff);
                array_push($brkdown_hrs,$total_time);
                
             
                
                    }
                    if($value1->start_date != "0000-00-00 00:00:00" && $value1->end_date != "0000-00-00 00:00:00"){
                
                    //array_push($repair_hrs,$this->timedifference($value1->approved_on,$value1->repaired_on));
                        $repair_brk_hr=$value1->start_date.":00";
                    $time_diff1=$this->timedifference($value1->start_date,$value1->end_date);
                    $total_time1=$this->mtbftime1($issue_date,$time_diff1);
                    array_push($repair_hrs,$total_time1);
                   
                        
                    }
                    }
                    if(!empty($brkdown_hrs)){
                         $tot_brkdown_hrs=$this->total_time($brkdown_hrs);
                         array_push($total_brkdown_hrs,$tot_brkdown_hrs);
//                          if($month_no != "02"){
//                         $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,"208:00:00");
//                         } else {
//                             $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,"200:00:00");
//                         }
                         $total_mtbf_time=$this->mtbftime1($tot_brkdown_hrs,$availhrs);
                        // $total_mtbf_time=$this->mtbftime($tot_brkdown_hrs,"208:00:00");
                        //$mtbf_hrs=$this->dividetime($tot_brkdown_hrs,$no_brkdown);
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
          //  dd($avail_hrs);
          //  dd($total_details);
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
//                if(!empty($yr_mtbf_hrs[$no])){
//                $yr_total[$no]['mtbf_hrs']=$yr_mtbfhr=$this->total_time($yr_mtbf_hrs[$no]);
//                array_push($overall_mtbf_hrs,$yr_mtbfhr);
//                }
                if(!empty($yr_mttr_hrs[$no])){
                $yr_total[$no]['mttr_hrs']=$yr_mttrhr=$this->total_time($yr_mttr_hrs[$no]);
                array_push($overall_mttr_hrs,$yr_mttrhr);
                }if(!empty($yr_brkdown[$no])){
                $yr_total[$no]['no_brkdwn']=$yr_brkdwn=array_sum($yr_brkdown[$no]);
                array_push($overall_brkdown,$yr_brkdwn);
                } if(!empty($yr_availability_hrs[$no])){
                $yr_total[$no]['avail_hrs']=$yr_avail_hrs=$this->total_time($yr_availability_hrs[$no]);
                array_push($overall_avail_hrs,$yr_avail_hrs);
                }
                $yr_total[$no]['up_time']=$yr_uptime=$this->mtbftime1($yr_brkhr,$yr_avail_hrs);
                array_push($overall_up_time,$yr_uptime);
               
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
      $this->data['department_id']=$department_id;
                        
                        
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
               //dd($brkdown_hrss);
               $this->data['mttr']=json_encode($mttr);
               $this->data['brkdown_hrss']=json_encode($brkdown_hrss);
               $this->data['mtbf']=json_encode($mtbf);
    }
 function mtbftime1($time1,$time2){
          //  $time2 = '208:00:00';
          //  $time1 = '09:00:00';

                list($hours, $minutes, $seconds) = explode(':', $time2);
                $interval2 = $hours*3600 + $minutes*60 + $seconds;

                list($hours, $minutes, $seconds) = explode(':', $time2);
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

     function total_time($time){
                    //$time = array("05:00:00", "06:00:01", "10:05:00");
             //print_r($time);
                    $sum="00:00:00";
                    $sum_new = explode(':',$sum);
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
     
}
