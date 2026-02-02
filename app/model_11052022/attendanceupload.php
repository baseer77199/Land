<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendanceupload extends Model
{
	
	protected $table='attendance_upload_t';
    protected $primaryKey='employee_id';
    protected $fillable=['employee_no','date','checkin','checkout','choosefile'];
    public function getTableColumns() 
	 {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
     }
}
