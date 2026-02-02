<?php

namespace App\Http\Controllers;

use App\Drawing;
use Illuminate\Http\Request;
use DB;
class DrawingController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model = new Drawing();
       $this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
       $this->data['pageFormtype']='ajax';
       $this->data['pageModule']='drawing_tbl';
       $this->table=" drawing_tbl";   
       $this->middleware('auth');
        //$this->data['urlmenu']=$this->indexs();
    }
    public function index()
    {

               $this->data['department'] = $this->jCombo('ma_department_t','department_id','department_name','');
                $table = \DB::table('drawing_tbl')->get();
                $this->data['datas']=json_encode($table);
                $this->data['pageMethod']="drawingfiles";
          return view('drawingfiles.form',$this->data);
    }

    
  public function filegrids(Drawing $Drawing)
    {
      // dd($_GET);
          $compy=\Session::get('companyid');
       //dd("sdsd");
      
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
        $tables=[];
        $tables[]="ma_department_t";
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('drawing_tbl',$_GET['filters'],$tables);
        }
    if(!$sidx) $sidx =1;
        
        

    $result = \DB::select("SELECT COUNT(drawing_id) AS count FROM  drawing_tbl LEFT join ma_department_t ON (drawing_tbl.department= ma_department_t.department_id) where 1=1 $wh");
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

        
    $SQL = "SELECT drawing_tbl.drawing_id,drawing_tbl.document,drawing_tbl.created_at,ma_department_t.department_name ,ma_department_t.department_id
                    FROM
                        drawing_tbl LEFT join ma_department_t ON (drawing_tbl.department= ma_department_t.department_id)
                    WHERE 1 = 1 $wh ORDER BY $sidx $sord LIMIT $start,$limit";
        
       
    $result = \DB::select($SQL);
   
          $download_sql = "SELECT drawing_tbl.drawing_id,drawing_tbl.document,drawing_tbl.created_at,ma_department_t.department_name ,ma_department_t.department_id
                    FROM
                        drawing_tbl LEFT join ma_department_t ON (drawing_tbl.department= ma_department_t.department_id)
                    WHERE 1 = 1 $wh ORDER BY $sidx $sord";                 
        
        $result1 = \DB::select( $download_sql );

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

    
        
 public function store(Request $request)
    {   
       //dd($_POST);
        //dd("cvcv");
              $edit_id = $request->input('edit_id');
             // dd($edit_id);
        if($edit_id == '')
        {

            
            $drawing= new Drawing();
            $drawing->department = $request->input('department');
            $drawing->document = $request->input('document');
            //dd($drawing->department);
            $drawing->file =  $request->input('file');
            $drawing->updated_at =  "";
            $drawing->created_by=\Session::get('id');
           // dd($drawing);
            $input_data = $request->all();
              $file = $request->file('file');
           // dd($file);
            if($file != "")
            {
                $name = uniqid().'.'.$file->getClientOriginalExtension();

                $destinationPath = public_path('/upload/drawing');
                 // dd($destinationPath);
                $file->move($destinationPath, $name);
               // dd($file);
                $input_data['file'] = $name;
            }
             // dd($request->input('severity_name'));
             $drawing->fill($input_data)->save();

            // dd($drawing);

            return 1;
        }
        else
        {   
            //dd($_POST);

           $action="Edit";
            $edit_id=$_POST['edit_id'];
            drawing::find($edit_id)->update($_POST); 
            $this->auditlog($edit_id,"drawing",$action,$_POST,"drawing_tbl");
            //dd( $this);
            return response()->json(array('status' => 'success', 'message' => 'Drawing Updated Successfully','id'=>$edit_id));
            return 2;
        }
       
    }
    
    /*Ajith Purpose for Used Data Should Not Allow to Edit Function*/
    public function edit(Request $request, $id=null) 
    {

       $column = array('drawing_id');
        $table = array('drawing_tbl');
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

 
    public function destroy(Request $request)
  {

        $del_id = $_GET['del_id'];
      

        $j=0;
        if($j==0)
        {
            $query =\DB::table('drawing_tbl')->where('drawing_id',$del_id)->delete();
           
        }
       
        if($j == 1)
            return 1;
        else if($j == 0)
            return 2;
        else if($j == 3)
            return 3;
    }
}
