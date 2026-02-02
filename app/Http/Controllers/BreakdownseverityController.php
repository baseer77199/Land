<?php

namespace App\Http\Controllers;

use App\Breakdownseverity;
use Illuminate\Http\Request;
use DB;
class BreakdownseverityController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model = new Breakdownseverity();
        $this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='breakdown_severity';
        $this->table=" breakdown_severity";   
        $this->middleware('auth');
        //$this->data['urlmenu']=$this->indexs();
    }
    public function index()
    {
        // print_r(\Session::all());die;
                $table = \DB::table('breakdown_severity')->get();
                $this->data['datas']=json_encode($table);
                $this->data['pageMethod']="breakdownseverity";
          return view('breakdownseverity.form',$this->data);
    }

      public function create()
    {
        return view('breakdownsenerity.form');
    }

  public function severitygrids(Breakdownseverity $Breakdownseverity)
    {
       {
       // dd("sdsd");
      
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('breakdown_severity',$_GET['filters']);
        }
        $wh1='';
        $loc=\Session::get('location');
        if($loc != 0){
            $wh1='and  breakdown_severity.location_id='.$loc;
        }
    if(!$sidx) $sidx =1;
        
        

    $result = \DB::select("SELECT COUNT(breakdownseverity_id) AS count FROM  breakdown_severity as breakdown_severity where 1=1 $wh $wh1");
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

        
    $SQL = "SELECT * FROM breakdown_severity WHERE 1 = 1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start,$limit";
    $download = "SELECT * FROM breakdown_severity WHERE 1 = 1 $wh $wh1 ORDER BY $sidx $sord";
        
       
    $result = \DB::select($SQL);
   // dd($result);
    if(isset($_GET['download']))
    {   $result1 = \DB::select($download);
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
        return $result1;
    }
    
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

       

    echo json_encode($responce);
    }

    }
        
 public function save($id=null,Request $request)
    {   
              $edit_id = $request->input('edit_id');
             // dd($edit_id);
             $validatedData=   $this->validate($request, [
            'severity_name' =>  ['required',
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
                //       return $fail($attribute. ' contains =.');
                //   }
                // },
                function ($attribute, $value, $fail) {
                    //no url = nourl
                    //no url no email = nourlnoemail
                    $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                    $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                  },
            ],'description' =>  [
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
                //   if (str_contains($value, '=')) {  
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
             
    // $validatedData= $this->validate($request, [
    //         'severity_name' => 'required',
    //         'description' => 'not_in:script|not_in:url'
    //         ]);
   // dd($validatedData);
        if($edit_id == '')
        {

            
            $breakdownseverity= new Breakdownseverity();
            $breakdownseverity->severity_name = $request->input('severity_name');
            $breakdownseverity->description =  $request->input('description');
            $breakdownseverity->created_by =  \Session::get('id');
            $breakdownseverity->last_updated_by =  '';
            $breakdownseverity->company_id =  \Session::get('companyid');
            $breakdownseverity->location_id =  \Session::get('location');
            $breakdownseverity->organization_id =  \Session::get('organization');
            $breakdownseverity->created_at =  date('Y-m-d H:i:s');
            $breakdownseverity->updated_at =  "";
             // dd($request->input('severity_name'));
            $breakdownseverity->save(); 

            // dd($breakdownseverity);

            return 1;
        }
        else
        {    $action="Edit";
            $edit_id=$_POST['edit_id'];
            // $_POST['created_by'] =  \Sesion::get('id');
            $_POST['last_updated_by'] =  \Session::get('id');
            $_POST['company_id'] =  \Session::get('companyid');
            $_POST['location_id'] =  \Session::get('location');
            $_POST['organization_id'] =  \Session::get('organization');
            // $_POST['created_at'] =  date('Y-m-d H:i:s');
            $_POST['updated_at'] =  date('Y-m-d H:i:s');
            // print_r($_POST);die;
            breakdownseverity::find($edit_id)->update($_POST); 
            $this->auditlog($edit_id,"breakdownseverity",$action,$_POST,"breakdown_severity");
            return response()->json(array('status' => 'success', 'message' => 'Serverity Updated Successfully','id'=>$edit_id));
            return 2;
        }
       
    }
    
    /*Ajith Purpose for Used Data Should Not Allow to Edit Function*/
    // public function edit(Request $request, $id=null) 
    // {

    //    $column = array('breakdownseverity_id');
    //     $table = array('breakdown_severity');
    //     for($i=0; $i<count($table); $i++)
    //     {
    //         $j=0;
    //         $query = \DB::table($table[$i])->where($column[$i],$id)->get();
    //         if(count($query)>0)
    //         {
    //             $j=1;
    //            return $j;
    //         }
    //     }
    // return $j;
    // }

 
    public function destroy($id)
  {
             
              if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
                $del_id = $id;
        $column = array('breakdown_sevearity');
        $table = array('b_maintenance_t');
        for($i=0; $i<count($table); $i++)
        {
            
            $j=0;
            $query = \DB::table($table[$i])->where($column[$i],$del_id)->get();
            
           // dd($query);
            if(count($query)>0)
            {
                $j=1;
                break;
            }
            //dd($j);
        }
        //$j=0;
//dd($j);
        if($j==0)
        {
            $query =\DB::table('breakdown_severity')->where('breakdownseverity_id',$del_id)->delete();
           
        }
       
        if($j == 1)
            return 1;
        else if($j == 0)
            return 2;
        else if($j == 3)
            return 3;
    }
  }
}
