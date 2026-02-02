<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addmachinelines extends Model
{
	
	protected $table='machine_lines_t';
    protected $primaryKey='machine_lines_id';
    protected $foreignKey='machine_id';
    protected $fillable=['frequency_id','frequency_date','machine_id'];
    public function getTableColumns() 
	 {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
     }
}
