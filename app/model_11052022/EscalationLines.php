<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscalationLines extends Model{
   protected $table='m_escalation_lines_tbl';
   public $foreignKey='escalation_hrd_id';
   protected $primaryKey='escalation_lines_id';
   protected $fillable =['department_id','designation_id','type','duration'];
}
