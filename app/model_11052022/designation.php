<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class designation extends Model
{
	protected $table='designation_tbl';
    protected $primaryKey='designation_id';
    protected $fillable=['designation_name','description','created_at','updated_at','last_updated_by','company_id','location_id','organization_id','active'];
    }

