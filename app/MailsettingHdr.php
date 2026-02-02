<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailsettingHdr extends Model
{
    
    protected $table='m_mailsetting_hrd_tbl';
      protected $primaryKey='mailsetting_hrd_id';
      protected $fillable =['module','description','active','created_by','location_id','company_id','last_updated_by','created_by_mail'];
}