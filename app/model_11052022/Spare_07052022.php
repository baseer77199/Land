<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
	protected $table='m_spares_t';
    protected $primaryKey='spares_id';
    protected $fillable=['spares_name', 'department_id', 'category', 'spare_quantity', 'upload_image','description','created_by'];
    }

