<?php

namespace App\Http\Controllers;

use App\Companydocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CompanydocumentController extends Controller
{
   
    
    public function __construct()
    {
        $this->data=array();
        $this->model=new Companydocument();
         $this->data['pageMethod']=\Request::route()->getName();
         $this->data['urlmenu']=$this->indexs();
    }
    /** company document form index function start **/
    public function index()
    {
        $table = \DB::table('m_company_check_list')->get();
        $this->data['datas'] = $table;
       
        return view('companydocument.form',$this->data);
    }
   /** company document form index function end **/

       /** company document form save function start **/
    public function save(Request $request)
    {
        
        $edit_id = $request->input('edit_id');
        if($edit_id == '')
        {
           
            $position           = new Companydocument();
            $position->document = $_POST['document']; 
            $position->active       = $request->input('active');
            $position->save(); 
            
            
            
            $name = $position->getKeyName();
            $id = $position->$name; 
            $table = $position->getTable();
            $column = $position->getKeyName();
            $this->hrmssaveinsert($table,$column,$id,1);
 // auditlog
              $this->auditlog($id,"companydocument","create",$_POST,"m_company_check_list");
            return 1;
        }
        else
        { 
            $position = new Companydocument();
            $edit_id=$_POST['edit_id'];
            Companydocument::find($edit_id)->update($_POST); 
            $table = $position->getTable();
            $column = $position->getKeyName();
            $this->hrmssaveinsert($table,$column,$edit_id,2);
              // auditlog
              $this->auditlog($edit_id,"companydocument","edit",$_POST,"m_company_check_list");
            return 2;
        }
    }

       /** company document form save function end **/


      /** company document form remove function start **/
     public function getRemove(Request $request)
    {
        $del_id = $_GET['del_id'];

        $j=0;
        if($j==0)
        {
            $query = DB::table('m_company_check_list')->where('id',$del_id)->delete();
                     // auditlog
              $this->auditlog($del_id,"companydocument","delete",'',"m_company_check_list");
        }
       
        if($j == 1)
            return 1;
        else if($j == 0)
            return 2;
        else if($j == 3)
            return 3;
    }
          /** company document form remove function end **/
          /** company document name duplicate function start **/
    public function getCheckname(Request $request)
    {
        $edit_id = $_GET['edit_id'];
        if($edit_id == '')
        {
            $query=DB::table('m_company_check_list')->where('document',$_GET['cmp_document'])->get();
        }
        else
        {              
            $whereData = [['document', $_GET['cmp_document']],['id', '!=', $edit_id]];
            $query=DB::table('m_company_check_list')->where($whereData)->get();
        }
       
        if(count($query)>0)
            return 1;
        else
            return 0;
    }
        /** company document name duplicate function end **/


  public function companydocumentgrid()
    {  //dd($_GET['filters']);
          $compy=\Session::get('companyid');  
         $logged_user = \Session::get('emp_id');
          $wh = "";
      
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearchnotab('v1',$_GET['filters']);
        }

        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        if(!$sidx) $sidx =1;
        $result = \DB::select("select * from m_company_check_list v1 where 1=1 $wh GROUP BY v1.id");
          $count = count($result);
        if($limit==0)
            $limit=$count;
        
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
         $comp=\Session::get('companyid');
    $SQL = "select * from m_company_check_list v1 where 1=1  $wh ORDER by v1.id $sord LIMIT $start , $limit";
    
    
      $download_SQL = "select * from m_company_check_list v1 where 1=1 $wh ORDER by v1.id $sord";
         $result1 = \DB::select( $download_SQL );
        $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
        
        $result = \DB::select( $SQL );
        
    
        // dd($SQL);
        $responce->rows[]='';
        $responce->rows=$result;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        
        echo json_encode($responce);
    }









   
         /** company document grid data function end **/
}
