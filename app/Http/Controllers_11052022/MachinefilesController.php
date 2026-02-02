<?php

namespace App\Http\Controllers;

use App\machinefiles;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use File;

class MachinefilesController extends Controller
{
   public function __construct()
    {
        $this->data=array();
        $this->model    = new machinefiles();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='filemachine';
        $this->table=" machine_hdr_t";   
        $this->middleware('auth');
                $this->data['urlmenu']=$this->indexs(); 

    }

    public function index()
    {
        $this->data['pageMethod']="filemachine";
     return view('machinefiles.table',$this->data);
    }

    public function create($id=null)
    {
        
        if(isset($_POST['id']))    
    $id=$_POST['id'];       
      if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
       if($id!='0')
        { 

            $this->data['id'] = $id;
            $this->data['pagemode'] = "edit";

            $table = \DB::table('m_machine_file_t')
            ->select('m_machine_file_t.*','ma_department_t.department_name')
            ->leftjoin('ma_department_t','ma_department_t.department_id','=','m_machine_file_t.department_id')
            ->where('machine_file_id',$id)->get();
  
            $this->data['row'] = $table[0];

            $this->data['department_id'] = $this->jCombologin('ma_department_t', 'department_id', 'department_name ', $table[0]->department_id);  
               
                     $this->data['machine_id'] = $table[0]->machine_id;
                    
                       $this->data['machine_id'] = $this->jCombolocation('machine_hdr_t','machine_id','asset_code|machine_name',$table[0]->machine_id,''); 
                     $this->data['machine_name'] = $this->jCombolocation('machine_hdr_t','machine_id','machine_id|machine_no',$table[0]->machine_id,''); 

        }
      else{
        $this->data['pagemode'] = "create";
                $this->modelname = new machinefiles();
                $this->data['row']= (object)array();
               $table = $this->modelname->getTableColumns();
                foreach($table as $key=>$val)
                {       
                  $this->data['row']->$val='';
                }
                 $this->data['department_id'] = $this->jCombologin('ma_department_t', 'department_id', 'department_name', ''); 
                   $this->data['machine_id'] = '';
                   $this->data['machine_name'] = '';

                         $this->data['machine_id'] = $this->jCombolocation('machine_hdr_t','machine_id','asset_code|machine_name','',''); 
                     $this->data['machine_name'] = $this->jCombolocation('machine_hdr_t','machine_id','machine_id|machine_no','',''); 


      }
    }
       // dd($this->data);
  return view('machinefiles.form',$this->data);
    
    }
