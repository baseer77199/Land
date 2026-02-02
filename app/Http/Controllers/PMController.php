<?php

namespace App\Http\Controllers;

use App\pmupload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, DateTime;
use Storage;
class PMController extends Controller
{
  public function __construct()
  {
    $this->data = array();
    $this->table = "machine_pm_detail_t";
    $this->pageModule = "pmchecksheet";
    $this->model = new pmupload;
    $this->data['urlmenu'] = $this->indexs();
    $this->data['pageMethod'] = \Request::route()->getName();
    $this->data['pageModule'] = \Request::route()->getName();
    $this->data['pageFormtype'] = 'ajax';
  }



  public function pmimport()
  {
    $this->data['batch_no'] = $this->jCombologin('hr_emp_upload_details_t', 'batch_no', 'batch_no', '');

    return view('initiatepm.pmupload', $this->data);
  }

  public function getpmuploaddata()
  {
    $wh = '';

    if (isset($_GET['_search'])) {
      if ($_GET['_search'] == 'true') {
        $wh = $this->jqgridsearch('m_pm_machine_upload_tbl', $_GET['filters']);
      }
    }

    if (isset($_GET['batchname'])) {
      if ($_GET['batchname'] != "") {
        $wh = " and batch_no like '" . $_GET['batchname'] . "'";
      }
    }

    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];

    if (!$sidx)
      $sidx = 1;

    $SQL = "SELECT *,
                  DATE_FORMAT(m_pm_machine_upload_tbl.actual_pm_date, '%d-%m-%Y') AS actual_pm_date
                  from m_pm_machine_upload_tbl 
                  where 1=1 $wh 
                  ORDER BY $sidx $sord ";
    $result = \DB::select($SQL);
    $count = count($result);
    if ($count > 0 && $limit > 0) {
      $total_pages = ceil($count / $limit);
    } else {
      $total_pages = 0;
    }

    if ($page > $total_pages)
      $page = $total_pages;
    $start = $limit * $page - $limit;
    if ($start < 0)
      $start = 0;

    $responce->rows[] = '';
    $responce->rows = array_slice($result, $start, $limit);
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

