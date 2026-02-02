<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table='m_amc_tb';
    protected $primaryKey='vendor_id';
    protected $fillable =['vendor_name','address','contact_no','email_id','active'];
    public function getTableColumns() 
    {
       return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
