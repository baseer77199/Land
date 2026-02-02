<?php

namespace App\Http\Controllers;

use App\Createuser;
use App\Http\Controllers\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Database\Eloquent\Model,Input;

class CreateuserController extends Controller
{
    
  public function __construct(){
        $this->data=array();
    $this->table="a_m_users_t";
    //$this->data['urlmenu']=$this->indexs(); 
    $this->pageModule="user";
    $this->model=new Createuser;
    $this->data['pageModule']=$this->pageModule;
    $this->data['pageMethod']=\Request::route()->getName();
    $this->data['pageFormtype']='ajax';
		$this->data=array(
			'pageModule'=> 'createuser',
			'pageUrl' =>  url($this->data['pageMethod']),
'pageMethod'=>$this->data['pageMethod']
		  );
    $this->modelname = new Createuser();
    $this->data['pageFormtype']='ajax';
    $this->data['urlmenu']=$this->indexs();
               
  }

    public function index(){
    $this->data['pageMethod']=\Request::route()->getName();
        $table = \DB::table('tb_users')->get();   
        $this->data['data']=$table;
       
        return view("createuser.table",$this->data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
     if(isset($_POST['id']))    
    $id=$_POST['id'];       
     if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
         if(isset($_GET['pagemethod'])){
          $this->data['pageMethod']=$_GET['pagemethod'];
         }
          $this->data['pageModule']="user";

            if(!empty($id))
            {
                
                $this->data['row']= (object)array();
                $user_id=\DB::select("select * from tb_users where id='$id'");
                $this->data['row']->group_id=$this->jCombologin('a_m_group_t','group_id','group_name',$user_id[0]->group_id);  
                $this->data['row']->org_id=$this->jCombologin('m_organizations_t','organization_id','organization_name', $user_id[0]->org_id); 
    //             $locid=json_decode($user_id[0]->loc_id);
				// if($locid !==null)
				// {
    //             $locationid=implode($locid,",");
				// }
				// else					
				// {
				// $locationid='';	
				// }
        $dep=json_decode($user_id[0]->admindept_id);
				if($dep !==null)
				{
                $deptid=implode($dep,",");
				}
				else					
				{
				$deptid='';	
				}
                $comp=\Session('companyid');
                $sqlhdr=\DB::select("select * from m_company_t where company_id=".$comp);
                $sql=\DB::select("select * from m_company_line_t where companyid=".$sqlhdr[0]->company_id);
                
                // $locarr ='';
                
                // foreach($sql as $key=>$value)
                // {
                //     $locarr.=$value->locationid.',';
                // }
                
                // $arr = rtrim($locarr ,',');
               
                $this->data['row']->loc_id=$this->jcombologin('m_location_t','location_id','location_name',$user_id[0]->loc_id); 
                $this->data['row']->comp_id=$this->jCombocomp('m_company_t','company_id','company_name',\Session('companyid'));  
                  $this->data['row']->designation=$this->jcombologin('designation_tbl','designation_id','designation_name',$user_id[0]->designation_id);
                  $this->data['row']->department_id=$this->jcombologin('user_department_t','department_id','department_name',$user_id[0]->department_id);     
                  $this->data['row']->machine_department_id=$this->jcombologin('ma_department_t','department_id','department_name',$user_id[0]->machine_department_id);     
                $this->data['row']->first_name=$user_id[0]->first_name;   
                $this->data['row']->username=$user_id[0]->username;   
                $this->data['row']->last_name=$user_id[0]->last_name;  
                $this->data['row']->active=$user_id[0]->active; 
                $this->data['row']->email=$user_id[0]->email;   
                $this->data['row']->mobile_no=$user_id[0]->mobile_no;
                $this->data['row']->user_id=$user_id[0]->id;
                $this->data['row']->avatar=$user_id[0]->avatar;
                $this->data['row']->user_mail=$user_id[0]->user_mail;
                $this->data['row']->employee_id=$user_id[0]->employee_id;
           }
        else
        {
           
            $this->data['row']= (object)array();
            $this->data['row']->group_id=$this->jCombologin('a_m_group_t','group_id','group_name','');  
            $this->data['row']->org_id=$this->jCombologin('m_organizations_t','organization_id','organization_name',\Session::get('organization'));  
            $comp=\Session('companyid');
            $sqlhdr=\DB::select("select * from m_company_t where company_id=".$comp);
            $sql=\DB::select("select * from m_company_line_t where companyid=".$sqlhdr[0]->company_id);
            // $locarr ='';
            // foreach($sql as $key=>$value)
            // {
            //     $locarr.=$value->locationid.',';
            // }
            // $arr = rtrim($locarr ,',');

            $this->data['row']->loc_id=$this->jcombologin('m_location_t','location_id','location_name','');
            $this->data['row']->comp_id=$this->jcustomselect('m_company_t','company_id','company_name',\Session('companyid'),'');  
            $this->data['row']->designation=$this->jcombologin('designation_tbl','designation_id','designation_name','');  
            $this->data['row']->department_id=$this->jcombologin('user_department_t','department_id','department_name','');
             $this->data['row']->machine_department_id=$this->jcombologin('ma_department_t','department_id','department_name',''); 
            $this->data['row']->first_name="";   
            $this->data['row']->username=""; 
            $this->data['row']->active=""; 
            $this->data['row']->last_name="";   
            $this->data['row']->email="";   
            $this->data['row']->mobile_no="";
            $this->data['row']->user_id="";
            $this->data['row']->user_mail="";
            $this->data['row']->employee_id="";

        }
    }      
        return view("createuser.form",$this->data);
    }

