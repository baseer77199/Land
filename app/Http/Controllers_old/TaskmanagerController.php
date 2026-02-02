<?php

namespace App\Http\Controllers;

use App\Taskmanager;
use Illuminate\Http\Request,DB;

class TaskmanagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->model    = new Taskmanager();
        $this->data=array();
        //$this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['urlname']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='Taskmanager';
        $this->table="a_taskmanager_t";
        $this->data['urlmenu']=$this->indexs();
    }

    public function index()
    {
        $this->model    = new Taskmanager();
        $this->data=array();
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['urlname']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']='Taskmanager';
        $this->table="a_taskmanager_t";
        
        return view("taskmanager.table",$this->data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        $this->data['pageMethod']="taskmanager";
        $taskmanager=Taskmanager::find($id);
        $sql=\Session::get('id');
        
        if($id == '0'){
            $this->data['row'] = (object) array();
            $this->data['row']->taskmanager_id="";
            $this->data['row']->department=$this->jCombo('m_department_lines_t','department_line_id','sub_department_name','');
            $this->data['row']->assigned_to=$this->jCombologin('hr_employee_t','employee_id','first_name','');
            $this->data['row']->start_date="";
            $this->data['row']->end_date="";
            $this->data['row']->department_lead=$this->jCombologin('hr_employee_t','employee_id','first_name','');
            $this->data['row']->task="";
            $this->data['row']->status="";
            $this->data['row']->admin=$this->jCombologin('hr_employee_t','employee_id','first_name','');
            $this->data['row']->description="";
            $this->data['row']->created_by=$this->jCombologin('tb_users','id','first_name',$sql);
        }else{
            $sql=\DB::table('a_taskmanager_t')->where('taskmanager_id',$id)->get();
            $this->data['productdata']=$taskmanager;
            $this->data['row'] = $sql[0];
            $this->data['row']->department=$this->jCombo('m_department_lines_t','department_line_id','sub_department_name',$sql[0]->department);
            $this->data['row']->assigned_to=$this->jCombologin('hr_employee_t','employee_id','first_name',$sql[0]->assigned_to);
            $this->data['row']->admin=$this->jCombologin('hr_employee_t','employee_id','first_name',$sql[0]->admin);
            $this->data['row']->department_lead=$this->jCombologin('hr_employee_t','employee_id','first_name',$sql[0]->department_lead);
            $this->data['row']->created_by=$this->jCombologin('tb_users','id','first_name',$sql[0]->created_by);
        }

        if(isset($_GET['status'])){
		if($_GET['status']=="approve")	
            $this->data['pageMethod']="taskmanagerapproval";
		else
			$this->data['pageMethod']="taskmanagerupdate";
        }

        return view('taskmanager.form',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    public function save(Request $request){

        
        $id='';
        $data = $this->validatePost($request->all(),$this->table,'header');
        $data['description']=trim($_POST['description']);
        \DB::beginTransaction();
        try{
            
            $id=$this->model->insertRow($data);
            \DB::commit();
        
            return response()->json(array('status' => 'success', 'message' =>'Saved Successfully','id' => $id));
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            $message = explode('(', $e->getMessage());
            $dbCode = rtrim($message[0], ']');
            // dd($dbCode);
            $dbCode = trim($dbCode, '[');
            \DB::rollback();
            return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Taskmanager  $taskmanager
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {
        $sql=\DB::table('a_taskmanager_t')->where('taskmanager_id',$id)->get();
        if($sql->isNotEmpty()){
            $this->data['taskmanager']=$sql[0];
            if($sql[0]->department){
                $this->data['department']=$this->idname('sub_department_name','m_department_lines_t','department_line_id',$sql[0]->department);
            }else{
                $this->data['department']='';
            }

            if($sql[0]->assigned_to){
                $this->data['assigned_to']=$this->idname('first_name','hr_employee_t','employee_id',$sql[0]->assigned_to);
            }else{
                $this->data['assigned_to']='';
            }

            if($sql[0]->department_lead){
                $this->data['department_lead']=$this->idname('first_name','hr_employee_t','employee_id',$sql[0]->department_lead);
            }else{
                $this->data['department_lead']='';
            }

            if($sql[0]->created_by){
                $this->data['created_by']=$this->idname('first_name','tb_users','id',$sql[0]->created_by);
            }else{
                $this->data['created_by']='';
            }
            if($sql[0]->admin){
                $this->data['admin']=$this->idname('first_name','hr_employee_t','employee_id',$sql[0]->admin);
            }else{
                $this->data['admin']='';
            }
        }
        
        return view('taskmanager.view',$this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Taskmanager  $taskmanager
     * @return \Illuminate\Http\Response
     */
    public function edit(Taskmanager $taskmanager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Taskmanager  $taskmanager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taskmanager $taskmanager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taskmanager  $taskmanager
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=null)
    {
        $count=0;
        if($count <= 0)
        {
            $query = \DB::table('a_taskmanager_t')->where('taskmanager_id',$id)->delete();
            if($query)
            {
                return 0;
            }
            else
            {
                return 1;
            }

        }
        else
        {
            return 2;
        }
    }

     public function gettaskmanData()   
    {
         
        $wh='';
        $search_table=[];
        $search_table[]="hr_employee_t";
        $search_table[]="tb_users";
        $search_table[]="m_department_lines_t";
        if($_GET['_search']=='true')
        {
           
            $wh.=$this->jqgridsearch('a_taskmanager_t',$_GET['filters'],$search_table);
        }
        
        if(isset($_GET['status'])){
            
            if($_GET['status'] == "approval"){
                $wh.= " and a_taskmanager_t.status = 'INITIATED'";
            } else if($_GET['status'] == "update"){
				
				$wh.= " and a_taskmanager_t.status = 'APPROVED'";
			}
        }

        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        if(!$sidx) $sidx =1;
         
        $result = \DB::select("SELECT count(a_taskmanager_t.taskmanager_id) as count FROM `a_taskmanager_t` left join hr_employee_t on(hr_employee_t.employee_id = a_taskmanager_t.assigned_to) left join m_department_lines_t on (m_department_lines_t.department_line_id = a_taskmanager_t.department) left join `tb_users` on (tb_users.id=a_taskmanager_t.created_by) where 1=1 $wh");

        $count = count($result);
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
        
        $emp=\Session::get('id');
        $sql="SELECT a_taskmanager_t.status ,a_taskmanager_t.taskmanager_id,a_taskmanager_t.end_date,a_taskmanager_t.start_date,a_taskmanager_t.task,a_taskmanager_t.created_by, hr_employee_t.first_name,m_department_lines_t.sub_department_name,tb_users.username FROM `a_taskmanager_t` left join hr_employee_t on(hr_employee_t.employee_id = a_taskmanager_t.assigned_to) left join m_department_lines_t on (m_department_lines_t.department_line_id = a_taskmanager_t.department) left join `tb_users` on (tb_users.id=a_taskmanager_t.created_by) where 1=1 and a_taskmanager_t.created_by='".$emp."' $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        $download_SQL="SELECT a_taskmanager_t.status ,a_taskmanager_t.taskmanager_id,a_taskmanager_t.end_date,a_taskmanager_t.start_date,a_taskmanager_t.task,a_taskmanager_t.created_by, hr_employee_t.first_name,m_department_lines_t.sub_department_name,tb_users.username FROM `a_taskmanager_t` left join hr_employee_t on(hr_employee_t.employee_id = a_taskmanager_t.assigned_to) left join m_department_lines_t on (m_department_lines_t.department_line_id = a_taskmanager_t.department) left join `tb_users` on (tb_users.id=a_taskmanager_t.created_by) where 1=1 and a_taskmanager_t.created_by='".$emp."' $wh ORDER BY $sidx $sord";
           $result1 = \DB::select( $download_SQL );
    $result1=collect($result1)->map(function($x){ return (array) $x; })->toArray();
    if(isset($_GET['download']))
    {
        return $result1;
    }
          
        $result = \DB::select($sql);
        // dd($result);
        $responce->rows[]='';
        $responce->rows=$result;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;

        echo json_encode($responce);
    }

}
