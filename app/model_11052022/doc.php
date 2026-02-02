<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class doc extends Model
{
    protected $table='document_tb';
    protected $primaryKey='document_id';
    protected $fillable=['doc_id','renewed_on','status','new_renewal_date','document_id','department_id','form_no','frequency','valid_from','valid_to','description','machine_id','file','renewal_date','remainder_days'];
    public function getTableColumns() 
	 {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
     }

}
