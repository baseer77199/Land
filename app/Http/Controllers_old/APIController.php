<?php
namespace App\Http\Controllers;
use App\Helpers\BoilerHelper;
use App\Product;
use App\Http\Controllers\Controller;
use App\User;
use Socialize;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;
use DB;
use Excel;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Worksheet_Drawing;
use PDO;
class APIController extends Controller {

	private $helperService;

	public function __construct(BoilerHelper $helperService) {
		$this->helperService = $helperService;
	}

	public function mobileLogin(Request $request){

		$posted_data= $request->json()->all();

		$remember ='false';

		if (\Auth::attempt(array('username'=>$posted_data['username'], 'password'=> $posted_data['password'] ), $remember )) {

			if(\Auth::check())
			{

				$data = (object)array();

				$row = User::find(\Auth::user()->id);
				$id=$row['id'];
				$fcm_token=$posted_data['fcm_token'];

				{
					$token = md5(rand());
					if($row['m_token']=='')
					{
						\DB::update("update tb_users set m_token='$token',fcm_token='$fcm_token' where id='$id'");
					}else{
						\DB::update("update tb_users set fcm_token='$fcm_token' where id='$id'");
					}
					$data=array();
					$data['result'] = $datass = User::find(\Auth::user()->id);
					$group_id = $datass['group_id'];
					$group= \DB::SELECT("select group_name from a_m_group_t where group_id=$group_id");
					$data['result']->group=$group[0]->group_name;
					$data['token']=$datass['m_token'];
					$data['success']="Success";
					$data['msg']="Log in Successfully";
				}
			}
		}else{


			$data['message']="Invalid Username or Password";
		}

		return response()->json($data);
	}

