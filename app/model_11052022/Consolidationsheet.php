<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class consolidationsheet extends Sximo  {
	
	protected $table = 'issue_tbl';
	protected $primaryKey = 'issue_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT issue_tbl.* FROM issue_tbl  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE issue_tbl.issue_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
