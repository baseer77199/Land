<?php

namespace App\Http\Controllers;
use DB;
use validate;
use App\checklist;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model = new checklist();
        $this->data['pageMethod']=\Request::route()->getName();
                $this->data['pageModule']='checklist';
        $this->data['pageFormtype']='ajax';
        $this->table=" checklist_tbl";   
                $this->middleware('auth');
                                $this->data['urlmenu']=$this->indexs(); 


    }
    public function index()
    { 
        $this->data['row']= (object)array();
        $this->data['row']->frequency_name=$this->jCombologin('frequency_tbl','frequency_id','frequency_name','');

        $this->data['pageMethod']="checklist";
        return view('checklist.form',$this->data);
    }


   

    
    public function save(Request $request)
    {   
// dd($_POST);

$validatedData=   $this->validate($request, [
            'checklist_name' =>  ['required',
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
                //   }if (str_contains($value, '=')) {  
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
             'terms' =>  [
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
                //   } if (str_contains($value, '=')) {  
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
             'file'=>'file',
            ]);
        $edit_id = $request->input('edit_id');
        if($edit_id == '')
        {
  

            $checklist= new checklist();
            $checklist->checklist_name = $request->input('checklist_name');      
            $checklist->terms =  $request->input('terms');

            $checklist->location_id=\Session::get('location');
            $checklist->organization_id=\Session::get('organization');
            $checklist->company_id=\Session::get('companyid');
            $checklist->created_by=\Session::get('id');
            $checklist->last_updated_by=\Session::get('id');
                
             $input_data = $request->all();
              $image = $request->file('file');

             //dd($image);
             
                     
            if($image != "")
            {
                $name = uniqid().'.'.$image->getClientOriginalExtension();
            
                $destinationPath = public_path('/upload/checklist');
                
                $image->move($destinationPath, $name);

                $input_data['file'] = $name;
                // $checklist->file=$name;
            }  
            
          $checklist->fill($input_data)->save();
          // $id = $checklist->description_id;
          //   $table = $checklist->getTable();
          //   $column = $checklist->getKeyName();
          //   $this->hrmssaveinsert($table,$column,$id,1);
          //   //auditlog
          //   $this->auditlog($id,"checklist","create",$checklist,"checklist_tbl");


          
            return 1;
        }
        else
        {  $checklist  = checklist::findOrFail($edit_id);
             $file_upload = $request->file('file');
             $file_save='';
            if($file_upload != "")
            {
                $old_file = $checklist->file;
            
                $name = uniqid().'.'.$file_upload->getClientOriginalExtension();

                $destinationPath = public_path('/upload/checklist');
                $file_upload->move($destinationPath, $name);
                $checklist->file =$file_save= $name;
                if($old_file!=''){
                $myPublicFolder = public_path();
                $old_file = public_path().'/upload/checklist'.$old_file;
                unlink($old_file);
                }
            }
            $input_data = $request->all();

              DB::table('checklist_tbl')
                ->where('checklist_id', $edit_id)
                ->update(['checklist_name' =>$input_data['checklist_name'] ,'file'=>$file_save,'terms'=>$input_data['terms'],'updated_at'=>date('Y-m-d H:i:s'),
                'last_updated_by'=>\Session::get('id'),'company_id'=>\Session::get('companyid'),'organization_id'=>\Session::get('organization'),'location_id'=>\Session::get('location')]);
        
                 //$checklist->save(); 
           // $table = $checklist->getTable();
           //  $column = $checklist->getKeyName();
           //  $this->hrmssaveinsert($table,$column,$edit_id,2);s
           //  //auditlog
           //  $this->auditlog($edit_id,"checklist","Update",$_POST,"checklist_tbl");
            return 2;
        }
       
    }

    
    public function checklistgrid(checklist $checklist)
    {
       {
      
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('checklist_tbl',$_GET['filters']);
        }
    if(!$sidx) $sidx =1;
        
        
    $wh1='';
    $loc=\Session::get('location');
    if($loc != 0){
        $wh1='and  checklist_tbl.location_id='.$loc;
    }

    $result = \DB::select("SELECT COUNT(checklist_id) AS count FROM  checklist_tbl as checklist_tbl where 1=1 $wh $wh1");
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
                        checklist_tbl
                   
                    WHERE
                        1 = 1 $wh $wh1 ORDER BY $sidx $sord LIMIT $start,$limit";

          $download_sql = "SELECT
                   *
                    
                    FROM
                        checklist_tbl
                   
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
 if(!is_numeric($id)){
        return \Redirect::back()->withErrors(['msg' => 'The Message']);
    }else{
    $column = array('checklist_id');

        $table = array('checklist_lines_tbl');
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
            $query = \DB::table('checklist_tbl')->where('checklist_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"checklist",$action,$id,"checklist_tbl");
            
        }

    return $j;

    }  
     }
}
