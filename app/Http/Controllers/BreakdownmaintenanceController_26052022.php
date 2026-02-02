<?php

namespace App\Http\Controllers;

use App\Breakdownmaintenance;
use App\Breakdownmaintenancelines;
use Illuminate\Http\Request;
use DB;
class BreakdownmaintenanceController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model=new Breakdownmaintenance;
        $this->submodel=new Breakdownmaintenancelines;
    $this->data['pageMethod']=\Request::route()->getName();
    $this->data['pageModule']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data=array(
            'pageModule'=> $this->data['pageModule'],
            'pageUrl' =>  url($this->data['pageMethod']),
            'pageMethod'=>$this->data['pageMethod']
          );
        $this->table="b_maintenance_t";
        $this->subtable="b_maintenance_t_lines";

                $this->data['urlmenu']=$this->indexs(); 

        
    }
    public function index()
    {
// print_r(\Session::all());die;
                $this->data['pageMethod']=\Request::route()->getName();
          return view('Breakdownmaintenance.table',$this->data);
    }

      public function create($id=null)
    {
      // print_r(\Session::all());die;
        $pageMethod=\Request::route()->getName();
        if(isset($_POST['id']))    
          $id=$_POST['id'];  
          if(isset($_POST['btnval']))   
          $btnval=$_POST['btnval'];  
          if(isset($_POST['notif_id']))$id=$_POST['notif_id'];
          if(isset($_GET['btnval']))$btnval=$_POST['btnval'];  

     // dd($id);
      // print_r($btnval); die;
    if(!is_numeric($id) && ($btnval != "approverequest" || $btnval != "requestraise" || $btnval != "allocateengineer" || $btnval != "allocatetechnician" || $btnval != "closerequest" || $btnval !="sopupload" || $btnval!="createissue")){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    } else  {

        if($id!=0)
        {
        $sql = \DB::SELECT("select * from b_maintenance_t where id=$id");
        
        //print_r($sql);die;
        $this->data['row']= (object)array();
       //  $this->data['row']->causes=$sql[0]->causes;
      //  $this->data['lastmaintenance']= (object)array();
         $this->data['row']->department_id=$this->jCombologin('ma_department_t','department_id','department_name',$sql[0]->department_id);
        $this->data['row']->breakdown_sevearity=$this->jCombologin('breakdown_severity','breakdownseverity_id','severity_name',$sql[0]->breakdown_sevearity);
        $this->data['row']->break_type_id=$this->jCombologin('m_breakdowntype_t','breakdowntype_id','breakdown_name',$sql[0]->break_type_id);
        $this->data['row']->engineer=$this->jCombologintechnician('tb_users','id','first_name',$sql[0]->engineer,'machine_department_id');
        $this->data['row']->spares_id=$this->jCombologin('m_spares_t','spares_id','spares_name','');
        // $this->data['row']->engineer=$this->jCombologin('tb_users','id','first_name',$sql[0]->engineer);
        $this->data['row']->machine_id=$sql[0]->machine_id;
                            $mid=$sql[0]->machine_id;

       $this->data['lastmaintenance']=$sql12=\DB::select("select ticket_number,maintenance_type,corrective_action,preventive_action,issue_date FROM b_maintenance_t WHERE machine_id='$mid' and request_status='CLOSED' ORDER By id DESC LIMIT 0,5 ");
      
        $this->data['row']->maintenance_type=$sql[0]->maintenance_type;
        $this->data['row']->priority_option=$sql[0]->priority_option;
        $this->data['row']->causes=$sql[0]->causes;
        $this->data['row']->request_remark=$sql[0]->request_remark;
        $this->data['row']->approve_remarks=$sql[0]->approve_remarks;
        //dd($this->data['row']->causes);
       $this->data['row']->ticket_number=$sql[0]->ticket_number;
        $this->data['row']->active=$sql[0]->active;
        $this->data['row']->shift=$sql[0]->shift;
        $this->data['row']->issue_date=date('d-m-Y H:i',strtotime($sql[0]->issue_date));
        $this->data['row']->id=$sql[0]->id;
        $this->data['row']->others=$sql[0]->others;
        $this->data['row']->approve_remarks=$sql[0]->approve_remarks;
        $this->data['row']->is_breakdown=$sql[0]->is_breakdown;
        $this->data['row']->critical_spare=$sql[0]->critical_spare;

        if($_POST['btnval']=="approverequest"){
           /* $this->data['row']->start_date="";
        $this->data['row']->end_date="";*/
         $this->data['row']->start_date=date('d-m-Y H:i',strtotime($sql[0]->start_date));
        $this->data['row']->end_date=date('d-m-Y H:i',strtotime($sql[0]->end_date));
        }else{
        $this->data['row']->start_date=date('d-m-Y H:i',strtotime($sql[0]->start_date));
        $this->data['row']->end_date=date('d-m-Y H:i',strtotime($sql[0]->end_date));
    }
    // dd($sql[0]->start_date);
    // print_r($this->data['row']);die;
    if($sql[0]->start_date=='0000-00-00 00:00:00'){
      $this->data['row']->start_date = date('d-m-Y H:i');
    }
    if($sql[0]->end_date=='0000-00-00 00:00:00'){
      $this->data['row']->end_date = date('d-m-Y H:i');
    }
     // print_r($this->data['row']);die;
        $this->data['row']->preventive_action=$sql[0]->preventive_action;
        $this->data['row']->corrective_action=$sql[0]->corrective_action;
        // var_dump($this->data['row']);die();
        if($_POST['btnval']=='editissue'){
          $this->data['returnurl']=$pageMethod;
        }else{
          $this->data['returnurl']=$_POST['btnval'];
        }
        $this->data['pageMethod']=$_POST['btnval'];

        if($this->data['pageMethod']=='createissue'){
          $this->data['noti_type'] = "ticket_generate";
        }else if($this->data['pageMethod']=='allocatetechnician'){
          $this->data['noti_type'] = "allocate_technician";
        }else if($this->data['pageMethod']=='requestraise'){
          $this->data['noti_type'] = "closure_request";
        }else if($this->data['pageMethod']=='approverequest'){
          $this->data['noti_type'] = "approve_request";
        }else if($this->data['pageMethod']=='closerequest'){
          $this->data['noti_type'] = "closure_request";
        }else{
          $this->data['noti_type'] = "";
        }

        //  print_r($this->data['pageMethod']);die;
        // $this->data['pm']=$_POST['btnval'];
        
        $technician=json_decode($sql[0]->technician);
                if($technician !==null)
                {
                $technician=implode($technician,",");
                }
                else                    
                {
                $technician=''; 
                }
                $this->data['row']->technician=$this->technicianjcustommultiselect('tb_users','id','first_name',$technician,'');
                // print_r($this->data['row']->technician);die;
        }else{
          //dd('hh');
        $this->data['row']= (object)array();
                   $userid=(\Session::get('id'));
                   $dept=\DB::SELECT("select * from tb_users where id=$userid ");
        $this->data['row']->breakdown_sevearity=$this->jCombologin('breakdown_severity','breakdownseverity_id','severity_name','');
       $this->data['row']->department_id=$this->jCombologin('ma_department_t','department_id','department_name',$dept[0]->machine_department_id);
        $this->data['row']->break_type_id=$this->jCombologin('m_breakdowntype_t','breakdowntype_id','breakdown_name','');
        $this->data['row']->machine_id='';
        if($_POST['btnval']=='editissue'){
          $this->data['returnurl']=$pageMethod;
        }else{
          $this->data['returnurl']=$_POST['btnval'];
        }
        //print_r($this->data['pageMethod']);die;
        $this->data['row']->priority_option='';
        // $this->data['row']->machine_id=$this->jCombologin('machine_hdr_t','department_id','asset_code|machine_name',$userid);
       $this->data['row']->issue_date=date('d-m-Y H:i');
     // // $table= DB::getSchemaBuilder()->getColumnListing("b_maintenance_t");

     //  // foreach ($table as $key => $val) {
     //  //   $this->data['row']->$val;
     //  // }

     //    $this->data['row']->engineer='';
     //    $this->data['row']->spares_id='';
     //    $this->data['row']->engineer='';
     //    $this->data['row']->machine_id='';
     //    $this->data['row']->maintenance_type='';
     //    $this->data['row']->causes='';
     //   $this->data['row']->ticket_number='';
     //    $this->data['row']->active='';
     //    $this->data['row']->issue_date='';
     //    $this->data['row']->id='';
     //    $this->data['pageMethod']='';
     //    $this->data['row']->technician='';
     //    $this->data['row']->critical_spare='';
     //    $this->data['row']->others='';
     //    $this->data['row']->start_date ='';
     //     $this->data['row']->preventive_action='';
     //    $this->data['row']->end_date='';
     //    $this->data['row']->corrective_action='';
     //    $this->data['parent_id'] ='';
if($this->data['pageMethod']=='createissue'){
  $this->data['noti_type'] = "ticket_generate";
}else if($this->data['pageMethod']=='allocatetechnician'){
  $this->data['noti_type'] = "allocate_technician";
}else if($this->data['pageMethod']=='requestraise'){
  $this->data['noti_type'] = "closure_request";
}else if($this->data['pageMethod']=='approverequest'){
  $this->data['noti_type'] = "approve_request";
}else if($this->data['pageMethod']=='closerequest'){
  $this->data['noti_type'] = "closure_request";
}else{
  $this->data['noti_type'] = "";
}

        }
    }
    // print_r($this->data);die;
        return view('Breakdownmaintenance.form',$this->data);
    }

    
    public function save(Request $request)
    {
      $edit_id = $request->input('id');
      if($edit_id==""){
          $todayDate = date('d-m-Y H:i');
          // $request->input('issue_date')=date("Y-m-d h:i:sa", strtotime($request->input('issue_date')));       
          $validatedData=   $this->validate($request, [
            'causes' => ['required',
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
          'department_id' => 'required|numeric',
          'machine_id' => 'required|numeric',
          'break_type_id' => 'required|numeric',
          'issue_date'=>'required|date_format:d-m-Y H:i|before_or_equal:'.$todayDate,
          'breakdown_sevearity' => 'required|numeric',
          'maintenance_type' => ['required',
          function($attribute, $value, $fail) {
                 $regex1= "Machine"; // Anchor 
                 $regex2= "Facility"; // Anchor 
             if($regex1==$value || $regex2==$value) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                  //  return $fail($attribute.' is invalid (contains url).');
                  }else{
                     return $fail('Maintenance Type invalid Entry.');  
                  }
                  //dd($regex);
                }
          ],
          'shift' => 'required|numeric',
          
        //  'technician' => ['required',
        //   function($attribute, $value, $fail) {
        //          $regex1= "/^[0-9,]+$/"; // Anchor 
           
        //      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //           {
        //             //  dd($regex);
        //             return $fail($attribute.' Invalid Data.');
        //           }
        //         }
        //   ],
        ]);
        //dd("dsd");
                $breakdown = new Breakdownmaintenance();
                $breakdown->ticket_number = $request->input('ticket_number');
                $breakdown->department_id = $request->input('department_id');
                $breakdown->machine_id = $request->input('machine_id');
                $breakdown->break_type_id = $request->input('break_type_id');
                $breakdown->active      = $request->input('active');
                $breakdown->issue_date       = date("Y-m-d H:i:sa", strtotime($request->input('issue_date')));
                $breakdown->causes           = $request->input('causes');

               // $breakdown->ticket_number           = $request->input('');
                $breakdown->breakdown_sevearity           = $request->input('breakdown_sevearity');
                $breakdown->maintenance_type           = $request->input('maintenance_type');
                $breakdown->shift           = $request->input('shift');
                $breakdown->company_id      = \Session::get('companyid');
                $breakdown->organization_id          = \Session::get('organization');
                $breakdown->location_id          = \Session::get('location');
                $breakdown->issue_created_by          = \Session::get('id');
                $breakdown->created_by          = \Session::get('id');
                $breakdown->issue_created_on          = date("Y-m-d H:i:s");
                $breakdown->request_status          = "OPEN";
              
              $seqno = $this->Seqnoe("TICKET-".\Session::get('location')."-", 'b_maintenance_t', '','ticket_count');
                $breakdown->ticket_number = $seqno[0];
                $breakdown->ticket_count = $seqno[1];
                // dd($breakdown);
               $breakdown->save();
        // dd($breakdown);
            $edit_id= DB::getPdo()->lastInsertId();
            $action="Create";
                  $data_machine=\DB::SELECT("SELECT * from machine_hdr_t where machine_id=".$request->input('machine_id')) ;
            $this->auditlog($edit_id,"Breakdownmaintenance",$action,$_POST,"b_maintenance_t");
            $user_data=\DB::SELECT("select id from tb_users where department_id=4");
            if(count($user_data)>0){
            $id_notiy='';
            foreach($user_data as $key=>$value){
            $id_notiy.=$value->id.',';    
            }
            $id_notiy=rtrim($id_notiy, ',');
             $noti_msg = "Breakdown Ticket Generated - ". $breakdown->ticket_number;
             $noti_msg1 = "Breakdown Ticket Generated for the machine ".$data_machine[0]->machine_name." - [". $breakdown->ticket_number."] on ".date('d-m-Y H:i:s',strtotime($breakdown->issue_created_on))." by ".$this->getusername($breakdown->issue_created_by);
            //  $hist="";
             $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'ticket_generate');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $id_notiy;
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
              
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
            // print_r($mto);die;
            

            $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_generated',"engineerallocate",$mto,$mcc,\Session::get('id'),'requestraise');
            // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$notimsg1,$hist,"engineerallocate",$id_notiy,\Session::get('id'),'allocateengineer');
             }
             $notification['body']="Ticket Generated";
             $notification['title']=$breakdown->ticket_number." - ".$data_machine[0]->machine_name;
             $notification['icon']="";
             $notification['sound']="default";
             $count['body']="Ticket Generated";
             $count['title']=$_POST['ticket_number'];
             $count['count']="28";
             $count['sound']="default";
            
               $fcm_data = \DB::select("select * from tb_users where department_id=4");
             foreach ($fcm_data as $key => $val) {
             $msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
             }
            return response()->json(array('status' => 'success', 'message' => 'Breakdown Maintenance Saved Successfully','id'=>$edit_id,'no'=>$breakdown->ticket_number));
        }else if($edit_id!="" && $_POST['request_status']=='SAVE')
        {
               $todayDate = date('d-m-Y H:i');
                // $request->input('issue_date')=date("Y-m-d h:i:sa", strtotime($request->input('issue_date')));       
            $validatedData=   $this->validate($request, [
              'causes' => ['required',
                    function($attribute, $value, $fail) {
                      //  $regex .= "(.=?)"; // Anchor 
                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                        $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                      
              //  dd($regex);
                      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' is invalid (contains url).');
                      }
                      //dd($regex);
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, 'script')) {  
                          return $fail($attribute. ' contains script.');
                      }
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, '=')) {  
                          return $fail($attribute. ' Invalid Data.');
                      }
                    },
                ],
              'department_id' => 'required|numeric',
              'machine_id' => 'required|numeric',
              'break_type_id' => 'required|numeric',
              'issue_date'=>'required|date_format:d-m-Y H:i|before_or_equal:'.$todayDate,
              'breakdown_sevearity' => 'required|numeric',
              'maintenance_type' => ['required',
              function($attribute, $value, $fail) {
                    $regex1= "Machine"; // Anchor 
                    $regex2= "Facility"; // Anchor 
                if($regex1==$value || $regex2==$value) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                      //  return $fail($attribute.' is invalid (contains url).');
                      }else{
                        return $fail('Maintenance Type invalid Entry.');  
                      }
                      //dd($regex);
                    }
              ],
              'shift' => 'required|numeric',
              
            //  'technician' => ['required',
            //   function($attribute, $value, $fail) {
            //          $regex1= "/^[0-9,]+$/"; // Anchor 
              
            //      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
            //           {
            //             //  dd($regex);
            //             return $fail($attribute.' Invalid Data.');
            //           }
            //         }
            //   ],
            ]);
            //dd("dsd");
            // $ma =  $data_machine=\DB::SELECT("SELECT ") ;
                    $breakdown = new Breakdownmaintenance();
                    $data['ticket_number'] = $request->input('ticket_number');
                    $data['department_id'] = $request->input('department_id');
                    $data['machine_id'] = $request->input('machine_id');
                    $data['break_type_id'] = $request->input('break_type_id');
                    $data['active']      = $request->input('active');
                    $data['issue_date']       = date("Y-m-d H:i:sa", strtotime($request->input('issue_date')));
                    $data['causes']           = $request->input('causes');

                  // $breakdown->ticket_number           = $request->input('');
                    $data['breakdown_sevearity']           = $request->input('breakdown_sevearity');
                    $data['maintenance_type']           = $request->input('maintenance_type');
                    $data['shift']           = $request->input('shift');
                    $data['company_id']      = \Session::get('companyid');
                    $data['organization_id']          = \Session::get('organization');
                    $data['location_id']          = \Session::get('location');
                    // $data['issue_created_by']          = \Session::get('id');
                    $data['issue_updated_by']          = \Session::get('id');
                    // $data['created_by']          = \Session::get('id');
                    // $data['issue_created_on']          = date("Y-m-d H:i:s");
                    $data['issue_updated_on']          = date("Y-m-d H:i:s");
                    $data['request_status']          = "OPEN";
                  
                  // $seqno = $this->Seqnoe("TICKET", 'b_maintenance_t', '','ticket_count');
                  //   $breakdown->ticket_number = $seqno[0];
                  //   $breakdown->ticket_count = $seqno[1];
                    // print_r($breakdown);die;
                    Breakdownmaintenance::find($edit_id)->update($data);
                    // $breakdown->save();
            // dd($breakdown);
                $edit_id= DB::getPdo()->lastInsertId();
                $action="Create";
                      $data_machine=\DB::SELECT("SELECT * from machine_hdr_t where machine_id=".$request->input('machine_id')) ;
                $this->auditlog($edit_id,"Breakdownmaintenance",$action,$_POST,"b_maintenance_t");
                $user_data=\DB::SELECT("select id from tb_users where department_id=4");
                if(count($user_data)>0){
                $id_notiy='';
                foreach($user_data as $key=>$value){
                $id_notiy.=$value->id.',';    
                }
                $id_notiy=rtrim($id_notiy, ',');
                $noti_msg = "Ticket Updated - ". $breakdown->ticket_number;
             $noti_msg1 = "Breakdown Ticket Updated for the machine ".$data_machine[0]->machine_name." - [". $breakdown->ticket_number."] on ".date('d-m-Y H:i:s',strtotime($data['issue_updated_on']))." by ".$this->getusername($data['issue_updated_by']) ;
            //  $hist="Breakdown Ticket Created - ".$breakdown->ticket_number;
             $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'ticket_generate');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $id_notiy;
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
              
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
                
                $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_updated',"engineerallocate",$mto,$mcc,\Session::get('id'),'requestraise');
                // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"engineerallocate",$id_notiy,\Session::get('id'),'allocateengineer');
                }
                $notification['body']="Ticket Updated";
                $notification['title']=$breakdown->ticket_number." - ".$data_machine[0]->machine_name;
                $notification['icon']="";
                $notification['sound']="default";
                $count['body']="Ticket Updated";
                $count['title']=$_POST['ticket_number'];
                $count['count']="28";
                $count['sound']="default";
                
                  $fcm_data = \DB::select("select * from tb_users where department_id=4");
                foreach ($fcm_data as $key => $val) {
                $msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
                }
                return response()->json(array('status' => 'success', 'message' => 'Breakdown Maintenance Saved Successfully','id'=>$edit_id,'no'=>$breakdown->ticket_number));
            }else if($_POST['request_status']=="CLOSED"){
// echo 'hi';die;
      $todayDate = date('d-m-Y H:i');
        $validatedData=   $this->validate($request, [
            'request_status' => ['required',
                    function($attribute, $value, $fail) {
                       //  $regex .= "(.=?)"; // Anchor 
                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                        $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                       
               // dd($regex);
                      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' is invalid (contains url).');
                      }
                      //dd($regex);
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, 'script')) {  
                          return $fail($attribute. ' contains script.');
                      }
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, '=')) {  
                          return $fail($attribute. ' Invalid Data.');
                      }
                    },
                ],
            'department_id' => 'required|numeric',
            'machine_id' => 'required|numeric',
            'break_type_id' => 'required|numeric',
            'issue_date'=>'required|date_format:d-m-Y H:i|before_or_equal:'.$todayDate,
            'breakdown_sevearity' => 'required|numeric',
            'maintenance_type' => ['required',
              function($attribute, $value, $fail) {
                // dd($value);
                     // $regex1= "Machine"; // Anchor 
                     // $regex2= "Facility"; // Anchor 
                 if($value=='Machine' || $value=='Facility') // `i` flag for case-insensitive
                      {
                         // dd($regex);
                      //  return $fail($attribute.' is invalid (contains url).');
                      }else{
                         return $fail('Maintenance Type invalid Entry.');  
                      }
                       // dd($value);
                    }
              ],
            'is_breakdown' => [
              function($attribute, $value, $fail) {
                     if($value!='Yes' && $value!='No') // `i` flag for case-insensitive
                      {
                        return $fail($attribute.' invalid Entry.'); 
                      }
                      //dd($regex);
                    }
              ],
            'preventive_action'=>['required',
                    function($attribute, $value, $fail) {
                       //  $regex .= "(.=?)"; // Anchor 
                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                        $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                       
                // dd($regex);
                      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' is invalid (contains url).');
                      }
                      //dd($regex);
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, 'script')) {  
                          return $fail($attribute. ' contains script.');
                      }
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, '=')) {  
                          return $fail($attribute. ' Invalid Data.');
                      }
                    },],
            'others'=>[
                    function($attribute, $value, $fail) {
                      // dd($_POST['critical_spare']);
                       //  $regex .= "(.=?)"; // Anchor 
                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                        $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                       
              //  dd($regex);
                      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' is invalid (contains url).');
                      }
                      //dd($regex);
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, 'script')) {  
                          return $fail($attribute. ' contains script.');
                      }
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, '=')) {  
                          return $fail($attribute. ' Invalid Data.');
                      }
                    },],
            'corrective_action'=>['required',
                    function($attribute, $value, $fail) {
                       //  $regex .= "(.=?)"; // Anchor 
                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                        $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                       
              //  dd($regex);
                      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' is invalid (contains url).');
                      }
                      //dd($regex);
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, 'script')) {  
                          return $fail($attribute. ' contains script.');
                      }
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, '=')) {  
                          return $fail($attribute. ' Invalid Data.');
                      }
                    },],
            'critical_spare' =>[
              function($attribute, $value, $fail) {
                     // echo $value;die;
                 if($value!='Yes' && $value!='No' && $value!='Other' && $value!=''  && $value!=null) // `i` flag for case-insensitive
                      {
                        return $fail($attribute.' invalid Entry.'); 
                        //  dd($regex);
                      //  return $fail($attribute.' is invalid (contains url).');
                      }
                      //dd($value);
                    }
              ],
            'ticket_number'=>['required',
                    function($attribute, $value, $fail) {
                       //  $regex .= "(.=?)"; // Anchor 
                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                        $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                       
              //  dd($regex);
                      if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' is invalid (contains url).');
                      }
                      //dd($regex);
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, 'script')) {  
                          return $fail($attribute. ' contains script.');
                      }
                    },function($attribute,$value,$fail){
                  
                      if (str_contains($value, '=')) {  
                          return $fail($attribute. ' Invalid Data.');
                      }
                    },
                ],
            'bulk_spares_id'=>[
                    function($attribute, $value, $fail) {
                       
                      
                      foreach($value as $val)
                      {
                         if(!is_numeric($val) && $val!=null && $val!=''){
                              return $fail($attribute.' is invalid.');
                         }
                      }
                    },
                ],
            'bulk_inventory_stock'=>[
                    function($attribute, $value, $fail) {
                       //  $regex .= "(.=?)"; // Anchor 
                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                        $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                    //   print_r($value);die;
              //  dd($regex);
                    foreach($value as $val){
                    //   echo $val;die;
                    if(preg_match("/^$regex$/i", $val)) // `i` flag for case-insensitive
                          {
                            //  dd($regex);
                            return $fail($attribute.' is invalid (contains url).');
                          }
                      }
                    //   dd($regex);
                    },function($attribute,$value,$fail){
                        foreach($value as $val){
                              if (str_contains($val, 'script')) {  
                                  return $fail($attribute. ' contains script.');
                              }
                        }
                    },function($attribute,$value,$fail){
                        foreach($value as $val){
                          if (str_contains($val, '=')) {  
                              return $fail($attribute. ' Invalid Data.');
                          }
                        }
                    },
                ],
            'technician' => [
              function($attribute, $value, $fail) {
                     $regex1= "/[0-9]+$/"; // Anchor 
               // print_r($value);
                     foreach($value as $key=>$val){
                      if(!is_numeric($val) && $val!='' && $val!=null) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' Invalid Data.');
                      }
                     }
                 
                    }
              ],
            'shift' => 'required|numeric',
        ]);
        
        
      /*   dd($_POST);*/
             $data['request_status']=$_POST['request_status'];
             $data['is_breakdown']=$_POST['is_breakdown'];
             $data['preventive_action']=$_POST['preventive_action'];
             $data['corrective_action']=$_POST['corrective_action'];
             $data['others']=$_POST['others'];
              $data['closed_engineer_by'] = \Session::get('id');
             $data['closed_engineer_on'] = date("Y-m-d H:i:s");
             $data['critical_spare'] = $_POST['critical_spare'];
            
             $lines_data = $this->validatePost($request->all(),$this->subtable,'lines');
					/*deepika purpose:subtract qty from spare qty*/
            if($_POST['critical_spare']=="Yes"){
				foreach($_POST['bulk_spares_id'] as $k=>$v){
				$spareqty=$_POST['bulk_inventory_stock'][$k]-$_POST['bulk_qty'][$k];
				DB::table('m_spares_t')->where('spares_id',$v)->update(['spare_quantity'=>$spareqty]);		
				}
			}

          /* print_r($data);
              dd($data);*/
             
					/*end*/
              Breakdownmaintenance::find($edit_id)->update($data); 
             unset($lines_data['technician']);
            $lid=$this->submodel->subgridSave($lines_data,$edit_id); 
            $this->auditlog($edit_id,"Breakdownmaintenance","closed",$_POST,"b_maintenance_t");
              $user_data=\DB::SELECT("select id from tb_users where machine_department_id=". $request->input('department_id'));
                $data_machine=\DB::SELECT("SELECT * from machine_hdr_t where machine_id=".$request->input('machine_id')) ;
            if(count($user_data)>0){
            $id_notiy='';
            foreach($user_data as $key=>$value){
            $id_notiy.=$value->id.',';    
            
            }
            $id_notiy=rtrim($id_notiy, ',');
             $noti_msg = "Closed Successfully ". $_POST['ticket_number']." - ".$data_machine[0]->machine_name." - ".\Session::get('username');
             
             $noti_msg = "Ticket Closed Successfully - ". $_POST['ticket_number'];
             $noti_msg1 = "Breakdown Ticket Closed Successfully for the machine ".$data_machine[0]->machine_name." - [". $_POST['ticket_number']."] on ".date('d-m-Y H:i:s',strtotime($data['closed_engineer_on']))." by ". $this->getusername($data['closed_engineer_by']);
            
             $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'ticket_generate');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $id_notiy;
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
              
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
            
            // $hist=$this->getTicketHistory($edit_id,'ticket_closed');
            // print_r($hist);die;
            $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_closed',"userview",$mto,$mcc,\Session::get('id'),'createissue');
            // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"userview",$id_notiy,\Session::get('id'),'createissue');
            }
          
            	 $notification['body']="Ticket Closed";
             $notification['title']=$_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $notification['icon']="";
             $notification['sound']="default";
             $count['body']="Ticket Closed";
             $count['title']=$_POST['ticket_number'];
             $count['count']="28";
             $count['sound']="default";
            
               $fcm_data = \DB::select("select * from tb_users where department_id='". $request->input('department_id')."'");
             foreach ($fcm_data as $key => $val) {
             $msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
             }
            return response()->json(array('status' => 'success', 'message' => 'Closed Successfully','id'=>$edit_id,'no'=>$_POST['ticket_number']));
            
       

        }else{
            $message='';
              $todayDate = date('Y-m-d H:i:s');
                 $validatedData=   $this->validate($request, [
                     
          
          'technician' => [
                function($attribute, $value, $fail) {
                   
                  
                  foreach($value as $val)
                  {
                     if(!is_numeric($val)){
                          return $fail($attribute.' is invalid.');
                     }
                  }
                },
            ],
          'request_status' => ['required',
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
          'priority_option' => ['required',
          function($attribute, $value, $fail) {
                 $regex1= "Medium"; // Anchor 
                 $regex2= "Low"; // Anchor 
                 $regex3="High";
                 $regex4="Critical/Emergency";
             if($regex1==$value || $regex2==$value || $regex3==$value || $regex4==$value) // `i` flag for case-insensitive
                  {
                  }else{
                     return $fail('Priority Option invalid Entry.');  
                  }
                 
                }
          ],
           'issue_date'=>'required|before_or_equal:'.$todayDate,
          'ticket_number'=> ['required',
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            'maintenance_type' => ['required',
          function($attribute, $value, $fail) {
                 $regex1= "Machine"; // Anchor 
                 $regex2= "Facility"; // Anchor 
             if($regex1==$value || $regex2==$value) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                  //  return $fail($attribute.' is invalid (contains url).');
                  }else{
                     return $fail('Maintenance Type invalid Entry.');  
                  }
                  //dd($regex);
                }
          ],
            'causes'=> ['required',
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            'approve_remarks'=>[
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            
            'is_breakdown' => [
          function($attribute, $value, $fail) {
                 $regex1= "Yes"; // Anchor 
                 $regex2= "No"; // Anchor 
             if($regex1==$value || $regex2==$value) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                  //  return $fail($attribute.' is invalid (contains url).');
                  }else{
                     return $fail($attribute.' invalid Entry.');  
                  }
                  //dd($regex);
                }
          ],
          'critical_spare' =>[
          function($attribute, $value, $fail) {
                 $regex1= "Yes"; // Anchor 
                 $regex2= "No"; // Anchor 
                 $regex3= "Other";// Anchor 
                //  echo $value;die;
             if($regex1==$value || $regex2==$value || $regex3==$value || $value==''  || $value==null) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                  //  return $fail($attribute.' is invalid (contains url).');
                  }else{
                     return $fail($attribute.' invalid Entry.');  
                  }
                  //dd($regex);
                }
          ],
          'error_code'=>[
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            'bulk_spares_id'=>[
                function($attribute, $value, $fail) {
                   
                  
                  foreach($value as $val)
                  {
                     if(!is_numeric($val) && $val!=null && $val!=''){
                          return $fail($attribute.' is invalid.');
                     }
                  }
                },
            ],
            'bulk_inventory_stock'=>[
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                //   print_r($value);die;
          //  dd($regex);
                foreach($value as $val){
                //   echo $val;die;
                if(preg_match("/^$regex$/i", $val)) // `i` flag for case-insensitive
                      {
                        //  dd($regex);
                        return $fail($attribute.' is invalid (contains url).');
                      }
                  }
                //   dd($regex);
                },function($attribute,$value,$fail){
                    foreach($value as $val){
                          if (str_contains($val, 'script')) {  
                              return $fail($attribute. ' contains script.');
                          }
                    }
                },function($attribute,$value,$fail){
                    foreach($value as $val){
                      if (str_contains($val, '=')) {  
                          return $fail($attribute. ' Invalid Data.');
                      }
                    }
                },
            ],
            'request_remark'=>[
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            
            'start_date'=>['nullable',
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            'end_date'=>['nullable',
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            'corrective_action'=>['nullable',
                function($attribute, $value, $fail) {
                   //  $regex .= "(.=?)"; // Anchor 
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                   
          //  dd($regex);
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  //dd($regex);
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
          'shift' => 'required|numeric',
        ]);
        
        // dd('hi');
            $data_machine=\DB::SELECT("SELECT * from machine_hdr_t where machine_id=".$request->input('machine_id')) ;
             $action="Edit";
             $eng_hist['engineer'] = $data['engineer']=$_POST['engineer'];
             $eng_hist['technician'] = $data['technician']=$_POST['technician'];
            if($_POST['request_status']=="INITIATED"){
              $eng_hist['breakdown_id'] = $edit_id;
              $eng_hist['created_by'] = $data['allocate_engineer_by'] = \Session::get('id');
              $eng_hist['created_at'] = $data['allocate_engineer_on'] = date("Y-m-d H:i:s");
             $data['priority_option'] = $request->input('priority_option');
                 
      $eng_hist['organization_id']=\Session::get('organization');
      $eng_hist['location_id']=\Session::get('location');
      $eng_hist['company_id']=\Session::get('companyid');
      if(isset($eng_hist['technician'])){
        $eng_hist['technician']=json_encode($_POST['technician']);
      }
      $hist_ins = \DB::table('engineer_history_tbl')->insert($eng_hist);

             $message="Allocated Successfully";
             $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'allocate_technician');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $_POST['engineer'];
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
            $noti_msg = "Ticket Allocated Successfully - ". $_POST['ticket_number'];
            $noti_msg1 = "Breakdown Ticket Allocated Successfully for the machine ".$data_machine[0]->machine_name." - [". $_POST['ticket_number']."] on ".date('d-m-Y H:i:s',strtotime($data['allocate_engineer_on']))." by ".$this->getusername($data['allocate_engineer_by']);
            
            //  $noti_msg = "Allocated Successfully ". $_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_allocated',"userview",$mto,$mcc,\Session::get('id'),'createissue');
            // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"engineerallocate",$mto,$mcc,\Session::get('id'),'requestraise');
            
              $data['allocate_technician_by'] = \Session::get('id');
             $data['allocate_technician_on'] = date("Y-m-d H:i:s");
                  $data['priority_option'] = $request->input('priority_option');
                  
                  $notification['body']="Ticket Allocated";
             $notification['title']=$_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $notification['icon']="";
             $notification['sound']="default";
             $count['body']="Ticket Allocated";
             $count['title']=$_POST['ticket_number'];
             $count['count']="28";
             $count['sound']="default";
	    	 $fcm_data=\DB::select("select * from tb_users where id='".$_POST['engineer']."'");
	    	 $msg1[]=$this->fcmMsgNotifications($fcm_data[0]->fcm_token,$notification,$count);
             
             }
             if($_POST['request_status']=="REALLOCATED"){

              $_POST['request_status'] = "INITIATED";
              $eng_hist['breakdown_id'] = $edit_id;
              $eng_hist['created_by'] = $data['allocate_engineer_by'] = \Session::get('id');
              $eng_hist['created_at'] = $data['allocate_engineer_on'] = date("Y-m-d H:i:s");
             $data['priority_option'] = $request->input('priority_option');
                 
      $eng_hist['organization_id']=\Session::get('organization');
      $eng_hist['location_id']=\Session::get('location');
      $eng_hist['company_id']=\Session::get('companyid');
      if(isset($eng_hist['technician'])){
        $eng_hist['technician']=json_encode($_POST['technician']);
      }
      $hist_ins = \DB::table('engineer_history_tbl')->insert($eng_hist);
             $message="Reallocated Successfully";
             $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'allocate_technician');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $_POST['engineer'];
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
            $noti_msg = "Ticket Reallocated Successfully - ". $_POST['ticket_number'];
            $noti_msg1 = "Breakdown Ticket Reallocated Successfully for the machine ".$data_machine[0]->machine_name." - [". $_POST['ticket_number']."] on ".date('d-m-Y H:i:s',strtotime($data['allocate_engineer_on']))." by ".$this->getusername($data['allocate_engineer_by']);
            
            //  $noti_msg = "Allocated Successfully ". $_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_allocated',"userview",$mto,$mcc,\Session::get('id'),'createissue');
            // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"engineerallocate",$mto,$mcc,\Session::get('id'),'requestraise');
            
              $data['allocate_technician_by'] = \Session::get('id');
             $data['allocate_technician_on'] = date("Y-m-d H:i:s");
                  $data['priority_option'] = $request->input('priority_option');
                  
                  $notification['body']="Ticket Reallocated";
             $notification['title']=$_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $notification['icon']="";
             $notification['sound']="default";
             $count['body']="Ticket Reallocated";
             $count['title']=$_POST['ticket_number'];
             $count['count']="28";
             $count['sound']="default";
         $fcm_data=\DB::select("select * from tb_users where id='".$_POST['engineer']."'");
         $msg1[]=$this->fcmMsgNotifications($fcm_data[0]->fcm_token,$notification,$count);
             
             }
              if($_POST['request_status']=="REQUESTED"){
              $data['request_request_by'] = \Session::get('id');
             $data['request_request_on'] = date("Y-m-d H:i:s");
             $data['start_date']= date("Y-m-d H:i:sa", strtotime($_POST['start_date']));
             $data['end_date']= date("Y-m-d H:i:sa", strtotime($_POST['end_date']));
             $data['request_remark'] = $request->input('request_remark');
                 $message="Requested Successfully";
                  $user_data=\DB::SELECT("select id from tb_users where machine_department_id=". $request->input('department_id'));
                 // print_r($user_data);die;
            if(count($user_data)>0){
            $id_notiy='';
            foreach($user_data as $key=>$value){
              $id_notiy.=$value->id.',';    
            }
            $id_notiy=rtrim($id_notiy, ',');
            $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'closure_request');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $id_notiy;
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
            $noti_msg = "Ticket Closure Requested Successfully - ". $_POST['ticket_number'];
            $noti_msg1 = "Breakdown Ticket Closure Requested Successfully for the machine ".$data_machine[0]->machine_name." - [". $_POST['ticket_number']."] on ".date('d-m-Y H:i:s',strtotime($data['request_request_on']))." by ".$this->getusername($data['request_request_by']);
            
            //  $noti_msg = "Requested Successfully ". $_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             //print_r($noti_msg);die;
             $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_requested',"userview",$mto,$mcc,\Session::get('id'),'createissue');
            // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"engineerallocate",$mto,$mcc,\Session::get('id'),'approverequest');
            }
            
            $notification['body']="Ticket Requested";
             $notification['title']=$_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $notification['icon']="";
             $notification['sound']="default";
             $count['body']="Ticket Requested";
             $count['title']=$_POST['ticket_number'];
             $count['count']="28";
             $count['sound']="default";
            
               $fcm_data = \DB::select("select * from tb_users where department_id='". $request->input('department_id')."'");
             foreach ($fcm_data as $key => $val) {
             $msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
             }
             }
             if($_POST['request_status']=="APPROVED"){
             $data['is_breakdown']=$_POST['is_breakdown'];
              $data['request_approve_by'] = \Session::get('id');
             $data['request_approve_on'] = date("Y-m-d H:i:s");
             $data['approve_remarks'] = $request->input('approve_remarks');
              $message="Approved Successfully";
              //  $noti_msg = "Approved Successfully ". $_POST['ticket_number']." - ".\Session::get('username');
               $issue_user=\DB::SELECT("select issue_created_by from b_maintenance_t where id=$edit_id");
               
               $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'approve_request');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $issue_user[0]->issue_created_by;
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
            $noti_msg = "Ticket Closure Request Approved Successfully - ". $_POST['ticket_number'];
            $noti_msg1 = "Breakdown Ticket Closure Request Approved Successfully for the machine ".$data_machine[0]->machine_name." - [". $_POST['ticket_number']."] on ". date('d-m-Y H:i:s',strtotime($data['request_approve_on']))." by ".$this->getusername($data['request_approve_by']);
          //  $hist = '';
           
            $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_approved',"engineerallocate",$mto,$mcc,\Session::get('id'),'closerequest');
            // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"engineerallocate",$mto,$mcc,\Session::get('id'),'closerequest');
           
             $notification['body']="Approved Ticket";
             $notification['title']=$_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $notification['icon']="";
             $notification['sound']="default";
             $count['body']="Approved Ticket";
             $count['title']=$_POST['ticket_number'];
             $count['count']="28";
             $count['sound']="default";
            
               $fcm_data = \DB::select("select * from tb_users where id='". $issue_user[0]->issue_created_by."'");
             foreach ($fcm_data as $key => $val) {
             $msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
             }
             }
             if($_POST['request_status']=="REJECTED"){
             $data['request_approve_by'] = \Session::get('id');
             $data['request_approve_on'] = date("Y-m-d H:i:s");
              $message="Rejected Successfully";
              //  $noti_msg = "Rejected Successfully ". $_POST['ticket_number']." - ".$data_machine[0]->machine_name;
                 $issue_user=\DB::SELECT("select issue_created_by from b_maintenance_t where id=$edit_id");
              
              $mailto = $this->getNotySettings($data_machine[0]->location_id,$data_machine[0]->department_id,'reject_request');
             
             if($mailto['to']!=''){
               $mto = $mailto['to'];
             }else{
               $mto = $issue_user[0]->issue_created_by;
             }
             if($mailto['cc']!=''){
              $mcc = $mailto['cc'];
            }else{
              $mcc = '';
            }
            $mto = rtrim(($mto.','.$mcc),',');
            $noti_msg = "Ticket Closure Request Rejected Successfully - ". $_POST['ticket_number'];
            $noti_msg1 = "Breakdown Ticket Closure Request Rejected Successfully for the machine ".$data_machine[0]->machine_name." - [". $_POST['ticket_number']."] on ".date('d-m-Y H:i:s',strtotime($data['request_approve_on']))." by ".$this->getusername($data['request_approve_by']);
           $hist = '';

            $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_rejected',"userview",$mto,$mcc,\Session::get('id'),'createissue');
            // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"userview",$mto,$mcc,\Session::get('id'),'createissue');
            
             $notification['body']="Rejected Ticket";
             $notification['title']=$_POST['ticket_number']." - ".$data_machine[0]->machine_name;
             $notification['icon']="";
             $notification['sound']="default";
             $count['body']="Rejected Ticket";
             $count['title']=$_POST['ticket_number'];
             $count['count']="28";
             $count['sound']="default";
            
               $fcm_data = \DB::select("select * from tb_users where id='". $issue_user[0]->issue_created_by."'");
             foreach ($fcm_data as $key => $val) {
             $msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
             }
             }
             if(isset($_POST['technician']))
             {
                 
               $data['technician']=json_encode($_POST['technician']);
                 $message = "Technician Ticket";
             }

            $data['request_status']=$_POST['request_status'];
             if(isset($_POST['error_code'])){
                     $data['error_code']=$_POST['error_code'];
 if($request->hasfile('choosefile'))
                    {
                        $file = $request->file('choosefile');
                        
                            $name=$file->getClientOriginalName();

                            $file->move(public_path().'/upload/sop/', $name);  
                            $dataupload = $name;  
                        
                    
                     $attachfile_name=$dataupload;  
                     $data['error_code']=$_POST['error_code'];
                     $data['request_status']="CLOSED";
                     $message="SOP Uploaded Successfully";
                     // print_r($attachfile_name);
                     // dd($attachfile_name);
                     \DB::update("update b_maintenance_t set files='".$attachfile_name."' where id='$edit_id'");
                 }
                 }
                 //var_dump($data);
            Breakdownmaintenance::find($edit_id)->update($data); 
            /**Auditlog**/
            $this->auditlog($edit_id,"Breakdownmaintenance",$action,$_POST,"b_maintenance_t");
            return response()->json(array('status' => 'success', 'message' =>$message,'id'=>$edit_id,'no'=>$_POST['ticket_number']));
        }
    }

         public function issueData($type=null){
    
    $wh='';
        
    if($_GET['_search']=='true')
    {
    $search_table=array('ma_department_t','m_breakdowntype_t','breakdown_severity','machine_hdr_t');
    $wh=$this->jqgridsearch('b_maintenance_t',$_GET['filters'],$search_table);
    }
//print_r(\Session::all());die;
      $org=\Session::get('organization');
        $loc=\Session::get('location');
        $compy=\Session::get('companyid');
       $id= \Session::get('id');
       $department_id= \Session::get('department_id');
       $dept_id= \Session::get('machine_department_id');
       $is_tech = \Session::get('is_technician');
    //  $user_data=\DB::SELECT("SELECT * FROM tb_users where id=$id");
    //  $dept_id=$user_data[0]->machine_department_id;
    $allocate = 0;
        $wh.='and b_maintenance_t.company_id='.$compy; 
     if($_GET['status']=="createissue"){
         $wh.=" and b_maintenance_t.request_status='OPEN' and issue_created_by=$id";
     }
      if($_GET['status']=="allocateengineer"){
         $wh.=" and (b_maintenance_t.request_status='OPEN' or b_maintenance_t.request_status='INITIATED' or b_maintenance_t.request_status='REJECTED')";
     }
      if($_GET['status']=="allocatetechnician"){
        $allocate = 1;
         $wh.=" and b_maintenance_t.request_status = 'OPEN' and (b_maintenance_t.technician is null)";
    } 
    if($_GET['status']=="reallocatetechnician"){
      $allocate = 1;
      $wh.=" and (b_maintenance_t.request_status='INITIATED' or b_maintenance_t.request_status='REJECTED')";
  }
     if($_GET['status']=="requestraise"){
      $allocate = 1;
         $wh.=" and (b_maintenance_t.request_status='INITIATED' or b_maintenance_t.request_status='REJECTED') and  (engineer=$id or technician like '%".'"'.$id.'"'."%')";
     }
     if($_GET['status']=="approverequest"){
      $allocate = 1;
         $wh.=" and (b_maintenance_t.request_status='REQUESTED')";
     }
       if($_GET['status']=="closerequest"){
        $allocate = 1;
         $wh.=" and b_maintenance_t.request_status='APPROVED' and (engineer=$id or technician like '%".'"'.$id.'"'."%')";
     }
     if($_GET['status']=="sopupload"){
        $wh.=" and b_maintenance_t.request_status='CLOSED'";
     }

$wh1='';
         $loc=\Session::get('location');
         if($loc != 0){
             $wh1.=' and  machine_hdr_t.location_id='.$loc;
         } 
         if($dept_id!=0){
            if($is_tech==0 && $allocate==0){
              $wh1.=' and b_maintenance_t.department_id='.$dept_id;
            }
         }
        
 //echo($wh1.','.$wh);die;
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;
    
$result = \DB::select("SELECT COUNT(b_maintenance_t.id) AS count FROM b_maintenance_t left join(ma_department_t) on (ma_department_t.department_id=b_maintenance_t.department_id) left join(m_breakdowntype_t) on (m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) left join breakdown_severity on breakdown_severity.breakdownseverity_id=b_maintenance_t.breakdown_sevearity left join tb_users on tb_users.id=b_maintenance_t.issue_created_by 
     left join machine_hdr_t on machine_hdr_t.machine_id=b_maintenance_t.machine_id 

     where 1=1 $wh $wh1");
 if($_GET['status']=="allocateengineer"){
if($dept_id==4){
    $count = $result[0]->count;
}else{
    $count =0;
}
}else{
     $count = $result[0]->count;
}
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
    
   

   
    $SQL = "SELECT b_maintenance_t.*,
      (case when b_maintenance_t.request_status = 'OPEN' AND (b_maintenance_t.technician is null or b_maintenance_t.technician='' or b_maintenance_t.technician=0)  then 'INITIATED'
    when b_maintenance_t.request_status= 'INITIATED' and b_maintenance_t.technician!='' then 'ALLOCATED'
    when b_maintenance_t.request_status= 'REQUESTED' and b_maintenance_t.technician!='' then 'CLOSURE REQUEST INITIATED'
    when b_maintenance_t.request_status= 'APPROVED' and b_maintenance_t.technician!='' then 'CLOSURE REQUEST APPROVED'
    when b_maintenance_t.request_status= 'REJECTED' and b_maintenance_t.technician!='' then 'CLOSURE REQUEST REJECTED'
    when b_maintenance_t.request_status= 'CLOSED' and b_maintenance_t.technician!='' then 'CLOSED'
      end ) ticket_status,
      ma_department_t.department_name,
      m_breakdowntype_t.breakdown_name,
      tb_users.first_name as created_by_name,
      engineer.first_name as allocated_to_name,
      machine_hdr_t.machine_name,
      machine_hdr_t.asset_code,
      breakdown_severity.severity_name

FROM
    b_maintenance_t left join(ma_department_t) on (ma_department_t.department_id=b_maintenance_t.department_id)
     left join(m_breakdowntype_t) on (m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) 
     left join breakdown_severity on breakdown_severity.breakdownseverity_id=b_maintenance_t.breakdown_sevearity 

     left join tb_users on tb_users.id=b_maintenance_t.issue_created_by 
     left join tb_users engineer on engineer.id=b_maintenance_t.engineer 
     left join machine_hdr_t on machine_hdr_t.machine_id=b_maintenance_t.machine_id 


     where 1=1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start , $limit";


 $download_SQL = "SELECT b_maintenance_t.*,ma_department_t.department_name,m_breakdowntype_t.breakdown_name,breakdown_severity.severity_name

FROM
    b_maintenance_t left join(ma_department_t) on (ma_department_t.department_id=b_maintenance_t.department_id) left join(m_breakdowntype_t) on (m_breakdowntype_t.breakdowntype_id=b_maintenance_t.break_type_id) left join breakdown_severity on breakdown_severity.breakdownseverity_id=b_maintenance_t.breakdown_sevearity left join tb_users on tb_users.id=b_maintenance_t.issue_created_by 

         left join machine_hdr_t on machine_hdr_t.machine_id=b_maintenance_t.machine_id 
where 1=1 $wh $wh1 ORDER BY $sidx $sord";
    if($_GET['status']=="allocateengineer"){
    if($dept_id==4){
     $result1 = \DB::select( $download_SQL );
        
    }else{
       $result1=[]; 
    }
    }else{
         $result1 = \DB::select( $download_SQL );
    }
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
 if($_GET['status']=="allocateengineer"){
 if($dept_id==4){
     $result = \DB::select( $SQL );
        
    }else{
        $result = [];  
    }
 }else{
      $result = \DB::select( $SQL );
 }
   
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);
    }

    function view($id=null)
    {
        // dd($id);
        if(isset($_POST['id']))    
    $id=$_POST['id'];  
        if(isset($_POST['btnval']))    
            $this->data['pageMethod']=$_POST['btnval'];
          if(isset($_GET['btnval']))
            $btnval = $_GET['btnval'];
            
            // echo $id;die;
 if(!is_numeric($id) && ($btnval != "approverequest" || $btnval != "requestraise" || $btnval != "allocateengineer" || $btnval != "allocatetechnician" || $btnval != "closerequest" || $btnval !="sopupload" || $btnval!="createissue")){
         return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
      
        $data = \DB::table('b_maintenance_t')
        ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
        ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
        ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
        ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
        ->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.engineer')
            ->select('b_maintenance_t.issue_date','b_maintenance_t.ticket_number','b_maintenance_t.maintenance_type','b_maintenance_t.causes','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','b_maintenance_t.maintenance_type','b_maintenance_t.active','tb_users.username','tb_users.first_name')
            ->where('b_maintenance_t.id',$id)
            ->get();
        // dd($data);
      //  $this->data['data'] = $data;
      //  dd($this->data['data']);

            $this->data['department_name'] = $data[0]->department_name;
                        $this->data['first_name'] = $data[0]->first_name;

            //$this->data['department_name'] = $data[0]->first_name;

            //$this->data['issue_date'] = $data[0]->issue_date;
           $this->data['issue_date']=date(\Session::get('p_date_format'), strtotime($data[0]->issue_date));
            $this->data['maintenance_type'] = $data[0]->maintenance_type;
            $this->data['causes'] = $data[0]->causes;
            $this->data['ticket_number'] = $data[0]->ticket_number;
            $this->data['machine_name'] = $data[0]->machine_name;
            $this->data['breakdown_name'] = $data[0]->breakdown_name;
            $this->data['severity_name'] = $data[0]->severity_name;
            $this->data['active'] = $data[0]->active;
       // $this->data['data']=$data;    
//dd($this->data);
        return view('Breakdownmaintenance.view',$this->data);
    }
    }

       function show($id=null)
    {
              //  $this->data['pageMethod']=$_GET['btnval'];
    if(!is_numeric($id)){
         return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
        $data = \DB::table('b_maintenance_t')
        ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
        ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
        ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
        ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
        ->leftjoin('tb_users as engineer','engineer.id','=','b_maintenance_t.engineer')
        ->leftjoin('tb_users as technicians','technicians.id','=','b_maintenance_t.technician')
            ->select('b_maintenance_t.issue_date','b_maintenance_t.preventive_action','b_maintenance_t.shift','b_maintenance_t.ticket_number','b_maintenance_t.is_breakdown','b_maintenance_t.error_code','b_maintenance_t.end_date','b_maintenance_t.start_date','b_maintenance_t.causes','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','b_maintenance_t.maintenance_type','b_maintenance_t.active','engineer.first_name as e_name','technicians.first_name as t_name')
            ->where('b_maintenance_t.id',$id)
            ->get();
       //  dd($data);
      //  $this->data['data'] = $data;
      //  dd($this->data['data']);

            $this->data['department_name'] = $data[0]->department_name;
             $this->data['e_name'] = $data[0]->e_name;
              $this->data['t_name'] = $data[0]->t_name;
           $this->data['shift'] = $data[0]->shift;
            $this->data['error_code'] = $data[0]->error_code; 
            $this->data['start_date'] = $data[0]->start_date;
            $this->data['end_date'] = $data[0]->end_date;
           $this->data['issue_date']=date(\Session::get('p_date_format'), strtotime($data[0]->issue_date));
            $this->data['maintenance_type'] = $data[0]->maintenance_type;
            $this->data['causes'] = $data[0]->causes;
            $this->data['ticket_number'] = $data[0]->ticket_number;
            $this->data['machine_name'] = $data[0]->machine_name;
            $this->data['breakdown_name'] = $data[0]->breakdown_name;
            $this->data['severity_name'] = $data[0]->severity_name;
       
            $this->data['preventive_action'] = $data[0]->preventive_action;
            $this->data['is_breakdown'] = $data[0]->is_breakdown;
 
//dd($this->data);
        return view('Breakdownmaintenance.sopview',$this->data);
        }
    }


 public  function view1($id=null)
    {
        $data = \DB::table('b_maintenance_t')
        ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
        ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
        ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
        ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
        ->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.engineer')
            ->select('b_maintenance_t.issue_date','b_maintenance_t.ticket_number','b_maintenance_t.maintenance_type','b_maintenance_t.causes','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','b_maintenance_t.maintenance_type','b_maintenance_t.active','tb_users.username','tb_users.first_name')
            ->where('b_maintenance_t.id',$id)
            ->get();

                $html = '';
                        //$grnlineid=$_GET['line_id'];
               
                    $html.='<table class="serial serial"><thead>
                           <thead>
                          <tr>
                          <th>Line No</th>
                          <th>Ticket Number</th>
                          <th>Machine Name</th>
                          <th>Department</th>
                          <th>Issue Date</th>
                          <th>Maintenance Type</th>
                          <th>Allocate Engineer</th>
                          <th>Allocate Technician</th>
                          </tr>    
                            </thead><tbody>';
   
                 if(count($data)>0){
foreach($data as $key=>$val){
               
     
        $html.='<tr class="table'.$key.'">
               <td><input type="text" name="line_no[]" class="input-sm s_no" value="'.($key+1).'" readonly="readonly" style="width:68px !important; color:black;">
               </td>';
      
        $html.='<td><input type="text"  name="bulk_parameter'.$grnlineid.'['.$key.']" class="input-sm bulk_parameter'.$grnlineid.$key.'" value="'.$val->parameter.'" readonly="readonly" style="width:150px !important; color:black;">
             </td>
             <td><input type="text"  name="bulk_spec_criteria'.$grnlineid.'['.$key.']" class="input-sm bulk_spec_criteria'.$grnlineid.$key.'" value="'.$spec[0]->lookup_code.'" readonly="readonly" style="width:150px !important;color:black;"></td>
             <td><input type="text"  name="bulk_spec_value_from'.$grnlineid.'['.$key.']" class="input-sm bulk_spec_value_from'.$grnlineid.$key.'" value="'.$val->spec_value_from.'" readonly="readonly" style="width:100px !important;color:black;"></td>
             <td><input type="text"  name="bulk_spec_value_to'.$grnlineid.'['.$key.']" class="input-sm bulk_spec_value_to'.$grnlineid.$key.'" value="'.$val->spec_value_to.'" readonly="readonly" style="width:100px !important;color:black;"></td>';


        // dd($data);
      //  $this->data['data'] = $data;
      //  dd($this->data['data']);

            $this->data['department_name'] = $data[0]->department_name;
                        $this->data['first_name'] = $data[0]->first_name;

            //$this->data['department_name'] = $data[0]->first_name;

            //$this->data['issue_date'] = $data[0]->issue_date;
            $this->data['issue_date']=date(\Session::get('p_date_format'), strtotime($data[0]->issue_date));
            $this->data['maintenance_type'] = $data[0]->maintenance_type;
            $this->data['causes'] = $data[0]->causes;
            $this->data['ticket_number'] = $data[0]->ticket_number;
            $this->data['machine_name'] = $data[0]->machine_name;
            $this->data['breakdown_name'] = $data[0]->breakdown_name;
            $this->data['severity_name'] = $data[0]->severity_name;
            $this->data['active'] = $data[0]->active;
       // $this->data['data']=$data;    
// dd($this->data);
        return view('home',$this->data);

    }
}
}
     public function getspareqty($hdrid=null){

        $sql=\DB::select("select spares_id,spares_name,spare_quantity as inventory_stock,upload_image from m_spares_t where spares_id = '$hdrid' ");
//dd($sql);
        return $sql;
    }

	 public function fcmMsgNotifications($token,$res,$count){
//  define('FIREBASE_API_KEY', 'AAAA-1PGQSU:APA91bFAdX2X4pFZ5kOE2-SMjcTYtmRGS08MTsCbn13nvg4uo5BetO3K3c8mHSmzGZsCM4WLvnK9Rv30N8jExnAvpLe4yySGT9hnERDCbdlz5QMs-oQXoQqNueFf6zMTIRRTcHQztHGA');
 
     $FIREBASE_API_KEY = 'AAAA-1PGQSU:APA91bFAdX2X4pFZ5kOE2-SMjcTYtmRGS08MTsCbn13nvg4uo5BetO3K3c8mHSmzGZsCM4WLvnK9Rv30N8jExnAvpLe4yySGT9hnERDCbdlz5QMs-oQXoQqNueFf6zMTIRRTcHQztHGA';
     
        $fields = array(
            'to' => $token,
            'notification' =>$res, 
            'data' =>$count
        );
    

        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
// dd(FIREBASE_API_KEY);
        $headers = array(
            'Authorization: key=' .$FIREBASE_API_KEY,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
      // dd($result);

        return $result;
    }
public function issuemachinecheck($id,$machine){
  if($id!=''){
    $issue = \DB::table('b_maintenance_t')->where('machine_id',$machine)->where('id','!=',$id)->where('request_status','!=','CLOSED')->get();
  }else{
    $issue = \DB::table('b_maintenance_t')->where('machine_id',$machine)->where('request_status','!=','CLOSED')->get();
  }
  if(count($issue)>0){return 1;}else{return 0;}
}

}
