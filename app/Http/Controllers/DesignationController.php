<?php

namespace App\Http\Controllers;
use DB;
use App\designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model = new designation();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='designation_tbl';
        $this->table=" designation_tbl";   
        $this->middleware('auth');
        $this->data['urlmenu']=$this->indexs(); 
    }
    public function index()
    {
        $this->data['pageMethod']="designation";
        return view('designation.form',$this->data);
    }

    
    public function save($id=null,Request $request)
    {   
        //   $validatedData=   $this->validate($request, [
        //     'designation_name' => 'required',
        //     'description' => 'not_in:script|not_in:url'
        // ]);
        
        $validatedData=   $this->validate($request, [
            'designation_name' =>  ['required',
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
                //   }  if (str_contains($value, '=')) {  
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
                //   }  
                //   if (str_contains($value, 'equal')) {  
                //       return $fail($attribute. ' contains =.');
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
            
        $edit_id = $request->input('edit_id');
        if($edit_id == '')
        {
            
            $designation= new designation();
            $designation->designation_name = $request->input('designation_name');
          
            $designation->description =  $request->input('description');
            $designation->updated_at =  "";
            $designation->created_at =  date('Y-m-d H:i:s');
            $designation->created_by =  \Session::get('id');
            $designation->last_updated_by =  "";
            $designation->company_id =  \Session::get('companyid');
            $designation->location_id =  \Session::get('location');
            $designation->organization_id =  \Session::get('organization');
            $designation->active =  "Yes";
            
            $designation->save(); 
            return 1;
        }
        else
        {    $action="Edit";
            $edit_id=$_POST['edit_id'];
            $_POST['updated_at'] =   date('Y-m-d H:i:s');
            $_POST['last_updated_by'] =  \Session::get('id');
            $_POST['company_id'] =  \Session::get('companyid');
            $_POST['location_id'] =  \Session::get('location');
            $_POST['organization_id'] =  \Session::get('organization');
            designation::find($edit_id)->update($_POST); 
            $this->auditlog($edit_id,"designation",$action,$_POST,"designation_tbl");
            return response()->json(array('status' => 'success', 'message' => 'Designation Updated Successfully','id'=>$edit_id));
            return 2;
        }
       
    }

    
    public function designationgrid(designation $designation)
    {
       {
      
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('designation_tbl',$_GET['filters']);
        }
    if(!$sidx) $sidx =1;
        
    $wh1='';
    $loc=\Session::get('location');
    if($loc != 0){
        $wh1='and  designation_tbl.location_id='.$loc;
    }

    $result = \DB::select("SELECT COUNT(designation_id) AS count FROM  designation_tbl as designation_tbl where 1=1 $wh $wh1");
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

        
    $SQL = "SELECT
                   *
                    
                    FROM
                        designation_tbl
                   
                    WHERE
                        1 = 1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start,$limit";

          $download_sql = "SELECT
                   *
                    
                    FROM
                        designation_tbl
                   
                    WHERE
                        1 = 1 $wh $wh1 ORDER BY $sidx $sord";                 
        
        $result1 = \DB::select( $download_sql );

        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();

    if(isset($_GET['download']))
    {
        return $result1;
    } 
       
    $result = \DB::select($SQL);
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

       

    echo json_encode($responce);
    }

    }

  
    
    public function destroy($id=null)
  {
       // $j=0;
       if(!is_numeric($id)){
           return 3;
       }else{
        $column = array('designation_id');

        $table = array('tb_users');
        for($i=0; $i<count($table); $i++)
        {
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
            $query = \DB::table('designation_tbl')->where('designation_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"designation",$action,$id,"designation_tbl");
            
        }

    return $j;
}
    }  
    
}
