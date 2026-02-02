<?php

namespace App\Http\Controllers;

use DB;
use App\amc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AmcController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->model=new Amc();
        $this->data['pageFormtype']='ajax';
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['urlmenu']=$this->indexs(); 
    }
    public function index()
    {

        $this->data['created_by'] = $this->jCombologin('tb_users','id','username',\Session::get('id'));
                $table = \DB::table('m_amc_tb')->get();
                $this->data['datas']=json_encode($table);
                $this->data['pageMethod']="createamc";
       return view('amc.form',$this->data);  
    }


     public function getGridData($type=null)
    {

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
        if($groupname=='Superadmin' || $groupname=='Admin'){
        $wh.='and  m_amc_tb.company_id='.$compy;  
        }else{
            $wh.='and  m_amc_tb.company_id='.$compy;    
        }   
        if(!$sidx) $sidx =1;
        $result = \DB::select("SELECT COUNT(vendor_id) AS count FROM m_amc_tb left join tb_users on (tb_users.id =m_amc_tb.created_by) where 1=1 $wh");
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
        $SQL = "SELECT m_amc_tb.*,tb_users.username,tb_users.id as created_id FROM m_amc_tb left join tb_users on tb_users.id =m_amc_tb.created_by where 1=1 and m_amc_tb.company_id=$compy $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        
        $download_SQL = "SELECT m_amc_tb.*,tb_users.username,tb_users.id as created_id FROM m_amc_tb left join tb_users on tb_users.id =m_amc_tb.created_by where 1=1 and m_amc_tb.company_id=$compy $wh ORDER BY $sidx $sord";
        
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
    /*End*/
        
 public function save(Request $request)
    {
        // print_r($_POST);die;
        $edit_id = $request->input('vendor_id');
       if($edit_id == ''){ 
        $amc=new amc(); 
            $amc->vendor_name=$_POST['vendor_name'];
            $amc->address=$_POST['address'];
            $amc->mobileno=$_POST['mobileno'];
            $amc->email_id=$_POST['email_id'];
            $amc->location_id=\Session::get('location');
            $amc->organization_id=\Session::get('organization');
            $amc->company_id=\Session::get('companyid');
            $amc->created_by=\Session::get('id');
            $amc->last_updated_by=\Session::get('id');
            // print_r($amc);die;
            $amc->save();
            $edit_id= DB::getPdo()->lastInsertId();
            $action="Create";
            /**Auditlog**/
            $this->auditlog($edit_id,"amc",$action,$_POST,"m_amc_tb");
            return response()->json(array('status' => 'success', 'message' => 'Vendor Details Saved Successfully','id'=>$edit_id));
        }
        else{
            $action="Edit";
            $edit_id=$_POST['vendor_id'];
            amc::find($edit_id)->update($_POST); 
            /**Auditlog**/
            $this->auditlog($edit_id,"amc",$action,$_POST,"m_amc_tb");
            return response()->json(array('status' => 'success', 'message' => 'Vendor Details Updated Successfully','id'=>$edit_id));
        }
          
 
    }

    
    /*Ajith Purpose for Used Data Should Not Allow to Edit Function*/
    public function edit(Request $request, $id=null) 
    {

       $column = array('vendor_id');
        $table = array('m_amc_tb');
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

   public function getCheckname(Request $request)
    { 
        $vendor_id = $_GET['edit_id']; //dd($vendor_id);
        
        if($vendor_id == ''){
            $whereData = [['vendor_name', $_GET['vendor_name']]];
            $department=DB::table('m_amc_tb')->where($whereData)->get();
        } else {
            $whereData = [['vendor_name', $_GET['vendor_name']],['vendor_id', '!=', $vendor_id]];
            $department=DB::table('m_amc_tb')->where($whereData)->get();
        }
        
        if(count($department)>0)
            return 1;
        else
            return 0;
    }

    public function getRemove(Request $request,$id=null)
    {
    $column = array('vendor_id');
        $table = array('m_amc_tb');
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
            
            $query = \DB::table('m_amc_tb')->where('vendor_id',$id)->delete();
            /**Auditlog**/
            $action = "Delete";
            $this->auditlog($id,"amc",$action,$id,"m_amc_tb");
            
        }

    return $j;

    }       
}
