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
class AndroidController extends Controller {

	private $helperService;

	public function __construct(BoilerHelper $helperService) {

header_remove('Access-Control-Allow-Methods');
header_remove('Access-Control-Allow-Origin');
header_remove('Access-Control-Allow-Headers');
header_remove('Access-Control-Allow-Credentials');


$allowed_host=array('172.31.61.248:156','192.168.1.5','localhost','localhost:156','172.31.61.248','103.74.215.40','103.74.215.40:156','ticketingsolutions.lntecc.com','ticketingsolutions.lntecc.com:156');


if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_host)) 
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 421 Misdirected Request');

echo "<html><head>
<title>421 Misdirected Request</title>
</head><body>
<h1>Misdirected Request</h1>
<p>The client needs a new connection for this
request as the requested host name does not match
the Server Name Indication (SNI) in use for this
connection.</p>
</body></html>";

    exit;
}
		$this->helperService = $helperService;
	}

	public function mobileLogin(Request $request){
		$posted_data= $request->json()->all();

		$remember ='false';
	    $username = $posted_data['username'];
        $attempt = \DB::SELECT("select * from login_attempt_tbl where user_name='$username'");
		$userTbl = \DB::SELECT("select * from tb_users where employee_number='$username'");
		$data=array();
		 if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
		if (\Auth::attempt(array('username'=>$posted_data['username'], 'password'=> $posted_data['password'] ), $remember )) {
// dd('kk');
			if(\Auth::check())
			{    
			    if(count($attempt)>0&& count($userTbl)>0 &&$attempt[0]->login_attempt!=3){
		        $tblId = $attempt[0]->id;
		        \DB::update("update login_attempt_tbl set login_attempt='0' where id='$tblId'"); 
		        $data = (object)array();
				$row = User::find(\Auth::user()->id);
				$id=$row['id'];
				$fcm_token=$posted_data['fcm_token'];
				$token = md5(rand());
				\DB::update("update tb_users set m_token='$token',fcm_token='$fcm_token' where id='$id'");
				$data=array();
				$data['result'] = $datass = User::find(\Auth::user()->id);
				$group_id = $datass['group_id'];
				$group= \DB::SELECT("select group_name from a_m_group_t where group_id=$group_id");
				$data['result']->group=$group[0]->group_name;
				$data['token']=$datass['m_token'];
				$data['success']="Success";
				$data['message']="Log in Successfully";
		     }else if(count($userTbl)>0&&count($attempt)==0){
		        $datas['user_name']=$username;
		        $datas['login_attempt']='0';
			   \DB::table('login_attempt_tbl')->insert($datas);
		        $data = (object)array();
				$row = User::find(\Auth::user()->id);
				$id=$row['id'];
				$fcm_token=$posted_data['fcm_token'];
				$token = md5(rand());
				\DB::update("update tb_users set m_token='$token',fcm_token='$fcm_token' where id='$id'");
				$data=array();
				$data['result'] = $datass = User::find(\Auth::user()->id);
				$group_id = $datass['group_id'];
				$group= \DB::SELECT("select group_name from a_m_group_t where group_id=$group_id");
				$data['result']->group=$group[0]->group_name;
				$data['token']=$datass['m_token'];
				$data['success']="Success";
				$data['message']="Log in Successfully";
		     }else{
		        $data = (object)array();
			    $data=array();
		        $data['message']="You're blocked contact your admin";
		     }
			}
		}else{
		    if(count($attempt)>0&&$attempt[0]->login_attempt!=3){
		        $tbAttempt = $attempt[0]->login_attempt+1 ;
		        $tblId = $attempt[0]->id;
		       \DB::update("update login_attempt_tbl set login_attempt='$tbAttempt' where id='$tblId'"); 
		       	$data['message']="Invalid Password";
		    }else if(count($attempt)>0&&$attempt[0]->login_attempt==3){
		       $data['message']="You're blocked contact your admin";
		    }else if(count($userTbl)>0){
		       $data['user_name']=$username;
		       $data['login_attempt']='1';
			   \DB::table('login_attempt_tbl')->insert($data);
     		   $data['message']="Invalid Password";
		    }else{
			   $data['message']="Invalid Username";
		    }
		}
		 }
		 else{
        $data['message']="failure";
        }
		return response()->json($data);
	}

	public function changepassword(Request $request)
	{
	    $posted_data= $request->json()->all();
		$token =$posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$userid = $user_details->id;
		$password=bcrypt($posted_data['password']);
		$data=array();
		 if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
		\DB::update("update tb_users set password='$password' where id='$userid'");
		$data['message']="SUCCESS";
		 }
		 else
		 {
		    $data['message']="failure"; 
		 }
		return response()->json($data);

	}
	public function allticket(Request $request){
		$posted_data= $request->json()->all();
        $returndata=array();
        if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token'])
		{
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
		$locid = $user_details->loc_id;
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		$loc_cond=[];
		if($locid!=0){
			$loc_cond=[['b_maintenance_t.location_id','=',$locid]];
		}
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
			$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->select('b_maintenance_t.id','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where($array)->orWhere($array1)->orWhere($array2)->where($loc_cond)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')->get();
		}
		
		if (count($data)>0) {
			$returndata['message']="success";
			$returndata['token']=$token;
		}else{
			$returndata['message']="success";
			$returndata['token']=$token;
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		}else{
		 $returndata['message']="failure";
		}
            
        }else{
        $returndata['message']="failure";
        }
		return $returndata;
	}

	public function assignengineerticketlist(Request $request){
		$posted_data= $request->json()->all();
		$returndata=array();
		if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token'])
		{
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
		$locid = $user_details->loc_id;
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		$wh1="";
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];

			$wh1.=" and (machine_hdr_t.asset_code like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.ticket_number like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.issue_date like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.request_status like '%".$posted_data['search']."%')";

		}
		
		$wh=" and (b_maintenance_t.request_status='INITIATED' or b_maintenance_t.request_status='REJECTED') and `b_maintenance_t`.`location_id` = $locid";

		$SQL = "select `b_maintenance_t`.`id`, 
						`maintanance_type`.`maintanance_name` as `maintenance_type`, 
						`b_maintenance_t`.`causes`, 
						`b_maintenance_t`.`issue_date`, 
						`b_maintenance_t`.`technician`, 
						`b_maintenance_t`.`request_status`, 
						`b_maintenance_t`.`ticket_number`, 
						`ma_department_t`.`department_name`, 
						`machine_hdr_t`.`machine_name`, 
						`machine_hdr_t`.`asset_code`, 
						`machine_hdr_t`.`files` as `image`, 
						`m_breakdowntype_t`.`breakdown_name`, 
						`breakdown_severity`.`severity_name`, 
						`tb_users`.`employee_number` 
						from `b_maintenance_t` 
						left join `ma_department_t` on `ma_department_t`.`department_id` = `b_maintenance_t`.`department_id` 
						left join `machine_hdr_t` on `machine_hdr_t`.`machine_id` = `b_maintenance_t`.`machine_id` 
						left join `m_breakdowntype_t` on `m_breakdowntype_t`.`breakdowntype_id` = `b_maintenance_t`.`break_type_id` 
						left join `breakdown_severity` on `breakdown_severity`.`breakdownseverity_id` = `b_maintenance_t`.`breakdown_sevearity` 
						left join `tb_users` on `tb_users`.`id` = `b_maintenance_t`.`issue_created_by` 
						left join `maintanance_type` on `maintanance_type`.`maintanance_name` = `b_maintenance_t`.`maintenance_type` 
						where 1=1 $wh $wh1
						order by `b_maintenance_t`.`id` desc";
		$data = DB::select($SQL);
		// $data = DB::table('b_maintenanc_t')
		// 			->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
		// 			->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
		// 			->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
		// 			->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
		// 			->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')
		// 			->leftjoin('maintanance_type','maintanance_type.mt_id','=','b_maintenance_t.maintenance_type')
		// 			->select('b_maintenance_t.id','maintanance_type.maintanance_name as maintenance_type','b_maintenance_t.causes','b_maintenance_t.issue_date','b_maintenance_t.technician','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')
		// 			->where('b_maintenance_t.request_status','INITIATED')
		// 			->where('b_maintenance_t.location_id','=',$locid)
		// 			->orWhere('b_maintenance_t.request_status','REJECTED')
		// 			->where($array)
		// 			->orWhere($array1)
		// 			->orWhere($array2)
		// 			->orWhere($array3)
		// 			->orderBy('b_maintenance_t.id', 'desc')
		// ->get();
		
		if (count($data)>0) {
			$returndata['message']="success";
			$returndata['token']=$token;
		}else{
		    $returndata['message']="success";
		    $returndata['token']=$token;
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		}else{
		 $returndata['message']="failure";
		}
		    
		}else{
        $returndata['message']="failure";
        }
		return $returndata;
	}

	public function assigntechticketlist(Request $request){
		$posted_data= $request->json()->all();
		$returndata=array();
		if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token'])
		{
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
		$locid = $user_details->loc_id;
	
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		$wh1 = "";
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];

			$wh1.=" and (machine_hdr_t.asset_code like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.ticket_number like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.issue_date like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.request_status like '%".$posted_data['search']."%')";
		}

		$wh=" and b_maintenance_t.request_status = 'OPEN' and `b_maintenance_t`.`location_id` = $locid";

		$SQL = "select `b_maintenance_t`.`id`, 
						`maintanance_type`.`maintanance_name` as `maintenance_type`, 
						`b_maintenance_t`.`technician`, 
						`b_maintenance_t`.`causes`, 
						`b_maintenance_t`.`issue_date`, 
						`b_maintenance_t`.`request_status`, 
						`b_maintenance_t`.`ticket_number`, 
						`ma_department_t`.`department_name`, 
						`machine_hdr_t`.`machine_name`, 
						`machine_hdr_t`.`asset_code`, 
						`machine_hdr_t`.`files` as `image`, 
						`m_breakdowntype_t`.`breakdown_name`, 
						`breakdown_severity`.`severity_name`, 
						`tb_users`.`employee_number`, 
						`eng`.`employee_number` as `engineer_name` 
						from `b_maintenance_t` 
						left join `ma_department_t` on `ma_department_t`.`department_id` = `b_maintenance_t`.`department_id` 
						left join `machine_hdr_t` on `machine_hdr_t`.`machine_id` = `b_maintenance_t`.`machine_id` 
						left join `m_breakdowntype_t` on `m_breakdowntype_t`.`breakdowntype_id` = `b_maintenance_t`.`break_type_id` 
						left join `breakdown_severity` on `breakdown_severity`.`breakdownseverity_id` = `b_maintenance_t`.`breakdown_sevearity` 
						left join `tb_users` as `eng` on `eng`.`id` = `b_maintenance_t`.`engineer` 
						left join `tb_users` on `tb_users`.`id` = `b_maintenance_t`.`issue_created_by` 
						left join `maintanance_type` on `maintanance_type`.`maintanance_name` = `b_maintenance_t`.`maintenance_type` 
						where 1=1 $wh $wh1
						order by `b_maintenance_t`.`id` desc";
						// echo $SQL;exit;
		$data = DB::select($SQL);
		// $data = DB::table('b_maintenance_t')
		// 			->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
		// 			->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
		// 			->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
		// 			->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
		// 			->leftjoin('tb_users as eng','eng.id','=','b_maintenance_t.engineer')
		// 			->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')
		// 			->leftjoin('maintanance_type','maintanance_type.mt_id','=','b_maintenance_t.maintenance_type')
		// 			->select('b_maintenance_t.id','maintanance_type.maintanance_name as maintenance_type','b_maintenance_t.technician','b_maintenance_t.causes','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number','eng.employee_number as engineer_name')
		// 			->where('b_maintenance_t.location_id','=',$locid)
		// 			->Where('b_maintenance_t.request_status','OPEN')
		// 			->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		// ->get();
		
		if (count($data)>0) {
		    foreach($data as $k=>$v){
		        $firstname="";
		        if($v->technician!="" && $v->technician!="[]"){
		        $name=json_decode($v->technician);
		       // dd($name);
		        foreach($name as $kk=>$vv){
		            $use=DB::table('tb_users')->select('first_name')->where('id',$vv)->get();
		           if(count($use)>0){
		            $firstname.=$use[0]->first_name.',';
		               
		           }
		        }   
		        $data[$k]->techname=$firstname;
		        
		        }else{
		            $data[$k]->techname="";
		        }
		        
		    }
		    $returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
			$returndata['message']="success";
			$returndata['token']=$token;
		}else{
			$returndata['message']="success";
			$returndata['token']=$token;
		}
		
		}else{
         $returndata['message']="failure";
         }
	    
	}else{
        $returndata['message']="failure";
        }
		return $returndata;
	}
	public function approvalrequestlist(Request $request){
		$posted_data= $request->json()->all();
		$returndata=array();
        if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token'])
        {
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
		$locid = $user_details->loc_id;
	
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		$wh1="";
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];

			$wh1.=" and (machine_hdr_t.asset_code like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.ticket_number like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.issue_date like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.request_status like '%".$posted_data['search']."%') ";
		}

		 $wh=" and (b_maintenance_t.request_status='INITIATED' or b_maintenance_t.request_status='REJECTED') and  (engineer=$id or technician like '%".'"'.$id.'"'."%') and `b_maintenance_t`.`location_id` = $locid";

		$SQL = "select `eng`.`employee_number` as `engineer_name`,
						`b_maintenance_t`.`id`, 
						`maintanance_type`.`maintanance_name` as `maintenance_type`,
						`b_maintenance_t`.`technician`,
						`b_maintenance_t`.`causes`,
						`b_maintenance_t`.`issue_date`, 
						`b_maintenance_t`.`request_status`, 
						`b_maintenance_t`.`ticket_number`, 
						`ma_department_t`.`department_name`, 
						`machine_hdr_t`.`machine_name`, 
						`machine_hdr_t`.`asset_code`, 
						`machine_hdr_t`.`files` as `image`, 
						`m_breakdowntype_t`.`breakdown_name`, 
						`breakdown_severity`.`severity_name`, 
						`tb_users`.`employee_number` 
						from `b_maintenance_t` 
						left join `ma_department_t` on `ma_department_t`.`department_id` = `b_maintenance_t`.`department_id` 
						left join `machine_hdr_t` on `machine_hdr_t`.`machine_id` = `b_maintenance_t`.`machine_id` 
						left join `m_breakdowntype_t` on `m_breakdowntype_t`.`breakdowntype_id` = `b_maintenance_t`.`break_type_id` 
						left join `breakdown_severity` on `breakdown_severity`.`breakdownseverity_id` = `b_maintenance_t`.`breakdown_sevearity` 
						left join `tb_users` on `tb_users`.`id` = `b_maintenance_t`.`issue_created_by` 
						left join `tb_users` as `eng` on `eng`.`id` = `b_maintenance_t`.`engineer` 
						left join `maintanance_type` on `maintanance_type`.`maintanance_name` = `b_maintenance_t`.`maintenance_type` 
						where 1=1 $wh $wh1
						order by `b_maintenance_t`.`id` desc";
						// echo $SQL;die;
		$data = \DB::select($SQL);
		// $data = DB::table('b_maintenance_t')
		// ->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')
		// ->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')
		// ->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')
		// ->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')
		// ->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')
		// ->leftjoin('tb_users as eng','eng.id','=','b_maintenance_t.engineer')
		// ->leftjoin('maintanance_type','maintanance_type.mt_id','=','b_maintenance_t.maintenance_type')
		// ->select('eng.employee_number as engineer_name','b_maintenance_t.id','maintanance_type.maintanance_name as maintenance_type','b_maintenance_t.technician','b_maintenance_t.causes','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')
		// ->where('b_maintenance_t.location_id','=',$locid)
		// ->where('b_maintenance_t.request_status','INITIATED')
		// ->orWhere('b_maintenance_t.request_status','REJECTED')
		// ->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)
		// ->orderBy('b_maintenance_t.id', 'desc')
		// ->get();
		
		if (count($data)>0) {
		    foreach($data as $k=>$v){
		        $firstname="";
		        if($v->technician!=""&&$v->technician!="[]"){
		        $name=json_decode($v->technician);
		       // dd($name);
		        foreach($name as $kk=>$vv){
		            $use=DB::table('tb_users')->select('first_name')->where('id',$vv)->get();
		           if(count($use)>0){
		            $firstname.=$use[0]->first_name.',';
		               
		           }
		        }   
		        $data[$k]->techname=$firstname;
		        
		        }else{
		            $data[$k]->techname="";
		        }
		        
		    }
			$returndata['message']="success";
			$returndata['token']=$token;
		}else{
			$returndata['message']="success";
			$returndata['token']=$token;
		}
		$returndata['token']=$token;
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
	    }
	    else{
          $returndata['message']="failure";
        }
	    
	}else{
        $returndata['message']="failure";
        }
		return $returndata;
	}		
	public function approvallist(Request $request){
	    
		$posted_data= $request->json()->all();
		$returndata=array();
		if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token']){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
		$locid = $user_details->loc_id;
		
		$array=[];
		$array1=[];
		$array2=[];
		$array3=[];
		$wh1="";
		if(isset($posted_data['search']))
		{
			$array=[['machine_hdr_t.asset_code','like', '%' . $posted_data['search'] . '%']];
			$array1=[['b_maintenance_t.ticket_number','like', '%' . $posted_data['search'] . '%']];
			$array2=[['b_maintenance_t.issue_date','like', '%' . $posted_data['search'] . '%']];
			$array3=[['b_maintenance_t.request_status','like', '%' . $posted_data['search'] . '%']];
			
			$wh1.=" and (machine_hdr_t.asset_code like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.ticket_number like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.issue_date like '%".$posted_data['search']."%'";
			$wh1.=" or b_maintenance_t.request_status like '%".$posted_data['search']."%')";
		}
		$wh=" and (b_maintenance_t.request_status='REQUESTED') and `b_maintenance_t`.`location_id` = $locid";

		$SQL = "select `eng`.`employee_number` as `engineer_name`, 
						`b_maintenance_t`.`request_remark`, 
						`b_maintenance_t`.`technician`, 
						`b_maintenance_t`.`approve_remarks`, 
						`b_maintenance_t`.`id`, 
						`maintanance_type`.`maintanance_name` as `maintenance_type`, 
						`b_maintenance_t`.`causes`, 
						`b_maintenance_t`.`start_date`, 
						`b_maintenance_t`.`end_date`, 
						`b_maintenance_t`.`issue_date`, 
						`b_maintenance_t`.`request_status`, 
						`b_maintenance_t`.`ticket_number`, 
						`ma_department_t`.`department_name`, 
						`machine_hdr_t`.`machine_name`, 
						`machine_hdr_t`.`asset_code`, 
						`machine_hdr_t`.`files` as `image`, 
						`m_breakdowntype_t`.`breakdown_name`, 
						`breakdown_severity`.`severity_name`, 
						`tb_users`.`employee_number` 
						from `b_maintenance_t` 
						left join `ma_department_t` on `ma_department_t`.`department_id` = `b_maintenance_t`.`department_id` 
						left join `machine_hdr_t` on `machine_hdr_t`.`machine_id` = `b_maintenance_t`.`machine_id` 
						left join `m_breakdowntype_t` on `m_breakdowntype_t`.`breakdowntype_id` = `b_maintenance_t`.`break_type_id` 
						left join `breakdown_severity` on `breakdown_severity`.`breakdownseverity_id` = `b_maintenance_t`.`breakdown_sevearity` 
						left join `tb_users` on `tb_users`.`id` = `b_maintenance_t`.`issue_created_by` 
						left join `tb_users` as `eng` on `eng`.`id` = `b_maintenance_t`.`engineer` 
						left join `maintanance_type` on `maintanance_type`.`maintanance_name` = `b_maintenance_t`.`maintenance_type` 
						where 1=1 $wh $wh1
						order by `b_maintenance_t`.`id` desc";
// echo $SQL;exit;
		$data = DB::select($SQL);

		// $data = DB::table('b_maintenanc_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->leftjoin('tb_users as eng','eng.id','=','b_maintenance_t.engineer')->leftjoin('maintanance_type','maintanance_type.mt_id','=','b_maintenance_t.maintenance_type')->select('eng.employee_number as engineer_name','b_maintenance_t.request_remark','b_maintenance_t.technician','b_maintenance_t.approve_remarks','b_maintenance_t.id','maintanance_type.maintanance_name as maintenance_type','b_maintenance_t.causes','b_maintenance_t.start_date','b_maintenance_t.end_date','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','m_breakdowntype_t.breakdown_name','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','REQUESTED')->where('b_maintenance_t.location_id','=',$locid)->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		// ->get();
		
		if (count($data)>0) {
		    foreach($data as $k=>$v){
		        $firstname="";
		        if($v->technician!=""&&$v->technician!="[]"){
		        $name=json_decode($v->technician);
		       // dd($name);
		        foreach($name as $kk=>$vv){
		            $use=DB::table('tb_users')->select('first_name')->where('id',$vv)->get();
		           if(count($use)>0){
		            $firstname.=$use[0]->first_name.',';
		               
		           }
		        }   
		        $data[$k]->techname=$firstname;
		        
		        }else{
		            $data[$k]->techname="";
		        }
		        
		    }
			$returndata['message']="success";
			$returndata['token']=$token;
		}else{
			$returndata['message']="success";
			$returndata['token']=$token;
		}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		}else{
        $returndata['message']="failure";
        }
	    
	}else{
        $returndata['message']="failure";
        }
		return $returndata;
	}
	
		public function notificationlist(Request $request){
	    
		$posted_data= $request->json()->all();
		$returndata=array();
        if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token']){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$userid = $user_details->id;
     	$id = $user_details->id;
    
		$data = DB::table('notifications_t')->select('*')->where('user_id',$userid)->orderBy('notifications_t.notification_id', 'desc')
		->get();
		$data1 = DB::table('notifications_t')->select('*')->where('user_id',$userid)->where('read/unread','unread')->orderBy('notifications_t.notification_id', 'desc')
		->get();
		
		foreach($data as $kk=>$vv){
		 $str = $vv->description;
// dd($str);
        //  preg_match('/TICKET\s*(\d+)/', $str, $matches);
		//  dd( $matches);
        //  $data[$kk]->ticket_number = (int)$matches[1];
		 $data[$kk]->ticket_number = $str;
		 }   
		if (count($data)>0) {
		    $returndata['token']=$token;
			$returndata['message']="success";
		}else{
		    $returndata['token']=$token;
			$returndata['message']="success";
		}
			if (count($data1)>0) {
			$returndata['count']=count($data1);
			}else{
			$returndata['count']="0";
			}
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		}else{
         $returndata['message']="failure";
         }
		 
		}else{
        $returndata['message']="failure";
        }
		return $returndata;
	}

	public function getalldata(Request $request)
	{
	    $posted_data= $request->json()->all();
	    $returndata=array();
	    if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token']){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
        $dept = $user_details->machine_department_id;
		$locid = $user_details->loc_id;
		$loc_cond=[];
		$loc_cond_usr = [];
		if($locid!=0){
			$loc_cond=[['location_id','=',$locid]];
			$loc_cond_usr=[['loc_id','=',$locid]];
		}
		$dept_cond=[['department_id','=',$dept]];
		
		$data1 = DB::table('ma_department_t')->select('department_id','department_name')->where($loc_cond)->where($dept_cond)->orderBy('department_name', 'asc')->get();
		$returndata['department']=collect($data1)->map(function($x){ return (array) $x; })->toArray();
		$data2 = DB::table('machine_hdr_t')->select('machine_id','department_id','machine_name')->where($loc_cond)->where($dept_cond)->orderBy('machine_name', 'asc')->get();
		$returndata['machine']=collect($data2)->map(function($x){ return (array) $x; })->toArray();
		$data3 = DB::table('m_breakdowntype_t')->select('breakdowntype_id','breakdown_name')->where($loc_cond)->orderBy('breakdown_name', 'asc')->get();
		$returndata['breakdowntype']=collect($data3)->map(function($x){ return (array) $x; })->toArray();
		$data4 = DB::table('breakdown_severity')->select('breakdownseverity_id','severity_name')->where($loc_cond)->orderBy('severity_name', 'asc')->get();
		$returndata['breakdown_severity']=collect($data4)->map(function($x){ return (array) $x; })->toArray();
		$data7 = DB::table('maintanance_type')->select('maintanance_name as mt_id','maintanance_name')->orderBy('maintanance_name', 'asc')->get();
		$returndata['maintenance']=collect($data7)->map(function($x){ return (array) $x; })->toArray();
		$data5 = DB::table('tb_users')->join('ma_department_t','ma_department_t.department_id','=','tb_users.machine_department_id')->select('id','first_name as username')->where('ma_department_t.is_technician','Yes')->where($loc_cond_usr)->orderBy('username', 'asc')->get();
		$returndata['users']=collect($data5)->map(function($x){ return (array) $x; })->toArray();
		$data6 = DB::table('m_spares_t')->select('spares_id','spares_name')->where($loc_cond)->orderBy('spares_name', 'asc')->get();
		$returndata['spares']=collect($data6)->map(function($x){ return (array) $x; })->toArray();
		$data7 = DB::table('shift_timing')->select('shift_id','shift_name','start_time','end_time')->orderBy('shift_name', 'asc')->get();
		$returndata['shift']=collect($data7)->map(function($x){ return (array) $x; })->toArray();
	/*	$returndata['maintenance'][0]['name'] ='Machine';
		$returndata['maintenance'][1]['name'] ='Facility';*/
		$returndata['message']="success";
		$returndata['token']=$token;
       }else{
        $returndata['message']="success";
        }
	        
	    }else{
        $returndata['message']="failure";
        }
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
	  //  dd("dfsd");
		$posted_data= $request->json()->all();
		
		$data=array();
	 	if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
	 
        if($posted_data['token'])
         {
      
		$token = $posted_data['token'];
	//	dd($token);
		$user_details = $this->getTokenUser($token);
	//	dd($user_details);
 		$id = $user_details->id;
        $locid = $user_details->loc_id;

		 $seqno = $this->ticket_seq_no("TICKET-".$locid."-",$locid, 'b_maintenance_t','ticket_count');
		 
		$out_put[0] = $seqno[0];
		$out_put[1] = $seqno[1];
		$datas=array();
		
		$count=array();

		$issue = \DB::table('b_maintenance_t')->where('machine_id',$posted_data['machine_id'])->where('request_status','!=','CLOSED')->get();
		if(count($issue)<=0){
		
		if(isset($posted_data['id'])){
			$datas['id']=$posted_data['id'];
			$get = \DB::table('b_maintenance_t')->where('id',$posted_data['id'])->get();
			$machine = \DB::table('machine_hdr_t')->where('machine_id',$posted_data['machine_id'])->get();
			$ticket_number=$get[0]->ticket_number;
			$machine_number=$machine[0]->machine_name;
			$emp_name=$user_details->employee_number;
            
		}else{
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                  
                  if(preg_match("/^$regex$/i", $posted_data['causes'])) // `i` flag for case-insensitive
                  {
                        $returndata['message']="Causes Is Invalid Input";
                    return $returndata;
                  }
             
                  if (str_contains($posted_data['causes'], 'script')) { 
                          $returndata['message']="Causes contains script.";
                    return $returndata;
                  }
                  if (str_contains($posted_data['causes'], 'Calc')) { 
                          $returndata['message']="Causes Is Invalid Input.";
                    return $returndata;
                  }
              
		    $datas['department_id']=$posted_data['department_id'];
		    $datas['machine_id']=$posted_data['machine_id'];
		    $datas['break_type_id']=$posted_data['breakdown_id'];
		    $datas['issue_date']=date("Y-m-d h:i:sa", strtotime($posted_data['issue_date']));
			$datas['issue_date']=date('Y-m-d H:i:s');
		    $datas['breakdown_sevearity']=$posted_data['breakdown_severity_id'];
		    $datas['causes']=$posted_data['causes'];
		    $datas['maintenance_type']=$posted_data['maintenance_type_id'];
		    $datas['issue_created_on']=date('Y-m-d H:i:s');
		    $datas['issue_created_by']=$user_details->id;
		    $datas['company_id']=$user_details->company_id;
		    $datas['location_id']=$user_details->loc_id;
		    $datas['request_status']=$posted_data['request_status'];
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

		}
		if(isset($posted_data['assignengg_id'])){	    
			$datas['engineer']=$posted_data['assignengg_id'];
		    $datas['request_status']=$posted_data['request_status'];

			$get = \DB::table('b_maintenance_t')->where('id',$posted_data['id'])->get();
			$machine = \DB::table('machine_hdr_t')->where('machine_id',$posted_data['machine_id'])->get();
			$ticket_number=$get[0]->ticket_number;
			$machine_number=$machine[0]->machine_name;
			$emp_name=$user_details->employee_number;
			$created_by = \DB::table('tb_users')->where('id',$user_details->id)->get();

			
			// $notification['body']="Ticket Assigned By"." - ".$created_by[0]->username;
			// $notification['title']=$ticket_number." - ".$machine_number;
			// $notification['icon']="";
			// $notification['sound']="default";
			// $count['body']="Ticket Assigned";
			// $count['title']=$ticket_number;
			// $count['count']="28";
			// $count['sound']="default";
			// $fcm_data=\DB::select("select * from tb_users where id='".$datas['engineer']."'");
			// if(count($fcm_data)>0){
			// 	$id_notiy='';
			// 	foreach($fcm_data as $key=>$value){
			// 		$id_notiy.=$value->id.',';    
			// 	}
			// 	$id_notiy=rtrim($id_notiy, ',');
			// 	$noti_msg = "Ticket Assigned ".$ticket_number." - ".$machine_number;
			// 	$this->sendPopUpHomeNoty($datas['id'],"Ticket Assigned",$noti_msg,"engineerallocate",$id_notiy,$user_details->id,'requestraise');
			// }
			// $msg1[]=$this->fcmMsgNotifications($fcm_data[0]->fcm_token,$notification,$count);
		}else{
			$datas['engineer']='';
		}
		if(isset($posted_data['assign_technician_id'])){
			$eng_hist['technician'] = $datas['technician']=json_encode($posted_data['assign_technician_id']);
			$eng_hist['engineer'] = $datas['engineer']=$posted_data['assign_technician_id'][0];
			$datas['request_status'] = $posted_data['request_status'];
			$eng_hist['created_at'] = $datas['allocate_engineer_on']=date('Y-m-d H:i:s');
			
			$noti_msg = "Ticket Allocated Successfully - ". $ticket_number;
            $noti_msg1 = "Breakdown Ticket Allocated Successfully for the machine ".$machine_number." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($datas['allocate_engineer_on']))." by ".$this->getusername($user_details->id);
            $module = "ticket_allocated";
		}else if(isset($posted_data['reassign_technician_id'])){
			$eng_hist['technician'] = $datas['technician']=json_encode($posted_data['reassign_technician_id']);
			$eng_hist['engineer'] = $datas['engineer']=$posted_data['reassign_technician_id'][0];
			$datas['request_status'] = $posted_data['request_status'];
			$eng_hist['created_at'] = $datas['allocate_engineer_on']=date('Y-m-d H:i:s');
			
			$noti_msg = "Ticket Reallocated Successfully - ". $ticket_number;
            $noti_msg1 = "Breakdown Ticket Reallocated Successfully for the machine ".$machine_number." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($datas['allocate_engineer_on']))." by ".$this->getusername($user_details->id);
            $module = "ticket_allocated";
		}else{
			$datas['technician']='';
			
			$noti_msg = "";
            $noti_msg1 = "";
            $module = "";
		}
		
		if($datas['id']=="")
		{
			$datas['created_at'] = date('Y-m-d');
			// dd($datas);
			$id=DB::table('b_maintenance_t')->insertGetId($datas);
			$edit_id = $id;
			$noti_msg = "Ticket Generated Successfully - ". $ticket_number;
			$noti_msg1 = "Breakdown Ticket Generated Successfully for the machine ".$machine_number." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($datas['issue_created_on']))." by ".$this->getusername($user_details->id);
			$module = "ticket_generate";
		}else{
			
		$eng_hist['created_by'] = $user_details->id;
		$eng_hist['organization_id']=$user_details->org_id;
		$eng_hist['location_id']=$user_details->loc_id;
		$eng_hist['company_id']=$user_details->company_id;
		
		$hist_ins = \DB::table('engineer_history_tbl')->insert($eng_hist);

			$datas['updated_at'] = date('Y-m-d');
			DB::table('b_maintenance_t')
			->where('id',$datas['id'])
			->update($datas);
			$edit_id = $datas['id'];

			// $noti_msg = "Ticket Allocated Successfully - ". $ticket_number;
			// $noti_msg1 = "Breakdown Ticket Allocated Successfully for the machine ".$machine[0]->machine_name." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($datas['allocate_engineer_on']))." by ".$this->getusername($user_details->id);
			// $module = "ticket_generate";
		}
			// $mailto = $this->getNotySettings($user_details->loc_id,$posted_data['department_id'],$module);
							
			// 			if($mailto['to']!=''){
			// 			$mto = $mailto['to'];
			// 			}else{
			// 			$mto = $_POST['engineer'];
			// 			}
			// 			if($mailto['cc']!=''){
			// 			$mcc = $mailto['cc'];
			// 		}else{
			// 			$mcc = '';
			// 		}
			// 		$mto = rtrim(($mto.','.$mcc),',');

			$not_data['location'] = $user_details->loc_id;
			$not_data['dept_id'] = $posted_data['department_id'];
			$not_data['module'] = $module;
			$not_data['edit_id'] = $edit_id;
			$not_data['noti_msg'] = $noti_msg;
			$not_data['noti_msg1'] = $noti_msg1;
			$not_data['user'] = $user_details->id;
			$not_data['btn_val'] = 'requestraise';
			$not_data['created_at'] = date('Y-m-d H:i:s');
			$not_data['location_id'] = $user_details->loc_id;
			$not_data['organization_id'] = $user_details->org_id;
			$not_data['created_by'] = $user_details->id;
			$not_data['created_at'] = date('Y-m-d H:i:s');
			$not_data['status'] = 0;

			$not_save = \DB::table('pending_noti_t')->insert($not_data);

					
					
					// //  $noti_msg = "Allocated Successfully ". $_POST['ticket_number']." - ".$data_machine[0]->machine_name;
					// 	$this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_generated',"engineerallocate",$mto,$mcc,$user_details->id,'requestraise');
					// // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"engineerallocate",$mto,$mcc,\Session::get('id'),'requestraise');
					
					// 	$fcm_data = \DB::select("select * from tb_users where id in ($mto)");

					// 	$count['body'] = $notification['body']=$noti_msg1;
					// 	$count['title'] = $notification['title']=$noti_msg;
					// 	$notification['icon']="";
					// 	$count['sound'] = $notification['sound']="default";
					// 	$count['count']="28";

					// 	foreach ($fcm_data as $key => $val) {
					// 		$msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
					// 	}

		$data['ticket']= $ticket_number;
		$data['message']="Success";
		$data['token']=$token;
         }else{
          $data['message']="Machine already in breakdown";
        }
	}else{
		$data['message']="failure";
	}
	}else{
        $returndata['message']="failure";
    }
		return $data;

	}

	public function getassigndetails(Request $request)
	{
		$posted_data= $request->json()->all();
		if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token']){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$locid = $user_details->loc_id;
		
		$returndata=array();
		$data['data']=DB::table('b_maintenance_t')->where('id','=',$posted_data['id'])->get();
	
		if (count($data)>0) {
			$data['message']="success";
		}else{
			$data['message']="success";
		}
		}else{
          $data['message']="failure";
        }
		    
		}else{
        $returndata['message']="failure";
        }
		return $data;

	}

	public function requestticket(Request $request)
	{
		$posted_data= $request->json()->all();
		$data1=array();
	   if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
       if($posted_data['token'])
        {
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$ids = $user_details->id;
    
		$id=$posted_data['id'];
		$data=array();
		
		$data['request_status']=$posted_data['request_status'];
		if(isset($posted_data['request_remark'])){
		      $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                  
                  if(preg_match("/^$regex$/i", $posted_data['request_remark'])) // `i` flag for case-insensitive
                  {
                        $returndata['message']="Causes Is Invalid Input";
                    return $returndata;
                  }
             
                  if (str_contains($posted_data['request_remark'], 'script')) { 
                          $returndata['message']="Causes contains script.";
                    return $returndata;
                  }
                  if (str_contains($posted_data['request_remark'], 'Calc')) { 
                          $returndata['message']="Causes Is Invalid Input.";
                    return $returndata;
                  }
                  
			$data['request_remark']=$posted_data['request_remark'];
		}if(isset($posted_data['repair_start_date'])){
			$data['start_date']=$posted_data['repair_start_date'];
		}if(isset($posted_data['repair_end_date'])){
			$data['end_date']=$posted_data['repair_end_date'];
		}
		if(isset($posted_data['approve_remark']))
		{
			if(isset($posted_data['approve_remark'])){
			    
			     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                  
                  if(preg_match("/^$regex$/i", $posted_data['approve_remark'])) // `i` flag for case-insensitive
                  {
                        $returndata['message']="Causes Is Invalid Input";
                    return $returndata;
                  }
             
                  if (str_contains($posted_data['approve_remark'], 'script')) { 
                          $returndata['message']="Causes contains script.";
                    return $returndata;
                  }
                  if (str_contains($posted_data['approve_remark'], 'Calc')) { 
                          $returndata['message']="Causes Is Invalid Input.";
                    return $returndata;
                  }
			    
				$data['approve_remarks']=$posted_data['approve_remark'];
			}
			$data['request_approve_by']=$user_details->id;
			$data['request_approve_on']=date("Y-m-d H:i:s");
		}else{
			$data['request_request_by']=$user_details->id;
			$data['request_request_on']=date("Y-m-d H:i:s");
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
			$module='ticket_approved';
			$noti_msg = "Ticket Closure Request Approved Successfully -". $ticket_number;
		   $noti_msg1 = "Breakdown Ticket Closure Request Approved Successfully for the machine ".$machine_number." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($data['request_approve_on']))." by ".$this->getusername($user_details->id);
		   $btnval = "closerequest";
		}
		else{
			$notification['body']="Ticket Requested By"." - ".$created_by[0]->username;
			$count['body']="Ticket Requested";  
			$module='ticket_requested'; 
			$noti_msg = "Ticket Closure Requested Successfully - ". $ticket_number;
			$noti_msg1 = "Breakdown Ticket Closure Requested Successfully for the machine ".$machine_number." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($data['request_request_on']))." by ".$this->getusername($user_details->id);
			$btnval = "requestraise"; 
		}

		$breakdown = \DB::table('b_maintenance_t')->where('id',$id)->get();
// dd($breakdown);
		$not_data['location'] = $user_details->loc_id;
		$not_data['dept_id'] = $breakdown[0]->department_id;
		$not_data['module'] = $module;
		$not_data['edit_id'] = $id;
		$not_data['noti_msg'] = $noti_msg;
		$not_data['noti_msg1'] = $noti_msg1;
		$not_data['user'] = $user_details->id;
		$not_data['btn_val'] = $btnval;
		$not_data['created_at'] = date('Y-m-d H:i:s');
		$not_data['location_id'] = $user_details->loc_id;
		$not_data['organization_id'] = $user_details->org_id;
		$not_data['created_by'] = $user_details->id;
		$not_data['created_at'] = date('Y-m-d H:i:s');
		$not_data['status'] = 0;
// dd($not_data);
		$not_save = \DB::table('pending_noti_t')->insert($not_data);

		// $notification['title']=$ticket_number." - ".$machine_number;
		// $notification['icon']="";
		// $notification['sound']="default";

		// $count['title']=$ticket_number;
		// $count['count']="28";
		// $count['sound']="default";

					
		// 	$mailto = $this->getNotySettings($user_details->loc_id,$posted_data['department_id'],$module);
             
		// 	if($mailto['to']!=''){
		// 	  $mto = $mailto['to'];
		// 	}else{
		// 	  $mto = $_POST['engineer'];
		// 	}
		// 	if($mailto['cc']!=''){
		// 	 $mcc = $mailto['cc'];
		//    }else{
		// 	 $mcc = '';
		//    }
		//    $mto = rtrim(($mto.','.$mcc),',');
		//    $noti_msg = "Ticket Generated Successfully - ". $ticket_number;
		//    $noti_msg1 = "Breakdown Ticket Generated Successfully for the machine ".$machine[0]->machine_name." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($datas['issue_created_on']))." by ".$this->getusername($user_details->id);
		   
		//    //  $noti_msg = "Allocated Successfully ". $_POST['ticket_number']." - ".$data_machine[0]->machine_name;
		// 	$this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,$noti_msg1,'ticket_generated',"engineerallocate",$mto,$mcc,$user_details->id,'requestraise');
		//    // $this->sendPopUpHomeNoty($edit_id,"Ticket Generate",$noti_msg,"engineerallocate",$mto,$mcc,\Session::get('id'),'requestraise');
		   
		// 	 $data['allocate_technician_by'] = \Session::get('id');
		   
		// 	 $fcm_data = \DB::select("select * from tb_users where id in ($mto)");

			 
        //      $count['body'] = $notification['body']=$noti_msg1;
        //      $count['title'] = $notification['title']=$noti_msg;
        //      $notification['icon']="";
        //      $count['sound'] = $notification['sound']="default";
        //      $count['count']="28";

		// 	foreach ($fcm_data as $key => $val) {
		// 		$msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
		// 	}


		// $fcm_data = \DB::select("select * from tb_users where machine_department_id='".$get[0]->department_id."'");
		// foreach ($fcm_data as $key => $val) {
		// 	$msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
		// }
		// if(count($fcm_data)>0){
		// 	$id_notiy='';
		// 	foreach($fcm_data as $key=>$value){
		// 		$id_notiy.=$value->id.',';    

		// 	}
		// 	$id_notiy=rtrim($id_notiy, ',');
		// 	if(isset($posted_data['approve_remark']))
		// 	{
		// 		$noti_msg = "Ticket Approved ".$ticket_number." - ".$machine_number;
		// 		$this->sendPopUpHomeNoty($posted_data['id'],"Ticket Generate",$noti_msg,"engineerallocate",$id_notiy,$user_details->id,'closerequest');
		// 	}else{
		// 		$noti_msg = "Ticket Requested ".$ticket_number." - ".$machine_number;  
		// 		$this->sendPopUpHomeNoty($posted_data['id'],"Ticket Generate",$noti_msg,"engineerallocate",$id_notiy,$user_details->id,'approverequest');
		// 	}

		// }
		DB::table('b_maintenance_t')
		->where('id',$id)
		->update($data);
		$data1['status']=$data['request_status'];
		$data1['message']="Success";
		$data1['token']=$token;
        }else{
        $data1['message']="failure";
         }
	    
	}else{
        $returndata['message']="failure";
        }
		return $data1;

	}
	public function closeticket(Request $request)
	{
		$posted_data= $request->json()->all();
		$data1=array();
		if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
        if($posted_data['token'])
        {
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$ids = $user_details->id;
        
		$id=$posted_data['id'];
		$data=array();
		$data['critical_spare']=$posted_data['critical_spares_used'];
		$data['preventive_action']=$posted_data['preventive_action'];
		$data['corrective_action']=$posted_data['corrective_action'];
		
		 $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5}?)?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                  
                  if(preg_match("/^$regex$/i", $data['critical_spare'])) // `i` flag for case-insensitive
                  {
                        $returndata['message']="Critical Spare Is Invalid Input";
                    return $returndata;
                  }
             
                  if (str_contains($data['critical_spare'], 'script')) { 
                          $returndata['message']="Critical Spare contains script.";
                    return $returndata;
                  }
                  if (str_contains($data['critical_spare'], 'Calc')) { 
                          $returndata['message']="Critical Spare Is Invalid Input.";
                    return $returndata;
                  }
        
                  if(preg_match("/^$regex$/i", $data['preventive_action'])) // `i` flag for case-insensitive
                  {
                        $returndata['message']="Preventive Action Is Invalid Input";
                    return $returndata;
                  }
             
                  if (str_contains($posted_data['preventive_action'], 'script')) { 
                          $returndata['message']="Preventive Action contains script.";
                    return $returndata;
                  }
                  if (str_contains($posted_data['preventive_action'], 'Calc')) { 
                          $returndata['message']="Preventive Action Is Invalid Input.";
                    return $returndata;
                  }
               
                  if(preg_match("/^$regex$/i", $posted_data['corrective_action'])) // `i` flag for case-insensitive
                  {
                        $returndata['message']="Corrective Action  Is Invalid Input";
                    return $returndata;
                  }
             
                  if (str_contains($posted_data['corrective_action'], 'script')) { 
                          $returndata['message']="Corrective Action contains script.";
                    return $returndata;
                  }
                  if (str_contains($posted_data['corrective_action'], 'Calc')) { 
                          $returndata['message']="Corrective Action Is Invalid Input.";
                    return $returndata;
                  }      
        $data['closed_engineer_on'] = date('Y-m-d H:i:s');
		$data['closed_engineer_by'] = $user_details->id;
		$data['request_status']="CLOSED";
		$id=$posted_data['id'];
		$datas2 = [];
		if($data['critical_spare']=="Yes"){
			$index = 0;
			$spare_qty = 0;
			foreach($posted_data['spares'] as $k=>$v){
				$chk = DB::table('m_spares_t')->where('spares_id',$v['spares_id'])->get();
				$qty=$chk[0]->spare_quantity;
				$spare_qty = $qty-$v['qty'];
				DB::table('m_spares_t')->where('spares_id',$v['spares_id'])->update(['spare_quantity'=>$spare_qty]);	

				$datas2[$index]['spares_id']=$v['spares_id'];
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
		
		$get = \DB::table('b_maintenance_t')->where('id',$posted_data['id'])->get();
		$machine = \DB::table('machine_hdr_t')->where('machine_id',$get[0]->machine_id)->get();
		$ticket_number=$get[0]->ticket_number;
		$machine_number=$machine[0]->machine_name;
		
		$module='close_ticket'; 
		$noti_msg = "Ticket Closure Requested Successfully - ". $ticket_number;
		$noti_msg1 = "Breakdown Ticket Closure Requested Successfully for the machine ".$machine_number." - [". $ticket_number."] on ".date('d-m-Y H:i:s',strtotime($data['closed_engineer_on']))." by ".$this->getusername($user_details->id);
		$btnval = "requestraise"; 

		$breakdown = \DB::table('b_maintenance_t')->where('id',$id)->get();

		$not_data['location'] = $user_details->loc_id;
		$not_data['dept_id'] = $breakdown[0]->department_id;
		$not_data['module'] = $module;
		$not_data['edit_id'] = $id;
		$not_data['noti_msg'] = $noti_msg;
		$not_data['noti_msg1'] = $noti_msg1;
		$not_data['user'] = $user_details->id;
		$not_data['btn_val'] = $btnval;
		$not_data['created_at'] = date('Y-m-d H:i:s');
		$not_data['location_id'] = $user_details->loc_id;
		$not_data['organization_id'] = $user_details->org_id;
		$not_data['created_by'] = $user_details->id;
		$not_data['created_at'] = date('Y-m-d H:i:s');
		$not_data['status'] = 0;

		$not_save = \DB::table('pending_noti_t')->insert($not_data);

		// $get = \DB::table('b_maintenance_t')->where('id',$id)->get();
		// $machine = \DB::table('machine_hdr_t')->where('machine_id',$get[0]->machine_id)->get();
		// $ticket_number=$get[0]->ticket_number;
		// $machine_number=$machine[0]->machine_name;
		// $emp_name=$user_details->employee_number;
		// $created_by = \DB::table('tb_users')->where('id',$user_details->id)->get();

		// $notification['body']="Ticket Closed By"." - ".$created_by[0]->username;
		// $notification['title']=$ticket_number." - ".$machine_number;
		// $notification['icon']="";
		// $notification['sound']="default";
		// $count['body']="Ticket Closed";
		// $count['title']=$ticket_number;
		// $count['count']="28";
		// $count['sound']="default";

		// $fcm_data = \DB::select("select * from tb_users where machine_department_id='".$user_details->department_id."'");
		// foreach ($fcm_data as $key => $val) {
		// 	$msg1[]=$this->fcmMsgNotifications($val->fcm_token,$notification,$count);
		// }
		// if(count($fcm_data)>0){
		// 	$id_notiy='';
		// 	foreach($fcm_data as $key=>$value){
		// 		$id_notiy.=$value->id.',';    

		// 	}
		// 	$id_notiy=rtrim($id_notiy, ',');
		// 	$noti_msg = "Ticket Closed ".$ticket_number." - ".$machine_number;
		// 	$this->sendPopUpHomeNoty($id,"Ticket Generate",$noti_msg,"userview",$id_notiy,$user_details->id,'createissue');
		// }
		
		$data1['status']="CLOSED";
		$data1['message']="Success";
		$data1['token']=$token;
	}else{
          $data1['message']="failure";
        }
	    
	}else{
        $returndata['message']="failure";
        }
		return $data1;
	}
	public function getcloselist(Request $request){
	   
		$posted_data= $request->json()->all();
        $returndata=array();
	if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
         if($posted_data['token'])
        {		
        $token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
        
		$locid = $user_details->loc_id;
		
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
		$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->leftjoin('tb_users as eng','eng.id','=','b_maintenance_t.engineer')->leftjoin('maintanance_type','maintanance_type.maintanance_name','=','b_maintenance_t.maintenance_type')->select('eng.employee_number as engineer_name','b_maintenance_t.technician','b_maintenance_t.start_date','b_maintenance_t.end_date','b_maintenance_t.request_remark','b_maintenance_t.approve_remarks','b_maintenance_t.id','maintanance_type.maintanance_name as maintenance_type','b_maintenance_t.causes','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.start_date','b_maintenance_t.end_date','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.request_status','=','APPROVED')->where('b_maintenance_t.location_id','=',$locid)->where($array)->orWhere($array1)->orWhere($array2)->orWhere($array3)->orderBy('b_maintenance_t.id', 'desc')
		->get();
		if (count($data)>0) {
		    foreach($data as $k=>$v){
		        $firstname="";
		        if($v->technician!=""&&$v->technician!="[]"){
		        $name=json_decode($v->technician);
		       // dd($name);
		        foreach($name as $kk=>$vv){
		            $use=DB::table('tb_users')->select('first_name')->where('id',$vv)->get();
		           if(count($use)>0){
		            $firstname.=$use[0]->first_name.',';
		               
		           }
		        }   
		        $data[$k]->techname=$firstname;
		        
		        }else{
		            $data[$k]->techname="";
		        }
		        
		    }
			$returndata['message']="success";
			$returndata['token']=$token;
		}else{
			$returndata['message']="success";
			$returndata['token']=$token;
		}
			$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
         }else{
         $returndata['message']="failure";
        }
	    
	}else{
        $returndata['message']="failure";
        }
		return $returndata;
	}
	
	
		public function getTicketID(Request $request){
		$posted_data= $request->json()->all();
		$returndata=array();
		if($posted_data['_token']=="#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa"){
		if($posted_data['token']){
		$token = $posted_data['token'];
		$user_details = $this->getTokenUser($token);
		$id = $user_details->id;
       
		$id=$posted_data['id'];
		$notifyid=$posted_data['notification_id'];
		
		$data = DB::table('b_maintenance_t')->leftjoin('ma_department_t','ma_department_t.department_id','=','b_maintenance_t.department_id')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','b_maintenance_t.machine_id')->leftjoin('m_breakdowntype_t','m_breakdowntype_t.breakdowntype_id','=','b_maintenance_t.break_type_id')->leftjoin('breakdown_severity','breakdown_severity.breakdownseverity_id','=','b_maintenance_t.breakdown_sevearity')->leftjoin('tb_users','tb_users.id','=','b_maintenance_t.issue_created_by')->leftjoin('tb_users as eng','eng.id','=','b_maintenance_t.engineer')->select('eng.employee_number as engineer_name','b_maintenance_t.start_date','b_maintenance_t.end_date','b_maintenance_t.request_remark','b_maintenance_t.approve_remarks','b_maintenance_t.id','b_maintenance_t.maintenance_type','b_maintenance_t.causes','b_maintenance_t.issue_date','b_maintenance_t.request_status','b_maintenance_t.start_date','b_maintenance_t.end_date','b_maintenance_t.ticket_number','ma_department_t.department_name','machine_hdr_t.machine_name','m_breakdowntype_t.breakdown_name','machine_hdr_t.asset_code','machine_hdr_t.files as image','breakdown_severity.severity_name','tb_users.employee_number')->where('b_maintenance_t.id','=',$id)->orderBy('b_maintenance_t.id', 'desc')
		->get();
		$returndata['result']=collect($data)->map(function($x){ return (array) $x; })->toArray();
		if (count($data)>0) {
		\DB::update("update notifications_t set `read/unread`='read' where notification_id='$notifyid'");
			$returndata['message']="success";
			$returndata['token']=$token;
		}else{
			$returndata['message']="success";
			$returndata['token']=$token;
		}
		}else{
        $returndata['message']="failure";
        }
		    
		}else{
        $returndata['message']="failure";
        }
		return $returndata;
	}



	public function fcmMsgNotifications($token,$res,$count){
//  define('FIREBASE_API_KEY', 'AAAA-1PGQSU:APA91bFAdX2X4pFZ5kOE2-SMjcTYtmRGS08MTsCbn13nvg4uo5BetO3K3c8mHSmzGZsCM4WLvnK9Rv30N8jExnAvpLe4yySGT9hnERDCbdlz5QMs-oQXoQqNueFf6zMTIRRTcHQztHGA');

		$FIREBASE_API_KEY = 'AAAAoI-4ZqA:APA91bG6QaOhHkey_gqj3mEirm9tGRsJH3mrKK2sVPm68B96XYUVW7jtcVxavZeBl1RLrZAWphWF39lW_5QjN9Stgr-UekcKo2CbkPGN56CspTNvON0u6Nirnx1K4RB22p2n51w9HXI-';

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
		if($posted_data['_token']!=null)
		{
			$date=array();
			if($posted_data['_token']=='e4ae5b782c4506955f10d26af45934cel32n68s98')
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
	
	/*	public function sendMessage(Request $request){
	    $data = [
    'phone' => '919698885142', // Receivers phone
    'body' => 'Hello, vignesh!', // Message
];
$json = json_encode($data); // Encode data to JSON
// URL for request POST /message
$token = 'ybxrbq9bjsu55gj3';
$instanceId = 'instance226057';
$url = 'https://eu29.chat-api.com/instance226057/message?token='.$token;
// Make a POST request
$options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $json
    ]
]);
// Send a request
$result = file_get_contents($url, false, $options);
	}
*/

public function gettoken(Request $request)
{
  // $_token= $request->session()->token();
 //dd($_token);
 $_token= "#2y#10#hwbFRbQAwvWteHTGpg8Y6ey0urfGGxRFan1LOrGf8YXeicA4jtkFa";
//DB::table("");
 $this->data['logtoken']=$_token;
  return $this->data; 
}

public function ticket_seq_no($seqname,$location,$table,$column)
{
	$seqno = \DB::table($table)->where('location_id',$location)->orderBy($column,'desc')->get();

    if(count($seqno)>0)
    {
         $seqno = $count = $seqno[0]->{$column};
    }
    else
    {
        $seqno = $count = 0;
    }

	$y = date('Y');
	$nxt = date('Y',strtotime('+1 year'));
    $seqno = sprintf('%03d',$seqno+1);
    $count = $count+1;
	$out_put[0] = $seqname.$seqno;
    $out_put[1] = $count;

    return $out_put;

}

}

?>
