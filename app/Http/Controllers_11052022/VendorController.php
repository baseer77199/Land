<?php

namespace App\Http\Controllers;

use App\amc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VendorController extends Controller
{
    public function __construct()
    {
         $this->data=array();
        $this->model=new amc();
        $this->data['pageFormtype']='ajax';
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['urlmenu']=$this->indexs(); 
    }



    public function vendorcheckname(Request $request)
    {
        
        $edit_id = $_GET['vendor_id'];
       
       if(is_numeric($edit_id) || $edit_id=''){
        if($edit_id == '')
        {
            
            $group=\DB::table('m_amc_tb')->where('vendor_name',$_GET['vendor_name'])->get();
            
        }
        else
        {
                        

            $whereData = [['vendor_name', $_GET['vendor_name']],['vendor_id', '!=', $edit_id]];

            $group=\DB::table('m_amc_tb')->where($whereData)->get();
        }


        if(count($group)>0)
            return 1;
        else
            return 0;
       }
    }


     public function index()
    {
        
        
        $table = \DB::table('m_amc_tb')->get();
        $this->data['data'] = json_encode($table);
       // $this->data['organization_name']=$this->jqgridselect('m_organizations_t','organization_id','organization_name');
        return view("vendor.table",$this->data);
    }
    public function  vendorform($id="null")
    {
             if(isset($_POST['id']))    
    $id=$_POST['id'];       
if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
        if($id==0)
        {
            $table = \DB::table('m_amc_tb')->get(); 
            $this->data['data']=$table;
            // dd($table[0]);
            $this->data['row']= (object)array(); 
            $this->data['row']->vendor_id="";   
            $this->data['row']->vendor_name="";
            $this->data['row']->email_id="";
            $this->data['row']->contact_no="";
            $this->data['row']->address="";
            $this->data['row']->active="";
            $this->data['pageMethod']="createvendor";
            //$this->data['linedata'] = array();
            // $this->data['location_id'] = $this->jCombo('m_location_t','location_id','location_name','');
            // // $org=\Session::get('organization');
            // $this->data['row']->default_org_id= $this->jCombo('m_organizations_t','organization_id','organization_name',$org);
        }
        else{

           $table = \DB::table('m_amc_tb')->where('vendor_id',$id)->get();
            
            $this->data['data']=$table;
            $this->data['row']= (object)array(); 
            $this->data['row']->vendor_id=$table[0]->vendor_id;
            $this->data['row']->vendor_name=$table[0]->vendor_name;
            $this->data['row']->address=$table[0]->address;
            $this->data['row']->email_id=$table[0]->email_id;
            $this->data['row']->contact_no=$table[0]->contact_no;
            $this->data['row']->active=$table[0]->active;
            $this->data['pageMethod']="vendoredit";
            
            // $this->data['row']->default_org_id= $this->jCombo('m_organizations_t','organization_id','organization_name',$table[0]->default_org_id);
            // $tablelines = \DB::table('m_company_line_t')->where('companyid',$id)->get();
            //  $this->data['location_id'] = $this->jCombo('m_location_t','location_id','location_name','');
            // $this->data['linedata'] = $tablelines;
            
        }
    }
    //dd($tablelines);
        // if(count($this->data['linedata']) >= 1)
        // {
        //     foreach ($this->data['linedata'] as $key => $value)
        //     {
        //         $this->data['linedata'][$key]->location_id = $this->jCombo('m_location_t','location_id','location_name',$value->locationid);
        //     }
        // }
             
        return view("vendor.form",$this->data);

    } 

    public function vendorsave(Request $request)
    {
               
      //  dd($request);
       // $data = $this->validatePost($request->all(),$this->table,'header');  
       $validatedData=   $this->validate($request, [
            'vendor_name' =>  ['required',
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
              'active' => 'required|max:3',
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
                  } if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains equal.');
                  }
                },
            ],
            //   'email_id' =>  [
            //     function($attribute, $value, $fail) {
            //         $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
            //      //   $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
            //         $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
            //         $regex .= "(\:[0-9]{2,5})?"; // Port 
            //         $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
            //     //    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
            //         $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
            
            //       if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
            //       {
            //         return $fail($attribute.' is invalid (contains url).');
            //       }
            //     },function($attribute,$value,$fail){
              
            //       if (str_contains($value, 'script')) {  
            //           return $fail($attribute. ' contains script.');
            //       }
            //     },
            // ],
             'email_id' => 'required|email',
             'contact_no' => 'required|numeric',
            ]);
            
