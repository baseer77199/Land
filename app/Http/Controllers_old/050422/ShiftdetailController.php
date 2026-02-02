<?php

namespace App\Http\Controllers;

use App\Shiftdetail;
use Illuminate\Http\Request;
use DB,DateTime;
class ShiftdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	/** Page Loading function **/

   public function __construct(){
        $this->data=array();
        $this->data['pageModule']=\Request::route()->getName();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
                $this->data=array(
                    'pageModule'=> \Request::route()->getName(),
                    'pageUrl'   =>  url($this->data['pageMethod']),
            'pageMethod'=>$this->data['pageMethod']
                  );
                $this->data['urlmenu']=$this->indexs(); 
              
      
        $this->data['pageFormtype']='ajax';
      
    }


// shift index load
    public function index()
    {
    	$this->data['pageMethod']=\Request::route()->getName();
    	$this->data['urlmenu']=$this->indexs();
        return view('shifttimings.form',$this->data);
    }

    

   /** Shiftiming Save Start **/
    public function store(Request $request)
    {
      //  $this->offsetSet('curr_date',date('Y-m-d H:i:s'));
        $todayDate = date('Y-m-d H:i:s');
          
           $stop_date =  date('Y-m-d H:i:s', strtotime($todayDate . ' +1 day'));
$validatedData=   $this->validate($request, [
           
            'shift_name' => ['required',
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
            'start_time' => 'required|date_format:Y-m-d H:i:s|before_or_equal:'.$todayDate,
            'end_time' => 'required|date_format:Y-m-d H:i:s|after_or_equal:start_time|before_or_equal:'.$stop_date
            ]);
        //   $validatedData=   $this->validate($request, [
        //     'shift_name' => 'required',
        //     'start_time' => 'required|date_format:Y-m-d H:i:s|before_or_equal:'.$todayDate,
        //     'end_time' => 'required|date_format:Y-m-d H:i:s|after_or_equal:start_time|before_or_equal:'.$stop_date
        // ]);
        
		$edit_id = $request->input('edit_id');
		if($edit_id == '')
		{
			$shifttimings = new Shiftdetail();
			$shifttimings->shift_name = $request->input('shift_name');
                        $start= new DateTime($request->input('start_time'));
			$shifttimings->start_time = $start->format("Y-m-d H:i:s");
                         $end= new DateTime($request->input('end_time'));
			$shifttimings->end_time = $end->format("Y-m-d H:i:s");
			$shifttimings->save();
			$id = $shifttimings->shift_id; 
			// auditlog
			$this->auditlog($id,"Shift Timing","create",$_POST,"shift_timing");
            return 1;
		}
		else
		{
				
			$shifttimings  = Shiftdetail::findOrFail($edit_id);
    		        $input = $request->all();
                       
                         $start= new DateTime($request->input('start_time'));
			$input['start_time'] = $start->format("Y-m-d H:i:s");
                         $end= new DateTime($request->input('end_time'));
			$input['end_time'] = $end->format("Y-m-d H:i:s");
			$shifttimings->fill($input)->save();
			// auditlog
			$this->auditlog($edit_id,"Shift Timing","Update",$_POST,"shift_timing");
            return 2;
		}
    }
	/** Shiftiming Save End **/
	
	/** Jqgrid Shiftiming Load data Start **/
	public function ShiftdetailControllergriddata()
	{
    	$wh='';
		$page = $_GET['page'];
		$limit = $_GET['rows'];
		$sidx = $_GET['sidx'];
		$sord = $_GET['sord'];
		$search_tables=[""];
       if($_GET['_search']=='true'){
         $wh=$this->jqgridsearch("shift_timing",$_GET['filters'],$search_tables);
       }
       
	if(!$sidx) $sidx =1;
        
	$result = \DB::select("SELECT COUNT(shift_id) AS count FROM shift_timing where 1=1 $wh");
	$count = $result[0]->count;
	if( $count > 0 && $limit > 0)
	{
		$total_pages = ceil($count/$limit);
	}
	else
	{
            $total_pages = 0;
	}

	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit;
	if($start <0) $start = 0;
	
	$SQL = "SELECT *
			FROM
			shift_timing
			 WHERE 1 = 1 $wh ORDER BY $sidx $sord LIMIT $start,$limit";
		
			
       
			$result = \DB::select($SQL);
			$responce->rows[]='';
			$responce->rows=$result;
			$responce->page = $page;
			$responce->total = $total_pages;
			$responce->records = $count;

			echo json_encode($responce);

	}
	/** Jqgrid Shiftiming Load data End **/

	/** Shiftiming Delete data Start **/
    public function delete(Request $request)
    {
       $del_id = $_GET['del_id'];
    	$j=0;
       
        if($j==0)
        {
			$query = \DB::table('shift_timing')->where('shift_id',$del_id)->delete();
			// auditlog
			$this->auditlog($del_id,"Shift Timing","Delete",$query,"shift_timing");
        }
       
        if($j == 1)
            return 1;
        else if($j == 0)
            return 2;
        else if($j == 3)
            return 3;
	}
	/** Shiftiming Delete data End **/

	  /** Shift Timing duplicate name check start**/
      public function getCheckname(Request $request)
    {
       //dd('asd');
        $edit_id = $_GET['edit_id'];
  
        
        if($edit_id == ''){
            $department=DB::table('shift_timing')->where('shift_name','like',$_GET['shift_name'])->get();
		}
        else
        {              
            $whereData = [['shift_name','like',$_GET['shift_name']],['shift_id', '!=', $edit_id]];
            $department=DB::table('shift_timing')->where($whereData)->get();
        }
       
        if(count($department)>0)
            return 1;
        else
            return 0;
        
        
    }
// ot index load
        public function otindex()
    {
           $this->data['pageMethod']="ot";
    	$this->data['urlmenu']=$this->indexs();
         $table = \DB::table('m_ot_t')->get();  
         $columns =  \DB::getSchemaBuilder()->getColumnListing('m_ot_t');
         
        $this->data['data']=$table;
        $this->data['row']= (object)array(); 
        foreach ($columns as $key => $val) {
        	$this->data['row']->$val="";   
        
        }
      
              
              
        return view("ot.form",$this->data);
    }
    
//ot save
   public function otsave(Request $request)
    {
     
     
                        $id='';
            $data = $request->all();
		
            unset($data['_token']);
                       
              
            \DB::beginTransaction();
            try
            {
          if($data['ot_id']==""){
            $msg="OT Saved Successfully";
           $data['company_id'] = \Session::get('companyid');
           $id = \DB::table('m_ot_t')->insertGetId($data);
		 // auditlog
              $this->auditlog($id,"ot","create",$data,"m_ot_t");	
        }
        else{
            $msg="OT Updated Successfully";
			$data['company_id'] = \Session::get('companyid');
			//dd($data);
            $id=$data['ot_id'];
            \DB::table('m_ot_t')->where('ot_id', $data['ot_id'])->update($data); // auditlog
              $this->auditlog($data['ot_id'],"ot","update",$data,"m_ot_t");
            

        }
                //$lid=$this->submodel->subgridSave($lines_data,$id);
                \DB::commit();

                return response()->json(array('status' => 'success', 'message' => $msg,'id' => $id));
            }
            catch (\Illuminate\Database\QueryException$e)
            {
                $message = explode('(', $e->getMessage());
                $dbCode = rtrim($message[0], ']');
                $dbCode = trim($dbCode, '[');
            
                \DB::rollback();
               
                return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
            }
    }


       public function otdelete(Request $request,$id=null)
    {

        
            $query = \DB::table('m_ot_t')->where('ot_id',$id)->delete();
            if($query)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        
      
    }




      /***** Deduction Check Category data Start ***/
        public function Checkcategory(Request $request)
        {

            $edit_id = $_GET['edit_id'];
      
             $employee_type = $_GET['employee_type'];
    
               
            if($edit_id == ''){
                
            $whereData = [['employee_type',$employee_type]];
            }
            else
            {
               
              $whereData = [['employee_type',$employee_type],['ot_id', '!=', $edit_id]];
              }

                
                $result=DB::table('m_ot_t')->where($whereData)->get();
                
            
            if(count($result)>0)
                return 1;
            else
                return 0;
           
        }
        /***** Deduction Check Category data End ***/








      /** Shift Timing duplicate name check End **/
    /** ot grid data **/
     public function otData($type=null){
    $wh='';
    if($_GET['_search']=='true')
    {
		
    $search_tables=array("a_lookuplines_t");
    $wh=$this->jqgridsearch('m_ot_t',$_GET['filters'],$search_tables);
    }
   
        
        
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;
    $result = \DB::select("SELECT COUNT(m_ot_t.ot_id) AS count  FROM `m_ot_t`  left join a_lookuplines_t  on(a_lookuplines_t.lookuplines_id=m_ot_t.`employee_type`)  where 1=1 $wh");
    $count = $result[0]->count;
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
    $SQL = "SELECT m_ot_t.*,a_lookuplines_t.lookuplines_id,a_lookuplines_t.lookup_code,m_position.position,m_job_title.job_title_name FROM `m_ot_t`  left join a_lookuplines_t  on(a_lookuplines_t.lookuplines_id=m_ot_t.`employee_type`) left join m_job_title  on(m_job_title.job_title_id=m_ot_t.`position_id`) left join m_position  on(m_position.position_id=m_ot_t.`grade_id`) where 1=1 $wh ORDER BY $sidx $sord LIMIT $start , $limit";
    $result = \DB::select( $SQL );
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);
    }