public function getmachinefilesData(machinefiles $machinefiles)   
    {
       {
    $wh='';
    $table=array('ma_department_t','tb_users','machine_hdr_t');
    if($_GET['_search']=='true')
    {     
    $wh.=$this->jqgridsearch('m_machine_file_t',$_GET['filters'],$table);
    }
     $loc=\Session::get('location');
        $compy=\Session::get('companyid');      
        $groupname=\Session::get('groupname');
        // if($groupname=='Superadmin' || $groupname=='Admin'){
        // $wh.='and  m_machine_file_t.company_id='.$compy;  
        // }else{
        //     $wh.='and  m_machine_file_t.company_id='.$compy.' and m_machine_file_t.location_id='.$loc;      
        // 
//}
       $loc=\Session::get('location');
    $wh1='';
    if($loc != 0){
 $wh1='and  machine_hdr_t.location_id='.$loc;  
    }
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;    
    $result = \DB::select("SELECT COUNT(machine_file_id) AS count FROM  m_machine_file_t
     left join tb_users on(tb_users.id=m_machine_file_t.created_by)
         left join machine_hdr_t on(machine_hdr_t.machine_id=m_machine_file_t.machine_id)
         left join ma_department_t on(ma_department_t.department_id=m_machine_file_t.department_id) 
         where 1=1 $wh $wh1");
    // dd($result);
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
      $sql="SELECT m_machine_file_t.*,ma_department_t.department_name,tb_users.username,machine_hdr_t.machine_name,machine_hdr_t.machine_no from m_machine_file_t left join tb_users on(tb_users.id=m_machine_file_t.created_by)
      left join machine_hdr_t on(machine_hdr_t.machine_id=m_machine_file_t.machine_id)
            left join ma_department_t on(ma_department_t.department_id=m_machine_file_t.department_id)
            where 1=1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start,$limit ";
          //  dd($sql);
$download_SQL="SELECT m_machine_file_t.*,ma_department_t.department_name,tb_users.username,machine_hdr_t.machine_name,machine_hdr_t.machine_no from m_machine_file_t left join tb_users on(tb_users.id=m_machine_file_t.created_by)
      left join machine_hdr_t on(machine_hdr_t.machine_id=m_machine_file_t.machine_id)
            left join ma_department_t on(ma_department_t.department_id=m_machine_file_t.department_id)
            where 1=1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start,$limit";

        $result1 = \DB::select( $download_SQL );
        //dd($result1);
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    } 
    $result = \DB::select($sql);
  //dd($result);
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);
    }

    }

    /** Store a newly created data & update data in db  */
     public function save(Request $request)
    {  
       // dd($request);
      $edit_id = $request->input('machine_file_id');
      $validatedData=   $this->validate($request, [
            'department_id' =>  ['required','numeric',
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
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
             'file_name' =>  ['required',
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
           
           // 'file_name' => 'required|file' ,
            ]); 
       if($edit_id == ''){ 
// dd($edit_id);
        $machinefiles=new machinefiles(); 
            $machinefiles->department_id=$_POST['department_id'];
            $machinefiles->machine_id=$_POST['machine_id'];
            $machinefiles->file_name=$_POST['file_name'];          
            $machinefiles->created_by=\Session::get('created_by');
            $machinefiles->location_id=\Session::get('location');
            $machinefiles->company_id=\Session::get('companyid');
            $machinefiles->created_by=\Session::get('id');
            $machinefiles->last_updated_by=\Session::get('id');
            $edit_id= \DB::getPdo()->lastInsertId();
            $action="Create";
            if($request->hasfile('upload_file'))
         {
             $file=$request->file('upload_file'); 
              $name=$file->getClientOriginalName();
                $file->move(public_path().'/upload/machinefile', $name);  
                $machinefiles->upload_file=$name;
            }
             $machinefiles->save();
            /**Auditlog**/

            $this->auditlog($edit_id,"machinefilescreate",$action,$_POST,"machine_hdr_t");
            return response()->json(array('status' => 'success', 'message' => 'Machinefiles Saved Successfully','id'=>$edit_id));
    }
        else{

            $action="Edit";
            $edit_id=$_POST['machine_file_id'];

             $machinefiles['department_id']=$_POST['department_id'];
              //  $machinefiles['machine_name']=$_POST['machine_name'];
                $machinefiles['machine_no'] =$_POST['machine_id'];
                $machinefiles['file_name'] =$_POST['file_name'];
                // $machinefiles['files'] =$_POST['files'];
            machinefiles::find($edit_id)->update($_POST); 
            /**Auditlog**/
            $this->auditlog($edit_id,"machinefilescreate",$action,$_POST,"machine_hdr_t");
            return response()->json(array('status' => 'success', 'message' => 'Machinefiles Updated Successfully','id'=>$edit_id));
        }
    }
        
        
 public function destroy(Request $request,$id=null)
    {  
        if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
            $query = \DB::table('machine_hdr_t')->where('machine_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"machinefiles",$action,$id,"machine_hdr_t");
    return 0;
    }
    }

 /*deepika purpose:to check duplicate name*/ 
      public function machinefilesnamechk(Request $request)
    { 
        $machine_id = $_GET['edit_id'];
      //  dd($machine_id);
        if($machine_id == ''){
            $whereData = [['machine_name', $_GET['machine_name']]];
            $machine_name=\DB::table('machine_hdr_t')->where($whereData)->get();
        } else {
            $whereData = [['machine_name', $_GET['machine_name']],['machine_id', '!=', $machine_id]];
            $machine_name=\DB::table('machine_hdr_t')->where($whereData)->get();
        }
        
        if(count($machine_name)>0)
            return 1;
        else
            return 0;
    }
        /*end*/
}
