<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
	protected $table='m_spares_t';
    protected $primaryKey='spares_id';
    protected $fillable=['spares_name', 'department_id', 'category', 'spare_quantity','spares_no', 'upload_image','description','created_by','last_updated_by','created_at','updated_at','company_id','location_id','organization_id'];
    }

