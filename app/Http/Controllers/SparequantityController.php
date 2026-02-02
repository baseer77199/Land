<?php

namespace App\Http\Controllers;

use App\Spare;
use Illuminate\Http\Request;
use DB;
class SparequantityController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model    = new Spare();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='sparequantity';
        $this->table=" m_spares_t";   
        $this->middleware('auth');
        $this->data['urlmenu']=$this->indexs(); 
    }

 public function index($id=null)
    {
        $this->data['row'] = (object) array();
        $this->data['row']->department_id=$this->jCombologin('ma_department_t','department_id','department_name','');
        $this->data['row']->spare_id=$this->jCombologin('m_spares_t','spares_id','spares_name','');
        $this->data['created_by'] = $this->jCombo('tb_users','id','username',\Session::get('id'));
        $table = \DB::table('m_breakdowntype_t')->get();
        $this->data['datas']=json_encode($table);
        $this->data['pageMethod']="sparequantity";
   return view('sparequantity.form',$this->data);
    }
    
    public function save(Request $request)
    {   
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
             'spare_id' =>  ['required','numeric',
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
            'quantity' =>  ['required','numeric',
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
            
            ]);
        
                        $department_id = $request->input('department_id');
		            	$spare_no = $request->input('spare_id');
                        $query =  \DB::select("select * from m_spares_t where department_id='$department_id' and spares_id='$spare_no'");
                        if(count($query)>0)
                        {
                            $old_quantity = $query[0]->spare_quantity;
                            $update_quantity = $old_quantity + $request->input('quantity');
                            $update =  \DB::update("update m_spares_t set spare_quantity='$update_quantity' where spares_id='$spare_no' and department_id='$department_id'");
                            
                        }
       return 1;
    }
    
    public function sparegriddata(Spare $Spare)
    {
      
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('m_spares_t',$_GET['filters']);
        }
    if(!$sidx) $sidx =1;
   $result = \DB::select("SELECT COUNT(spares_id) AS count FROM  m_spares_t left join tb_users on(tb_users.id=m_spares_t.created_by)
            left join ma_department_t on(ma_department_t.department_id=m_spares_t.department_id) where 1=1 $wh");
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

        
    $SQL = "SELECT m_spares_t.*,ma_department_t.department_name,tb_users.username from m_spares_t left join tb_users on(tb_users.id=m_spares_t.created_by)
            left join ma_department_t on(ma_department_t.department_id=m_spares_t.department_id)
            where 1=1 $wh ORDER BY $sidx $sord LIMIT $start,$limit ";
        $download_SQL = "SELECT m_spares_t.*,ma_department_t.department_name,tb_users.username from m_spares_t left join tb_users on(tb_users.id=m_spares_t.created_by)
            left join ma_department_t on(ma_department_t.department_id=m_spares_t.department_id)
            where 1=1 $wh ORDER BY $sidx $sord";   
       $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
    $result = \DB::select($SQL);
    //dd($result);
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

       

    echo json_encode($responce);
    }
    
    
      public function destroy(Request $request,$id=null)
    {  

    $column = array('spares_id');

        $table = array('m_spares_t');
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
            $query = \DB::table('m_spares_t')->where('spares_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"sparequantity",$action,$id,"m_spares_t");
            
        }

    return $j;

    }
   // public function getCheckname(Request $request)
   //  { //dd("sadf");
   //      $department_id = $_GET['edit_id']; //dd($vendor_id);
        
   //      if($department_id == ''){
   //          $whereData = [['department_name', $_GET['department_name']]];
   //          $department=DB::table('ma_department_t')->where($whereData)->get();
   //      } else {
   //          $whereData = [['department_name', $_GET['department_name']],['department_id', '!=', $break_type_id]];
   //          $department=DB::table('ma_department_t')->where($whereData)->get();
   //      }
        
   //      if(count($department)>0)
   //          return 1;
   //      else
   //          return 0;
   //  }
}
