<?php

namespace App\Http\Controllers;

use App\machinechecklist;
use Illuminate\Http\Request;
use DB;
class MachinechecklistController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageModule']=\Request::route()->getName();
        $this->data=array(
            'pageModule'=> $this->data['pageModule'],
            'pageUrl' =>  url($this->data['pageMethod']),
            'pageMethod'=>$this->data['pageMethod']
          );
        $this->data['pageFormtype']='ajax';
    }
    public function index()
    {
          return view('machinechecklist.table',$this->data);
    }

      public function create()
    {
        $this->data['row']= (object)array();
        $this->data['row']->department_id=$this->jCombologin('ma_department_t','department_id','department_name','');
        $this->data['row']->break_type_id=$this->jCombologin('m_breakdowntype_t','breakdowntype_id','breakdown_name','');
        return view('machinechecklist.form',$this->data);
    }

    
    public function save(Request $request)
    {
        $edit_id = $request->input('id');
                $breakdown = new Machinechecklist();
                $breakdown->department_id = $request->input('department_id');
                $breakdown->break_type_id = $request->input('break_type_id');
                $breakdown->active      = $request->input('active');
                $breakdown->issue_date       = $request->input('issue_date');
                $breakdown->causes           = $request->input('causes');
                $breakdown->breakdown_sevearity           = $request->input('breakdown_sevearity');
                $breakdown->maintenance_type           = $request->input('maintenance_type');
                $breakdown->company_id      = \Session::get('companyid');
                $breakdown->organization_id          = \Session::get('organization');
                $breakdown->location_id          = \Session::get('location');
                $breakdown->save();
          //  dd($breakdowntype);
            $edit_id= DB::getPdo()->lastInsertId();
            $action="Create";
            /**Auditlog**/
            $this->auditlog($edit_id,"Machinechecklist",$action,$_POST,"b_maintenance_t");
            return response()->json(array('status' => 'success', 'message' => 'Breakdown Maintenance Saved Successfully','id'=>$edit_id));
    }

    
    public function show(addmachine $addmachine)
    {
        
    }

    
    public function edit(addmachine $addmachine)
    {
        //
    }

    
    public function update(Request $request, addmachine $addmachine)
    {
        //
    }

    
    public function destroy(addmachine $addmachine)
    {
        //
    }
}
