<?php

namespace App\Http\Controllers;

use App\Spare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SpareController extends Controller
{
     public function __construct()
    {
        $this->data=array();
        $this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
    }
    public function index()
    {
    	 $table = \DB::table('m_spares_t')->get();
    	$this->data['datas']=json_encode($table);
                $this->data['pageMethod']="sparescreation";
        $this->data['row'] = (object) array();
        $this->data['row']->department_id=$this->jCombologin('ma_department_t','department_id','department_name','');
        $this->data['created_by'] = $this->jCombo('tb_users','id','username',\Session::get('id'));
          return view('spares.form', $this->data);
    }

  public function sparesgrids(Spare $Spare)
    {
       {
       // dd("sdsd");
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     	$table=array('ma_department_t');
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('m_spares_t',$_GET['filters'],$table);
        }
    if(!$sidx) $sidx =1;
        
      $loc=\Session::get('location');
    $wh1='';
    if($loc != 0){
 $wh1='and  m_spares_t.location_id='.$loc;      
    }

    $result = \DB::select("SELECT COUNT(m_spares_t.spares_id) AS count FROM  m_spares_t left join ma_department_t on (ma_department_t.department_id=m_spares_t.department_id) where 1=1 $wh $wh1");
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

        
    $SQL = "SELECT m_spares_t.*,ma_department_t.department_name FROM m_spares_t left join ma_department_t on (ma_department_t.department_id=m_spares_t.department_id) WHERE 1 = 1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start,$limit";
    $download_SQL = "SELECT m_spares_t.*,ma_department_t.department_name FROM m_spares_t left join ma_department_t on (ma_department_t.department_id=m_spares_t.department_id) WHERE 1 = 1 $wh $wh1 ORDER BY $sidx $sord";
        
       
    $result = \DB::select($SQL);
  $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
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
        
    public function save(Request $request)
   	{
    // dd($request);
    
    $validatedData=   $this->validate($request, [
            'department_id' =>'required|numeric',
            'category'  => ['required',
          function($attribute, $value, $fail) {
                 $regex1= "consumable"; // Anchor 
                 $regex2= "spare"; // Anchor 
             if($regex1==$value || $regex2==$value) // `i` flag for case-insensitive
                  {
                    //  dd($regex);
                  //  return $fail($attribute.' is invalid (contains url).');
                  }else{
                     return $fail('Category invalid Entry.');  
                  }
                  //dd($regex);
                }
          ],
            'spares_name' => ['required',
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
            'spare_quantity' => ['required','numeric',
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
                          return $fail($attribute. ' contains script.');
                      }
                      if (str_contains($value, '=')) {  
                      return $fail($attribute. ' contains Equal.');
                  }
                    },
                ],
            
        
        ]);

    
        $edit_id = $request->input('spares_id');

        if($edit_id == ''){ 
        $Spare=new Spare();

            $Spare->spares_name=$_POST['spares_name'];
            $Spare->department_id=$_POST['department_id'];
            $Spare->category=$_POST['category'];
            $Spare->spare_quantity=$_POST['spare_quantity'];
            $Spare->description=$_POST['description'];
            if($request->hasfile('upload_image'))
            {
                $file=$request->file('upload_image'); 
                $name='spare_'.time().$file->getClientOriginalName();
                $file->move(public_path().'/upload/spares', $name);  
                $Spare->upload_image=$name;
            }
            $Spare->created_by=$_POST['created_by'];
            $Spare->location_id=\Session::get('location');
            $Spare->organisation_id=\Session::get('organization');
            $Spare->company_id=\Session::get('companyid');
            $Spare->created_by=\Session::get('id');
            $Spare->last_updated_by=\Session::get('id');
            $Spare->save();
          //  dd($breakdowntype);
            $edit_id= DB::getPdo()->lastInsertId();
            $action="Create";

            /**Auditlog**/
            $this->auditlog($edit_id,"sparescreation",$action,$_POST,"m_spares_t");
            return response()->json(array('status' => 'success', 'message' => 'Spare Saved Successfully','id'=>$edit_id));
        }
        else{

            $action="Edit";
            $edit_id=$_POST['spares_id'];
          //  dd($edit_id);
            // spare::find($edit_id)->update($_POST); 
			
            if($request->hasfile('upload_image'))
            {
                $file=$request->file('upload_image'); 
                $name='spare_'.time().$file->getClientOriginalName();
                $file->move(public_path().'/upload/spares', $name);  
                $upload_image=$name;
                DB::table('m_spares_t')
                ->where('spares_id', $edit_id)
                ->update(['department_id' => $_POST['department_id'], 'category' => $_POST['category'], 'spare_quantity' => $_POST['spare_quantity'], 'spares_name' => $_POST['spares_name'], 'created_by' => $_POST['created_by'], 'description' => $_POST['description'], 'upload_image' => $upload_image]);
            }
            else
            {
				$upload_image="";
                DB::table('m_spares_t')
                ->where('spares_id', $edit_id)
                ->update(['department_id' => $_POST['department_id'], 'category' => $_POST['category'], 'spare_quantity' => $_POST['spare_quantity'], 'spares_name' => $_POST['spares_name'], 'created_by' => $_POST['created_by'], 'description' => $_POST['description'], 'upload_image' => $upload_image]);
            }

            /**Auditlog**/
            $this->auditlog($edit_id,"sparescreation",$action,$_POST,"m_spares_t");
            return response()->json(array('status' => 'success', 'message' => 'Spare Updated Successfully','id'=>$edit_id));
        }
          
        
 
    }

     public function edit(Request $request, $id=null) 
    {
      if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
       $column = array('spares_id');
        $table = array('b_maintenance_t_lines');
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
    }

  public function getCheckname(Request $request)
    { 
      
        $spares_id = $_GET['edit_id']; 
         
        if($spares_id == ''){
            $whereData = [['spares_name', $_GET['spares_name']]];
            $spares=DB::table('m_spares_t')->where($whereData)->get();
        } else {
            $whereData = [['spares_name', $_GET['spares_name']],['spares_id', '!=', $spares_id]];
            $spares=DB::table('m_spares_t')->where($whereData)->get();
        }
        if(count($spares)>0)
            return 1;
        else
            return 0;
    
    }
    public function destroy(Request $request,$id=null)
    {
  if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
    $column = array('spares_id');

        $table = array('b_maintenance_t_lines');
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
            $this->auditlog($id,"sparescreation",$action,$id,"m_spares_t");
            
        }

    return $j;
}
    }  
}
