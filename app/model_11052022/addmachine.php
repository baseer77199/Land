<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addmachine extends Model
{
	
	protected $table='machine_hdr_t';
    protected $primaryKey='machine_id';
    protected $fillable=['machine_name','department_id','machine_no','capacity','location','relocated_date','purchased_date','remarks','machine_make','cost','choosefile','vendor_id','amc_vendor_id','from_date','to_date','renewal_date','critical'];
    public function getTableColumns() 
	 {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
     }
}