    echo json_encode($responce);
  }
  public function pmuploadsave(Request $request)
  {
    $datas['uploaded_by'] = \Session::get('empid');
    $datas['date'] = $dates['date'] = date('Y-m-d');

    if (!is_null($request->file('file_upload'))) {
      $updates = array();
      $file = $request->file('file_upload');
      $files = $request->file('file_upload');
      $destinationPath = '/pmupload/';
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension(); //if you need extension of the file
      $date = new DateTime();
      $fname = $date->getTimestamp();
      $newfilename = $filename . '_' . $fname . '.' . $extension;

      //  $uploadSuccess = $file->move($destinationPath, $filename);
      $datas['file_name'] = $newfilename;
      $datas['source'] = "pmimport";
      $id = \DB::table('hr_attendance_import_details_tbl')->insertGetId($datas);
      $path = $_FILES['file_upload']['name'];
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      $data = array();
      $files = $_FILES['file_upload']['tmp_name'];
      $handle = fopen($files, "r");
      $c = 0;


      if ($ext == "csv") {
        $batch_no = $batch['batch_no'] = "BATCH_" . date('Y-m-d') . "_" . date('Hi');
        $id = DB::table('hr_emp_upload_details_t')->insertGetId(['batch_no' => $batch_no, 'location_id' => \Session::get('location')]);
        $cantain = 0;
        while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
          if ($c > 1) {
            if ($filesop[0] != '') {
              if (str_contains($filesop[0], 'script')) {
                $cantain = 1;
              }
              if (str_contains($filesop[0], '=')) {
                $cantain = 1;
              }


              $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
              $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
              $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
              $regex .= "(\:[0-9]{2,5})?"; // Port 
              $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
              $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
              $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

              if (preg_match("/^$regex$/i", $filesop[0])) // `i` flag for case-insensitive
              {

                $cantain = 1;
              }

              if ($filesop[1] != '') {
                if (preg_match("/^$regex$/i", $filesop[1])) // `i` flag for case-insensitive
                {
                  $cantain = 1;
                }
                if (str_contains($filesop[1], 'script')) {
                  $cantain = 1;
                }
                if (str_contains($filesop[1], '=')) {
                  $cantain = 1;
                }
              }

              if ($filesop[2] != '') {
                if (preg_match("/^$regex$/i", $filesop[2])) // `i` flag for case-insensitive
                {
                  $cantain = 1;
                }
                if (str_contains($filesop[2], 'script')) {
                  $cantain = 1;
                }
                if (str_contains($filesop[2], '=')) {
                  $cantain = 1;
                }
              }
              if ($filesop[3] != '') {
                if (preg_match("/^$regex$/i", $filesop[3])) // `i` flag for case-insensitive
                {
                  $cantain = 1;
                }
                if (str_contains($filesop[3], 'script')) {
                  $cantain = 1;
                }
                if (str_contains($filesop[3], '=')) {
                  $cantain = 1;
                }
              }

              $attendencedata['machine_id'] = $filesop[1];
              $attendencedata['department_id'] = $filesop[2];
              $attendencedata['frequency_id'] = $filesop[3];
              $attendencedata['actual_pm_date'] = date('Y-m-d', strtotime($filesop[4]));
              $attendencedata['batch_no'] = $batch_no;
              $attendencedata['created_at'] = date('Y-m-d');
              $attendencedata['batch_status'] = "UPLOADED";
              $attendencedata['location_id'] = \Session::get('location');
              $attendencedata['company_id'] = \Session::get('companyid');
              $attendencedata['organization_id'] = \Session::get('organization');
              $attendencedata['created_by'] = \Session::get('id');

              if ($cantain == 0) {
                $id = \DB::table('m_pm_machine_upload_tbl')->insertGetId($attendencedata);
              }

            }
          }
          $cantain = 0;
          $c++;

        }
        $file->move(public_path() . $destinationPath, $newfilename);
        return 1;
      } else {
        $file->move(public_path() . $destinationPath, $newfilename);

        return 2;
      }


    }
  }
  public function getpmvalidate(Request $request)
  {

    if (isset($_GET['batchname'])) {
      if (!empty($_GET['batchname'])) {
        $filter = 'AND hr_emp_upload_details_t.batch_no = "' . $_GET['batchname'] . '"';
        $batch = $_GET['batchname'];
      }
    }

    if (isset($_GET['type'])) {
      $type = 'PRODUCTUPLOAD';
      $message['status'] = 'success';
      switch ($_GET['type']) {
        case 'verify':
          $upload = $this->uploadValidation($batch, $message);
          $this->data['status'] = $upload['status'];
          $this->data['message'] = $upload['message'];
          return $upload;
          break;

        case 'load':
          $upload = $this->LoadMaster($batch, $message);
          $this->data['status'] = $upload['status'];
          $this->data['message'] = $upload['message'];
          return $upload;
          break;
      }
    }
  }
  function uploadValidation($batchno, $status)
  {
    $status['status'] = 'success';
    $status['message'] = ' ';
    $sql = "select * from m_pm_machine_upload_tbl where batch_status ='UPLOADED'  and batch_no='" . $batchno . "'";
    $result_pr = \DB::select($sql);
    if (!empty($result_pr)) {
      $check = 0;

      foreach ($result_pr as $key => $value) {
        $status['status'] = 'success';
        $status['message'] = ' ';

        if (!empty($value->frequency_id)) {
          $checkvalue = $this->checkvalue('frequency_tbl', $value->frequency_id, "frequency_name");

          if (count($checkvalue) <= 0) {
            $status['status'] = 'error';
            $status['message'] .= 'Frequency not exist' . ' ,';
          }
        } else {
          $status['status'] = 'error';
          $status['message'] .= 'Please enter Frequency' . ' ,';
        }

        if (!empty($value->machine_id)) {
          $checkvalue = $this->checkvalue('machine_hdr_t', $value->machine_id, "machine_name");

          if (count($checkvalue) <= 0) {
            $status['status'] = 'error';
            $status['message'] .= 'Machine not exist' . ' ,';
          }
        } else {
          $status['status'] = 'error';
          $status['message'] .= 'Please enter Machine' . ' ,';
        }


        if (!empty($value->department_id)) {
          $checkvalue = $this->checkvalue('ma_department_t', $value->department_id, "department_name");
          if (count($checkvalue) <= 0) {
            $status['status'] = 'error';
            $status['message'] .= 'Department not exist' . ' ,';
          }
        } else {
          $status['status'] = 'error';
          $status['message'] .= 'Please enter Department' . ' ,';
        }


        if (!empty($value->actual_pm_date)) {
          if ($value->actual_pm_date == null || $value->actual_pm_date == '0000-00-00') {
            $status['status'] = 'error';
            $status['message'] .= 'Please enter Actual PM Date' . ' ,';
          }

        } else {
          $status['status'] = 'error';
          $status['message'] .= 'Please enter Actual PM Date' . ' ,';
        }

        $status['message'] = rtrim($status['message'], ',');

        if ($status['status'] == 'success') {
          $check_already_pm = \DB::table('machine_pm_detail_t')
            ->leftjoin('ma_department_t', 'ma_department_t.department_id', '=', 'machine_pm_detail_t.department_id')
            ->leftjoin('machine_hdr_t', 'machine_hdr_t.machine_id', '=', 'machine_pm_detail_t.machine_id')
            ->where('machine_pm_detail_t.frequency_id', $value->frequency_id)
            ->where('machine_hdr_t.machine_name', $value->machine_id)
            ->where('ma_department_t.department_name', $value->department_id)
            ->get();

          if (count($check_already_pm) > 0) {
            $status['status'] = 'error';
            $status['message'] = 'Already PM Machine Was Upload';
          }
        }

        if ($status['status'] == "error") {
          $check = 1;
          $sql = "update m_pm_machine_upload_tbl set batch_status ='ERROR' , batch_comments='" . $status['message'] . "\n'  WHERE pm_hrd_id='" . $value->pm_hrd_id . "' ";
          $result = \DB::update($sql);
          $status['message'] = 'PM Upload data have some error';
        } else {
          $sql = "update m_pm_machine_upload_tbl set batch_status ='VALIDATED' , batch_comments='' where pm_hrd_id='" . $value->pm_hrd_id . "' ";
          $result = \DB::update($sql);
          $status['status'] = 'success';
          $status['message'] = 'PM Upload Data validated successfully';
        }


      }
      if ($check == 0) {
        return $status;
      } else {
        $status['status'] = 'error';
        $status['message'] = 'PM data have some error';
        return $status;
      }
    }
    $status['status'] = 'error';
    $status['message'] = 'NO DATA TO VALIDATE';
    return $status;
  }

  public function LoadMaster($loadModname, $status)
  {
    $status['status'] = '';
    $status['message'] = '';
    $sql = "select * from m_pm_machine_upload_tbl  where  batch_status ='VALIDATED'  and batch_no='" . $loadModname . "' group by department_id,machine_id,frequency_id";
    $result = \DB::select($sql);

    $data = array();
    $loadid = array();

    if (count($result) > 0) {
      foreach ($result as $key => $value) {
        $sql1 = "select * from m_pm_machine_upload_tbl  where  batch_status ='VALIDATED'  and batch_no='" . $loadModname . "' and department_id='" . $value->department_id . "' and  machine_id='" . $value->machine_id . "'  and  frequency_id='" . $value->frequency_id . "'";
        $result1 = \DB::select($sql1);
        $department_id = $this->checkvalue('ma_department_t', $value->department_id, "department_name");
        $machine_id = $this->checkvalue('machine_hdr_t', $value->machine_id, "machine_name");
        $frequency_id = $this->checkvalue('frequency_tbl', $value->frequency_id, "frequency_name");
        $seqno = $this->Seqnoe('PM-', 'machine_pm_detail_t', '', 'pm_count');
        $hdr_details['pm_no'] = $seqno[0];
        $hdr_details['pm_count'] = $seqno[1];
        $hdr_details['department_id'] = $department_id[0]->department_id;
        $hdr_details['machine_id'] = $machine_id[0]->machine_id;
        $hdr_details['frequency_id'] = $frequency_id[0]->frequency_name;


        $bulk_frequency_date = date("Y-m-d", strtotime($value->actual_pm_date));

        if ($hdr_details['frequency_id'] == "Daily") {
          $hdr_details['actual_pm_date'] = date('Y-m-d', strtotime('+1 day', strtotime($bulk_frequency_date)));
        } else if ($hdr_details['frequency_id'] == "Weekly") {
          $hdr_details['actual_pm_date'] = date('Y-m-d', strtotime('+7 day', strtotime($bulk_frequency_date)));
        } else if ($hdr_details['frequency_id'] == "Monthly") {
          $hdr_details['actual_pm_date'] = date('Y-m-d', strtotime('+1 month', strtotime($bulk_frequency_date)));
        } else if ($hdr_details['frequency_id'] == "Yearly") {
          $hdr_details['actual_pm_date'] = date('Y-m-d', strtotime('+1 year', strtotime($bulk_frequency_date)));
        } else if ($hdr_details['frequency_id'] == "Quartely") {
          $hdr_details['actual_pm_date'] = date('Y-m-d', strtotime('+3 month', strtotime($bulk_frequency_date)));
        } else {
          $hdr_details['actual_pm_date'] = date('Y-m-d', strtotime('+6 month', strtotime($bulk_frequency_date)));
        }

        $hdr_details['location_id'] = \Session::get('location');
        $hdr_details['organization_id'] = \Session::get('organization');
        $hdr_details['company_id'] = \Session::get('companyid');
        $hdr_details['created_by'] = \Session::get('id');
        $hdr_details['last_updated_by'] = \Session::get('id');
        $hdr_details['created_at'] = now();
        $hdr_details['updated_at'] = now();

        $hdr_id = DB::table('machine_pm_detail_t')->insertGetId($hdr_details);
        $sql = "update m_pm_machine_upload_tbl set batch_status ='LOADED' , batch_comments='' where pm_hrd_id='" . $value->pm_hrd_id . "' ";
        $result = \DB::update($sql);
        $this->auditlog($value->pm_hrd_id, "pmimport", "update", $data, "m_pm_machine_upload_tbl");
      }

      // auditlog
      $data['batch_status'] = $data_up['batch_status'] = 'LOADED';

      $status['status'] = 'success';
      $status['message'] = 'PM Loaded Sucessfully';
      return $status;
      return true;
    } else {

      $sql = \DB::select("select * from m_pm_machine_upload_tbl where batch_no='" . $loadModname . "'");
      if ($sql[0]->batch_status == "UPLOADED") {
        $status['status'] = 'info';
        $status['message'] = 'Pls Validate the Batch First..!';
        return $status;
      } else if ($sql[0]->batch_status == "ERROR") {
        $status['status'] = 'error';
        $status['message'] = 'Batch Error..!';
        return $status;
      } else {
        $status['status'] = 'info';
        $status['message'] = 'PM Data already Loaded';
        return $status;
      }
    }
  }

  public function checkvalue($table, $id, $column)
  {

    $loc_id = \Session::get('location');

    $data = \DB::SELECT("select * from $table where $column like '%$id%' and location_id = '$loc_id'");

    return $data;
  }



  public function checklistuploaddelete($del_id = null)
  {

    // dd($_POST);
    if (isset($_POST['id'])) {
      $del_id = $_POST['id'];
      if (!is_numeric($del_id)) {
        return \Redirect::back()->withErrors(['msg' => 'Invalid Id']);
      } else {
        $data = DB::table('m_pm_machine_upload_tbl')->where('pm_hrd_id', $del_id)->get();
        DB::table('m_pm_machine_upload_tbl')->where('pm_hrd_id', $del_id)->delete();
        // auditlog
        $this->auditlog($del_id, "pmimport", "delete", $data[0], "m_pm_machine_upload_tbl");

        return 1;
      }
    } else {
      return \Redirect::back()->withErrors(['msg' => 'Invalid Input']);
    }
    //   if(!is_numeric($del_id)){
    //     return \Redirect::back()->withErrors(['msg' => 'The Message']);
    // }else{
    //   $data= DB::table('m_pm_machine_upload_tbl')->where('pm_hrd_id',$del_id)->get();
    //         $query = DB::table('m_pm_machine_upload_tbl')->where('pm_hrd_id',$del_id)->delete();
    //           // auditlog
    //           $this->auditlog($del_id,"pmimport","delete",$data[0],"m_pm_machine_upload_tbl");
    //               return 0;
    // }
  }
  public function checklistuploadedit($id = null)
  {

    // dd($_POST);
    // echo $_POST['edit_id'];die;
    if (isset($_POST['edit_id'])) {
      $edit_id = $_POST['edit_id'];

      if (!is_numeric($edit_id)) {
        return \Redirect::back()->withErrors(['msg' => 'Invalid Id']);
      } else {
        $this->data['edit_id'] = $edit_id;
        $this->data['id'] = $edit_id;
        $id = $edit_id;
        $table = \DB::table('m_pm_machine_upload_tbl')->where('pm_hrd_id', $edit_id)->get();
        // print_r($table);die; 
        $this->data['batch_comments'] = $table[0]->batch_comments;
        $this->data['department_id'] = $this->jCombo('ma_department_t', 'department_name', 'department_name', $table[0]->department_id);
        $this->data['machine_id'] = $this->jCombologin('machine_hdr_t', 'machine_name', 'asset_code|machine_name', $table[0]->machine_id);
        // $this->data['frequency_id'] = $this->jcustomselect('frequency_tbl','frequency_name','frequency_name','','');
        $this->data['frequency_id'] = $this->jcustomselect('frequency_tbl', 'frequency_name', 'frequency_name', $table[0]->frequency_id, '');
        $this->data['checklist_id'] = $this->jCombologin('checklist_tbl', 'checklist_name', 'checklist_name', $table[0]->checklist_id);

        return view('pm.uploadform', $this->data);
      }
    } else {
      return \Redirect::back()->withErrors(['msg' => 'Invalid Input']);
    }
    // if(!is_numeric($id)){
    //         return \Redirect::back()->withErrors(['msg' => 'The Message']);
    //     }else{
    //              $this->data['id'] = $id;
    //              $table = \DB::table('m_pm_machine_upload_tbl')->where('pm_hrd_id', $id)->get();

    //              $this->data['batch_comments'] = $table[0]->batch_comments;
    //              $this->data['department_id']=$this->jCombo('ma_department_t','department_name','department_name',$table[0]->department_id);
    //              $this->data['machine_id']=$this->jCombologin('machine_hdr_t','machine_name','asset_code|machine_name',$table[0]->machine_id);
    //              $this->data['frequency_id']=$this->jCombologin('frequency_tbl','frequency_name','frequency_name',$table[0]->frequency_id);
    //              $this->data['checklist_id'] = $this->jCombologin('checklist_tbl','checklist_name','checklist_name',$table[0]->checklist_id);

    //        return view('pm.uploadform',$this->data);
    //     }
  }

}