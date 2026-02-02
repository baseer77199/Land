<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $table='ma_department_t';
    protected $primaryKey='department_id';
    protected $fillable=['department_id','department_name','department_no','description'];
    }
