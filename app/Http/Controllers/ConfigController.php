<?php
namespace App\Http\Controllers;

use App\Confighdr;
use App\Configlines;
use App\Breakdownmaintenance;

use Illuminate\Http\Request, DB;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->data = array();
        $this->data['urlmenu'] = $this->indexs();
        $this->data['pageMethod'] = \Request::route()
            ->getName();
        $this->data['urlname'] = \Request::route()
            ->getName();
        $this->data['pageFormtype'] = 'ajax';
        $this->data['pageModule'] = \Request::route()
            ->getName();
        $this->table = "c_config_hdr_t";
        $this->subtable = "c_config_lines_t";
        $this->model = new Confighdr;
        $this->submodel = new Configlines;

    }

    /*isac purpose:configuration*/
    public function index1()
    {
        $this->data['pageMethod'] = \Request::route()
            ->getName();
        $this->data['urlname'] = \Request::route()
            ->getName();

        $table = \DB::select("show tables");

        $html = '<option value="">--Please Select--</option>';

        foreach ($table as $value) {

            // print_r($value);die;
            $html .= "<option value='" . $value->Tables_in_landt_db . "'>" . $value->Tables_in_landt_db . "</option>";

        }
        $this->data['table'] = $html;

        return view("configform.fileconfigform", $this->data);

    }

    public function gettablefield($table)
    {
        $table = \DB::select("SHOW COLUMNS FROM $table");
        return $table;

    }
    public function configurationdatasave(Request $request)
    {

        $data = $this->validatePost($_POST, $this->table, 'header');

        $lines_data = $this->validatePost($request->all(), $this->subtable, 'lines');
        // dd($data);
        \DB::beginTransaction();
        try {
            $id = $this
                ->model
                ->insertRow($data);
            $lid = $this
                ->submodel
                ->subgridSave($lines_data, $id);

            \DB::commit();
            /**Auditlog**/
            if ($_POST['config_hdr_id'] == "") {
                $action = "Save";
            } else {
                $action = "Update";
            }
            return response()->json(array(
                'status' => 'success',
                'message' => 'Config Saved',
                'id' => $id,
                'lid' => $lid,
                'auto_no' => ''
            ));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = explode('(', $e->getMessage());
            $dbCode = rtrim($message[0], ']');
            $dbCode = trim($dbCode, '[');
            dd($dbCode);
            \DB::rollback();
            return response()->json(array(
                'status' => 'error',
                'message' => 'DatabaseError:=>' . $dbCode . "\n"
            ));
        }

    }
    /*end*/
    public function uploadindex()
    {
        $this->data['pageMethod'] = \Request::route()
            ->getName();
        $this->data['urlname'] = \Request::route()
            ->getName();
        $module = '';
        if ($this->data['urlname'] == 'agencyupload') {
            $module = 31;
        } else if ($this->data['urlname'] == 'vendorupload') {
            $module = 32;
        } else if ($this->data['urlname'] == 'sparesupload') {
            $module = 33;
        } else if ($this->data['urlname'] == 'departmentupload') {
            $module = 34;
            $module = 39;
        } else if ($this->data['urlname'] == 'breakdowntypeupload') {
            $module = 35;
        } else if ($this->data['urlname'] == 'designationupload') {
            $module = 37;
        } else if ($this->data['urlname'] == 'userupload') {
            $module = 38;
        } else if ($this->data['urlname'] == 'machinegroupupload') {
            $module = 40;
        } else if ($this->data['urlname'] == 'initiatepmupload') {
            $module = 41;
        } else if ($this->data['urlname'] == 'ticketgenerateupload') {
            $module = 43;
        }

        $this->data['module_name'] = $this->jcombocomp('c_config_hdr_t', 'config_hdr_id', 'module_name', $module);
        return view('configform.uploadconfig', $this->data);
    }
    /*end*/
    /* deepika purpose:download template with dynamic title*/
    function getDownloadtemplate($module = null)
    {
        $sql_c = \DB::table('c_config_hdr_t')->leftjoin('c_config_lines_t', 'c_config_lines_t.config_hdr_id', '=', 'c_config_hdr_t.config_hdr_id')
            ->where('c_config_hdr_t.config_hdr_id', $module)->where('c_config_lines_t.type', 'Yes')
            ->select('c_config_hdr_t.module_name', 'c_config_lines_t.title')
            ->get();

        $a1 = array();
        foreach ($sql_c as $k => $v) {
            $level = json_decode(json_encode($v->title), true);
            array_push($a1, $level);
        }
        $arr = $a1;
        $module1 = $sql_c[0]->module_name;
        if (!empty($sql_c)) {
            $result = array_map(
                function ($item) {
                    return $item;
                }
                ,
                $arr
            );
            // array_unshift($result, 'PS DATE');
            $filepath = $module1 . ' TEMPLATE.csv';
            array_map('unlink', glob("uploads/" . $module1 . " TEMPLATE"));
            $output = fopen("uploads/" . $filepath, 'w+');
            $re[0] = $result;

            fputcsv($output, $re[0]);
            // fputcsv($output, $re[1]);
            return array(
                'status' => 1
            );

        } else {
            return array(
                'status' => 0
            );
        }
    }

    /*End*/
    /*Vignesh purpose:upload config save*/

    public function uploadsave(Request $request)
    {
        if ($_POST['stage'] == '1') {

            if (!is_null(\Input::file('upload_file'))) {

                //dd("dsghyjfgdshjbgds");
                $file = $request->file('upload_file');
                $destinationPath = './uploads/templte/';
                $path = $_FILES['upload_file']['name'];
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $file = $_FILES['upload_file']['tmp_name'];
                $handle = fopen($file, "r");
                $c = 0;

                if ($extension == "csv") {

                    while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                        if ($c == 0) {
                            $filesop;
                        }
                        break;
                    }

                }
            } else {
                return response()->json(array(
                    'message' => "Upload CSV File",
                    'status' => 'error'
                ));
            }

            $option = "<option value=''>--Please Select--</option>";
            foreach ($filesop as $k => $v) {
                $option .= "<option value='" . $k . "'>$v</option>";
            }
            $column_names = \DB::select("SELECT c_config_lines_t.field,c_config_lines_t.title FROM `c_config_lines_t` where type='Yes' and config_hdr_id='" . $_POST['module_name'] . "'");

            $column_fields = '';
            foreach ($column_names as $key => $fields) {

                $column_fields .= '<div class="form-group row col-md-4">
                    <label for="inputIsValid" class="form-control-label col-md-4">' . $fields->title . '</label>
                    <div class="col-md-8">
                        <select name="' . $fields->field . '" class="form-control select2 field' . $key . '"  tabindex="' . ($key + 1) . '" >
                            ' . $option . '
                        </select>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>';
            }
            $column_fields .= '<div class="row">
                                         <button type="button" name="upload" id="upload" class="upload btn btn-primary btn-sm saveform"><i class="fa  fa-save "></i>  Upload </button>                              
                                </div>';

            foreach ($column_names as $key => $fields) {
                $p = 0;

                foreach ($filesop as $k => $v) {
                    $sim = similar_text($fields->title, $v, $perc);
                    if ($p < $perc) {
                        $column_names[$key]->position = $k;
                        $p = $perc;
                    }
                }
            }

            return response()->json(array(
                'filesop' => $column_names,
                'table_fields' => $column_fields,
                'status' => 'mapping'
            ));

        } else {
            $file = $request->file('upload_file');
            $destinationPath = './uploads/templte/';
            $path = $_FILES['upload_file']['name'];
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $file = $_FILES['upload_file']['tmp_name'];
            $handle = fopen($file, "r");
            $c = 0;
            $column_names = \DB::select("SELECT * FROM `c_config_lines_t` where type='Yes' and config_hdr_id='" . $_POST['module_name'] . "'");

            $column_fields = '';

            $table = \DB::select("select module_table,module_table_pk from c_config_hdr_t where c_config_hdr_t.config_hdr_id='" . $_POST['module_name'] . "'");

            $pk = $table[0]->module_table_pk;
            $table = $table[0]->module_table;
            if (isset($_POST['read_option'])) {
                $read_option = $_POST['read_option'];
            } else {
                $read_option = 'Clone';
            }

           

            $total_record = 0;
            $skip = 0;
            $clone = 0;
            $overwrite = 0;
            $new = 0;
            $excel = array();

            if ($extension == "csv") {

                while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
 
                    if ($c > 0) {
                       

                        $insert = array();
                        if ($_POST['module_name'] != 38) {
                            $insert['location_id'] = \Session::get('location');
                            $insert['company_id'] = \Session::get('companyid');
                            $insert['organization_id'] = \Session::get('organization');
                            $insert['created_by'] = \Session::get('id');
                            $insert['last_updated_by'] = \Session::get('id');
                            $insert['created_at'] = now();
                            $insert['updated_at'] = now();

                            //Baseer : Purpose For Preventive Maintence Count Increase For Upload
                            if ($_POST['module_name'] == 41) {
                                $seqno = $this->Seqnoe('PM-', 'machine_pm_detail_t', '', 'pm_count');
                                $insert['pm_no'] = $seqno[0];
                                $insert['pm_count'] = $seqno[1];
                            }

                        } else {
                            $insert['loc_id'] = \Session::get('location');
                            $insert['company_id'] = \Session::get('companyid');
                            $insert['org_id'] = \Session::get('organization');
                            $insert['password'] = bcrypt('welcome123');
                            //$insert['created_by']=\Session::get('id');

                        }
                        $s = 1;
                        $total_record++;
                        $excel[$c] = (object) array();
                        $reason = '';
                        $spare_name_csv = '';
                        $spare_qty_csv = '';

                        foreach ($column_names as $key => $fields) {
                            $ins_id = 0;
                            $upd_id = 0;

                            // Skip if field is not mapped (empty POST value)
                            if (!isset($_POST[$fields->field]) || $_POST[$fields->field] === '' || !isset($filesop[$_POST[$fields->field]])) {
                                continue;
                            }

                            if ($fields->field_type == 'Select') {
                                $name = $filesop[$_POST[$fields->field]];

                                // For ticket upload (module 43), skip Spare Name validation if critical_spare is not "Yes"
                                if ($_POST['module_name'] == 43 && $fields->field == 'bulk_spares_id') {
                                    // Get the critical_spare value from CSV
                                    $critical_spare_value = '';
                                    foreach ($column_names as $cs_field) {
                                        if ($cs_field->field == 'critical_spare' && isset($_POST[$cs_field->field]) && isset($filesop[$_POST[$cs_field->field]])) {
                                            $critical_spare_value = $filesop[$_POST[$cs_field->field]];
                                            break;
                                        }
                                    }
                                    // If critical_spare is not "Yes", skip the master validation for Spare Name
                                    if ($critical_spare_value != 'Yes') {
                                        $excel[$c]->{$fields->title} = $name;
                                        $spare_name_csv = $name; // Store for later use but don't validate
                                        continue; // Skip to next field
                                    }
                                }

                                if ($fields->display2 != '' && $fields->display2 != null) {
                                    $wh = " and (" . $fields->display1 . "='" . $name . "' or " . $fields->display2 . "='" . $name . "')";
                                } else {
                                    $wh = " and (" . $fields->display1 . "='" . $name . "')";
                                }

                                $d = \DB::select("select " . $fields->select_option_pri_id . " from " . $fields->select_option_tbl . " where 1=1 $wh ");

                                if (count($d) > 0) {
                                    $excel[$c]->{$fields->title} = $name;
                                    $insert[$fields->field] = $d[0]->{$fields->select_option_pri_id};
                                } else {

                                    $excel[$c]->{$fields->title} = $name;
                                    $s = 0;
                                    $reason .= $fields->title . " Not available in master,";
                                    // print_r("select " . $fields->select_option_pri_id . " from " . $fields->select_option_tbl . " where 1=1 $wh ");die;
                                }
                            } else {
                                $excel[$c]->{$fields->title} = $filesop[$_POST[$fields->field]];
                                // For ticket upload (module 43), do NOT add bulk_spares_id and bulk_qty to $insert
                                // These fields are for the lines table (b_maintenance_t_lines), not the main table
                                if ($_POST['module_name'] == 43 && ($fields->field == 'bulk_spares_id' || $fields->field == 'bulk_qty')) {
                                    // Store in separate variables, handled later in module 43 specific section
                                    if ($fields->field == 'bulk_spares_id') {
                                        $spare_name_csv = $filesop[$_POST[$fields->field]];
                                    } else if ($fields->field == 'bulk_qty') {
                                        $spare_qty_csv = $filesop[$_POST[$fields->field]];
                                    }
                                } else {
                                    $insert[$fields->field] = $filesop[$_POST[$fields->field]];
                                }
                            }

                            // Baseer : Purpose For Ticket Number Auto Generation & Issue Date Format Change

                            if ($_POST['module_name'] == 43) {
                                if ($fields->field == 'issue_date') {
                                    // Parse date in d-m-y H:i format (e.g., 26-01-19 10:00)
                                    $date_value = $filesop[$_POST[$fields->field]];
                                    $parsed_date = \DateTime::createFromFormat('d-m-y H:i', $date_value);
                                    if (!$parsed_date) {
                                        // Try d-m-y format without time
                                        $parsed_date = \DateTime::createFromFormat('d-m-y', $date_value);
                                    }
                                    if ($parsed_date) {
                                        $insert['issue_date'] = $parsed_date->format("Y-m-d H:i:s");
                                    } else {
                                        // Fallback to strtotime if format doesn't match
                                        $insert['issue_date'] = date("Y-m-d H:i:s", strtotime($date_value));
                                    }
                                    $insert['issue_created_on'] = $insert['issue_date'];
                                    $insert['issue_created_by'] = \Session::get('id');
                                } else if ($fields->field == 'start_date' && isset($_POST[$fields->field]) && $filesop[$_POST[$fields->field]] != '') {
                                    // Parse date in d-m-y H:i format
                                    $date_value = $filesop[$_POST[$fields->field]];
                                    $parsed_date = \DateTime::createFromFormat('d-m-y H:i', $date_value);
                                    if (!$parsed_date) {
                                        $parsed_date = \DateTime::createFromFormat('d-m-y', $date_value);
                                    }
                                    if ($parsed_date) {
                                        $insert['start_date'] = $parsed_date->format("Y-m-d H:i:s");
                                    } else {
                                        $insert['start_date'] = date("Y-m-d H:i:s", strtotime($date_value));
                                    }
                                } else if ($fields->field == 'end_date' && isset($_POST[$fields->field]) && $filesop[$_POST[$fields->field]] != '') {
                                    // Parse date in d-m-y H:i format
                                    $date_value = $filesop[$_POST[$fields->field]];
                                    $parsed_date = \DateTime::createFromFormat('d-m-y H:i', $date_value);
                                    if (!$parsed_date) {
                                        $parsed_date = \DateTime::createFromFormat('d-m-y', $date_value);
                                    }
                                    if ($parsed_date) {
                                        $insert['end_date'] = $parsed_date->format("Y-m-d H:i:s");
                                    } else {
                                        $insert['end_date'] = date("Y-m-d H:i:s", strtotime($date_value));
                                    }
                                } else if ($fields->field == 'corrective_action' && isset($_POST[$fields->field])) {
                                    $insert['corrective_action'] = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'preventive_action' && isset($_POST[$fields->field])) {
                                    $insert['preventive_action'] = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'priority_option' && isset($_POST[$fields->field])) {
                                    $insert['priority_option'] = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'critical_spare' && isset($_POST[$fields->field])) {
                                    $insert['critical_spare'] = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'others' && isset($_POST[$fields->field])) {
                                    $insert['others'] = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'request_remark' && isset($_POST[$fields->field])) {
                                    $insert['request_remark'] = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'approve_remarks' && isset($_POST[$fields->field])) {
                                    $insert['approve_remarks'] = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'technician' && isset($_POST[$fields->field]) && $filesop[$_POST[$fields->field]] != '') {
                                    // Handle technician - lookup by employee_number
                                    $tech_emp_no = $filesop[$_POST[$fields->field]];
                                    $tech_user = \DB::table('tb_users')->where('employee_number', $tech_emp_no)->first();
                                    if ($tech_user) {
                                        $insert['technician'] = json_encode([$tech_user->id]);
                                    }
                                } else if ($fields->field == 'bulk_spares_id' && isset($_POST[$fields->field]) && $filesop[$_POST[$fields->field]] != '') {
                                    // Store in separate variable, NOT in $insert (these are NOT columns in b_maintenance_t)
                                    $spare_name_csv = $filesop[$_POST[$fields->field]];
                                } else if ($fields->field == 'bulk_qty' && isset($_POST[$fields->field]) && $filesop[$_POST[$fields->field]] != '') {
                                    // Store in separate variable, NOT in $insert (these are NOT columns in b_maintenance_t)
                                    $spare_qty_csv = $filesop[$_POST[$fields->field]];
                                }
                            }


                        }
 
                        
                        // Baseer : Auto-generate ticket_number and ticket_count for ticket upload (module 43)
                        // This runs after the field loop to ensure it always happens regardless of template fields
                        if ($_POST['module_name'] == 43) {
                            if (!isset($insert['ticket_number']) || $insert['ticket_number'] == '' || $insert['ticket_number'] == null) {
                                $seqno = $this->Seqnoe("TICKET-" . \Session::get('location') . "-", 'b_maintenance_t', '', 'ticket_count');
                                $excel[$c]->{'Ticket Number'} = $insert['ticket_number'] = $seqno[0];
                                $excel[$c]->{'ticket_count'} = $insert['ticket_count'] = $seqno[1];
                            } else if (!isset($insert['ticket_count']) || $insert['ticket_count'] == '') {
                                // If ticket_number was provided but ticket_count wasn't
                                $seqno = $this->Seqnoe("TICKET-" . \Session::get('location') . "-", 'b_maintenance_t', '', 'ticket_count');
                                $excel[$c]->{'ticket_count'} = $insert['ticket_count'] = $seqno[1];
                            }
                        }

                        if ($s == 1) {

                            $where = '1=1';

                            if (isset($_POST['find_duplicate'])) {
                                foreach ($_POST['find_duplicate'] as $rkey => $rval) {
                                    $where .= " and  $rval='" . $insert[$rval] . "'";
                                }
                            }


                        
                            if ($read_option == 'clone') {
                                $d = \DB::select("select * from $table where $where");

                                if (count($d) == 0) {
                                    $ins_id = \DB::table($table)->insertGetId($insert);
                                    $new++;
                                    $excel[$c]->Status = "Upload";
                                } else {
                                    $ins_id = \DB::table($table)->insertGetId($insert);
                                    $clone++;
                                    $excel[$c]->Status = "Clone";
                                }

                            } else if ($read_option == 'skip') {
                                $d = \DB::select("select * from $table where $where");

                                if (count($d) == 0) {
                                    $ins_id = \DB::table($table)->insertGetId($insert);
                                    $new++;
                                    $excel[$c]->Status = "Upload";
                                } else {
                                    $skip++;
                                    $excel[$c]->Status = "Skip";
                                }
                            } else if ($read_option == 'overwrite') {

                                $d = \DB::select("select * from $table where $where");

                                if (count($d) == 0) {
                                    $ins_id = \DB::table($table)->insertGetId($insert);
                                    $new++;
                                    $excel[$c]->Status = "Upload";
                                } else {

                                    $val = $d[0]->{$pk};
                                    $upd_id = \DB::table($table)->where($pk, $val)->update($insert);
                                    $overwrite++;
                                    $excel[$c]->Status = "Overwrite";
                                }
                            }else if($read_option == 'novalidate'){
                                $ins_id = \DB::table($table)->insertGetId($insert);
                                $new++;
                                $excel[$c]->Status = "Upload";
                            }
                        } else {
                            $skip++;
                            $excel[$c]->Status = "Skip";
                        }

                        $excel[$c]->Reason = "$reason";


                        // Baseer : Purpose For Ticket Pending Noti Update (INITIATED or CLOSED)
                        if ($_POST['module_name'] == 43) {
                            if ($ins_id != 0) {
                                $action = "Create";
                                $data_machine = \DB::SELECT("SELECT * from machine_hdr_t where machine_id=" . $insert['machine_id']);
                                $this->auditlog($ins_id, "Breakdownmaintenance", $action, $_POST, "b_maintenance_t");

                                $noti_msg = "Breakdown Ticket Generated - " . $insert['ticket_number'];
                                $noti_msg1 = "Breakdown Ticket Generated for the machine " . $data_machine[0]->machine_name . " - [" . $insert['ticket_number'] . "] on " . date('d-m-Y H:i:s', strtotime($insert['issue_created_on'])) . " by " . $this->getusername($insert['issue_created_by']);

                                $not_data['location'] = \Session::get('location');
                                $not_data['dept_id'] = $data_machine[0]->department_id;
                                $not_data['module'] = 'ticket_generate';
                                $not_data['edit_id'] = $ins_id;
                                $not_data['noti_msg'] = $noti_msg;
                                $not_data['noti_msg1'] = $noti_msg1;
                                $not_data['user'] = \Session::get('id');
                                $not_data['btn_val'] = 'requestraise';
                                $not_data['created_at'] = date('Y-m-d H:i:s');
                                $not_data['location_id'] = \Session::get('location');
                                $not_data['organization_id'] = \Session::get('organization');
                                $not_data['created_by'] = \Session::get('id');
                                $not_data['status'] = 0;
                                $not_save = \DB::table('pending_noti_t')->insert($not_data);

                                // Determine if ticket should be CLOSED based on available data
                                $is_closed_ticket = false;
                                if (
                                    isset($insert['end_date']) && $insert['end_date'] != '' && $insert['end_date'] != '1970-01-01 05:30:00'
                                    && isset($insert['corrective_action']) && $insert['corrective_action'] != ''
                                    && isset($insert['preventive_action']) && $insert['preventive_action'] != ''
                                ) {
                                    $is_closed_ticket = true;
                                }

                                // Purpose For Allocate Technician
                                $data = [];
                                $eng_hist['breakdown_id'] = $ins_id;
                                $eng_hist['created_by'] = $data['allocate_engineer_by'] = \Session::get('id');
                                $eng_hist['created_at'] = $data['allocate_engineer_on'] = date("Y-m-d H:i:s");

                                // Set priority from CSV or default to Low
                                $data['priority_option'] = isset($insert['priority_option']) && $insert['priority_option'] != '' ? $insert['priority_option'] : 'Low';

                                $eng_hist['organization_id'] = \Session::get('organization');
                                $eng_hist['location_id'] = \Session::get('location');
                                $eng_hist['company_id'] = \Session::get('companyid');

                                // Handle technician - use from CSV if provided, otherwise fetch all technicians
                                if (isset($insert['technician']) && $insert['technician'] != '') {
                                    $eng_hist['technician'] = $insert['technician'];
                                    $data['technician'] = $insert['technician'];
                                    // Extract first technician ID and save to engineer column
                                    $technicianArray = json_decode($insert['technician'], true);
                                    if (is_array($technicianArray) && count($technicianArray) > 0) {
                                        $data['engineer'] = $technicianArray[0]; // Save first value (e.g., "18" from ["18","41"])
                                    }
                                } else {
                                    $userIds = \DB::table('tb_users')
                                        ->join('ma_department_t', 'ma_department_t.department_id', '=', 'tb_users.machine_department_id')
                                        ->where('ma_department_t.is_technician', 'Yes')
                                        ->where('loc_id', \Session::get('location'))
                                        ->pluck('tb_users.id')
                                        ->toArray();

                                    if (count($userIds) > 0) {
                                        // Convert integer IDs to strings for proper JSON format ["33","35","36","62"]
                                        $userIdsStr = array_map('strval', $userIds);
                                        $eng_hist['technician'] = json_encode($userIdsStr);
                                        $data['technician'] = json_encode($userIdsStr);
                                        $data['engineer'] = $userIdsStr[0]; // Save first technician ID to engineer column
                                    } else {
                                        $eng_hist['technician'] = json_encode([]);
                                        $data['technician'] = json_encode([]);
                                        $data['engineer'] = '';
                                    }
                                }

                                $hist_ins = \DB::table('engineer_history_tbl')->insert($eng_hist);

                                if ($is_closed_ticket) {
                                    // CLOSED ticket - set all closure fields
                                    $data['request_status'] = "CLOSED";
                                    $data['is_breakdown'] = isset($insert['is_breakdown']) ? $insert['is_breakdown'] : 'Yes';
                                    $data['start_date'] = $insert['start_date'];
                                    $data['end_date'] = $insert['end_date'];
                                    $data['corrective_action'] = $insert['corrective_action'];
                                    $data['preventive_action'] = $insert['preventive_action'];
                                    $data['critical_spare'] = isset($insert['critical_spare']) ? $insert['critical_spare'] : '';
                                    $data['others'] = isset($insert['others']) ? $insert['others'] : '';
                                    $data['request_remark'] = isset($insert['request_remark']) ? $insert['request_remark'] : '';
                                    $data['approve_remarks'] = isset($insert['approve_remarks']) ? $insert['approve_remarks'] : '';
                                    $data['closed_engineer_by'] = \Session::get('id');
                                    $data['closed_engineer_on'] = date("Y-m-d H:i:s");
                                    $data['request_request_by'] = \Session::get('id');
                                    $data['request_request_on'] = date("Y-m-d H:i:s");
                                    $data['request_approve_by'] = \Session::get('id');
                                    $data['request_approve_on'] = date("Y-m-d H:i:s");

                                    // Handle spare parts if critical_spare is Yes
                                    if (
                                        isset($insert['critical_spare']) && $insert['critical_spare'] == 'Yes'
                                        && isset($spare_name_csv) && $spare_name_csv != ''
                                    ) {

                                        // Lookup spare by name
                                        $spare = \DB::table('m_spares_t')->where('spares_name', $spare_name_csv)->first();
                                        if ($spare) {
                                            $qty = isset($spare_qty_csv) && is_numeric($spare_qty_csv) ? (int) $spare_qty_csv : 1;

                                            // Insert into lines table
                                            $lines_data = [
                                                'id' => $ins_id,
                                                'line_no' => 1,
                                                'spares_id' => $spare->spares_id,
                                                'qty' => $qty,
                                                'inventory_stock' => $spare->spare_quantity,
                                                'company_id' => \Session::get('companyid'),
                                                'location_id' => \Session::get('location'),
                                                'organization_id' => \Session::get('organization'),
                                                'created_by' => \Session::get('id'),
                                                'created_at' => date('Y-m-d'),
                                                'last_updated_by' => \Session::get('id'),
                                                'updated_at' => date('Y-m-d')
                                            ];
                                            \DB::table('b_maintenance_t_lines')->insert($lines_data);

                                            // Update spare stock
                                            $new_qty = $spare->spare_quantity - $qty;
                                            \DB::table('m_spares_t')->where('spares_id', $spare->spares_id)->update(['spare_quantity' => $new_qty]);
                                        }
                                    }

                                    // Closure notification
                                    $noti_msg = "Ticket Closed Successfully - " . $insert['ticket_number'];
                                    $noti_msg1 = "Breakdown Ticket Closed Successfully for the machine " . $data_machine[0]->machine_name . " - [" . $insert['ticket_number'] . "] on " . date('d-m-Y H:i:s', strtotime($data['closed_engineer_on'])) . " by " . $this->getusername($data['closed_engineer_by']);

                                    $not_data2['location'] = \Session::get('location');
                                    $not_data2['dept_id'] = $data_machine[0]->department_id;
                                    $not_data2['module'] = 'close_ticket';
                                    $not_data2['edit_id'] = $ins_id;
                                    $not_data2['noti_msg'] = $noti_msg;
                                    $not_data2['noti_msg1'] = $noti_msg1;
                                    $not_data2['user'] = \Session::get('id');
                                    $not_data2['btn_val'] = 'closedrequest';
                                    $not_data2['created_at'] = date('Y-m-d H:i:s');
                                    $not_data2['location_id'] = \Session::get('location');
                                    $not_data2['organization_id'] = \Session::get('organization');
                                    $not_data2['created_by'] = \Session::get('id');
                                    $not_data2['status'] = 0;
                                    $not_save2 = \DB::table('pending_noti_t')->insert($not_data2);

                                } else {
                                    // INITIATED ticket - original behavior
                                    $data['request_status'] = "INITIATED";

                                    $noti_msg = "Ticket Allocated Successfully - " . $insert['ticket_number'];
                                    $noti_msg1 = "Breakdown Ticket Allocated Successfully for the machine " . $data_machine[0]->machine_name . " - [" . $insert['ticket_number'] . "] on " . date('d-m-Y H:i:s', strtotime($data['allocate_engineer_on'])) . " by " . $this->getusername($insert['issue_created_by']);

                                    $not_data1['location'] = \Session::get('location');
                                    $not_data1['dept_id'] = $data_machine[0]->department_id;
                                    $not_data1['module'] = 'allocate_technician';
                                    $not_data1['edit_id'] = $ins_id;
                                    $not_data1['noti_msg'] = $noti_msg;
                                    $not_data1['noti_msg1'] = $noti_msg1;
                                    $not_data1['user'] = \Session::get('id');
                                    $not_data1['btn_val'] = 'requestraise';
                                    $not_data1['created_at'] = date('Y-m-d H:i:s');
                                    $not_data1['location_id'] = \Session::get('location');
                                    $not_data1['organization_id'] = \Session::get('organization');
                                    $not_data1['created_by'] = \Session::get('id');
                                    $not_data1['status'] = 0;

                                    $not_save1 = \DB::table('pending_noti_t')->insert($not_data1);
                                }

                                Breakdownmaintenance::find($ins_id)->update($data);

                            }

                        }


                        if ($_POST['module_name'] == 38) {

                            if ($ins_id != 0) {
                                $user_data = \DB::table('tb_users')->where('id', $ins_id)->get();
                                if (count($user_data) > 0) {
                                    $group = $user_data[0]->group_id;
                                    $group_data = \DB::table('a_group_menu_access_t')->where('group_id', $group)->get();
                                    if (count($group_data) > 0) {
                                        $acc_data['user_id'] = $ins_id;
                                        $acc_data['group_id'] = $group;

                                        $acc_data['menus'] = $group_data[0]->menus;
                                        $acc_data['permission'] = $group_data[0]->permission;

                                        $acc_data['location_id'] = \Session::get('location');
                                        $acc_data['company_id'] = \Session::get('companyid');
                                        $acc_data['organization_id'] = \Session::get('organization');
                                        $acc_data['created_by'] = \Session::get('id');

                                        DB::table('a_user_access_t')->insert($acc_data);
                                    }
                                }

                            } else if ($upd_id != 0) {
                                $user_data = \DB::table('tb_users')->where('id', $upd_id)->get();
                                if (count($user_data) > 0) {
                                    $ua_data = \DB::table('a_user_access_t')->where('id', $upd_id)->get();
                                    if (count($ua_data) > 0) {
                                        $group = $user_data[0]->group_id;
                                        $group_data = \DB::table('a_group_menu_access_t')->where('group_id', $group)->get();
                                        if (count($group_data) > 0) {
                                            $acc_data['user_id'] = $ins_id;
                                            $acc_data['group_id'] = $group;

                                            $acc_data['menus'] = $group_data[0]->menus;
                                            $acc_data['permission'] = $group_data[0]->permission;

                                            $acc_data['location_id'] = \Session::get('location');
                                            $acc_data['company_id'] = \Session::get('companyid');
                                            $acc_data['organization_id'] = \Session::get('organization');
                                            $acc_data['created_by'] = \Session::get('id');

                                            DB::table('a_user_access_t')->where('a_user_access_id', $ua_data[0]->a_user_access_id)
                                                ->update($acc_data);
                                        }

                                    } else {
                                        $group = $user_data[0]->group_id;
                                        $group_data = \DB::table('a_group_menu_access_t')->where('group_id', $group)->get();
                                        if (count($group_data) > 0) {
                                            $acc_data['user_id'] = $ins_id;
                                            $acc_data['group_id'] = $group;

                                            $acc_data['menus'] = $group_data[0]->menus;
                                            $acc_data['permission'] = $group_data[0]->permission;

                                            $acc_data['location_id'] = \Session::get('location');
                                            $acc_data['company_id'] = \Session::get('companyid');
                                            $acc_data['organization_id'] = \Session::get('organization');
                                            $acc_data['created_by'] = \Session::get('id');

                                            DB::table('a_user_access_t')->insert($acc_data);
                                        }
                                    }
                                }

                            }
                        }

                    }
                    $c++;
                }
                if (count($excel) > 0) {
                    $excel = collect($excel)->map(function ($x) {
                        return (array) $x;
                    })->toArray();

                    header('Content-Type: text/csv; charset=utf-8');
                    header('Content-Disposition: attachment; filename=data.csv');
                    $output = fopen('uploads/upload_log.csv', 'w');
                    //dd($excel[1]);
                    fputcsv($output, array_keys($excel[1]));
                    foreach ($excel as $row) {
                        fputcsv($output, $row);
                    }
                }

            }

            return response()->json(array(
                'totalrecords' => $total_record,
                'clone' => $clone,
                'overwrite' => $overwrite,
                'skip' => $skip,
                'new' => $new,
                'status' => 'Success'
            ));

        }

    }
    /*End*/
}