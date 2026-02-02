<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $table='ma_department_t';
    protected $primaryKey='department_id';
    protected $fillable=['department_id','department_name','department_no','description','is_technician','created_by','last_updated_by','created_at','updated_at','company_id','location_id','organization_id'];
    public function getTableColumns() 
	 {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
     }
    }
