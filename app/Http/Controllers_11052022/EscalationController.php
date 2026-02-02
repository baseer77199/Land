<?php

namespace App\Http\Controllers;

use App\EscalationHdr;
use App\EscalationLines;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,DateTime;
use Storage;
class EscalationController extends Controller
{
    public function __construct()
    {
        $this->data=array();
         $this->table = "m_escalation_hrd_tbl";
        $this->subtable = "m_escalation_lines_tbl";
        $this->pageModule = "escalation";
        $this->model = new EscalationHdr;
        $this->submodel = new EscalationLines;
        $this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageModule']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
    }
     
    public function index()
    {
          return view('escalation.table',$this->data);
    }

    public function getGridData($type=null)
    {
       // dd("dhg");
        $wh='';
        if($_GET['_search']=='true')
        {
          $search_tables=array('tb_users','ma_department_t','machine_hdr_t','frequency_tbl');  
        $wh=$this->jqgridsearch('m_escalation_hrd_tbl',$_GET['filters'],$search_tables);
        }
        $compy=\Session::get('companyid');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        //dd($sidx);
        $sord = $_GET['sord'];
        $loc=\Session::get('location');
        $compy=\Session::get('companyid');      
        $groupname=\Session::get('groupname');
        // if($groupname=='Superadmin' || $groupname=='Admin'){
        // $wh.='and  m_escalation_hrd_tbl.company_id='.$compy;  
        // }else{
        //     $wh.='and  m_escalation_hrd_tbl.company_id='.$compy;    
        // }   

         $loc=\Session::get('location');
    $wh1='';
    if($loc != 0){
 $wh1='and  m_escalation_hrd_tbl.location_id='.$loc;      
    }

        if(!$sidx) $sidx =1;
        $result = \DB::select("SELECT COUNT(m_escalation_hrd_tbl.escalation_hrd_id) AS count FROM m_escalation_hrd_tbl  where 1=1 $wh $wh1");
//dd($result);
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
      
        $SQL = "SELECT m_escalation_hrd_tbl.*,breakdown_severity.severity_name,
                (case when m_escalation_hrd_tbl.condition=1 then 'Ticket Not Yet Allocated'
                when m_escalation_hrd_tbl.condition=2 then 'Ticket Closure Request Not Yet Raised'
                when m_escalation_hrd_tbl.condition=3 then 'Ticket Closure Request Not Yet Acknowledged'
                when m_escalation_hrd_tbl.condition=4 then 'Ticket Not Yet Closed' end) as statuss,
                (select location_name from m_location_t where m_location_t.location_id = m_escalation_hrd_tbl.location_id) as location_name 
                FROM m_escalation_hrd_tbl 
                left join breakdown_severity on breakdown_severity.breakdownseverity_id=m_escalation_hrd_tbl.severity
                where 1=1  $wh $wh1 
                ORDER BY m_escalation_hrd_tbl.escalation_hrd_id $sord LIMIT $start , $limit";

        $download_SQL = "SELECT m_escalation_hrd_tbl.*,(select location_name from m_location_t where m_location_t.location_id = m_escalation_hrd_tbl.location_id) as location_name FROM m_escalation_hrd_tbl where 1=1  $wh $wh1 ORDER BY m_escalation_hrd_tbl.escalation_hrd_id $sord";
        
        $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
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
    
     public function create($id = null) {

if(isset($_POST['id']))    
    $id=$_POST['id'];
    //dd($id);
     if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
      if ($id=='0') {
         $loc=\Session::get('location');

            $this->data['row'] = (object) array();
            $this->data['department_id']=$this->jCombo('ma_department_t','department_id','department_name','');
            $this->data['designation_id']=$this->jCombo('designation_tbl','designation_id','designation_name','','');
            $this->data['severity']=$this->jCombologin('breakdown_severity','breakdownseverity_id','severity_name','');
            $this->data['duration']=$this->jCombo('duration_tbl','duration_id','duration_name','');

            $this->data['row']->escalation_hrd_id = '';
            $this->data['row']->condition = '';
            $this->data['row']->severity = '';
            $this->data['row']->description = '';
            // $this->data['row']->level = '';
            $this->data['row']->active = '';
            $this->data['row']->created_by_mail = '';
            $this->data['linedata'] = array();
            // $this->data['checklist_id'] = $this->jCombologin('checklist_tbl', 'checklist_id', 'checklist_name', '');
            }
        else {
                     $loc=\Session::get('location');

            $this->data['id'] = $id;
           // dd($id);
            $table = \DB::table('m_escalation_hrd_tbl')->where('escalation_hrd_id', $id)->get();
          //dd($table);  
            $this->data['row'] = $table[0];
            $this->data['severity']=$this->jCombologin('breakdown_severity','breakdownseverity_id','severity_name',$table[0]->severity);

            $tablelines = \DB::table('m_escalation_lines_tbl')->where('escalation_hrd_id', $id)->get();
            $this->data['linedata'] = $tablelines;
			foreach($this->data['linedata'] as $key=>$val){
             $this->data['linedata'][$key]->department_id = $this->jCombologin('ma_department_t', 'department_id', 'department_name',$val->department_id);
             $this->data['linedata'][$key]->designation_id = $this->jCombologin('designation_tbl', 'designation_id', 'designation_name',$val->designation_id);
             $this->data['linedata'][$key]->duration = $this->jCombo('duration_tbl','duration_id','duration_name',$val->duration);
			}
				$this->data['created_by'] = $this->jCombologin('tb_users','id','username',\Session::get('id'));
        }
    }

     
       return view('escalation.form',$this->data);
    }
    
