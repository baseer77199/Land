<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pmupload extends Model
{

  protected $table = 'machine_pm_detail_t';
  protected $primaryKey = 'initiate_pm_id';
  protected $fillable = ['pm_no', 'pm_count', 'machine_id', 'department_id', 'actual_pm_date', 'initiate_date', 'prev_pm_id', 'user_clearance_by', 'initiate_status', 'postpone_status', 'status', 'cleared_by', 'cleared_on', 'shift_timing', 'postponed_date', 'change_date', 'allocated_agency', 'allocated_by', 'allocated_on', 'frequency_id', 'done_on_by', 'done_on_date', 'done_on_time', 'location_id', 'organization_id', 'company_id', 'created_by', 'created_at', 'last_updated_by', 'updated_at'];
}