// hrms account index load
        public function hrmsaccountsettingsindex()
    {
           $this->data['pageMethod']="hrmsaccountsettings";
    	$this->data['urlmenu']=$this->indexs();
         $table = \DB::table('f_hr_account_setting_t')->get();  
         $columns =  \DB::getSchemaBuilder()->getColumnListing('f_hr_account_setting_t');
         
        $this->data['data']=$table;
        $this->data['row']= (object)array(); 
        foreach ($columns as $key => $val) {
        	$this->data['row']->$val="";   
        
        }
      
              
              
        return view("ot.formaccount",$this->data);
    }
    
//hrmas account save
   public function hrmsaccountsettingssave(Request $request)
    {
     
     
                        $id='';
            $data = $request->all();
		
            unset($data['_token']);
                       
              
            \DB::beginTransaction();
            try
            {
          if($data['account_id']==""){
            $msg="HRMS Account Settings Saved Successfully";
           $data['company_id'] = \Session::get('companyid');
           $id = \DB::table('f_hr_account_setting_t')->insertGetId($data);
		 // auditlog
              $this->auditlog($id,"hrmsaccountsettings","create",$data,"f_hr_account_setting_t");	
        }
        else{
            $msg="HRMS Account Settings Updated Successfully";
			$data['company_id'] = \Session::get('companyid');
			//dd($data);
            $id=$data['account_id'];
            \DB::table('f_hr_account_setting_t')->where('account_id', $data['account_id'])->update($data); // auditlog
              $this->auditlog($data['account_id'],"hrmsaccountsettings","update",$data,"f_hr_account_setting_t");
            

        }
                //$lid=$this->submodel->subgridSave($lines_data,$id);
                \DB::commit();

                return response()->json(array('status' => 'success', 'message' => $msg,'id' => $id));
            }
            catch (\Illuminate\Database\QueryException$e)
            {
                $message = explode('(', $e->getMessage());
                $dbCode = rtrim($message[0], ']');
                $dbCode = trim($dbCode, '[');
            
                \DB::rollback();
               
                return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
            }
    }


       public function hrmsaccountsettingsdelete(Request $request,$id=null)
    {

        
            $query = \DB::table('f_hr_account_setting_t')->where('account_id',$id)->delete();
            if($query)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        
      
    }
   /** hrms account grid data **/
     public function hrmsaccountsettingsdata($type=null){
    $wh='';
    if($_GET['_search']=='true')
    {
		
    $search_tables=array("a_lookuplines_t");
    $wh=$this->jqgridsearch('f_hr_account_setting_t',$_GET['filters'],$search_tables);
    }
   
        
        
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;
    $result = \DB::select("SELECT COUNT(f_hr_account_setting_t.account_id) AS count  FROM `f_hr_account_setting_t`  left join m_department_lines_t  on(m_department_lines_t.department_line_id=f_hr_account_setting_t.`department_id`)  where 1=1 $wh");
    $count = $result[0]->count;
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
    $SQL = "SELECT f_hr_account_setting_t.*,m_department_lines_t.department_line_id,m_department_lines_t.sub_department_name FROM `f_hr_account_setting_t`  left join m_department_lines_t  on(m_department_lines_t.department_line_id=f_hr_account_setting_t.`department_id`)  where 1=1 $wh ORDER BY $sidx $sord LIMIT $start , $limit";
    $result = \DB::select( $SQL );
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);
    }

}