  public function save(Request $request)
    {
      
      
    $validatedData=   $this->validate($request, [
         'condition' => ['required',
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
            'severity' => ['required','numeric',
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
              'description' => ['required',
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
             'created_by_mail' => ['required',
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
            'active' => ['required',
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
           ]
          
        ]);

// dd($validatedData);
    $data = $this->validatePost($request->all(),$this->table,'header');
	  $lines_data = $this->validatePost($request->all(),$this->subtable,'lines'); 

       $id='';
  		     \DB::beginTransaction();
                try
                {
			           $id=$this->model->insertRow($data);
                     $lid=$this->submodel->subgridSave($lines_data,$id);
					/*deepika purpose:audit log*/
					if($_POST['escalation_hrd_id']==""){
					$action="create";	
					}else{
					$action="update";		
					}
					$this->auditlog($id,"escalation",$action,$data,"m_escalation_hrd_tbl");
					/*end*/
                     \DB::commit();
                     return response()->json(array('status' => 'success', 'message' => 'Saved Successfully','id' => $id,'lid' => $lid,'auto_no'=>$_POST['escalation_hrd_id']));
                }
                catch (\Illuminate\Database\QueryException $e)
                {
                     $message = explode('(', $e->getMessage());
                     $dbCode = rtrim($message[0], ']');
                     $dbCode = trim($dbCode, '[');

                     \DB::rollback();
                     return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
                }
    }
	/*end*/


    
    public function show($id=null)
    {
        if(isset($_POST['id']))    
    $id=$_POST['id'];
     if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
      $header = \DB::table('m_escalation_hrd_tbl')->where('escalation_hrd_id',$id)->get();
			$this->data['header'] = $header[0];
			
			$linesdata=\DB::table('m_escalation_lines_tbl')
      ->leftjoin('m_escalation_hrd_tbl','m_escalation_hrd_tbl.escalation_hrd_id','=','m_escalation_lines_tbl.escalation_hrd_id')
      ->leftjoin('designation_tbl','designation_tbl.designation_id','=','m_escalation_lines_tbl.designation_id')
      ->leftjoin('ma_department_t','ma_department_t.department_id','=','m_escalation_lines_tbl.department_id')
      ->where('m_escalation_hrd_tbl.escalation_hrd_id',$id)->get();
						$this->data['linesdata'] = $linesdata;
		return view("escalation.view",$this->data);
    }
}
    
}
