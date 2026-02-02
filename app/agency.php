<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class agency extends Model
{
    protected $table='ma_agency_t';
    protected $primaryKey='agency_id';
    protected $fillable=['agency_name','email','mobile_no','address','country','state','city','active','created_by','last_updated_by','created_at','updated_at','company_id','location_id','organization_id'];
    public function getTableColumns() 
	 {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
     }

}
