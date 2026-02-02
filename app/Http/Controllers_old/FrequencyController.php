<?php

namespace App\Http\Controllers;
use DB;
use App\frequency;
use Illuminate\Http\Request;

class FrequencyController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model = new frequency();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='frequency_tbl';
        $this->table=" frequency_tbl";   
        $this->middleware('auth');
        $this->data['urlmenu']=$this->indexs(); 
    }
    public function index()
    {
        $this->data['pageMethod']="frequency";
        return view('frequency.form',$this->data);
    }

    
    public function save($id=null,Request $request)
    {   
        $validatedData=   $this->validate($request, [
            'frequency_name' =>  ['required',
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
              'description' =>  [
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
             //   dd("fdgdfg");
                },
            ],
            ]);
        $edit_id = $request->input('edit_id');
        if($edit_id == '')
        {
            
            $frequency= new frequency();
            $frequency->frequency_name = $request->input('frequency_name');
          
            $frequency->description =  $request->input('description');
            $frequency->updated_at =  "";
            $frequency->created_at =  "";
            
            $frequency->save(); 

             

            return 1;
        }
        else
        {    $action="Edit";
            $edit_id=$_POST['edit_id'];
            frequency::find($edit_id)->update($_POST); 
            $this->auditlog($edit_id,"frequency",$action,$_POST,"frequency_tbl");
            return response()->json(array('status' => 'success', 'message' => 'Frequency Updated Successfully','id'=>$edit_id));
            return 2;
        }
       
    }

    
    public function frequencygrid(frequency $frequency)
    {
       {
      
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('frequency_tbl',$_GET['filters']);
        }
    if(!$sidx) $sidx =1;
        
        

    $result = \DB::select("SELECT COUNT(frequency_id) AS count FROM  frequency_tbl as frequency_tbl where 1=1 $wh");
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
                        frequency_tbl
                   
                    WHERE
                        1 = 1 $wh ORDER BY $sidx $sord LIMIT $start,$limit";

          $download_sql = "SELECT
                   *
                    
                    FROM
                        frequency_tbl
                   
                    WHERE
                        1 = 1 $wh ORDER BY $sidx $sord";                 
        
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
 if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
    $column = array('capacity');

        $table = array('machine_hdr_t');
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
            $query = \DB::table('frequency_tbl')->where('frequency_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"frequency",$action,$id,"frequency_tbl");
            
        }

    return $j;
    }

    }  
}
