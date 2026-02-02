<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confighdr extends Model
{
    protected $table='c_config_hdr_t';
    protected $primaryKey='config_hdr_id';
    protected $fillable=['module','module_table','location_id','organization_id','company_id','created_by','last_updated_by','updated_at','created_at'];
    
}
