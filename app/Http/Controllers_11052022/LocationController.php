<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
     public function __construct(){
        $this->data=array();
        $this->table="m_location_t";
        
        $this->pageModule="location";
        $this->model=new Location;
        
        $this->data['pageModule']=$this->pageModule;
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
                $this->data=array(
                    'pageModule'=> 'location',
                    'pageUrl'   =>  url($this->data['pageMethod']),
            'pageMethod'=>$this->data['pageMethod']
                  );
                $this->data['urlmenu']=$this->indexs(); 
              
        $this->modelname = new Location();
        $this->data['pageFormtype']='ajax';
      
    }
     public function index()
    {
           
         $table = \DB::table('m_location_t')->get();   
        $this->data['data']=$table;
        $this->data['row']= (object)array(); 
        $this->data['row']->location_id="";   
        $this->data['row']->location_code="";   
        $this->data['row']->location_name="";
        $this->data['row']->active="";
        $this->data['row']->location_type="";
        $this->data['row']->country_id="";
        $this->data['row']->state_id="";
        $this->data['row']->city_id="";
        $this->data['row']->address="";
        $this->data['row']->street_name="";
        $this->data['row']->pincode="";
              
        return view("location.form",$this->data);
    }


public function loccheckname(Request $request)
    {
       $edit_id = $_GET['location_id'];
    //   dd($edit_id);
       
        if($edit_id == '')
        {
            
            $group=\DB::table('m_location_t')->where('location_name',$_GET['location_name'])->get();
            
        }
        else
        {
            if(!is_numeric($edit_id)){
               return 3;
            }else{            
    
                $whereData = [['location_name', $_GET['location_name']],['location_id', '!=', $edit_id]];
    
                $group=\DB::table('m_location_t')->where($whereData)->get();
            }

        }
        if(count($group)>0)
            return 1;
        else
            return 0;
       
    }



    public function locationsave(Request $request)
    {
     
     //  dd($request->all());
                        $id='';
            $data = $request->all();
		
            unset($data['_token']);
            unset($data['removed_line_id']);
                        //dd($request->all());
         $validatedData=   $this->validate($request, [
            'location_name' =>  ['required',
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
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
              'location_code' =>  ['required',
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
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
              'location_type' =>  'numeric|required',
            'address' =>  [
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
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            'street_name' =>  [
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
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            'country_id' =>  'required|numeric',
            'state_id' =>  'required|numeric',
              'city_id' =>  'required|numeric',
            'pincode' =>  'nullable|numeric',
             'active' =>  ['required',
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
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
              ]);
              
            //   dd($data);
            \DB::beginTransaction();
            try
            {
          if($data['location_id']==""){
            $msg="Location Saved";
           $id = \DB::table('m_location_t')->insertGetId($data);
			  $data['company_id'] = \Session::get('companyid');
        }
        else{
            $msg="Location Updated";
			$data['company_id'] = \Session::get('companyid');
			//dd($data);
            $id=\DB::table('m_location_t')->where('location_id', $data['location_id'])->update($data);

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
                dd($dbCode);
                \DB::rollback();
               
                return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
            }
    }

 public function getlocationData($type=null){
    $wh='';
    if($_GET['_search']=='true')
    {
		
         $search_tables=array("a_lookuplines_t","m_cities_t","m_countries_t","m_states_t");
    $wh=$this->jqgridsearch('m_location_t',$_GET['filters'],$search_tables);
    }

    //dd($type);
        if($type!='')   
    {
        $wh.=" and source_type_id='".$type."'";
    }   
      $loc=\Session::get('location');  
$wh1='';
              $wh1.=" and m_location_t.location_id='".$type."'";

        
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;
    $result = \DB::select("SELECT COUNT(m_location_t.location_id) AS count  FROM `m_location_t`  left join a_lookuplines_t  on(a_lookuplines_t.lookuplines_id=m_location_t.`location_type`) left join m_cities_t  on(m_cities_t.city_id=m_location_t.`city_id`) left join m_countries_t  on(m_countries_t.country_id=m_location_t.`country_id`) left join m_states_t  on(m_states_t.state_id=m_location_t.`state_id`)

     where 1=1 $wh and m_location_t.location_id= $loc");
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
    $SQL = "SELECT m_location_t.*,m_cities_t.city_name,m_countries_t.country_name,m_states_t.state_name,a_lookuplines_t.lookup_code,m_cities_t.city_id,m_countries_t.country_id,m_states_t.state_id,a_lookuplines_t.lookuplines_id FROM `m_location_t`  left join a_lookuplines_t  on(a_lookuplines_t.lookuplines_id=m_location_t.`location_type`) left join m_cities_t  on(m_cities_t.city_id=m_location_t.`city_id`) left join m_countries_t  on(m_countries_t.country_id=m_location_t.`country_id`) left join m_states_t on(m_states_t.state_id=m_location_t.`state_id`)
    where 1=1 $wh and m_location_t.location_id= $loc ORDER BY $sidx $sord LIMIT $start , $limit";
     $download_SQL = "SELECT m_location_t.*,m_cities_t.city_name,m_countries_t.country_name,m_states_t.state_name,a_lookuplines_t.lookup_code,m_cities_t.city_id,m_countries_t.country_id,m_states_t.state_id,a_lookuplines_t.lookuplines_id FROM `m_location_t`  left join a_lookuplines_t  on(a_lookuplines_t.lookuplines_id=m_location_t.`location_type`) left join m_cities_t  on(m_cities_t.city_id=m_location_t.`city_id`) left join m_countries_t  on(m_countries_t.country_id=m_location_t.`country_id`) left join m_states_t on(m_states_t.state_id=m_location_t.`state_id`) 
      where 1=1 $wh  and m_location_t.location_id= $loc ORDER BY $sidx $sord LIMIT $start , $limit";
    //   echo($SQL);die;
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

  
    public function locationdelete(Request $request,$id=null)
    {
        // if
        $count = 0;
        $queryquote = \DB::table('tb_users')->where('loc_id',$id)->count();
        if($queryquote >=1)
        {
            $count++;
        }
        if($count <= 0)
            {
            $query = \DB::table('m_location_t')->where('location_id',$id)->delete();
            if($query)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        }
        else{
            return 2;
        }
    }
}
