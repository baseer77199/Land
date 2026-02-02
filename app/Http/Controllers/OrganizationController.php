<?php

namespace App\Http\Controllers;

use App\organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{public function __construct()
    {
        $this->data=array();
        $this->model    = new organization();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='organization';
        $this->table=" ma_organization_t";   
        $this->middleware('auth');
                $this->data['urlmenu']=$this->indexs(); 

    }
    public function index($id=null)
    {
 $this->data['pageMethod']="organization";
        return view('organization.form',$this->data);
    }
    
    public function save($id=null,Request $request)
    {   
        $edit_id = $request->input('edit_id');
        if($edit_id == '')
        {
            
            $organization= new Organization();
            $organization->organization_name = $request->input('organization_name');
            $organization->description =  $request->input('description');
            $organization->updated_at =  "";
            $organization->created_at =  "";
            
            $organization->save(); 

            return 1;
        }
        else
        { 
            $edit_id=$_POST['edit_id'];
            Organization::find($edit_id)->update($_POST); 
            return 2;
        }
       
    }
    
    public function organizationgriddata(Organization $organization)
    {
      
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('ma_organization_t',$_GET['filters']);
        }
    if(!$sidx) $sidx =1;
        
        

    $result = \DB::select("SELECT COUNT(organization_id) AS count FROM  ma_organization_t as ma_organization_t where 1=1 $wh");
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
                        ma_organization_t
                   
                    WHERE
                        1 = 1 $wh ORDER BY $sidx $sord LIMIT $start,$limit";
        
       
    $result = \DB::select($SQL);
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

       

    echo json_encode($responce);
    }
    
    
      public function destroy(Request $request)
    {
        $del_id = $_GET['del_id'];
      

        $j=0;
        if($j==0)
        {
            $query =\DB::table('ma_organization_t')->where('organization_id',$del_id)->delete();
          //  dd($query);
        }
       
        if($j == 1)
            return 1;
        else if($j == 0)
            return 2;
        else if($j == 3)
            return 3;
    }
}
