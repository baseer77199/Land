<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailsettingLines extends Model{
   protected $table='m_mailsetting_lines_tbl';
   public $foreignKey='mailsetting_hrd_id';
   protected $primaryKey='mailsetting_lines_id';
   protected $fillable =['department_id','designation_id','type'];
}
