<?php

namespace App\Http\Controllers;

use App\Groupaccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \DB;

class GroupaccessController extends Controller
{
      public function __construct()
    {
        $this->data=array();
        $this->model=new Groupaccess();
        $this->data['urlmenu']=$this->indexs();
        
    }
    public function index()
    {
        $table = \DB::table('a_m_group_t')->get();
        $this->data['datas'] = $table;
        $this->data['pageMethod'] = 'group';
        return view('groupaccess.form',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function save(Request $request)
    {
       
       $validatedData=   $this->validate($request, [
            'edit_id'=>'nullable|numeric',
            'group_name' =>  ['required',
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
                },function($attribute,$value,$fail){
              
                  if (str_contains($value, '=')) {  
                      return $fail($attribute. ' Invalid Data.');
                  }
                },
            ],
            
            ]);
       
        $edit_id = $request->input('edit_id');
        if($edit_id == '')
        {
            
            $groupaccess = new Groupaccess();
          
            $groupaccess->group_name = $_POST['group_name'];
            $groupaccess->description =  $_POST['description'];
          
         
 
            $groupaccess->save(); 
			$company=\Session::get('companyid');
			$menu_access = DB::table('a_company_menu_access_t')->where('company_id',$company)->get();
          $data['menus'] = $menu_access[0]->menus;
          $data['permission'] = $menu_access[0]->permission;
          $data['companyaccess_id'] = $company;
          $data['group_id'] = $groupaccess->group_id;
         
            $user_access = DB::table('a_group_menu_access_t')->insert($data); 
			

            return 1;
        }
        else
        { 
			$edit_id=$_POST['edit_id'];
            Groupaccess::find($edit_id)->update($_POST); 
            return 2;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCheckname(Request $request)
    {
       
        $edit_id = $_GET['edit_id'];
        if($edit_id == '')
            $department=DB::table('a_m_group_t')->where('group_name',$_GET['group_name'])->get();
        else
        {
            if(!is_numeric($edit_id)){
                return 3;
            }else{
                $whereData = [['group_name', $_GET['group_name']],['group_id', '!=', $edit_id]];
                
                $department=DB::table('a_m_group_t')->where($whereData)->get();
            }
        }
        
        
        if(count($department)>0)
            return 1;
        else
            return 0;
        
        
    }

   public function remove(Request $request)
    {
     
        $del_id = $_GET['del_id'];
       
      if(!is_numeric($del_id)){
          return 3;
      }else{
            $query = DB::table('a_m_group_t')->where('group_id',$del_id)->delete();
            return 2;
      }
       
    }
   public function Show(Request $request)
    {
        if(!is_numeric($_GET['group_id'])){
            return 3;
        }else{
            $out_put = array();
            $department=DB::table('a_m_group_t')->where('group_id',$_GET['group_id'])->first();
            
            $out_put['group_id'] = $department->group_id;
            $out_put['group_name'] = $department->group_name;
            $out_put['description'] = $department->description;        
            return $out_put;    
                
        }
       
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Groupaccess  $groupaccess
     * @return \Illuminate\Http\Response
     */
    public function edit(Groupaccess $groupaccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Groupaccess  $groupaccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Groupaccess $groupaccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Groupaccess  $groupaccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(Groupaccess $groupaccess)
    {
        //
    }
	public function getgroupgriddata($type=null)
	{
	
    $wh='';
	$search_table=array("a_m_group_t");
		
    if($_GET['_search']=='true')
    {
		
    $wh=$this->jqgridsearch('a_m_group_t',$_GET['filters'],$search_table);
    }
      $org=\Session::get('organization');
        $loc=\Session::get('location');
        $compy=\Session::get('companyid');
        //$wh.='and tb_users.company_id='.$compy; 
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;
$result = \DB::select("SELECT COUNT(group_id) AS count FROM a_m_group_t  where 1=1 $wh and location_id= $loc");
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
    
   
   
   
    $SQL = "SELECT * from a_m_group_t where 1=1 $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        $download_SQL = "SELECT * from a_m_group_t where 1=1 $wh and location_id= $loc ORDER BY $sidx $sord";
 $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
         
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
}
