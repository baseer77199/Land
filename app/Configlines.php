<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configlines extends Model
{
    protected $table='c_config_lines_t';
    protected $primaryKey='config_line_id';
    protected $foreignKey='config_hdr_id';
    protected $fillable=['config_hdr_id','line_no','field','title','field_type','type','show','select_option_tbl','select_option_pri_id','display1','display2'];
}