     public function delete(Request $request,$id=null)
    {
        if(!is_numeric($id)){
            return 3;
        }else{
    
                $query = \DB::table('tb_users')->where('id',$id)->delete();
                $query = \DB::table('a_user_access_t')->where('user_id',$id)->delete();
                return 0;
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

         public function save(Request $request){
        // dd($request->all());

$validatedData=   $this->validate($request, [
            'username' =>  ['required',
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
            'first_name' => ['required',
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
            'loc_id'=>'required|numeric',
            'last_name' => [
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
            'email'=> ['required','email',
                function($attribute, $value, $fail) {
                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                 //   $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                    $regex .= "(\:[0-9]{2,5})?"; // Port 
                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                  //  $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
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
            'company_id' => 'required|numeric',
            'designation_id' => 'required|numeric',
            'mobile_no' => 'required|numeric',
            'active' => ['required',
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
            'password' => [
                function($attribute,$value,$fail){
              
                  if (str_contains($value, 'script')) {  
                      return $fail($attribute. ' contains script.');
                  }
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
        'machine_department_id' => 'required|numeric',
        'department_id' => 'required|numeric',
        'group_id' => 'required|numeric',
        'user_id' => 'nullable|numeric',
        ]); 
       //   dd("dsf");
           if($_POST['user_id'] =="")
               {
              
                $createuser = new Createuser();
                $createuser->employee_number = $request->input('username');
                $createuser->username = $request->input('username');
                $createuser->first_name      = $request->input('first_name');
                $createuser->last_name       = $request->input('last_name');
                $createuser->email           = $request->input('email');
                $createuser->company_id      = $request->input('company_id');
                $createuser->org_id          = \Session::get('organization');
                $createuser->loc_id          = $request->input('loc_id');
                $createuser->designation_id    = $request->input('designation_id');
                $createuser->machine_department_id    = $request->input('machine_department_id');
                $createuser->department_id    = $request->input('department_id');
                $createuser->group_id        =     $group_id   = $request->input('group_id');
                if($request->input('password')==null){
                $createuser->password        ="welcome123";
              }
              else{
                 $createuser->password = $request->input('password');

              }
          
                $createuser->mobile_no       = $request->input('mobile_no');
                $createuser->active          = $request->input('active');
                $createuser->employee_id     =$request->input('employee_id');
                $createuser->updated_at      =  "";
                $createuser->created_at      =  "";
                 
                $image = $request->file('avatar');
                if($image != "")
                {
                    $name = $createuser->username.rand(10,100).'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/profile_images');
                    $image->move($destinationPath, $name);
                    $createuser->photo = $name;
                }else{
                  $createuser->photo = "profile_none.jpg";
                }
                
                
              
                //   dd(hash($createuser->password));
                /*** user table ****/
                $user_details = array('machine_department_id'=>$createuser->machine_department_id,'employee_number'=>$createuser->employee_number,'group_id' =>$createuser->group_id ,'username' =>$createuser->username,'password' => bcrypt($createuser->password),'email' => $createuser->email,
                'first_name' => $createuser->first_name,'last_name' => $createuser->last_name,'company_id'=>$createuser->company_id,'loc_id'=>$createuser->loc_id, 'designation_id'=>$createuser->designation_id,'department_id'=>$createuser->department_id,'org_id'=>$createuser->org_id,'avatar'=>$createuser->photo,'mobile_no'=>$createuser->mobile_no,'employee_id'=> $createuser->employee_id,'active'=>$createuser->active);
                /**********/
           // dd($user_details);
                $data['user_id'] = \DB::table('tb_users')->insertGetId($user_details);
         
          $group_access = DB::table('a_group_menu_access_t')->where('group_id',$group_id)->get();
			   if(count($group_access)>0){
          $data['menus'] = $group_access[0]->menus;
          $data['permission'] = $group_access[0]->permission;
          $data['group_id'] = $group_id;
			   }else{
		  $data['menus'] = "";
          $data['permission'] = "";
          $data['group_id'] = $group_id;   
			   }
            $user_access = DB::table('a_user_access_t')->insert($data);   
         
         
                
                return 1;
            } else 
            {
                
                $input_data = $request->all();
                $createuser = new Createuser();
                $createuser->username        = $request->input('username');
                $createuser->employee_number        = $request->input('username');
                $createuser->first_name      = $request->input('first_name');
                $createuser->user_mail      = $request->input('user_mail');
                $createuser->user_password      = $request->input('user_password');
                $createuser->last_name       = $request->input('last_name');
                $createuser->email           = $request->input('email');
                $createuser->company_id      = $request->input('company_id');
                $createuser->org_id          = \Session::get('organization');
                $createuser->loc_id          = $request->input('loc_id');
                $createuser->designation_id    = $request->input('designation_id');
                $createuser->department_id    = $request->input('department_id');
                $createuser->group_id        = $group_id   = $request->input('group_id');
                $createuser->active          = $request->input('active');
                $createuser->mobile_no       = $request->input('mobile_no');
                $createuser->employee_id     = $request->input('employee_id');
                $createuser->updated_at      =  "";
                $createuser->created_at      =  "";
                  $createuser->machine_department_id    = $request->input('machine_department_id');
                    $user = \DB::table('tb_users')->where('id',$_POST['user_id'])->get(); 
               
                    $image = $request->file('avatar');
                    if($image != "")
                    {
                          
                        $image_path =  public_path('/images/profile_images/'.$user[0]->avatar); 
                     
if($user[0]->avatar != null) {
   unlink($image_path);
}

                        $name = $createuser->username.rand(10,100).'.'.$image->getClientOriginalExtension();
                
                        $destinationPath = public_path('/images/profile_images');
                        $image->move($destinationPath, $name);
                        $photo = $name;
                        
                    }
                    else
                    {
                      
                        $photo = $user[0]->avatar;
                    }
                    //dd($request->input('password'));
                    $password= $request->input('password');
                    if($password!=null)
                    {
                        $password=bcrypt($_POST['password']);
                    } else
                    {
                        $password=$user[0]->password;  
                    }
                    
           
                    
                   $createuser->photo=$photo;
                   $createuser->password=$password;
                     $user_details = array('machine_department_id'=>$createuser->machine_department_id,'employee_number'=>$createuser->employee_number,'group_id' =>$createuser->group_id ,'username' =>$createuser->username,'password' => $password,'email' => $createuser->email,
                'first_name' => $createuser->first_name,'active'=>$createuser->active,'last_name' => $createuser->last_name,'company_id'=>$createuser->company_id,'loc_id'=>$createuser->loc_id,'designation_id'=>$createuser->designation_id,'department_id'=>$createuser->department_id, 'org_id'=>$createuser->org_id,'avatar'=>$createuser->photo,'mobile_no'=>$createuser->mobile_no,'employee_id'=> $createuser->employee_id,'user_mail'=>$createuser->user_mail,'user_password'=>$createuser->user_password);
                   
                     $tb_user = \DB::table('tb_users')->where('id', $_POST['user_id'])->update($user_details);
         
          $group_access = DB::table('a_group_menu_access_t')->where('group_id',$group_id)->get();
          $data['menus'] = $group_access[0]->menus;
          $data['permission'] = $group_access[0]->permission;
            $data['group_id'] = $group_id;
          $data['user_id']=$_POST['user_id'];
                    $check_exist =  \DB::table('a_user_access_t')->where('user_id',$data['user_id'])->get();
          if(count($check_exist)>0){
          $user_access = \DB::table('a_user_access_t')->where('user_id',$_POST['user_id'])->update($data);
          }
          else
          {
            $user_access = \DB::table('a_user_access_t')->insert($data);
          }
         
         
         
                    return 2;
                }
           
          
            
      
             
                    

        }
  

    /**
     * Display the specified resource.
     *
     * @param  \App\Createuser  $createuser
     * @return \Illuminate\Http\Response
     */
    public function show(Createuser $createuser,$id=null)
    {
         $id=$_POST['id'];
         
        if(isset($id)){
        if(!is_numeric($id)){
            return \Redirect::back()->withErrors(['msg' => 'The Message']);
        }else{
                  $user=DB::table('tb_users')->leftjoin('m_organizations_t','m_organizations_t.organization_id','=','tb_users.org_id')
                ->leftjoin('m_location_t','m_location_t.location_id','=','tb_users.loc_id')
                ->leftjoin('m_company_t','m_company_t.company_id','=','tb_users.company_id')
                 ->leftjoin('m_department_lines_t','m_department_lines_t.department_line_id','=','tb_users.admindept_id') 
                 ->leftjoin('a_m_group_t','a_m_group_t.group_id','=','tb_users.group_id') 
                  ->select('tb_users.*','m_location_t.location_id','m_company_t.company_id','m_department_lines_t.sub_department_name','m_department_lines_t.department_line_id','a_m_group_t.group_id')
                    ->where('id',$id)->get();
                  $this->data['user_name']=$user[0]->username;
                  $this->data['first_name']=$user[0]->first_name;
                  $this->data['last_name']=$user[0]->last_name;
                  $this->data['email']=$user[0]->email;
                  $this->data['mobile_no']=$user[0]->mobile_no;
            //       $location = json_decode($user[0]->loc_id);
            //       $l_tion='';
            //         foreach ($location as $key => $value) {
            //           $l_tion.= $value.",";
            //         }
            // // dd($user[0]);
            //         $l_tion = rtrim($l_tion);
                  $this->data['org_id']=$this->idname("organization_name","m_organizations_t","organization_id",$user[0]->org_id);
                  $this->data['loc_id']=$this->idname("location_name","m_location_t","location_id",$user[0]->loc_id);
                  $this->data['company_id']=$this->idname("company_name","m_company_t","company_id",$user[0]->company_id);
                  $this->data['admindept_id']=$user[0]->sub_department_name;
                  $this->data['group_id']=$this->idname("group_name","a_m_group_t","group_id",$user[0]->group_id);
            // dd($this->data);
             return view('createuser.view',$this->data);
        }
      }
    }

     public function userdata($type=null){
	
    $wh='';
	$search_table=array("a_m_group_t");
		
    if($_GET['_search']=='true')
    {
		
    $wh=$this->jqgridsearch('tb_users',$_GET['filters'],$search_table);
    }
      $org=\Session::get('organization');
        $loc=\Session::get('location');
        $compy=\Session::get('companyid');
        $uid=\Session::get('id');
        $wh.='and tb_users.company_id='.$compy; 

        $loc=\Session::get('location');
    $wh1='';
    if($uid==1){
     $wh1='';
    }else{
     $wh1='and  tb_users.loc_id='.$loc;     
    }
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;
$result = \DB::select("SELECT COUNT(id) AS count FROM tb_users left join a_m_group_t ON
    tb_users.group_id=a_m_group_t.group_id where 1=1 $wh $wh1");
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
    
   
   
   
    $SQL = "SELECT
    tb_users.id,
  tb_users.username,
  tb_users.email,
  tb_users.mobile_no,
  a_m_group_t.group_name

FROM
    tb_users
    left join a_m_group_t ON
    tb_users.group_id=a_m_group_t.group_id where 1=1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start , $limit";
 $download_SQL = "SELECT
    tb_users.id,
  tb_users.username,
  tb_users.email,
  tb_users.mobile_no,
  a_m_group_t.group_name

FROM
    tb_users
    left join a_m_group_t ON
    tb_users.group_id=a_m_group_t.group_id where 1=1 $wh $wh1 ORDER BY $sidx $sord";
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
    public function edit(Createuser $createuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Createuser  $createuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Createuser $createuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Createuser  $createuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Createuser $createuser)
    {
        //
    }
    
   
    
}