	public function allticket(Request $request){
		$posted_data= $request->json()->all();
	    if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];
		}
		if(isset($posted_data['machine_id']))
		{
			if($posted_data['machine_id']!=0){
				$array1=[['machine_hdr_t.machine_id','like', '%' . $posted_data['machine_id'] . '%']];
				$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','=','closed')->where('b_maintenance_t.location_id','=',$locid)->where($array1)->orderBy('b_maintenance_t.id', 'desc')->get();
			}
		}else{
			$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where($array)->orWhere($array1)->orWhere($array2)->where('b_maintenance_t.location_id','=',$locid)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')->get();
		}
		$returndata=array();
		if (count($data)>0) {
			$returndata['message']="success";
		}else{
			$returndata['message']="failure";
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		return $returndata;
	}

	public function assignengineerticketlist(Request $request){
	   
		$posted_data= $request->json()->all();
		if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];
		}
		$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.maintenance_type','b_maintenance_t.causes','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','INITIATED')->where('b_maintenance_t.location_id','=',$locid)->orWhere('b_maintenance_t.request_status','OPEN')->where('b_maintenance_t.location_id','=',$locid)->orWhere('b_maintenance_t.request_status','REJECTED')->where('b_maintenance_t.location_id','=',$locid)->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		->get();
		$returndata=array();
		if (count($data)>0) {
	
			$returndata['message']="success";
		}else{
			$returndata['message']="failure";
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		return $returndata;
	}

	public function assigntechticketlist(Request $request){
		$posted_data= $request->json()->all();
		if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];
		}
		$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','INITIATED')->where('b_maintenance_t.location_id','=',$locid)->orWhere('b_maintenance_t.request_status','REJECTED')->where('b_maintenance_t.location_id','=',$locid)->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		->get();
		$returndata=array();
		if (count($data)>0) {
			$returndata['message']="success";
		}else{
			$returndata['message']="failure";
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		return $returndata;
	}
	public function approvalrequestlist(Request $request){
		$posted_data= $request->json()->all();
		if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];
		}
		$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','INITIATED')->where('b_maintenance_t.location_id','=',$locid)->orWhere('b_maintenance_t.request_status','REJECTED')->where('b_maintenance_t.location_id','=',$locid)->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		->get();
		$returndata=array();
		if (count($data)>0) {
			$returndata['message']="success";
		}else{
			$returndata['message']="failure";
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		return $returndata;
	}		
	public function approvallist(Request $request){
	    
		$posted_data= $request->json()->all();
		if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array3=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];
		}
		$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.start_date','b_maintenance_t.end_date','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','REQUESTED')->where('b_maintenance_t.location_id','=',$locid)->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		->get();
		$returndata=array();
		if (count($data)>0) {
			$returndata['message']="success";
		}else{
			$returndata['message']="failure";
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		return $returndata;
	}

	public function getalldata(Request $request)
	{
	    $posted_data= $request->json()->all();
	    if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$returndata=array();
		$data1 = DB::table('ma_department_t')->select('department_id','department_name')->orderBy('department_name', 'asc')->get();
		$returndata['department']=collect($data1)->map(function($x){ return (array) $x; })->toArray();
		$data2 = DB::table('machine_hdr_t')->select('machine_id','machine_name')->where('location_id','=',$locid)->orderBy('machine_name', 'asc')->get();
		$returndata['machine']=collect($data2)->map(function($x){ return (array) $x; })->toArray();
		$data3 = DB::table('m_breakdowntype_t')->select('breakdowntype_id','breakdown_name')->orderBy('breakdown_name', 'asc')->get();
		$returndata['breakdowntype']=collect($data3)->map(function($x){ return (array) $x; })->toArray();
		$data4 = DB::table('breakdown_severity')->select('breakdownseverity_id','severity_name')->orderBy('severity_name', 'asc')->get();
		$returndata['breakdown_severity']=collect($data4)->map(function($x){ return (array) $x; })->toArray();
		$data5 = DB::table('tb_users')->select('id','username')->where('loc_id','=',$locid)->orderBy('username', 'asc')->get();
		$returndata['users']=collect($data5)->map(function($x){ return (array) $x; })->toArray();
		$data6 = DB::table('m_spares_t')->select('spares_id','spares_name')->orderBy('spares_name', 'asc')->get();
		$returndata['spares']=collect($data6)->map(function($x){ return (array) $x; })->toArray();
		$returndata['maintenance'][0]['name'] ='Machine';
		$returndata['maintenance'][1]['name'] ='Facility';
		$returndata['message']="success";

		return $returndata;
	}

	public function getTokenUser($token){
		$users = DB::table('tb_users')
		->select('*')
		->where('m_token', $token)
		->first();
		if($users==null){
			$data['message']="Invalid Token";
			response()->json($data)->send();
			die();
		}else{
			return $users;
		}
	}

	public function generateticket(Request $request)
	{
		$posted_data= $request->json()->all();
		$seqno = \DB::table('b_maintenance_t')->orderBy('id','desc')->get();
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		if(count($seqno)>0)
		{
			$seqno = $count = $seqno[0]->ticket_count;
		}
		else
		{
			$seqno = $count = 0;
		}
		$seqname = 'TICKET';
		$seqno = sprintf('%03d',$seqno+1);
		$count = $count+1;
		$out_put[0] = $seqname.$seqno;
		$out_put[1] = $count;
		$datas=array();
		$data=array();
		$count=array();
		$datas['department_id']=$posted_data['department_id'];
		$datas['machine_id']=$posted_data['machine_id'];
		$datas['break_type_id']=$posted_data['breakdown_id'];
		$datas['issue_date']=date("Y-m-d h:i:sa", strtotime($posted_data['issue_date']));
		$datas['breakdown_sevearity']=$posted_data['breakdown_severity_id'];
		$datas['causes']=$posted_data['causes'];
		$datas['maintenance_type']=$posted_data['maintenance_type_id'];
		$datas['issue_created_on']=date('Y-m-d H:i:s');
		$datas['issue_created_by']=$user_details->id;
		$datas['company_id']=$user_details->company_id;
		$datas['location_id']=$user_details->loc_id;
		$datas['request_status']=$posted_data['request_status'];

		if(isset($posted_data['id'])){
			$datas['id']=$posted_data['id'];
			$get = \DB::table('b_maintenance_t')->where('id',$posted_data['id'])->get();
			$machine = \DB::table('machine_hdr_t')->where('machine_id',$posted_data['machine_id'])->get();
			$user_details = $this->getTokenUser($token);
			$ticket_number=$get[0]->ticket_number;
			$machine_number=$machine[0]->machine_name;
			$emp_name=$user_details->employee_number;

		}else{
			$datas['id']='';
			$machine = \DB::table('machine_hdr_t')->where('machine_id',$posted_data['machine_id'])->get();
			$machine_number=$machine[0]->machine_name;
			$emp_name=$user_details->employee_number;
			$ticket_number = $datas['ticket_number']=$out_put[0];
			$datas['ticket_count']=$out_put[1];
			$datas['shift']=$posted_data['shift'];
			$created_by = \DB::table('tb_users')->where('id',$user_details->id)->get();

			$notification['body']="Ticket Generated By"." - ".$created_by[0]->username;
			$notification['title']=$ticket_number." - ".$machine_number;
			$notification['icon']="";
			$notification['sound']="default";
			$count['body']="Ticket Generated";
			$count['title']=$ticket_number;
			$count['count']="28";
			$count['sound']="default";

			$fcm_data = \DB::select("select * from tb_users where department_id  IN (4)");

			foreach ($fcm_data as $key => $val) {
				$msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
			}



		}
		if(isset($posted_data['assignengg_id'])){	    
			$datas['engineer']=$posted_data['assignengg_id'];

			$get = \DB::table('b_maintenance_t')->where('id',$posted_data['id'])->get();
			$machine = \DB::table('machine_hdr_t')->where('machine_id',$posted_data['machine_id'])->get();
			$ticket_number=$get[0]->ticket_number;
			$machine_number=$machine[0]->machine_name;
			$emp_name=$user_details->employee_number;
			$created_by = \DB::table('tb_users')->where('id',$user_details->id)->get();

			$notification['body']="Ticket Assigned By"." - ".$created_by[0]->username;
			$notification['title']=$ticket_number." - ".$machine_number;
			$notification['icon']="";
			$notification['sound']="default";
			$count['body']="Ticket Assigned";
			$count['title']=$ticket_number;
			$count['count']="28";
			$count['sound']="default";
			$fcm_data=\DB::select("select * from tb_users where id='".$datas['engineer']."'");
			if(count($fcm_data)>0){
				$id_notiy='';
				foreach($fcm_data as $key=>$value){
					$id_notiy.=$value->id.',';    
				}
				$id_notiy=rtrim($id_notiy, ',');
				$noti_msg = "Ticket Assigned ".$ticket_number." - ".$machine_number;
				$this->sendPopUpHomeNoty($datas['id'],"Ticket Assigned",$noti_msg,"engineerallocate",$id_notiy,$user_details->id,'requestraise');
			}
			$msg1[]=$this->fcmMsgNotifications($fcm_data[0]->fcm_token,$notification,$count);
		}else{
			$datas['engineer']='';
		}
		if(isset($posted_data['assign_technician_id'])){
			$datas['technician']=json_encode($posted_data['assign_technician_id']);
		}else{
			$datas['technician']='';
		}
		if($datas['id']=="")
		{
			$id=DB::table('b_maintenance_t')
			->insertGetId($datas);
			if(count($fcm_data)>0){
				$id_notiy='';
				foreach($fcm_data as $key=>$value){
					$id_notiy.=$value->id.',';    

				}
				$id_notiy=rtrim($id_notiy, ',');
				$noti_msg = "Ticket Generated ".$ticket_number." - ".$machine_number;
				$this->sendPopUpHomeNoty($id,"Ticket Generate",$noti_msg,"engineerallocate",$id_notiy,$user_details->id,'allocateengineer');
			}
		}else{
			DB::table('b_maintenance_t')
			->where('id',$datas['id'])
			->update($datas);
		}
		$data['ticket']=$out_put[0];
		$data['message']="Success";
		return $data;

	}

	public function getassigndetails(Request $request)
	{
		$posted_data= $request->json()->all();
		if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$returndata=array();
		$data=DB::table('b_maintenance_t')->where('id','=',$posted_data['id'])->get();
		$returndata=collect($data)->map(function($x){ return (array) $x; })->toArray();
		$returndata['data']=$data[0];
		if (count($data)>0) {
			$returndata['message']="success";
		}else{
			$returndata['message']="failure";
		}
		return $returndata;

	}

	public function requestticket(Request $request)
	{
		$posted_data= $request->json()->all();
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id=$posted_data['id'];
		$data=array();
		$data1=array();
		$data['request_status']=$posted_data['request_status'];
		if(isset($posted_data['request_remark'])){
			$data['request_remark']=$posted_data['request_remark'];
		}if(isset($posted_data['repair_start_date'])){
			$data['start_date']=$posted_data['repair_start_date'];
		}if(isset($posted_data['repair_end_date'])){
			$data['end_date']=$posted_data['repair_end_date'];
		}
		if(isset($posted_data['approve_remark']))
		{
			if(isset($posted_data['approve_remark'])){
				$data['approve_remarks']=$posted_data['approve_remark'];
			}
			$data['request_approve_by']=$user_details->id;
			$data['request_approve_on']=date("Y-m-d");
		}else{
			$data['request_request_by']=$user_details->id;
			$data['request_request_on']=date("Y-m-d");
		}
		$get = \DB::table('b_maintenance_t')->where('id',$posted_data['id'])->get();
		$machine = \DB::table('machine_hdr_t')->where('machine_id',$get[0]->machine_id)->get();
		$ticket_number=$get[0]->ticket_number;
		$machine_number=$machine[0]->machine_name;
		$emp_name=$user_details->employee_number;
		$created_by = \DB::table('tb_users')->where('id',$user_details->id)->get();

		if(isset($posted_data['approve_remark']))
		{
			$notification['body']="Ticket Approved By"." - ".$created_by[0]->username;
			$count['body']="Ticket Approved";

		}
		else{
			$notification['body']="Ticket Requested By"." - ".$created_by[0]->username;
			$count['body']="Ticket Requested";   
		}
		$notification['title']=$ticket_number." - ".$machine_number;
		$notification['icon']="";
		$notification['sound']="default";

		$count['title']=$ticket_number;
		$count['count']="28";
		$count['sound']="default";

		$fcm_data = \DB::select("select * from tb_users where machine_department_id='".$get[0]->department_id."'");
		foreach ($fcm_data as $key => $val) {
			$msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
		}
		if(count($fcm_data)>0){
			$id_notiy='';
			foreach($fcm_data as $key=>$value){
				$id_notiy.=$value->id.',';    

			}
			$id_notiy=rtrim($id_notiy, ',');
			if(isset($posted_data['approve_remark']))
			{
				$noti_msg = "Ticket Approved ".$ticket_number." - ".$machine_number;
				$this->sendPopUpHomeNoty($posted_data['id'],"Ticket Generate",$noti_msg,"engineerallocate",$id_notiy,$user_details->id,'closerequest');
			}else{
				$noti_msg = "Ticket Requested ".$ticket_number." - ".$machine_number;  
				$this->sendPopUpHomeNoty($posted_data['id'],"Ticket Generate",$noti_msg,"engineerallocate",$id_notiy,$user_details->id,'approverequest');
			}

		}
		DB::table('b_maintenance_t')
		->where('id',$id)
		->update($data);
		$data1['status']=$data['request_status'];
		$data1['message']="Success";
		return $data1;

	}
	public function closeticket(Request $request)
	{
		$posted_data= $request->json()->all();
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id=$posted_data['id'];
		$data=array();
		$data1=array();
		$data['critical_spare']=$posted_data['critical_spares_used'];
		$data['request_status']="CLOSED";
		$id=$posted_data['id'];
		$datas2 = [];
		if($data['critical_spare']=="Yes"){
			$index = 0;
			$spare_qty = 0;
			foreach($posted_data['spares'] as $k=>$v){
				$chk = DB::table('m_spares_t')->where('spares_id',$v['spare_id'])->get();
				$qty=$chk[0]->spare_quantity;
				$spare_qty = $qty-$v['qty'];
				DB::table('m_spares_t')->where('spares_id',$v['spare_id'])->update(['spare_quantity'=>$spare_qty]);	

				$datas2[$index]['spares_id']=$v['spare_id'];
				$datas2[$index]['qty']=$v['qty'];
				$datas2[$index]['id']=$id;
				$index++;
			}
			DB::table('b_maintenance_t_lines')
			->insert($datas2);
		}
		if($data['critical_spare']=="Others"){
			$data['others']=$posted_data['others'];
		}

		DB::table('b_maintenance_t')
		->where('id',$id)
		->update($data);


		$get = \DB::table('b_maintenance_t')->where('id',$id)->get();
		$machine = \DB::table('machine_hdr_t')->where('machine_id',$get[0]->machine_id)->get();
		$ticket_number=$get[0]->ticket_number;
		$machine_number=$machine[0]->machine_name;
		$emp_name=$user_details->employee_number;
		$created_by = \DB::table('tb_users')->where('id',$user_details->id)->get();

		$notification['body']="Ticket Closed By"." - ".$created_by[0]->username;
		$notification['title']=$ticket_number." - ".$machine_number;
		$notification['icon']="";
		$notification['sound']="default";
		$count['body']="Ticket Closed";
		$count['title']=$ticket_number;
		$count['count']="28";
		$count['sound']="default";

		$fcm_data = \DB::select("select * from tb_users where machine_department_id='".$user_details->department_id."'");
		foreach ($fcm_data as $key => $val) {
			$msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
		}
		if(count($fcm_data)>0){
			$id_notiy='';
			foreach($fcm_data as $key=>$value){
				$id_notiy.=$value->id.',';    

			}
			$id_notiy=rtrim($id_notiy, ',');
			$noti_msg = "Ticket Closed ".$ticket_number." - ".$machine_number;
			$this->sendPopUpHomeNoty($id,"Ticket Generate",$noti_msg,"userview",$id_notiy,$user_details->id,'createissue');


		}
		$data1['status']="CLOSED";
		$data1['message']="Success";
		return $data1;
	}
	public function getcloselist(Request $request){
		$posted_data= $request->json()->all();
		if(isset($posted_data['token'])){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		}else{
		$locid = '1';
		}
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];
		}
		$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.start_date','b_maintenance_t.end_date','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','=','APPROVED')->where('b_maintenance_t.location_id','=',$locid)->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		->get();
		$returndata=array();
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		if (count($data)>0) {
			$returndata['message']="success";
		}else{
			$returndata['message']="failure";
		}
		return $returndata;
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

	public function newticketrisse(Request $request)
	{
	    $posted_data= $request->json()->all();
		if($request->header('_token')!=null)
		{
			$date=array();
			if($request->header('_token')=='e4ae5b782c4506955f10d26af45934cel32n68s98')
			{
				$data['data']=json_encode($posted_data);
				\DB::table('api_new_ticket_t')->insert($data);

				$msg="Successfull";

			}
			else
			{
				$msg="Token Mismatch";
			}
		}
		else
		{
			$msg="Unauthenticated User";   
		}
		return $msg;
	}
	

}
?>
