<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Overallmachinereport;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use DateInterval;
use DateTime;
use DatePeriod;

class OverallmachinereportController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'overallmachinereport';
	static $per_page	= '10';
	
	public function __construct() 
	{
		parent::__construct();
		$this->model = new Overallmachinereport();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'			=> 	$this->info['title'],
			'pageNote'			=>  $this->info['note'],
			'pageModule'		=> 'overallmachinereport',
			'pageUrl'			=>  url('overallmachinereport'),
			'return' 			=> 	self::returnUrl()	
		);
		
			
				
	} 
	
	public function index()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
				
		$this->data['access']		= $this->access;	
		return view('overallmachinereport.index',$this->data);
	}			

}