<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breakdownseverity extends Model
{
	protected $table='breakdown_severity';
    protected $primaryKey='breakdownseverity_id';
    protected $fillable=['severity_name','description','created_by','last_updated_by','created_at','updated_at','company_id','location_id','organization_id'];
    
    }