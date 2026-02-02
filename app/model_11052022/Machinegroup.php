<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machinegroup extends Model
{
	protected $table='machine_group_t';
    protected $primaryKey='group_id';
    protected $fillable=['group_id','group_name','description'];
    }
