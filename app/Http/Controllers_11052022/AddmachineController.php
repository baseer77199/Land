<?php

namespace App\Http\Controllers;

use App\addmachine;
use App\addmachinelines;
use Illuminate\Http\Request;
use DB,DateTime;
use Storage;

class AddmachineController extends Controller
{
     /*deepika purpose: construct function to set values throughout the controller like model,submodel,pagemethod*/
	public function __construct()
	{
		$this->data=array();
		$this->model = new addmachine;
		$this->submodel=new addmachinelines;
		$this->data['pageMethod']=\Request::route()->getName();
		$this->data['pageFormtype']='ajax';
		$this->data['pageModule']='addmachine';
		$this->table="machine_hdr_t";
		$this->subtable="machine_lines_t";
		$this->middleware('auth');
        $this->data['urlmenu']=$this->indexs(); 
	}
	/*end*/
    public function index()
    {

		if(	$this->data['pageMethod']=="machinereport"){

		return view('addmachine.reporttable',$this->data);	
		}else{
          return view('addmachine.table',$this->data);
		}
    }
/*deepika purpose:to display material bom */	
	public function getmachineData()
	{
        $wh='';
		
        $compy=\Session::get('companyid');      
        $groupname=\Session::get('groupname');
        // if($groupname=='Superadmin' || $groupname=='Admin'){
        // $wh.='and  v1.company_id='.$compy;  
        // }else{
        //     $wh.='and  v1.company_id='.$compy;      
        // }  
 $loc=\Session::get('location');
    $wh1='';
    if($loc != 0){
 $wh1='and  machine_hdr_t.location_id='.$loc;      
    }
         	if($_GET['_search']=='true'){
			$wh.=$this->jqgridsearchnotab('v1',$_GET['filters']);
		}
		$page = $_GET['page'];
		$limit = $_GET['rows'];
		$sidx = $_GET['sidx'];
		$sord = $_GET['sord'];
		if(!$sidx) $sidx =1;
		$result = \DB::select("select* from(SELECT
machine_hdr_t.company_id,
machine_hdr_t.machine_id,
machine_hdr_t.files,
machine_hdr_t.machine_no,
machine_hdr_t.machine_name,
ma_department_t.department_name,
machine_hdr_t.capacity,
m_location_t.location_name as location,
machine_hdr_t.relocated_date,
machine_hdr_t.purchased_date,
machine_hdr_t.machine_make,
machine_hdr_t.cost,
machine_hdr_t.renewal_date,
machine_hdr_t.from_date,
machine_hdr_t.to_date,
machine_hdr_t.remarks,
machine_hdr_t.created_by,
vendor.vendor_name as vendorname,
tb_users.username,
amc.vendor_name as amcvendor
FROM `machine_hdr_t`
left join ma_department_t on(
ma_department_t.department_id=machine_hdr_t.`department_id`)
 left join m_amc_tb as vendor on(vendor.vendor_id=machine_hdr_t.vendor_id)
  left join tb_users on(tb_users.id=machine_hdr_t.created_by)
  left join m_location_t on(m_location_t.location_id=machine_hdr_t.locationid)
 left join m_amc_tb as amc on(amc.vendor_id=machine_hdr_t.amc_vendor_id ) where 1=1 $wh1 order by machine_hdr_t.machine_id desc)v1 where 1=1 $wh ");
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
		$SQL = "select* from(SELECT
                    machine_hdr_t.company_id,
machine_hdr_t.machine_id,
machine_hdr_t.files,
machine_hdr_t.machine_no,
machine_hdr_t.machine_name,
ma_department_t.department_name,
machine_hdr_t.capacity,
m_location_t.location_name as location,
machine_hdr_t.relocated_date,
machine_hdr_t.purchased_date,
machine_hdr_t.machine_make,
machine_hdr_t.cost,
machine_hdr_t.renewal_date,
machine_hdr_t.from_date,
machine_hdr_t.to_date,
machine_hdr_t.remarks,
machine_hdr_t.created_by,
vendor.vendor_name as vendorname,
tb_users.username,
amc.vendor_name as amcvendor
FROM `machine_hdr_t`
left join ma_department_t on(
ma_department_t.department_id=machine_hdr_t.`department_id`)
 left join m_amc_tb as vendor on(vendor.vendor_id=machine_hdr_t.vendor_id)
  left join tb_users on(tb_users.id=machine_hdr_t.created_by)
  left join m_location_t on(m_location_t.location_id=machine_hdr_t.locationid)
 left join m_amc_tb as amc on(amc.vendor_id=machine_hdr_t.amc_vendor_id) where 1=1 $wh1)v1 where 1=1 $wh ORDER BY v1.machine_id $sord  LIMIT $start , $limit";


