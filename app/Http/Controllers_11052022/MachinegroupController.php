<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machinegroup;
use App\Rules\Notinurl;

class MachinegroupController extends Controller
{

    public function __construct()
    {

        $this->data=array();
        $this->model    = new Machinegroup();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='machinegroup';
        $this->table=" machine_group_t";   
        $this->middleware('auth');
        $this->data['urlmenu']=$this->indexs(); 
    }

 public function index($id=null)
    {
     // print_r(\Session::all());
$this->data['pageMethod']="machinegroup";
        return view('machinegroup.form',$this->data);
    }
    
    public function save($id=null,Request $request)
    {	
       // dd($request);
              // dd($request);
       $validatedData=   $this->validate($request, [
            'group_name' => ['required',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                            //    $regex .= "(/[^0-9]/)"; // Number

                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return $fail($attribute.' is invalid (contains url).');
                  }
                //      if (str_contains($value, '=')) {  
                //       return $fail($attribute. ' contains Equal.');
                //   }
                  
                  
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. 'it contains script.');
                  }
                    if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
            'description' => [
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
                      return $fail($attribute. 'it contains script.');
                  }
                    if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                },
            ],
        ]);
  
        $edit_id = $request->input('edit_id');
        if($edit_id == '')
        {
            
            $Machinegroup= new Machinegroup();
            $Machinegroup->group_name = $request->input('group_name');
            $Machinegroup->description =  $request->input('description');
            $Machinegroup->updated_at =  "";
            $Machinegroup->created_at =  date('Y-m-d H:i:s');
            $Machinegroup->created_by =  \Session::get('id');
            $Machinegroup->last_updated_by =  "";
            $Machinegroup->company_id =  \Session::get('companyid');
            $Machinegroup->location_id =  \Session::get('location');
            $Machinegroup->organization_id =  \Session::get('organization');

            
            $Machinegroup->save(); 

            return 1;
        }
        else
        { 
            $edit_id=$_POST['edit_id'];
            $_POST['updated_at'] =   date('Y-m-d H:i:s');
            $_POST['last_updated_by'] =  \Session::get('id');
            $_POST['company_id'] =  \Session::get('companyid');
            $_POST['location_id'] =  \Session::get('location');
            $_POST['organization_id'] =  \Session::get('organization');
            Machinegroup::find($edit_id)->update($_POST); 
            return 2;
        }
       
    }
    
    public function machinegroupgriddata(Machinegroup $Machinegroup)
    {
      
		$page = $_GET['page'];
		$limit = $_GET['rows'];
		$sidx = $_GET['sidx'];
		$sord = $_GET['sord'];
    $loc=\Session::get('location');
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('machine_group_t',$_GET['filters']);
        }
        $wh1='';
        if($loc != 0){
        $wh1='and  machine_group_t.location_id='.$loc;      
        }
	if(!$sidx) $sidx =1;
        
        

	$result = \DB::select("SELECT COUNT(group_id) AS count FROM  machine_group_t as machine_group_t where 1=1 $wh1 $wh");
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

        
	$SQL = "SELECT * FROM machine_group_t  WHERE   1 = 1 $wh1 $wh ORDER BY $sidx $sord LIMIT $start,$limit";
        $download_SQL = "SELECT * FROM machine_group_t  WHERE   1 = 1 $wh1 $wh ORDER BY $sidx $sord";   
       $result1 = \DB::select( $download_SQL );
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
    
    
      public function destroy(Request $request,$id=null)
    {  

 if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
    $column = array('group_id');

        $table = array('machine_hdr_t');
        for($i=0; $i<count($table); $i++)
        {
            // dd($column[$i]);
            $j=0;
            $query = \DB::table($table[$i])->where($column[$i],$id)->get();
           // dd($query);
            if(count($query)>0)
            {
                $j=1;
                break;
            }
        }
        if($j==0)
        {
           // dd("fdg");
            $query = \DB::table('machine_group_t')->where('group_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"machinegroup",$action,$id,"mahcine_group_t");
            
        }

    return $j;
    }

    }
   public function getCheckname(Request $request)
    { //dd("sadf");
        $group_id = $_GET['edit_id']; //dd($vendor_id);
        $loc_id = \Session::get('location');
        
        if($group_id == ''){
            $whereData = [['group_name', $_GET['group_name']],['location_id',$loc_id]];
            $Machinegroup=DB::table('machin_group_t')->where($whereData)->get();
        } else {
            $whereData = [['group_name', $_GET['group_name']],['group_id', '!=', $break_type_id],['location_id',$loc_id]];
            $Machinegroup=DB::table('machine_group_t')->where($whereData)->get();
        }
        
        if(count($Machinegroup)>0)
            return 1;
        else
            return 0;
    }
}
