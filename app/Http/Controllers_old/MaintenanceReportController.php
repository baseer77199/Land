<?php namespace App\Http\Controllers;
//use bompending;
use Illuminate\Http\Request;
//dd('ghgjh');
class MaintenanceReportController extends Controller
{
    public function __construct()
	{
		$this->data=array();
                 $this->data['urlmenu']=$this->indexs(); 
		$this->data['pageMethod']=\Request::route()->getName();
		$this->data['pageFormtype']='ajax';
	}

		public function index(){


		 return view('reportnew.maintenancereport',$this->data);
		
    }
     public function searchReport($sd=null,$ed=null,$breakdowntype_id=null)
    {
         	dd('rrrrrrrrrrrrr');
        
         return view('reportnew.maintenancereport',$return_data);
  
    }

        

}