    if(isset($_GET['download']))
    {
      $download_SQL=	$SQL = "select* from(SELECT
                    machine_hdr_t.company_id,
machine_hdr_t.machine_id,
machine_hdr_t.files,
machine_hdr_t.machine_no,
machine_hdr_t.machine_name,
ma_department_t.department_name,
machine_hdr_t.capacity,
m_location_t.location_name as location,
machine_hdr_t.relocated_date,
machine_hdr_t.purchased_date,
machine_hdr_t.machine_make,
machine_hdr_t.cost,
machine_hdr_t.renewal_date,
machine_hdr_t.from_date,
machine_hdr_t.to_date,
machine_hdr_t.remarks,
machine_hdr_t.created_by,
vendor.vendor_name as vendorname,
tb_users.username,
amc.vendor_name as amcvendor
FROM `machine_hdr_t`
left join ma_department_t on(
ma_department_t.department_id=machine_hdr_t.`department_id`)
 left join m_amc_tb as vendor on(vendor.vendor_id=machine_hdr_t.vendor_id)
  left join tb_users on(tb_users.id=machine_hdr_t.created_by)
  left join m_location_t on(m_location_t.location_id=machine_hdr_t.locationid)
 left join m_amc_tb as amc on(amc.vendor_id=machine_hdr_t.amc_vendor_id) where 1=1 $wh1)v1 where 1=1 $wh ORDER BY v1.machine_id";
 
// $result1 = \DB::select( $download_SQL );
// print_r($result1);exit();
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }

		$result = \DB::select( $SQL );
		$responce->rows[]='';
		$responce->rows=$result;
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		echo json_encode($responce);
	}
	/*end*/
     /** * Show the form for creating a new resource */
    public function create($id=null)
    {
		if(isset($_POST['id']))    
    $id=$_POST['id'];       
      if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
        /*deepika purpose:to update machine*/
		if($id!='0')
		{   
			$this->data['id'] = $id;
			$this->data['pagemode'] = "edit";
			$table = \DB::table('machine_hdr_t')->where('machine_id',$id)->get();
			$this->data['row'] = $table[0];
			$linestable=\DB::table('machine_lines_t')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','machine_lines_t.machine_id')->where('machine_hdr_t.machine_id',$id)->get();

			

				$this->data['linedata'] = $linestable; 
			if(count($this->data['linedata'] )>0){
			foreach($this->data['linedata'] as $key => $value)
			{


			 $this->data['linedata'][$key]->frequency_date=date("d-m-Y",strtotime($value->frequency_date));

		      $this->data['linedata'][$key]->frequency_id=$this->data['frequency_id'] = $this->jcustomselect('frequency_tbl','frequency_name','frequency_name',$value->frequency_id,'');

		      	}
		      }else{
            $this->data['frequency_id'] = $this->jCombo('frequency_tbl','frequency_name','frequency_name','');

		      }
		       $this->data['locationid'] = $this->jCombologin('m_location_t','location_id','location_name',$table[0]->locationid);
		 $this->data['department_id'] = $this->jCombo('ma_department_t','department_id','department_no|department_name',$table[0]->department_id);
		      			 $this->data['vendor_id'] = $this->jCombo('m_amc_tb','vendor_id','vendor_name',$table[0]->vendor_id);
			 $this->data['amc_vendor_id'] = $this->jCombo('m_amc_tb','vendor_id','vendor_name',$table[0]->vendor_id);
			 $this->data['group_id'] = $this->jCombologin('machine_group_t','group_id','group_name',$table[0]->group_id);
					     $this->data['created_by'] = $this->jCombo('tb_users','id','username',\Session::get('id'));

		} /*end*/
		/*deepika purpose:to create new bom*/
		else{
                    // $loc=\Session::get('location');

			    $this->data['pagemode'] = "create";
		     	$this->modelname = new addmachine();
		   //  	dd($this->modelname);
	        	$this->data['row']= (object)array();
			    $table = $this->modelname->getTableColumns();
		        foreach($table as $key=>$val)
		        {		
		          $this->data['row']->$val='';
		        }
			 $this->data['row']->relocated_date=date('Y-m-d');
			 $this->data['row']->purchased_date=date('Y-m-d');
			 $this->data['row']->renewal_date=date('Y-m-d');
			 $this->data['row']->from_date=date('Y-m-d');
			 $this->data['row']->to_date=date('Y-m-d');
		     $this->data['created_by'] = $this->jCombo('tb_users','id','username',\Session::get('id'));
			 $this->data['linedata'] = array(); 
			 $this->data['department_id'] = $this->jCombo('ma_department_t','department_id','department_no|department_name','');
			 $this->data['vendor_id'] = $this->jCombo('m_amc_tb','vendor_id','vendor_name','');
			 $this->data['locationid'] = $this->jCombologin('m_location_t','location_id','location_name',\Session::get('location'));
			 $this->data['amc_vendor_id'] = $this->jCombo('m_amc_tb','vendor_id','vendor_name','');
			 $this->data['frequency_id'] = $this->jCombo('frequency_tbl','frequency_name','frequency_name','');
			 $this->data['group_id'] = $this->jCombologin('machine_group_t','group_id','group_name','');
			 	}
    }
	//print_r($this->data['linedata']);die;
	       return view("addmachine.form",$this->data);
    }
