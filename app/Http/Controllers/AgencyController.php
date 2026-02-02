<?php

namespace App\Http\Controllers;

use App\agency;
use App\doc;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;

class AgencyController extends Controller
{
 
public function __construct()
    {
        $this->data=array();
        $this->model    = new agency();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='agency';
        $this->table=" ma_agency_t";   
        $this->middleware('auth');
        $this->data['urlmenu']=$this->indexs(); 

    }

    public function index()
    {
        $this->data['pageMethod']="agency";
return view('Agency.table',$this->data);
    }

    public function create($id=null)
    {
        if(isset($_POST['id']))    
    $id=$_POST['id']; 
    if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
        if($id!=0)
        {   
            $this->data['id'] = $id;
            $this->data['pagemode'] = "edit";
            $table = \DB::table('ma_agency_t')->where('agency_id',$id)->get();
    //     dd($table);
            $this->data['row'] = $table[0];
             $this->data['country_id'] = $this->jCombologin('m_countries_t', 'country_id', 'country_name', $table[0]->country);
        $this->data['state_id'] =$table[0]->state; 
        $this->data['city_id'] = $table[0]->city;     
 }
 else{
     $this->data['pagemode'] = "create";
                $this->modelname = new agency();

               // dd($this->modelname);
                $this->data['row']= (object)array();
                // dd($this->data['row']);
               $table = $this->modelname->getTableColumns();
               // dd($table);
                foreach($table as $key=>$val)
                {       
                  $this->data['row']->$val='';
                }
            $this->data['country_id'] = $this->jCombologin('m_countries_t', 'country_id', 'country_name','');
            
             $this->data['state_id'] =""; 
             $this->data['city_id'] =""; 
             } 
    }
return view('Agency.form',$this->data);
    }

    public function getagencyData(Request $request)   
    
       {
       
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('ma_agency_t',$_GET['filters']);
        }
        $wh1='';
         $loc=\Session::get('location');
         if($loc != 0){
             $wh1='and  ma_agency_t.location_id='.$loc;
         }      

    if(!$sidx) $sidx =1;
        
        

    $result = \DB::select("SELECT COUNT(agency_id) AS count FROM  ma_agency_t where 1=1 $wh $wh1");
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
 $sql="SELECT ma_agency_t.*,tb_users.username from ma_agency_t left join tb_users on(tb_users.id=ma_agency_t.created_by) where 1=1 $wh $wh1 ORDER BY $sidx $sord  LIMIT $start,$limit";      
     
     $download_SQL="SELECT ma_agency_t.*,tb_users.username from ma_agency_t left join tb_users on(tb_users.id=ma_agency_t.created_by) where 1=1 $wh $wh1 ORDER BY $sidx $sord";
 $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
    $result = \DB::select($sql);
   // dd($result);
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

       

    echo json_encode($responce);
    }

    
        
 
    // 
     public function save(Request $request)
    { 
        
    //    dd($_POST['mobile_no']);
          $validatedData=   $this->validate($request, [
            // 'agency_name' => 'required',
            'mobile_no' => 'required|numeric',
              'country' => 'nullable|numeric',
              'state' => 'nullable|numeric',
              'city' => 'nullable|numeric',
            'email' => 'required|email',
            // 'address' => 'not_in:script|not_in:url'
            
                'agency_name' => ['required',
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
            
           
            
        ]);
        
         $edit_id = $request->input('agency_id');
       
       if($edit_id == ''){ 
 
        $agency=new agency(); 
            $agency->agency_name=$_POST['agency_name'];
            $agency->agency_id=$_POST['agency_id'];
            $agency->mobile_no=$_POST['mobile_no'];
            $agency->email=$_POST['email'];
            $agency->address=$_POST['address'];
            $agency->country=$_POST['country'];
            $agency->state=$_POST['state'];
            $agency->city=$_POST['city'];
            $agency->active=$_POST['active'];
            $agency->created_by=\Session::get('created_by');
            $agency->location_id=\Session::get('location');
           // $agency->organisation_id=\Session::get('organization_id');
            $agency->company_id=\Session::get('companyid');
            $agency->created_by=\Session::get('id');
            $agency->last_updated_by=\Session::get('id');
            $agency->save();
          //  dd($breakdowntype);
            $edit_id= \DB::getPdo()->lastInsertId();
            $action="Create";

            /**Auditlog**/
            $this->auditlog($edit_id,"agencycreate",$action,$_POST,"ma_agency_t");
            return response()->json(array('status' => 'success', 'message' => 'Agency Saved Successfully','id'=>$edit_id));
        }
        else{

            $action="Edit";
          //  dd($_POST['agency_id']);
            $edit_id=$_POST['agency_id'];
            // $_POST['created_by'] =  \Sesion::get('id');
            $_POST['last_updated_by'] =  \Session::get('id');
            $_POST['company_id'] =  \Session::get('companyid');
            $_POST['location_id'] =  \Session::get('location');
            $_POST['organization_id'] =  \Session::get('organization');
            // $_POST['created_at'] =  date('Y-m-d H:i:s');
            $_POST['updated_at'] =  date('Y-m-d H:i:s');
            //  dd(agency);
            agency::find($edit_id)->update($_POST); 
//dd($si);
            /**Auditlog**/
            $this->auditlog($edit_id,"agencycreate",$action,$_POST,"ma_agency_t");
            return response()->json(array('status' => 'success', 'message' => 'Agency Updated Successfully','id'=>$edit_id));
        }
      }
    public function destroy(Request $request,$id=null)
    {  
//dd($id);
    $column = array('allocated_agency');

        $table = array('machine_pm_detail_t');
        for($i=0; $i<count($table); $i++)
        {
            // dd($id);
            $j=0;
            $query = \DB::table($table[$i])->where($column[$i],$id)->get();
           // dd($query);
            if(count($query)>0)
            {
                $j=1;
                break;
            }
        }
//dd($j);
        if($j==0)
        {
           // dd("fdg");
            $query = \DB::table('ma_agency_t')->where('agency_id',$id)->delete();
           // dd($query);
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"agency",$action,$id,"ma_agency_t");
            
        }

    return $j;

    }
        public function editcheck($id=null) 
    {
              $column = array('agency_id');
         $table = array('ma_agency_t'); 
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
public function view($id=null)
{
     if(isset($_POST['id']))   
     $id=$_POST['id']; 
     if(!is_numeric($id)){
         return \Redirect::back()->withErrors(['msg' => 'The Message']);
     }else{
        $header = \DB::table('ma_agency_t')
        ->leftjoin('m_countries_t','m_countries_t.country_id','=','ma_agency_t.country')
        ->leftjoin('m_states_t','m_states_t.state_id','=','ma_agency_t.state')
        ->leftjoin('m_cities_t','m_cities_t.city_id','=','ma_agency_t.city')
        ->select('ma_agency_t.*','m_states_t.state_name','m_cities_t.city_name','m_countries_t.country_name')
        ->where('agency_id',$id)->get();
            $this->data['header'] = $header[0];

    return view('Agency.view',$this->data);
     }

}
// /*deepika purpose:to check duplicate name*/ 
      public function agencynamechk(Request $request)
    { 
        $agency_id = $_GET['edit_id'];
        
        if(is_numeric($agency_id) || $agency_id==''){
         
        if($agency_id == ''){
            $whereData = [['agency_name', $_GET['agency_name']]];
            $agency=\DB::table('ma_agency_t')->where($whereData)->get();
        //    dd($agency);
        } else {
            $whereData = [['agency_name', $_GET['agency_name']],['agency_id', '!=', $agency_id]];
            $agency=\DB::table('ma_agency_t')->where($whereData)->get();
        }
      
        if(count($agency)>0)
                     return 1;
        else
                      return 0;
        }
    }
//     /*end*/
    
          public function documentindex()
    {
        $this->data['pageMethod']=\Request::route()->getName();
        return view('Agency.doctable',$this->data);
    }  
    public function documentrenewelcreate($id=null)
    {
          $this->data['pagemethod'] = \Request::route()->getName();
          if(isset($_POST['id']))    
    $id=$_POST['id'];  
        if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{

        if($id!='')
        {   
            $this->data['id'] = $id;
            $this->data['pagemode'] = "edit";
          $this->data['row']= (object)array();
            $table = \DB::table('document_tb')->where('document_id',$id)->get();
      //   dd($table);
         $this->data['row']->document_id = $table[0]->document_id;
         $this->data['row']->description = $table[0]->description;
         $this->data['row']->file = '';
         $this->data['row']->company_id = $table[0]->company_id;
         $this->data['row']->location_id = $table[0]->location_id;
         $this->data['row']->new_renewal_date = $table[0]->new_renewal_date;
         $this->data['row']->renewed_on = $table[0]->renewed_on;
         $this->data['row']->renewal_date = $table[0]->renewal_date;
         $this->data['row']->valid_from  = '';
         $this->data['row']->valid_to   = '';
         $this->data['row']->remainder_days  = $table[0]->remainder_days;
         
          //  $this->data['row'] = $table[0];
             $this->data['department_id'] = $this->jCombologin('ma_department_t', 'department_id', 'department_name', $table[0]->department_id);
             $this->data['machine_id'] = $this->jCombologin('machine_hdr_t', 'machine_id', 'machine_name', $table[0]->machine_id);
             $this->data['frequency'] = $this->jCombologin('frequency_tbl', 'frequency_id', 'frequency_name', $table[0]->frequency);
             
 }
    }
 return view('Agency.docform',$this->data);
    }
  public function documentcreate($id=null)
    {
        if(isset($_POST['id']))    
            $id=$_POST['id'];  
             $this->data['pagemethod'] = \Request::route()->getName();
             if(!is_numeric($id)){
                 return \Redirect::back()->withErrors(['msg' => 'The Message']);
             }
             else{
        if($id!=0)
        {   
            $this->data['id'] = $id;
            $this->data['pagemode'] = "edit";
          
            $table = \DB::table('document_tb')->where('document_id',$id)->get();
    //     dd($table);
            $this->data['row'] = $table[0];
             $this->data['department_id'] = $this->jCombologin('ma_department_t', 'department_id', 'department_name', $table[0]->department_id);
             $this->data['machine_id'] = $this->jCombologin('machine_hdr_t', 'machine_id', 'machine_name', $table[0]->machine_id);
             $this->data['frequency'] = $this->jCombologin('frequency_tbl', 'frequency_id', 'frequency_name', $table[0]->frequency);
             
 }
 else{
     $this->data['pagemode'] = "create";
                $this->modelname = new doc();
               // dd($this->modelname);
                $this->data['row']= (object)array();
                // dd($this->data['row']);
               $table = $this->modelname->getTableColumns();
               // dd($table);
                foreach($table as $key=>$val)
                {       
                  $this->data['row']->$val='';
                }
          $this->data['machine_id'] = $this->jCombolocation('machine_hdr_t', 'machine_id', 'machine_name','');      
           $this->data['department_id'] = $this->jCombologin('ma_department_t', 'department_id', 'department_name','');
             $this->data['frequency'] = $this->jCombologin('frequency_tbl', 'frequency_id', 'frequency_name', '');
             } 
    }
return view('Agency.docform',$this->data);
    }

         public function getrenewalData(agency $agency)   
     {
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $wh='';
        if($_GET['_search']=='true')
        {
            $table = array('tb_users','ma_department_t','frequency_tbl','ma_department_t','machine_hdr_t');
        $wh.=$this->jqgridsearch('document_tb',$_GET['filters'],$table);
        }
    if(!$sidx) $sidx =1;
    $locat_id=\Session::get('location');
    $wh1='';   
    if($locat_id != 0){
      $wh1='and  machine_hdr_t.locationid='.$locat_id;
      
  }
    $result = \DB::select("SELECT document_tb.*,tb_users.username,frequency_tbl.frequency_name,ma_department_t.department_name,machine_hdr_t.machine_name from document_tb left join tb_users on(tb_users.id=document_tb.created_by) left join frequency_tbl on(frequency_tbl.frequency_id=document_tb.frequency) left join ma_department_t on(ma_department_t.department_id=document_tb.department_id) left join machine_hdr_t on machine_hdr_t.machine_id=document_tb.machine_id where 1=1  and status=0 $wh1 $wh");
    $count = count($result);
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
 $sql="SELECT document_tb.*,tb_users.username,frequency_tbl.frequency_name,ma_department_t.department_name,machine_hdr_t.machine_name from document_tb left join tb_users on(tb_users.id=document_tb.created_by) left join frequency_tbl on(frequency_tbl.frequency_id=document_tb.frequency) left join ma_department_t on(ma_department_t.department_id=document_tb.department_id) left join machine_hdr_t on machine_hdr_t.machine_id=document_tb.machine_id where 1=1  and status=0 $wh1 $wh ORDER BY $sidx $sord  LIMIT $start,$limit";      
 $download_SQL="SELECT document_tb.*,tb_users.username,frequency_tbl.frequency_name,ma_department_t.department_name,machine_hdr_t.machine_name from document_tb left join tb_users on(tb_users.id=document_tb.created_by) left join frequency_tbl on(frequency_tbl.frequency_id=document_tb.frequency) left join ma_department_t on(ma_department_t.department_id=document_tb.department_id) left join machine_hdr_t on machine_hdr_t.machine_id=document_tb.machine_id where 1=1  and status=0 $wh1 $wh ORDER BY $sidx $sord";
 $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
    $result = \DB::select($sql);
 //   dd($result);
    
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);
    }
    
  public function getdocumentData(agency $agency)   
        {
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $wh='';
        $locat_id=\Session::get('location');
        if($_GET['_search']=='true')
        {
             $table = array('tb_users','ma_department_t','frequency_tbl','ma_department_t','machine_hdr_t');
        $wh.=$this->jqgridsearch('document_tb',$_GET['filters'],$table);
        }
    if(!$sidx) $sidx =1;
     $wh1='';   
    if($locat_id != 0){
      $wh1='and  machine_hdr_t.locationid='.$locat_id;
      
  }

    $result = \DB::select("SELECT document_tb.*,tb_users.username,frequency_tbl.frequency_name,ma_department_t.department_name,machine_hdr_t.machine_name from document_tb left join tb_users on(tb_users.id=document_tb.created_by) left join frequency_tbl on(frequency_tbl.frequency_id=document_tb.frequency) left join ma_department_t on(ma_department_t.department_id=document_tb.department_id) left join machine_hdr_t on machine_hdr_t.machine_id=document_tb.machine_id where 1=1 $wh $wh1");
    $count = count($result);
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
 $sql="SELECT document_tb.*,tb_users.username,frequency_tbl.frequency_name,ma_department_t.department_name,machine_hdr_t.machine_name from document_tb left join tb_users on(tb_users.id=document_tb.created_by) left join frequency_tbl on(frequency_tbl.frequency_id=document_tb.frequency) left join ma_department_t on(ma_department_t.department_id=document_tb.department_id) left join machine_hdr_t on machine_hdr_t.machine_id=document_tb.machine_id where 1=1 $wh1 $wh ORDER BY $sidx $sord  LIMIT $start,$limit";      
     $download_SQL="SELECT document_tb.*,tb_users.username,frequency_tbl.frequency_name,ma_department_t.department_name,machine_hdr_t.machine_name from document_tb left join tb_users on(tb_users.id=document_tb.created_by) left join frequency_tbl on(frequency_tbl.frequency_id=document_tb.frequency) left join ma_department_t on(ma_department_t.department_id=document_tb.department_id) left join machine_hdr_t on machine_hdr_t.machine_id=document_tb.machine_id where 1=1 $wh1 $wh ORDER BY $sidx $sord";
 $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
    $result = \DB::select($sql);
 //   dd($result);
    
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

    echo json_encode($responce);
    }
    
    function checkurl($attribute,$value) {
        
        
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
                  if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
                  {
                    return ($attribute.' is invalid (contains url).');
                  }
                  
        
        
                }
   function checkscript($attribute,$value){
              
                  if (str_contains($value, 'script')) {  
                      return ($attribute. ' contains script.');
                  }
                }             
  public function documentsave(Request $request)
    {
        $edit_id = $request->input('document_id');

        $todayDate = date('Y-m-d');
        $valid_from=$request->input('valid_from');

        $stop_date =  date('Y-m-d', strtotime($valid_from));

  $validatedData=   $this->validate($request, [
            'frequency' =>  ['required',
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
                //       return $fail($attribute. ' contains equals(=).');
                //   }
                // },
                function ($attribute, $value, $fail) {
                  //no url = nourl
                  //no url no email = nourlnoemail
                  $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                  $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                },
            ],
            'description' =>  ['required',
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
                //       return $fail($attribute. ' contains equals(=).');
                //   }
                // },
                function ($attribute, $value, $fail) {
                  //no url = nourl
                  //no url no email = nourlnoemail
                  $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                  $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                },
            ],
             'department_id' =>  ['required',
                //  function($attribute, $value, $fail) {
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
                //       return $fail($attribute. ' contains equals(=).');
                //   }
                // },
                function ($attribute, $value, $fail) {
                  //no url = nourl
                  //no url no email = nourlnoemail
                  $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                  $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                },
            ],
              'machine_id' =>  ['required',
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
                // },
                function ($attribute, $value, $fail) {
                  //no url = nourl
                  //no url no email = nourlnoemail
                  $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                  $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                },
            ],
            'valid_from' =>  'required|date_format:Y-m-d|after_or_equal:'.$todayDate,
            'renewal_date' =>  'required|date_format:Y-m-d|after_or_equal:'.$todayDate,
            'valid_to' => 'required|date_format:Y-m-d|after_or_equal:'.$stop_date,
            'remainder_days'=>'required|numeric'
           
            ]);
            
           //  dd($_POST);
       if($edit_id == ''){ 
 
           $doc=new doc(); 
           $doc->department_id=$_POST['department_id'];
         //   $doc->form_no=$_POST['form_no'];
            $doc->frequency=$_POST['frequency'];
             $doc->valid_from=$_POST['valid_from'];
            $doc->valid_to=$_POST['valid_to'];
             $doc->description=$_POST['description'];
          //  $doc->fee=$_POST['fee'];
           // $doc->file=$_POST['file'];
          //  $doc->approval_authority=$_POST['approval_authority'];
            $doc->machine_id=$_POST['machine_id'];
          //  $doc->approval_valid=$_POST['approval_valid'];
            $doc->renewal_date=$_POST['renewal_date'];
            $doc->remainder_days=$_POST['remainder_days'];
            
            $doc->created_by=\Session::get('created_by');
            $doc->location_id=\Session::get('location');
           // $doc->organisation_id=\Session::get('organization_id');
            $doc->company_id=\Session::get('companyid');
            $doc->created_by=\Session::get('id');
            $doc->last_updated_by=\Session::get('id');
            $file_save=[];
            if($request->hasfile('file'))
	            {
        
                 foreach($request->file('file') as  $key1=>$file)
            {
                        
                   $name=$file->getClientOriginalName();
                   $file->move(public_path().'/document/', $name);
                  $file_save[$key1]=$name;
            }
                   $doc->file=json_encode($file_save);
            }
           
            $doc->save();
          //  dd($breakdowntype);
            $edit_id= \DB::getPdo()->lastInsertId();
            $action="Create";

            /**Auditlog**/
            $this->auditlog($edit_id,"documentcreate",$action,$_POST,"document_tb");
            return response()->json(array('status' => 'success', 'message' => 'Document Saved Successfully','id'=>$edit_id));
        }
        else{

            $action=$request->input('edit_id');
            $edit_id=$_POST['document_id'];
            if($action=='RENEW'){
                $_POST['renewed_on']=date('Y-m-d');
                //dd($_POST['renewed_on']);
            doc::find($edit_id)->update($_POST); 
            /**Auditlog**/
            $this->auditlog($edit_id,"documentrenew",$action,$_POST,"document_tb");
            
            $date_save=\DB::SELECT("select  file from document_tb where document_id=$edit_id");

            $action='documentrenewcreate';
             $doc=new doc(); 
           $doc->doc_id=$edit_id;
             $doc->department_id=$_POST['department_id'];
           // $doc->form_no=$_POST['form_no'];
            $doc->frequency=$_POST['frequency'];
             $doc->valid_from=$_POST['valid_from'];
            $doc->valid_to=$_POST['valid_to'];
             $doc->description=$_POST['description'];
          //  $doc->fee=$_POST['fee'];
          $doc->machine_id=$_POST['machine_id'];
          //  $doc->approval_authority=$_POST['approval_authority'];
         //   $doc->approval_valid=$_POST['approval_valid'];
            $doc->renewal_date=$_POST['new_renewal_date'];
            $doc->remainder_days=$_POST['remainder_days'];
            
            $doc->created_by=\Session::get('created_by');
            $doc->location_id=\Session::get('location');
           // $doc->organisation_id=\Session::get('organization_id');
            $doc->company_id=\Session::get('companyid');
            $doc->created_by=\Session::get('id');
            $doc->last_updated_by=\Session::get('id');
         
             if($request->hasfile('file'))
	            {
                 foreach($request->file('file') as  $key1=>$file)
            {
                     $name=$file->getClientOriginalName();
                  // dd($name);
                   $file->move(public_path().'/document/', $name);
                  $file_save[$key1]=$name;
            }
             $file_data=\DB::SELECT("select file from document_tb where document_id=".$edit_id);
          if($file_data[0]->file!=NULL){
          $file_new=json_decode($file_data[0]->file);
         $file_save= array_merge($file_new,$file_save);
          }
          
                 $doc->file=json_encode($file_save);
            }
            $doc->save();
            $edit_id= \DB::getPdo()->lastInsertId();
            $action="Create";

            /**Auditlog**/
            $this->auditlog($edit_id,"documentcreate",$action,$_POST,"document_tb");
            return response()->json(array('status' => 'success', 'message' => 'Calibration Renewed Successfully','id'=>$edit_id));
            }
            else{
                if($request->hasfile('file'))
	            {
                 foreach($request->file('file') as  $key1=>$file)
            {   
                   $name=$file->getClientOriginalName();
                  // dd($name);
                   $file->move(public_path().'/document/', $name);
                  $file_save[$key1]=$name;
            }
                  $_POST['file']=json_encode($file_save);
            }
            doc::find($edit_id)->update($_POST); 

            /**Auditlog**/
            $this->auditlog($edit_id,"documentcreate",$action,$_POST,"document_tb");
            return response()->json(array('status' => 'success', 'message' => 'Calibration Updated Successfully','id'=>$edit_id));  
            }
        }
      } 
   public function documentdestroy(Request $request,$id=null)
    {  
        if(!is_numeric($id)){
            return 3;
        }else{
            $query = \DB::table('document_tb')->where('document_id',$id)->delete();
         
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"document",$action,$id,"document_tb");
            
        

    return 0;
        }

    }
//        public function editcheck($id=null) 
//    {
//              $column = array('agency_id');
//         $table = array('ma_agency_t'); 
//        for($i=0; $i<count($table); $i++)
//        {
//            $j=0;
//            $query = \DB::table($table[$i])->where($column[$i],$id)->get();
//            if(count($query)>0)
//            {
//                $j=1;
//               return $j;
//            }
//        }
//    return $j;
//    }
    public function documentview($id=null)
{
 if(isset($_POST['id']))    
    $id=$_POST['id'];     
        $header = \DB::table('document_tb')
        ->leftjoin('ma_department_t','ma_department_t.department_id','=','document_tb.department_id')
        ->leftjoin('frequency_tbl','frequency_tbl.frequency_id','=','document_tb.frequency')
        ->select('document_tb.*','ma_department_t.department_name','frequency_tbl.frequency_name')
        ->where('document_id',$id)->get();
       // dd($header);
            $this->data['header'] = $header[0];

    return view('Agency.docview',$this->data);

}  
    
    
}
