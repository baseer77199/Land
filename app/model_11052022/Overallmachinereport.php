<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class overallmachinereport extends Sximo  {
	
	protected $table = 'machine_hdr_t';
	protected $primaryKey = 'machine_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT machine_hdr_t.* FROM machine_hdr_t  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE machine_hdr_t.machine_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