/*end*/

    
    /** * Store a newly created resource in storage.*/
    public function save(Request $request)
    {

// dd($request);

$todayDate = date('Y-m-d');
$stop_date =  date('Y-m-d', strtotime($todayDate . ' +1 day'));

$validatedData=   $this->validate($request, [
            'machine_no' =>  [
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  
                },
            ],
            'machine_name' => ['required',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'department_id'=>'required|numeric',
            'capacity' => ['nullable','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'asset_code'=> ['required',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'group_id' => 'required|numeric',
            'locationid' => 'required|numeric',
            'created_by' => 'required|numeric',
            'relocated_date' => 'required|date_format:d-m-Y|after_or_equal:'.$todayDate,
            'purchased_date' => 'required|date_format:d-m-Y|after_or_equal:'.$todayDate,
            'machine_make' => [
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'remarks' => [
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'machine_cost' => ['nullable','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'day_working_hrs' => [
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'renewal_date' =>  'required|date_format:d-m-Y|after_or_equal:'.$todayDate,
            'from_date' =>  'required|date_format:d-m-Y|after_or_equal:'.$todayDate,
            'to_date' => 'required|date_format:d-m-Y|after_or_equal:'.$stop_date,
             'vendor_id' => 'nullable|numeric',
              'amc_vendor_id' => 'nullable|numeric',
              'critical' => ['required',
          function($attribute, $value, $fail) {
                 $regex1= "high"; // Anchor 
                 $regex2= "medium"; // Anchor 
                 $regex3= "low"; // Anchor 
             if($regex1==$value || $regex2==$value) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                  //  return $fail($attribute.' is invalid (contains url).');
                  }else{
                     return $fail('Critical invalid Entry.');  
                  }
                  //dd($regex);
                }
          ],
        ]);
        // dd($validatedData);
        // foreach($_POST['counter'] as $key=>$val){
        //     $validatedData1 = $this->validate($_POST,[
                
            
        //     ]);
        // }
    $data = $this->validatePost($request->all(),$this->table,'header');
	  $lines_data = $this->validatePost($request->all(),$this->subtable,'lines'); 

       $id='';
     	
     //print_r($lines_data['rene']);exit();
           $data['relocated_date']=date("Y-m-d",strtotime($data['relocated_date']));
           $data['purchased_date']=date("Y-m-d",strtotime($data['purchased_date']));
           $data['from_date']=date("Y-m-d",strtotime($data['from_date']));
           $data['to_date']=date("Y-m-d",strtotime($data['to_date']));
           $data['renewal_date']=date("Y-m-d",strtotime($data['renewal_date']));
           foreach($lines_data['frequency_date'] as $lk=>$lv){
            //  echo $lv;die;
              $lines_data['frequency_date'][$lk]=date("Y-m-d",strtotime($lv));
           }
           //print_r($lines_data);exit();

			     \DB::beginTransaction();
                try
                {
					if ($_POST['machine_no'] == "") {
            $seqno = $this->Seqnoe('M-', 'machine_hdr_t', '','machine_count');
            $data['machine_no'] = $seqno[0];
            $data['machine_count'] = $seqno[1];
        } else {
            $seqno[0] = $_POST['machine_no'];
        }

    
		              $id=$this->model->insertRow($data);

                     $lid=$this->submodel->subgridSave($lines_data,$id);

 $machine_id=$id;
     	$mac_id = $request->input('machine_id');
				if($mac_id == '')
                {
                    $dataupload="noimg.png";
                	if($request->hasfile('choosefile'))
                    {
                    	$file = $request->file('choosefile');
                        
                            $name=$file->getClientOriginalName();

                            $file->move(public_path().'/upload/machineupload/', $name);  
                            $dataupload = $name;  
                        
                    }
                     $attachfile_name=$dataupload;	
                     // print_r($attachfile_name);
                     // dd($attachfile_name);
                     \DB::update("update machine_hdr_t set files='".$attachfile_name."' where machine_id='$machine_id'");
                }else{

                	$existing_file = $request->input('existing_file');
                    $choose_file = $request->file('choosefile');
                    $existing_file = explode(",",$existing_file);

                    
                    if(count($choose_file)==0 && count($existing_file)>0)
                    {
                        if(count($existing_file) == 1 && $existing_file[0] == ''){
                                          
                                \DB::update("update machine_hdr_t set files='noimg.png' where machine_id='$machine_id'");
                        }
                        else
                        {
                        $get_attach = DB::table('machine_hdr_t')->where('machine_id',$machine_id)->get();
                        $attach_file = json_decode($get_attach[0]->files);
                        $attach_file1 =array();
                    
                        foreach($attach_file as $k=>$v)
                        {
                            $attach_file1[]=$v;
                        }
                        $array_diff = array_diff($attach_file1,$existing_file);
                        
                        if(count($array_diff)>0)
                        {
                            foreach($array_diff as $k =>$v)
                            {
                                 unlink(public_path().'/upload/machineupload/'.$v);  
                            }
                            $attachfile_name=json_encode($existing_file);
                           
                            \DB::update("update machine_hdr_t set files='".$attachfile_name."' where machine_id='$machine_id'");
                        } 
                        }
                    }
                    else if(count($choose_file)>0 && count($existing_file)>0)
                    {
                          
                        $file=$request->file('choosefile');
                       
                            $name=$file->getClientOriginalName();
 
                            $file->move(public_path().'/upload/machineupload/', $name);  
                            $dataupload = $name;  
                       
                        
                        $get_attach = DB::table('machine_hdr_t')->where('machine_id',$machine_id)->get();
                        $attach_file = json_decode($get_attach[0]->files);
                        $attach_file1 =array();
                    
                     /*   foreach($attach_file as $k=>$v)
                        {
                            $attach_file1[]=$v;
                        }
                        
                        $array_diff = array_diff($attach_file1,$existing_file);*/
                        
                      /*  if(count($array_diff)>0)
                        {
                            foreach($attach_file as $k =>$v)
                            {
                                 unlink(public_path().'/upload/machineupload/'.$v);  
                            }
							$attachfile_name = array_merge($existing_file,$dataupload);
                            $attachfile_name = json_encode($attachfile_name);
                        }
                        else
                        {*/
                        	
                            $attachfile_name = $dataupload;
                            $attachfile_name = $attachfile_name;
                        // }
                        \DB::update("update machine_hdr_t set files='".$attachfile_name."' where machine_id='$machine_id'");
                        
                    }
                    else if(count($choose_file)>0 && count($existing_file)==0)
                    {

                        foreach($request->file('choosefile') as $file)
                        {
                            $name=$file->getClientOriginalName();

                            $file->move(public_path().'/upload/machineupload', $name);  
                            $dataupload[] = $name;  
                        }
                        $attachfile_name=json_encode($dataupload);
                        \DB::update("update machine_hdr_t set files='".$attachfile_name."' where machine_id='$machine_id'");
                    }
                }


					/*deepika purpose:insert data in pm machine table*/
					$sql=\DB::select('select * from machine_pm_detail_t where machine_id='.$id);
					if(count($sql)==0){
					foreach($_POST['bulk_frequency_id'] as $k=>$v){
					$bulk_frequency_date=date("Y-m-d",strtotime($_POST['bulk_frequency_date'][$k]));
				if($v=="Daily"){
							$data1['actual_pm_date']=date('Y-m-d', strtotime('+1 day', strtotime($bulk_frequency_date)));
						}else if($v=="Weekly"){
							$data1['actual_pm_date']=date('Y-m-d', strtotime('+7 day', strtotime($bulk_frequency_date)));
						}else if($v=="Monthly"){
							$data1['actual_pm_date']=date('Y-m-d', strtotime('+1 month', strtotime($bulk_frequency_date)));
						}
						else if($v=="Yearly"){
							$data1['actual_pm_date']=date('Y-m-d', strtotime('+1 year', strtotime($bulk_frequency_date)));
						}
						else if("Quartely") {
							$data1['actual_pm_date']=date('Y-m-d', strtotime('+3 month', strtotime($bulk_frequency_date)));
						}
						else {
							$data1['actual_pm_date']=date('Y-m-d', strtotime('+6 month', strtotime($bulk_frequency_date)));
						}
						 $seqno = $this->Seqnoe('PM-', 'machine_pm_detail_t', '','pm_count');
                         $data1['pm_no'] = $seqno[0];
                         $data1['pm_count'] = $seqno[1];
						 $data1['machine_id']=$id;
						 $data1['department_id']=$data['department_id'];
	                     $data1['frequency_id']=$v;
						 \DB::table('machine_pm_detail_t')->insert($data1);
					}
					}
					/*end*/
					/*deepika purpose:audit log*/
					if($_POST['machine_id']==""){
					$action="create";	
					}else{
					$action="update";		
					}
					$this->auditlog($id,"machine",$action,$data,"machine_hdr_t");
					/*end*/
                     \DB::commit();
                     return response()->json(array('status' => 'success', 'message' => 'Saved Successfully','id' => $id,'lid' => $lid,'auto_no'=>$_POST['machine_name']));
                }
                catch (\Illuminate\Database\QueryException $e)
                {
                     $message = explode('(', $e->getMessage());
                     $dbCode = rtrim($message[0], ']');
                     $dbCode = trim($dbCode, '[');
dd($dbCode);
                     \DB::rollback();
                     return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
                }
    }
	/*end*/

    
    public function view($id=null)
    {
         if(isset($_POST['id'])) 
        $id=$_POST['id'];
        if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
          
  	$header = \DB::table('machine_hdr_t')
    ->leftjoin('ma_department_t','ma_department_t.department_id','=','machine_hdr_t.department_id')
    	->leftjoin('m_amc_tb as vendor','vendor.vendor_id','=','machine_hdr_t.vendor_id')
    	 ->leftjoin('tb_users','tb_users.id','=','machine_hdr_t.created_by')
    	 ->leftjoin('m_location_t','m_location_t.location_id','=','machine_hdr_t.locationid')
    	->leftjoin('m_amc_tb as amc','amc.vendor_id','=','machine_hdr_t.amc_vendor_id')
    	->select('machine_hdr_t.*','ma_department_t.department_name','vendor.vendor_name as vendorname','m_location_t.location_name as location','tb_users.username','amc.vendor_name as amcvendor')->where('machine_id',$id)->get();
			$this->data['header'] = $header[0];
			//dd($header);
			$linesdata=\DB::table('machine_lines_t')->leftjoin('machine_hdr_t','machine_hdr_t.machine_id','=','machine_lines_t.machine_id')->where('machine_hdr_t.machine_id',$id)->get();
			//dd($linesdata);
						$this->data['linesdata'] = $linesdata;

    	//$headerdata->sales_order_no 
      	       return view("addmachine.view",$this->data);
  
    }
}
    
    public function assetindex(addmachine $addmachine)
    {
      
        $loc=\Session::get("location");
        $condition='';
        if($loc != 0){
    	 $condition=" and location_id=".$loc;
    	 
        } 
        $this->data['asset_code'] = $this->jCombolocation('machine_hdr_t','machine_id','asset_code','',$condition); 
    	 $this->data['machine_no'] ="";
    	 $this->data['machine_id'] ="";
    	 $this->data['department_id'] ="";
    	 $this->data['locationidold'] =$this->jCombologin('m_location_t','location_id','location_name',''); 
       $this->data['locationid'] = $this->jCombologin('m_location_t','location_id','location_name',''); 
        return view("addmachine.assettable",$this->data);
    }
  public function assetsave(Request $request)
    {
  $validatedData=   $this->validate($request, [
              'asset_code' =>  ['required','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },
            ],
            'locationidold' =>  'required|numeric',
            'locationid' =>  ['required','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },
                ],
                 'machine_id' =>  ['required','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },
            ],   ]);
            
        $currentid=$_POST['locationidold'];
        $newid=$_POST['locationid'];
        $machine_id=$_POST['machine_id'];
        $update=\DB::update("UPDATE machine_hdr_t SET locationid = '$newid' WHERE machine_id='$machine_id' ");
  
  return 1;
    }
    
    public function getmachinetbl($id=null)
    {
       // dd($_GET['machine_id']);
       $id= $_GET['machine_id'];
       if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
        $data11=\DB::select("select m_location_t.location_id from machine_hdr_t left join m_location_t on (m_location_t.location_id = machine_hdr_t.location_id)where machine_id='$id' ");

        $count= count($data11);
        if ($count>0) {
        $location=$data11[0]->location_id;
            return  $location;
        }else
        {
            return 0 ;
        }
}
        	//return $this->data['data11'];  
    }
    public function destroy($id=null)
    {
           $del_id = $id;
      
  if(!is_numeric($del_id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
        $j=0;
        if($j==0)
        {
            $query =\DB::table('machine_hdr_t')->where('machine_id',$del_id)->delete();
            return 0;
           
        }
       
        else if($j == 1)
            return 2;
           }
    }
	
	
//Upload
    public function machineimport()
    {
		//dd(\Session::all());
          $this->data['batch_no'] = $this->jCombologin('hr_emp_upload_details_new_t','batch_no','batch_no','');

       return view('addmachine.machineupload',$this->data);
    }
        public function machineuploadsave(Request $request)
    {
        $datas['uploaded_by'] = \Session::get('empid');
         $datas['date']=$dates['date']=date('Y-m-d');
      
        if (!is_null($request->file('file_upload'))) 
        {		
            $updates = array();
            $file = $request->file('file_upload');
            $files = $request->file('file_upload');
            $destinationPath = '/machineupload/';
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //if you need extension of the file
            $date = new DateTime();
            $fname = $date->getTimestamp();
            $newfilename = $filename.'_'.$fname.'.'.$extension;
            
          //  $uploadSuccess = $file->move($destinationPath, $filename);
            $datas['file_name'] = $newfilename;
            $datas['source'] = "machineimport";
            $id = \DB::table('hr_attendance_import_details_tbl')->insertGetId($datas);
            $path = $_FILES['file_upload']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $data = array();
            $files = $_FILES['file_upload']['tmp_name'];
            $handle = fopen($files, "r");
            $c = 0;
        
      
            if ($ext == "csv") 
            {
                $batch_no=$batch['batch_no']="BATCH_".date('Y-m-d')."_".date('Hi');
                $id = DB::table('hr_emp_upload_details_new_t')->insertGetId(['batch_no' =>$batch_no,'location_id'=>\Session::get('location')]);
             $cantain=0;
                        while (($filesop = fgetcsv($handle, 1000, ",")) !== false) 
                        {
                            if ($c != 0) 
                            {
                                 if($filesop[0]!='')
                                {
                                  if (str_contains($filesop[0], 'script')) { 
                                      $cantain=1;
								  } if (str_contains($filesop[0], '=')) {  
									$cantain=1;
								}
					$regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
					
					
                  if(preg_match("/^$regex$/i", $filesop[0])) // `i` flag for case-insensitive
                  {
                    $cantain=1;                  
				  }  
				for($inc=1;$inc<=21;$inc++){
					if($filesop[$inc]!='')
					{
						if(preg_match("/^$regex$/i", $filesop[$inc])) // `i` flag for case-insensitive
						{
							$cantain=1;                 
						}
						if (str_contains($filesop[$inc], 'script')) { 
							$cantain=1;
						} 
						if (str_contains($filesop[$inc], '=')) {  
							$cantain=1;
						}
					}
				}
						//dd($filesop);		
								$attendencedata['batch_no'] =$batch_no;
								$attendencedata['machine_name']=$filesop[1];
								$attendencedata['department_id']=$filesop[2];
								$attendencedata['machine_no']=$filesop[0];
								//$attendencedata['machine_count']=$filesop[];
								$attendencedata['capacity']=$filesop[3];
								$attendencedata['locationid']=$filesop[6];
								$attendencedata['relocated_date']=date('Y-m-d',strtotime($filesop[7]));
								$attendencedata['purchased_date']=date('Y-m-d',strtotime($filesop[8]));
								$attendencedata['remarks']=$filesop[10];
								$attendencedata['machine_make']=$filesop[9];
								$attendencedata['cost']=$filesop[11];
								//$attendencedata['files']=$filesop[];
								$attendencedata['vendor_id']=$filesop[15];
								$attendencedata['amc_vendor_id']=$filesop[16];
								$attendencedata['from_date']=date('Y-m-d',strtotime($filesop[18]));
								$attendencedata['to_date']=date('Y-m-d',strtotime($filesop[19]));
								$attendencedata['renewal_date']=date('Y-m-d',strtotime($filesop[17]));
								$attendencedata['location_id']=\Session::get('location');
								$attendencedata['company_id']=\Session::get('companyid');
								$attendencedata['organization_id']=\Session::get('organization');
								$attendencedata['created_by']=\Session::get('id');
								//$attendencedata['file_name']=$filesop[];
								$attendencedata['asset_code']=$filesop[4];
								$attendencedata['department_name']=$filesop[2];
								$attendencedata['critical']=$filesop[13];
								$attendencedata['day_working_hrs']=$filesop[14];
								$attendencedata['group_id']=$filesop[5];
								$attendencedata['frequency']=$filesop[20];
								$attendencedata['frequency_date']=date('Y-m-d',strtotime($filesop[21]));
								$attendencedata['batch_comments']='';
								$attendencedata['created_at'] =date('Y-m-d');
                                $attendencedata['batch_status'] ="UPLOADED";
                               // dd($cantain);
                          if($cantain==0)
                          {
                                $id=  \DB::table('m_machine_upload_tbl')->insertGetId($attendencedata);
                          }
                        //   else
                        //   {
                               
                        //  }
                                  // auditlog
                               // $this->auditlog($id,"checklistimport","create",$attendencedata,"checklist_tbl");
                                }    
                               
                              
                                
                            }
                            $cantain=0;
                            $c++;
                             
                        }
                    $file->move(public_path().$destinationPath, $newfilename);  
                    return 1;
                } 
                else 
                {  $file->move(public_path().$destinationPath, $newfilename);  
                    
                    return 2;
                }
                
            
        }
    }
       public function getmachinevalidate(Request $request) 
        {
            
            if (isset($_GET['batchname'])) 
            {
                if (!empty($_GET['batchname'])) 
                {
                    $filter = 'AND hr_emp_upload_details_new_t.batch_no = "' . $_GET['batchname'] . '"';
                    $batch = $_GET['batchname'];
                }
            }
            
            if (isset($_GET['type'])) 
            {
                $type = 'PRODUCTUPLOAD';
                $message['status'] = 'success';
                switch ($_GET['type']) 
                {
                    case 'verify':
                        $upload = $this->uploadValidation($batch, $message);
                        $this->data['status'] = $upload['status'];
                        $this->data['message'] = $upload['message'];
                        return $upload;
                        break;
                    
                    case 'load':$upload = $this->LoadMaster($batch, $message);
                        $this->data['status'] = $upload['status'];
                        $this->data['message'] = $upload['message'];
                        return $upload;
                        break;
                }
            }
        }
   function uploadValidation($batchno, $status) 
    {
    $status['status']='success';
        $status['message'] =' ';
        $sql = "select * from m_machine_upload_tbl where batch_status ='UPLOADED'  and batch_no='".$batchno."'"; 
        $result_pr = \DB::select($sql); 
        if (!empty($result_pr)) 
        { 
            $check=0;
            
            foreach($result_pr as $key=>$value)
            {
                   $status['status'] ='success';
                   $status['message'] =' ';
              
                if(!empty($value->department_id))
                {
                    $checkvalue =$this->checkvalue('ma_department_t',trim($value->department_id),trim($value->locationid),"department_name");
                 
                    if(count($checkvalue)<=0) 
                    {
                        $status['status'] = 'error';
                        $status['message'].= 'Department not exist' . ' ,';
                    }
                }
                else
                {
                    $status['status'] = 'error';
                    $status['message'].= 'Please enter Department' . ' ,';
                  }
               if(!empty($value->locationid))
                {
                    $checkvalue =$this->checkvalue1('m_location_t',trim($value->locationid),"location_name");
                 
                    if(count($checkvalue)<=0) 
                    {
                        $status['status'] = 'error';
                        $status['message'].= 'Location not exist' . ' ,';
                    }
                }
                else
                {
                    $status['status'] = 'error';
                    $status['message'].= 'Please enter Location' . ' ,';
                  }
   if(!empty($value->group_id))
                {
                    $checkvalue =$this->checkvalue('machine_group_t',trim($value->group_id),trim($value->locationid),"group_name");
                 
                    if(count($checkvalue)<=0) 
                    {
                        $status['status'] = 'error';
                        $status['message'].= 'Group not exist' . ' ,';
                    }
                }
                else
                {
                    $status['status'] = 'error';
                    $status['message'].= 'Please enter Group' . ' ,';
                  }
				  
				  
                    if(!empty($value->vendor_id))
                {
                    $checkvalue =$this->checkvalue('m_amc_tb',trim($value->vendor_id),trim($value->locationid),"vendor_name");
                 
                    if(count($checkvalue)<=0) 
                    {
                        $status['status'] = 'error';
                        $status['message'].= 'Vendor not exist' . ' ,';
                    }
                }
                    if(!empty($value->amc_vendor_id))
                {
                    $checkvalue =$this->checkvalue('m_amc_tb',trim($value->amc_vendor_id),trim($value->locationid),"vendor_name");
                 
                    if(count($checkvalue)<=0) 
                    {
                        $status['status'] = 'error';
                        $status['message'].= 'AMC Vendor not exist' . ' ,';
                    }
                }
                    if(!empty($value->frequency))
                {
                    $checkvalue =$this->checkvalue('frequency_tbl',trim($value->frequency),trim($value->locationid),"frequency_name");
                    //print_r($this->checkvalue);
                    if(count($checkvalue)<=0) 
                    {
                        $status['status'] = 'error';
                        $status['message'].= 'Frequency not exist' . ' ,';
                    }
                }
        
                $status['message']=rtrim($status['message'],',');
                              
                if($status['status'] == "error") 
                {
                                    $check=1;
                    $sql = "update m_machine_upload_tbl set batch_status ='ERROR' , batch_comments='" . $status['message'] . "\n'  WHERE machine_id='" . $value->machine_id . "' ";
                    $result = \DB::update($sql);
                    $status['message']='Checklist data have some error';  
                } 
                else
                {
                    $sql = "update m_machine_upload_tbl set batch_status ='VALIDATED' , batch_comments='' where machine_id='" . $value->machine_id . "' ";
                    $result = \DB::update($sql);
                    $status['status']='success';
                    $status['message']='Checklist Data validated successfully';
                }
                
          
        }
        if($check==0){
         return $status;
        }
        else{
            $status['status']='error';
        $status['message'] ='Checklist data have some error';
            return $status;
        }
    }
       $status['status']='error';
        $status['message'] ='NO DATA TO VALIDATE';
         return $status;
    }
      public function machineuploadnewsave(Request $request)
    {
        $validatedData=   $this->validate($request, [
         'department_id' => ['required','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                 
                },
            ],
              'machine_id' => ['required','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                 
                },
            ],
             'frequency_id' => ['required','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                 
                },
            ],
           'checklist_id' => ['required','numeric',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                  
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                 
                },
            ],
        ]);

        $attendencedata['department_id'] =$_POST['department_id'];  
        $attendencedata['machine_id'] =$_POST['machine_id'];  ;  
        $attendencedata['frequency_id'] =$_POST['frequency_id'];  ;
        $attendencedata['checklist_id'] =$_POST['checklist_id'];  ;
        $attendencedata['batch_status'] ="UPLOADED";
        $id=  \DB::table('m_machine_upload_tbl')->where('machine_id',$_POST['machine_id'])->update($attendencedata);
        return response()->json(array('status' => 'success', 'message' => 'Saved Successfully','id' => $_POST['machine_id']));

    }
    public function checkvalue($table,$id,$location,$column){
        $loc = \DB::select("select location_id from m_location_t where (m_location_t.location_name ='$location' or m_location_t.location_code ='$location') ");
        if(count($loc)>0){
          $loc_id = $loc[0]->location_id;
        }else{
          $loc_id=\Session::get('location');
        }
        $data=\DB::SELECT("select * from $table where $column like '%$id%' and location_id = '$loc_id'");
      
       return $data;
    }
    public function checkvalue1($table,$id,$column){
        if($table=='m_location_t'){
          $wh = " and (location_name like '%$id%' or location_code='$id')";
        }else{
          $wh = " and $column like '%$id%'";
        }
        
        
        $data=\DB::SELECT("select * from $table where 1=1 $wh");
      
       return $data;
    }
    
    public function LoadMaster($loadModname, $status){
      //$comnfun = new ProductuploadController;
      $status['status'] = '';
      $status['message'] = '';
      $sql = "select * from m_machine_upload_tbl  where  batch_status ='VALIDATED'  and batch_no='" . $loadModname . "' group by department_id,machine_no,machine_name,asset_code"; 
      $result = \DB::select($sql);
    
      $data=array();
      $loadid=array();
        
      if(count($result)>0)
      { 
        foreach($result  as $key=>$value)
        {
          $sql1 = "select * from m_machine_upload_tbl  where  batch_status ='VALIDATED'  and batch_no='" . $loadModname . "' and department_id='".$value->department_id."' and  machine_name='".$value->machine_name."'  and  asset_code='".$value->asset_code."'"; 
          $result1 = \DB::select($sql1);
                
				  $department_id =$this->checkvalue('ma_department_t',trim($value->department_id),trim($value->locationid),"department_name");
          $location =$this->checkvalue1('m_location_t',trim($value->locationid),"location_name");
          $group =$this->checkvalue('machine_group_t',trim($value->group_id),trim($value->locationid),"group_name");
				  $vendor =$this->checkvalue('m_amc_tb',trim($value->vendor_id),trim($value->locationid),"vendor_name");
				  $amc_vendor =$this->checkvalue('m_amc_tb',trim($value->amc_vendor_id),trim($value->locationid),"vendor_name");
				      
				  $hdr_details['department_id'] = $department_id[0]->department_id;
          $hdr_details['locationid'] = $location[0]->location_id;
				  $hdr_details['group_id'] = $group[0]->group_id;

          if(count($vendor)>0){
            $hdr_details['vendor_id'] = $vendor[0]->vendor_id;
          }
          if(count($amc_vendor)>0){
            $hdr_details['amc_vendor_id'] = $amc_vendor[0]->vendor_id;
          }
				  
				  
				 
				  $hdr_details['machine_name']=$value->machine_name;
				
				  $hdr_details['machine_no']=$value->machine_no;
				  $hdr_details['machine_count']=$value->machine_no;
				  $hdr_details['capacity']=$value->capacity;
				
				  $hdr_details['relocated_date']=$value->relocated_date;
				  $hdr_details['purchased_date']=$value->purchased_date;
				  $hdr_details['remarks']=$value->remarks;
				  $hdr_details['machine_make']=$value->machine_make;
				  $hdr_details['cost']=$value->cost;
				  $hdr_details['files']=$value->files;
				
				  $hdr_details['from_date']=$value->from_date;
				  $hdr_details['to_date']=$value->to_date;
				  $hdr_details['renewal_date']=$value->renewal_date;
				  $hdr_details['location_id']=$user_details['location_id']=$data1['location_id']=$location[0]->location_id;
				  $hdr_details['organization_id']=$user_details['organization_id']=$data1['organization_id']=$value->organization_id;
				
				  $hdr_details['created_by']=$user_details['created_by']=$data1['created_by']=$value->created_by;
				  $hdr_details['created_at']=$user_details['created_at']=$data1['created_at']=$value->created_at;
				  $hdr_details['asset_code']=$value->asset_code;
				  $hdr_details['department_name']=$value->department_name;
				  $hdr_details['critical']=$value->critical;
				  $hdr_details['day_working_hrs']=$value->day_working_hrs;
				 
                 
          $hdr_details['company_id'] =$user_details['company_id']=$data1['company_id'] = \Session::get('companyid');
          $hdr_id = DB::table('machine_hdr_t')->insertGetId($hdr_details);
				 
          foreach($result1  as $key1=>$value1){
              /***************** Load Employee Officia Details ************************************/
            $frequency =$this->checkvalue('frequency_tbl',trim($value1->frequency),trim($value->locationid),"frequency_name");
			     if(count($frequency)>0){

              $user_details['frequency_id'] = $frequency[0]->frequency_name;
              $user_details['frequency_date'] = $bulk_frequency_date= date("Y-m-d",strtotime($value1->frequency_date));
              $user_details['machine_id'] =$hdr_id;
                
              $tb_user = DB::table('machine_lines_t')->insertGetId($user_details);
              $sql = "update m_machine_upload_tbl set batch_status ='LOADED' , batch_comments='' where machine_id='" . $value1->machine_id . "' ";
              $result = \DB::update($sql);

              if($user_details['frequency_id']=="Daily"){
                $data1['actual_pm_date']=date('Y-m-d', strtotime('+1 day', strtotime($bulk_frequency_date)));
              }else if($user_details['frequency_id']=="Weekly"){
                $data1['actual_pm_date']=date('Y-m-d', strtotime('+7 day', strtotime($bulk_frequency_date)));
              }else if($user_details['frequency_id']=="Monthly"){
                $data1['actual_pm_date']=date('Y-m-d', strtotime('+1 month', strtotime($bulk_frequency_date)));
              }else if($user_details['frequency_id']=="Yearly"){
                $data1['actual_pm_date']=date('Y-m-d', strtotime('+1 year', strtotime($bulk_frequency_date)));
              }else if($user_details['frequency_id']=="Quartely") {
                $data1['actual_pm_date']=date('Y-m-d', strtotime('+3 month', strtotime($bulk_frequency_date)));
              }else {
                $data1['actual_pm_date']=date('Y-m-d', strtotime('+6 month', strtotime($bulk_frequency_date)));
              }
              
              $seqno = $this->Seqnoe('PM-', 'machine_pm_detail_t', '','pm_count');
              $data1['pm_no'] = $seqno[0];
              $data1['pm_count'] = $seqno[1];
              $data1['machine_id']=$hdr_id;
              $data1['department_id']=$hdr_details['department_id'];
              $data1['frequency_id']=$user_details['frequency_id'];
              \DB::table('machine_pm_detail_t')->insert($data1);
           }
          }
        }
      
        $data['batch_status']=$data_up['batch_status']='LOADED';
        $this->auditlog($value->machine_id,"machinechecklistimport","update",$data,"m_machine_upload_tbl");
        $status['status']='success';
        $status['message']='Checklist Data Loaded Sucessfully';
        return $status;
        return true;
      }else{
        $sql=\DB::select("select * from m_machine_upload_tbl where batch_no='".$loadModname."'");
        if($sql[0]->batch_status=="UPLOADED"){
          $status['status']='info';
          $status['message']='Pls Validate the Batch First..!';
          return $status;
        }else if($sql[0]->batch_status=="ERROR"){
          $status['status']='error';
          $status['message']='Batch Error..!';
          return $status;
        }else{
          $status['status']='info';
          $status['message']='Checklist  Data already Loaded';
          return $status;
        }
      }
    }
    
      public function getmachineuploaddata()
    {
        $wh='';
        

        if(isset($_GET['_search']))
        {   
        if($_GET['_search']=='true')
        {
        $wh=$this->jqgridsearch('m_machine_upload_tbl',$_GET['filters']);
        }
        }
            
        if(isset($_GET['batchname'])){
        if($_GET['batchname']!=""){
        $wh= " and batch_no like '" . $_GET['batchname'] . "'";   
        }}
            //print_r($wh);die;
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        
        if(!$sidx) $sidx =1;
        $result = \DB::select("SELECT COUNT(machine_id) AS count FROM m_machine_upload_tbl where 1=1 $wh");
        $count = $result[0]->count;
        if( $count > 0 && $limit > 0) {
        $total_pages = ceil($count/$limit);
        } else {
        $total_pages = 0;
        }

        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;
        if($start <0) $start = 0;

        $SQL = "SELECT * from m_machine_upload_tbl where 1=1 $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        $result = \DB::select($SQL);
        $responce->rows[]='';
        $responce->rows=$result;
        $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;

        echo json_encode($responce);

    }
    public function checklistuploaddelete($del_id=null)
    {
       
       if(!is_numeric($del_id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
      $data= DB::table('m_machine_upload_tbl')->where('machine_id',$del_id)->get();
            $query = DB::table('m_machine_upload_tbl')->where('machine_id',$del_id)->delete();
              // auditlog
              $this->auditlog($del_id,"machinechecklistimport","delete",$data[0],"m_machine_upload_tbl");
                  return 0;
    }
    }
    public function checklistuploadedit($id = null) {
if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
             $this->data['id'] = $id;
             $table = \DB::table('m_machine_upload_tbl')->where('machine_id', $id)->get();
             
             $this->data['batch_comments'] = $table[0]->batch_comments;
             $this->data['department_id']=$this->jCombo('ma_department_t','department_name','department_name',$table[0]->department_id);
             $this->data['machine_id']=$this->jCombologin('machine_hdr_t','machine_name','asset_code|machine_name',$table[0]->machine_id);
             $this->data['frequency_id']=$this->jCombologin('frequency_tbl','frequency_name','frequency_name',$table[0]->frequency);
            
       return view('addmachine.uploadform',$this->data);
    }
    }
   
}
