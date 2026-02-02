<?php

namespace App\Http\Controllers;

use App\Approvalsettings;
use App\Approvalsettingsline;
use Illuminate\Http\Request;

class ApprovalsettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public $module="materialbom";
	public function __construct()
	{
		$this->data=array();
    	$this->model=new Approvalsettings;
		$this->submodel=new Approvalsettingsline;
		$this->data['pageMethod']=\Request::route()->getName();
		$this->data['pageFormtype']='ajax';
		$this->data['pageModule']='approvalsettings';
		$this->table="m_approvalsettings_hdr_t";
		$this->subtable="m_approvalsettings_line_t";
		$this->middleware('auth');
                $this->data['urlmenu']=$this->indexs(); 
	}
    public function index()
    {
       
		return view('Approvalsettings.table',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function create($id=null)
    {
		
		if(isset($id))
		{   
			$this->data['id'] = $id;
			$this->data['pagemode'] = "edit";
			$table = \DB::table('m_approvalsettings_hdr_t')->where('approvalsettings_hdr_id',$id)->get();
			$this->data['row'] = $table[0];
	        $this->data['created_by']=$this->jcombo("tb_users","id","username",\Session::get('id')); 
	        $this->data['module_name']=$this->jcustomselect("a_lookuplines_t","lookup_code","lookup_code",$table[0]->module_name,'and lookup_type="APPROVAL_MODULE"'); 
			$linestable = \DB::table('m_approvalsettings_line_t')->where('approvalsettings_hdr_id',$id)->get(); 
			$this->data['linedata'] = $linestable; 
			foreach($this->data['linedata'] as $key => $value)
			{
		    $this->data['linedata'][$key]->approver_id = $this->jCombo('hr_employee_t','employee_id','employee_number|first_name',$value->approver_id);
			}
		
		}  else{
			    $this->data['pagemode'] = "create";
		     	$this->modelname = new Approvalsettings();
	        	$this->data['row']= (object)array();
			    $table = $this->modelname->getTableColumns();
		        foreach($table as $key=>$val)
		        {		
		          $this->data['row']->$val='';
		        }
	     	  $this->data['created_by']=$this->jcombo("tb_users","id","username",\Session::get('id')); 
	     	    $this->data['module_name']=$this->jcustomselect("a_lookuplines_t","lookup_code","lookup_code",'','and lookup_type="APPROVAL_MODULE"'); 

		
			 $this->data['linedata'] = array(); 
			 $this->data['approver_id'] = $this->jCombo('hr_employee_t','employee_id','employee_number|first_name','');
		}
        return view("Approvalsettings.form",$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
     //dd($_POST);
                $data = $this->validatePost($request->all(),$this->table,'header');
		      $lines_data = $this->validatePost($request->all(),$this->subtable,'lines'); 
			     \DB::beginTransaction();
                try
                {
					
                     $id=$this->model->insertRow($data);
                     $lid=$this->submodel->subgridSave($lines_data,$id);
                     \DB::commit();
                     return response()->json(array('status' => 'success', 'message' => 'Saved Successfully','id' => $id,'lid' => $lid));
                }
                catch (\Illuminate\Database\QueryException $e)
                {
                     $message = explode('(', $e->getMessage());
                     $dbCode = rtrim($message[0], ']');
                     $dbCode = trim($dbCode, '[');

                     \DB::rollback();
                     return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Approvalsettings  $approvalsettings
     * @return \Illuminate\Http\Response
     */
    public function show(Approvalsettings $approvalsettings,$id=null)
    {
		$data=Approvalsettings::find($id);
		
          $this->data['module_name']=$data['module_name'];  
          $this->data['created_by']=$this->idname("username","tb_users","id",$data['created_by']); 
		
             $linesdata = \DB::table('m_approvalsettings_line_t')
				 ->leftjoin('m_approvalsettings_hdr_t','m_approvalsettings_hdr_t.approvalsettings_hdr_id','=','m_approvalsettings_line_t.approvalsettings_hdr_id') 
				 ->leftjoin('tb_users','tb_users.id','=','m_approvalsettings_line_t.approver_id')
				 ->where('m_approvalsettings_hdr_t.approvalsettings_hdr_id',$id)->get();
           foreach($linesdata as $key=>$value){
			   $this->data['approver']=$this->idname("username","tb_users","id",$value->approver_id); 
			   
		   }
            $this->data['linesdata']=$linesdata; 
        return view("Approvalsettings.view",$this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Approvalsettings  $approvalsettings
     * @return \Illuminate\Http\Response
     */
    public function edit(Approvalsettings $approvalsettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Approvalsettings  $approvalsettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Approvalsettings $approvalsettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Approvalsettings  $approvalsettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approvalsettings $approvalsettings)
    {

    }
	public function getApprovalsettingsData()
	{
		$wh='';
	
		if($_GET['_search']=='true')
		{
			
		$wh=$this->jqgridsearch('m_approvalsettings_hdr_t',$_GET['filters']);
		}
		$page = $_GET['page'];
		$limit = $_GET['rows'];
		$sidx = $_GET['sidx'];
		$sord = $_GET['sord'];
		if(!$sidx) $sidx =1;
		$result = \DB::select("SELECT COUNT(m_approvalsettings_hdr_t.approvalsettings_hdr_id) AS count FROM m_approvalsettings_hdr_t where 1=1 $wh");
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
		$SQL = "SELECT * from m_approvalsettings_hdr_t where 1=1 $wh ORDER BY $sidx $sord  LIMIT $start , $limit";
                $download_SQL = "SELECT * from m_approvalsettings_hdr_t where 1=1 $wh ORDER BY $sidx $sord";
      $result1 = \DB::select( $download_SQL );
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
	
	public function approvalsettingschk(Request $request)
    {
       
        $edit_id = $_GET['edit_id'];
        if($edit_id == '')
            $bom=\DB::table('m_approvalsettings_hdr_t')->where('module_name',$_GET['module_id'])->get();
        else
        {
            $whereData = [['module_name', $_GET['module_id']],['approvalsettings_hdr_id', '!=', $edit_id]];
            
            $bom=\DB::table('m_approvalsettings_hdr_t')->where($whereData)->get();
        }
        
        
        if(count($bom)>0)
            return 1;
        else
            return 0;
        
        
    }	
}