//   $validatedData=   $this->validate($request, [
//             'vendor_name' => 'required',
//             'contact_no' => 'required|min:10|numeric',
//             'email_id' => 'required|email',
//             'address' => 'required|not_in:script|not_in:url|max:255'
//         ]);
        
        \DB::beginTransaction();
        try
        {
           // dd("dsf");
            $amc = new amc();  
            $edit_id = $request->input('vendor_id');

            if($edit_id=="")
            {
                $amc->vendor_name=$_POST['vendor_name'];
                $amc->address=$_POST['address'];
              
                $amc->email_id=$_POST['email_id'];
                $amc->contact_no=$_POST['contact_no'];
 
                $amc->active=$_POST['active'];

                $amc->save();
                $id = $amc->vendor_id;
               \DB::commit();             
             return response()->json(array('status' => 'success', 'message' => 'Saved Successfully','id' => $id));
            }else{

                $amc1['vendor_name']=$_POST['vendor_name'];
                $amc1['address']=$_POST['address'];
                $amc1['email_id'] =$_POST['email_id'];
                $amc1['contact_no'] =$_POST['contact_no'];
                $amc1['active']=$_POST['active'];
                   // dd($amc1);
                $update = \DB::table('m_amc_tb')->where('vendor_id',$edit_id)->update($amc1);
                $id = $edit_id;

             \DB::commit();             
             return response()->json(array('status' => 'success', 'message' => 'Update Successfully','id' => $id));
        }
         }
        catch (\Illuminate\Database\QueryException $e)
        {
             $message = explode('(', $e->getMessage());
             $dbCode = rtrim($message[0], ']');
             $dbCode = trim($dbCode, '[');
 //dd($dbCode);
             \DB::rollback();
            return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
        }
                       
    }

    public function getvendorData($type=null){

     $wh='';
        if($_GET['_search']=='true')
        {
          $search_tables=array('tb_users');  
        $wh=$this->jqgridsearch('m_amc_tb',$_GET['filters'],$search_tables);
        }
        $compy=\Session::get('companyid');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $loc=\Session::get('location');
        $compy=\Session::get('companyid');      
        $groupname=\Session::get('groupname');
        // if($groupname=='Superadmin' || $groupname=='Admin'){
        // $wh.='and  m_amc_tb.company_id='.$compy;  
        // }else{
        //     $wh.='and  m_amc_tb.company_id='.$compy;    
        // } 
        $wh1='';
         $loc=\Session::get('location');
         if($loc != 0){
             $wh1='and  m_amc_tb.location_id='.$loc;
         }      
  
        if(!$sidx) $sidx =1;
        $result = \DB::select("SELECT COUNT(vendor_id) AS count FROM m_amc_tb left join tb_users on (tb_users.id =m_amc_tb.created_by) where 1=1 $wh $wh1");
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
        $SQL = "SELECT m_amc_tb.*,tb_users.username,tb_users.id as created_id FROM m_amc_tb left join tb_users on tb_users.id =m_amc_tb.created_by where 1=1  $wh $wh1 ORDER BY $sidx $sord LIMIT $start , $limit";
        
        $download_SQL = "SELECT m_amc_tb.*,tb_users.username,tb_users.id as created_id FROM m_amc_tb left join tb_users on tb_users.id =m_amc_tb.created_by where 1=1  $wh $wh1 ORDER BY $sidx $sord";
        
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

    function vendorview($id=null)
    {
if(isset($_POST['id']))    
    $id=$_POST['id']; 
    if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
        $headerdata = \DB::table('m_amc_tb as ih')
            ->select('ih.*')
            ->where('ih.vendor_id',$id)
            ->get();
           // dd($headerdata);
        $this->data['headerdata']=$headerdata[0];    

        return view('vendor.view',$this->data);
    }

    }

    public function vendordelete(Request $request,$id=null)
    {
        if(!is_numeric($id)){
            return 3;
        }else{

        $count = 0;
        $queryquote = \DB::table('machine_hdr_t')->where('vendor_id',$id)->count();
        if($queryquote >=1)
        {
            $count++;
        }
        if($count <= 0)
            {
               // dd($id);
            $query = \DB::table('m_amc_tb')->where('vendor_id',$id)->delete();
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

}