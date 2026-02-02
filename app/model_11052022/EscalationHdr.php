<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscalationHdr extends Model
{
    
    protected $table='m_escalation_hrd_tbl';
      protected $primaryKey='escalation_hrd_id';
      protected $fillable =['condition','severity','description','active','created_by','location_id','company_id','last_updated_by','created_by_mail'];
}