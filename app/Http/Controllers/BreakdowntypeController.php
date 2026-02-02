<?php

namespace App\Http\Controllers;

use App\Breakdowntype;
use Illuminate\Http\Request;
use DB;
class BreakdowntypeController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
    }
    public function index()
    {
                $this->data['created_by'] = $this->jCombo('tb_users','id','username',\Session::get('id'));
                $table = \DB::table('m_breakdowntype_t')->get();
                $this->data['datas']=json_encode($table);
                $this->data['pageMethod']="breakdowntype";
          return view('breakdowntype.form',$this->data);
    }

      public function create()
    {
        return view('breakdowntype.form');
    }

    public function getGridData($type=null)
    {
       // dd("dhg");
        $wh='';
        if($_GET['_search']=='true')
        {
          $search_tables=array('tb_users');  
        $wh=$this->jqgridsearch('m_breakdowntype_t',$_GET['filters'],$search_tables);
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
        if($groupname=='Superadmin' || $groupname=='Admin'){
        $wh.='and  m_breakdowntype_t.company_id='.$compy;  
        }else{
            $wh.='and  m_breakdowntype_t.company_id='.$compy;    
        }   
        $wh1='';
        $loc=\Session::get('location');
        if($loc != 0){
            $wh1='and  m_breakdowntype_t.location_id='.$loc;
        } 
        if(!$sidx) $sidx =1;
        $result = \DB::select("SELECT COUNT(breakdowntype_id) AS count FROM m_breakdowntype_t left join tb_users on (tb_users.id =m_breakdowntype_t.created_by) where 1=1 $wh $wh1");

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
      
        $SQL = "SELECT m_breakdowntype_t.*,tb_users.username,tb_users.id as created_id FROM m_breakdowntype_t left join tb_users on tb_users.id =m_breakdowntype_t.created_by where 1=1 and m_breakdowntype_t.company_id=$compy $wh $wh1 ORDER BY $sidx $sord LIMIT $start , $limit";
       // dd($SQL);
        
    if(isset($_GET['download']))
    {
        $download_SQL = "SELECT m_breakdowntype_t.*,tb_users.username,tb_users.id as created_id FROM m_breakdowntype_t left join tb_users on tb_users.id =m_breakdowntype_t.created_by where 1=1 and m_breakdowntype_t.company_id=$compy $wh $wh1 ORDER BY $sidx $sord";
        
        $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
// print_r($result1);die;
        return $result1;
    }

        
        $result = \DB::select( $SQL );
       // dd($result);
        $responce->rows[]='';
        $responce->rows=$result;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        echo json_encode($responce);
    }
    /*End*/
        
 public function save(Request $request)
    {
       //dd($request);
         $edit_id = $request->input('breakdowntype_id');
     $validatedData=   $this->validate($request, [
            'breakdown_name' =>  ['required',
                // function($attribute, $value, $fail) {
                //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                //     $regex .= "(\:[0-9]{2,5})?"; // Port 
                //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                //   {
                //     return $fail($attribute.' is invalid (contains url).');
                //   }
                // },function($attribute,$value,$fail){
              
                //   if (str_contains($value, 'script')) {  
                //       return $fail($attribute. ' contains script.');
                //   } if (str_contains($value, '=')) {  
                //       return $fail($attribute. ' contains equal.');
                //   }
                // },
                function ($attribute, $value, $fail) {
                    //no url = nourl
                    //no url no email = nourlnoemail
                    $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                    $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                  },
            ], 
            'description' =>  [
                // function($attribute, $value, $fail) {
                //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                //     $regex .= "(\:[0-9]{2,5})?"; // Port 
                //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                //   {
                //     return $fail($attribute.' is invalid (contains url).');
                //   }
                // },function($attribute,$value,$fail){
              
                //   if (str_contains($value, 'script')) {  
                //       return $fail($attribute. ' contains script.');
                //   }if (str_contains($value, '=')) {  
                //       return $fail($attribute. ' contains equal.');
                //   }
                // },
                function ($attribute, $value, $fail) {
                    //no url = nourl
                    //no url no email = nourlnoemail
                    $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                    $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                  },
            ],
            ]);
       if($edit_id == ''){ 
          $edit_id = $request->input('breakdowntype_id');
        
        $breakdowntype=new Breakdowntype(); 

            $breakdowntype->breakdown_name=$_POST['breakdown_name'];
            $breakdowntype->description=$_POST['description'];
            $breakdowntype->location_id=\Session::get('location');
            $breakdowntype->organization_id=\Session::get('organization');
            $breakdowntype->company_id=\Session::get('companyid');
            $breakdowntype->created_by=\Session::get('id');
            $breakdowntype->last_updated_by=\Session::get('id');
            $breakdowntype->save();
          //  dd($breakdowntype);
            $edit_id= DB::getPdo()->lastInsertId();
            $action="Create";
            /**Auditlog**/
            $this->auditlog($edit_id,"breakdowntype",$action,$_POST,"m_breakdowntype_t");
            return response()->json(array('status' => 'success', 'message' => 'Breakdowntype Saved Successfully','id'=>$edit_id));
        }
        else{
           
            $action="Edit";
            $edit_id=$_POST['breakdowntype_id'];
            breakdowntype::find($edit_id)->update($_POST); 
            /**Auditlog**/
            $this->auditlog($edit_id,"breakdowntype",$action,$_POST,"m_breakdowntype_t");
            return response()->json(array('status' => 'success', 'message' => 'Breakdowntype Updated Successfully','id'=>$edit_id));
        }
          
        
 
    }

    
    /*Ajith Purpose for Used Data Should Not Allow to Edit Function*/
    public function edit($id=null) 
    {
        //print_r($id);exit();
       $column = array('break_type_id');
        $table = array('b_maintenance_t');
        for($i=0; $i<count($table); $i++)
        {
            $j=0;
            $query = \DB::table($table[$i])->where($column[$i],$id)->get();
            if(count($query)>0)
            {
                $j=1;
               return $j;
            }
        }
    return $j;
    }

   public function getCheckname(Request $request)
    { 
       // dd($_GET['edit_id']);
        $break_type_id = $_GET['edit_id']; //dd($vendor_id);
        
        if($break_type_id == ''){
            $whereData = [['breakdown_name', $_GET['breakdown_name']]];
            $breakdown=DB::table('m_breakdowntype_t')->where($whereData)->get();
        } else {
            $whereData = [['breakdown_name', $_GET['breakdown_name']],['breakdowntype_id', '!=', $break_type_id]];
            $breakdown=DB::table('m_breakdowntype_t')->where($whereData)->get();
        }
        
        if(count($breakdown)>0)
            return 1;
        else
            return 0;
    }

    public function destroy(Request $request,$id=null)
    {
//print_r("$id");exit;
if(!is_numeric($id)){
    return 3;
}else{
    $column = array('break_type_id');

        $table = array('b_maintenance_t');
        for($i=0; $i<count($table); $i++)
        {
            // dd($id);
            $j=0;
            $query = \DB::table($table[$i])->where($column[$i],$id)->get();
            if(count($query)>0)
            {
                $j=1;
                break;
            }
        }
        if($j==0)
        {
           // dd("fdg");
            $query = \DB::table('m_breakdowntype_t')->where('breakdowntype_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"breakdowntype",$action,$id,"m_breakdowntype_t");
            
        }

    return $j;

    }  
    }
}
