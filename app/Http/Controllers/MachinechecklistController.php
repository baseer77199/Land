<?php

namespace App\Http\Controllers;

use App\Machinechecklist;
use App\Machinechecklistlines;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, DateTime;
use Storage;
class MachinechecklistController extends Controller
{
  public function __construct()
  {
    $this->data = array();
    $this->table = "m_checklist_hrd_tbl";
    $this->subtable = "checklist_lines_tbl";
    $this->pageModule = "pmchecksheet";
    $this->model = new Machinechecklist;
    $this->submodel = new Machinechecklistlines;
    $this->data['urlmenu'] = $this->indexs();
    $this->data['pageMethod'] = \Request::route()->getName();
    $this->data['pageModule'] = \Request::route()->getName();
    $this->data['pageFormtype'] = 'ajax';
  }
  public function checklistimport()
  {
    $this->data['pageMethod'] = \Request::route()->getName();
    $this->data['pageModule'] = \Request::route()->getName();
    $this->data['urlmenu'] = $this->indexs();

    return view('machinechecklist.upload', $this->data);
  }

  public function checklistuploadsave(Request $request)
  {
    $datas['uploaded_by'] = \Session::get('empid');
    $datas['date'] = $dates['date'] = date('Y-m-d');

    if (!is_null($request->file('file_upload'))) {
      $updates = array();
      $file = $request->file('file_upload');
      $files = $request->file('file_upload');
      $destinationPath = '/checklistupload/';
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension(); //if you need extension of the file
      $date = new DateTime();
      $fname = $date->getTimestamp();
      $newfilename = $filename . '_' . $fname . '.' . $extension;

      //  $uploadSuccess = $file->move($destinationPath, $filename);
      $datas['file_name'] = $newfilename;
      $datas['source'] = "checklistimport";
      $id = \DB::table('hr_attendance_import_details_tbl')->insertGetId($datas);
      $path = $_FILES['file_upload']['name'];
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      $data = array();
      $files = $_FILES['file_upload']['tmp_name'];
      $handle = fopen($files, "r");
      $c = 0;


      if ($ext == "csv") {
        $cantain = 0;
        while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

          if ($c != 0) {
            //
            if ($filesop[0] != '') {
              if (str_contains($filesop[0], 'script')) {
                $cantain = 1;
              }
              if (str_contains($filesop[0], '=')) {
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
              if (str_contains($filesop[0], '=')) {
                $cantain = 1;
              }


              $attendencedata['checklist_name'] = $filesop[0];
              $attendencedata['terms'] = $filesop[1];
              $attendencedata['created_at'] = date('Y-m-d');
              // dd($cantain);
              if ($cantain == 0) {
                $id = \DB::table('checklist_tbl')->insertGetId($attendencedata);
              }
              //   else
              //   {

              //  }
              // auditlog
              // $this->auditlog($id,"checklistimport","create",$attendencedata,"checklist_tbl");
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
  public function machinechecklistimport()
  {
    $this->data['batch_no'] = $this->jCombologin('hr_emp_upload_details_t', 'batch_no', 'batch_no', '');

    return view('machinechecklist.machineupload', $this->data);
  }
  public function machinechecklistuploadsave(Request $request)
  {
    $datas['uploaded_by'] = \Session::get('empid');
    $datas['date'] = $dates['date'] = date('Y-m-d');
    //  print($request->all());die;
    // dd($_POST);
    if (!is_null($request->file('file_upload'))) {
      $updates = array();
      $file = $request->file('file_upload');
      $files = $request->file('file_upload');
      $destinationPath = '/machinechecklistupload/';
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension(); //if you need extension of the file
      $date = new DateTime();
      $fname = $date->getTimestamp();
      $newfilename = $filename . '_' . $fname . '.' . $extension;

      //  $uploadSuccess = $file->move($destinationPath, $filename);
      $datas['file_name'] = $newfilename;
      $datas['source'] = "machinechecklistimport";
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
          if ($c != 0) {
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

              $attendencedata['department_id'] = $filesop[0];
              $attendencedata['machine_id'] = $filesop[1];
              $attendencedata['batch_no'] = $batch_no;
              $attendencedata['frequency_id'] = $filesop[2];
              $attendencedata['checklist_id'] = $filesop[3];
              $attendencedata['created_at'] = date('Y-m-d');

              $attendencedata['batch_status'] = "UPLOADED";
              $attendencedata['location_id'] = \Session::get('location');
              $attendencedata['company_id'] = \Session::get('companyid');
              $attendencedata['organization_id'] = \Session::get('organization');
              $attendencedata['created_by'] = \Session::get('id');
              // dd($cantain);
              if ($cantain == 0) {
                $id = \DB::table('m_checklist_upload_tbl')->insertGetId($attendencedata);
              }
              //   else
              //   {

              //  }
              // auditlog
              // $this->auditlog($id,"checklistimport","create",$attendencedata,"checklist_tbl");
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
  public function getchecklistvalidate(Request $request)
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
    $sql = "select * from m_checklist_upload_tbl where batch_status ='UPLOADED'  and batch_no='" . $batchno . "'";
    $result_pr = \DB::select($sql);
    if (!empty($result_pr)) {
      $check = 0;

      foreach ($result_pr as $key => $value) {
        $status['status'] = 'success';
        $status['message'] = ' ';

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
        if (!empty($value->checklist_id)) {
          $checkvalue = $this->checkvalue('checklist_tbl', $value->checklist_id, "checklist_name");

          if (count($checkvalue) <= 0) {
            $status['status'] = 'error';
            $status['message'] .= 'Checklist not exist' . ' ,';
          }
        } else {
          $status['status'] = 'error';
          $status['message'] .= 'Please enter Checklist' . ' ,';
        }

        $status['message'] = rtrim($status['message'], ',');

        if ($status['status'] == "error") {
          $check = 1;
          $sql = "update m_checklist_upload_tbl set batch_status ='ERROR' , batch_comments='" . $status['message'] . "\n'  WHERE checklist_hrd_id='" . $value->checklist_hrd_id . "' ";
          $result = \DB::update($sql);
          $status['message'] = 'Checklist data have some error';
        } else {
          $sql = "update m_checklist_upload_tbl set batch_status ='VALIDATED' , batch_comments='' where checklist_hrd_id='" . $value->checklist_hrd_id . "' ";
          $result = \DB::update($sql);
          $status['status'] = 'success';
          $status['message'] = 'Checklist Data validated successfully';
        }


      }
      if ($check == 0) {
        return $status;
      } else {
        $status['status'] = 'error';
        $status['message'] = 'Checklist data have some error';
        return $status;
      }
    }
    $status['status'] = 'error';
    $status['message'] = 'NO DATA TO VALIDATE';
    return $status;
  }
  public function machinechecklistuploadnewsave(Request $request)
  {
    // print_r($request);die;
    // dd($_POST);
    $validatedData = $this->validate($request, [
      'department_id' => [
        'required',
        // function($attribute, $value, $fail) {
        //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        //     $regex .= "(\:[0-9]{2,5})?"; // Port 
        //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //   {
        //     return $fail($attribute.' is invalid (contains url).');
        //   }
        // },function($attribute,$value,$fail){

        //   if (str_contains($value, 'script')) {  
        //       return $fail($attribute. ' contains script.');
        //   }

        // },
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail', 'noscript', 'nohtml', 'noequal'];
          $this->safeInput($attribute, $value, $valuesToCheck, $fail);
        },
      ],
      'machine_id' => [
        'required',
        // function($attribute, $value, $fail) {
        //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        //     $regex .= "(\:[0-9]{2,5})?"; // Port 
        //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //   {
        //     return $fail($attribute.' is invalid (contains url).');
        //   }
        // },function($attribute,$value,$fail){

        //   if (str_contains($value, 'script')) {  
        //       return $fail($attribute. ' contains script.');
        //   }

        // },
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail', 'noscript', 'nohtml', 'noequal'];
          $this->safeInput($attribute, $value, $valuesToCheck, $fail);
        },
      ],
      'frequency_id' => [
        'required',
        // function($attribute, $value, $fail) {
        //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        //     $regex .= "(\:[0-9]{2,5})?"; // Port 
        //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //   {
        //     return $fail($attribute.' is invalid (contains url).');
        //   }

        // },function($attribute,$value,$fail){

        //   if (str_contains($value, 'script')) {  
        //       return $fail($attribute. ' contains script.');
        //   }

        // },
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail', 'noscript', 'nohtml', 'noequal'];
          $this->safeInput($attribute, $value, $valuesToCheck, $fail);
        },
      ],
      'checklist_id' => [
        'required',
        // function($attribute, $value, $fail) {
        //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        //     $regex .= "(\:[0-9]{2,5})?"; // Port 
        //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //   {
        //     return $fail($attribute.' is invalid (contains url).');
        //   }

        // },function($attribute,$value,$fail){

        //   if (str_contains($value, 'script')) {  
        //       return $fail($attribute. ' contains script.');
        //   }

        // },
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail', 'noscript', 'nohtml', 'noequal'];
          $this->safeInput($attribute, $value, $valuesToCheck, $fail);
        },
      ],
    ]);

    $attendencedata['department_id'] = $_POST['department_id'];
    $attendencedata['machine_id'] = $_POST['machine_id'];
    ;
    $attendencedata['frequency_id'] = $_POST['frequency_id'];
    ;
    $attendencedata['checklist_id'] = $_POST['checklist_id'];
    ;
    $attendencedata['batch_status'] = "UPLOADED";
    $id = \DB::table('m_checklist_upload_tbl')->where('checklist_hrd_id', $_POST['checklist_hrd_id'])->update($attendencedata);
    return response()->json(array('status' => 'success', 'message' => 'Saved Successfully', 'id' => $_POST['checklist_hrd_id']));

  }
  public function checkvalueold($table, $id, $column)
  {

    $data = \DB::SELECT("select * from $table where $column like '%$id%'");

    return $data;
  }
  public function checkvalue($table, $id, $column)
  {

    $loc_id = \Session::get('location');

    $data = \DB::SELECT("select * from $table where $column like '%$id%' and location_id = '$loc_id'");

    return $data;
  }
  public function LoadMaster($loadModname, $status)
  {
    //$comnfun = new ProductuploadController;
    $status['status'] = '';
    $status['message'] = '';
    $sql = "select * from m_checklist_upload_tbl  where  batch_status ='VALIDATED'  and batch_no='" . $loadModname . "' group by department_id,machine_id,frequency_id";
    $result = \DB::select($sql);

    $data = array();
    $loadid = array();

    if (count($result) > 0) {
      foreach ($result as $key => $value) {
        $sql1 = "select * from m_checklist_upload_tbl  where  batch_status ='VALIDATED'  and batch_no='" . $loadModname . "' and department_id='" . $value->department_id . "' and  machine_id='" . $value->machine_id . "'  and  frequency_id='" . $value->frequency_id . "'";
        $result1 = \DB::select($sql1);
        $department_id = $this->checkvalue('ma_department_t', $value->department_id, "department_name");
        $machine_id = $this->checkvalue('machine_hdr_t', $value->machine_id, "machine_name");
        $frequency_id = $this->checkvalue('frequency_tbl', $value->frequency_id, "frequency_name");
        $hdr_details['department_id'] = $department_id[0]->department_id;
        $hdr_details['machine_id'] = $machine_id[0]->machine_id;
        $hdr_details['frequency_id'] = $frequency_id[0]->frequency_name;
        $hdr_details['company_id'] = \Session::get('companyid');
        //$hdr_details['company_id'] = \Session::get('companyid');
        $hdr_id = DB::table('m_checklist_hrd_tbl')->insertGetId($hdr_details);

        foreach ($result1 as $key1 => $value1) {
          /***************** Load Employee Officia Details ************************************/

          $checklist_id = $this->checkvalue('checklist_tbl', $value1->checklist_id, "checklist_name");
          //print_r($checklist_id);
          $user_details['checklist_hrd_id'] = $hdr_id;
          $user_details['checklist_id'] = $checklist_id[0]->checklist_id;
          $tb_user = DB::table('checklist_lines_tbl')->insertGetId($user_details);
          $sql = "update m_checklist_upload_tbl set batch_status ='LOADED' , batch_comments='' where checklist_hrd_id='" . $value1->checklist_hrd_id . "' ";
          $result = \DB::update($sql);
        }

        //die;
      }

      // auditlog
      $data['batch_status'] = $data_up['batch_status'] = 'LOADED';

      $this->auditlog($value->checklist_hrd_id, "machinechecklistimport", "update", $data, "m_checklist_upload_tbl");
      $status['status'] = 'success';
      $status['message'] = 'Checklist Data Loaded Sucessfully';
      return $status;
      return true;
    } else {

      $sql = \DB::select("select * from m_checklist_upload_tbl where batch_no='" . $loadModname . "'");
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
        $status['message'] = 'Checklist  Data already Loaded';
        return $status;
      }
    }
  }

  public function getchecklistuploaddata()
  {
    $wh = '';


    if (isset($_GET['_search'])) {
      if ($_GET['_search'] == 'true') {
        $wh = $this->jqgridsearch('m_checklist_upload_tbl', $_GET['filters']);
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
    $result = \DB::select("SELECT COUNT(checklist_hrd_id) AS count FROM m_checklist_upload_tbl where 1=1 $wh");
    $count = $result[0]->count;
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

    $SQL = "SELECT * from m_checklist_upload_tbl where 1=1 $wh ORDER BY $sidx $sord LIMIT $start , $limit";
    $result = \DB::select($SQL);
    $responce->rows[] = '';
    $responce->rows = $result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;

    echo json_encode($responce);

  }
  public function checklistuploaddelete($del_id = null)
  {

    // dd($_POST);
    if (isset($_POST['id'])) {
      $del_id = $_POST['id'];
      if (!is_numeric($del_id)) {
        return \Redirect::back()->withErrors(['msg' => 'Invalid Id']);
      } else {
        $data = DB::table('m_checklist_upload_tbl')->where('checklist_hrd_id', $del_id)->get();
        DB::table('m_checklist_upload_tbl')->where('checklist_hrd_id', $del_id)->delete();
        // auditlog
        $this->auditlog($del_id, "machinechecklistimport", "delete", $data[0], "m_checklist_upload_tbl");

        return 1;
      }
    } else {
      return \Redirect::back()->withErrors(['msg' => 'Invalid Input']);
    }
    //   if(!is_numeric($del_id)){
    //     return \Redirect::back()->withErrors(['msg' => 'The Message']);
    // }else{
    //   $data= DB::table('m_checklist_upload_tbl')->where('checklist_hrd_id',$del_id)->get();
    //         $query = DB::table('m_checklist_upload_tbl')->where('checklist_hrd_id',$del_id)->delete();
    //           // auditlog
    //           $this->auditlog($del_id,"machinechecklistimport","delete",$data[0],"m_checklist_upload_tbl");
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
        $table = \DB::table('m_checklist_upload_tbl')->where('checklist_hrd_id', $edit_id)->get();
        // print_r($table);die; 
        $this->data['batch_comments'] = $table[0]->batch_comments;
        $this->data['department_id'] = $this->jCombo('ma_department_t', 'department_name', 'department_name', $table[0]->department_id);
        $this->data['machine_id'] = $this->jCombologin('machine_hdr_t', 'machine_name', 'asset_code|machine_name', $table[0]->machine_id);
        // $this->data['frequency_id'] = $this->jcustomselect('frequency_tbl','frequency_name','frequency_name','','');
        $this->data['frequency_id'] = $this->jcustomselect('frequency_tbl', 'frequency_name', 'frequency_name', $table[0]->frequency_id, '');
        $this->data['checklist_id'] = $this->jCombologin('checklist_tbl', 'checklist_name', 'checklist_name', $table[0]->checklist_id);

        return view('machinechecklist.uploadform', $this->data);
      }
    } else {
      return \Redirect::back()->withErrors(['msg' => 'Invalid Input']);
    }
    // if(!is_numeric($id)){
    //         return \Redirect::back()->withErrors(['msg' => 'The Message']);
    //     }else{
    //              $this->data['id'] = $id;
    //              $table = \DB::table('m_checklist_upload_tbl')->where('checklist_hrd_id', $id)->get();

    //              $this->data['batch_comments'] = $table[0]->batch_comments;
    //              $this->data['department_id']=$this->jCombo('ma_department_t','department_name','department_name',$table[0]->department_id);
    //              $this->data['machine_id']=$this->jCombologin('machine_hdr_t','machine_name','asset_code|machine_name',$table[0]->machine_id);
    //              $this->data['frequency_id']=$this->jCombologin('frequency_tbl','frequency_name','frequency_name',$table[0]->frequency_id);
    //              $this->data['checklist_id'] = $this->jCombologin('checklist_tbl','checklist_name','checklist_name',$table[0]->checklist_id);

    //        return view('machinechecklist.uploadform',$this->data);
    //     }
  }
  public function index()
  {
    return view('machinechecklist.table', $this->data);
  }

  public function getGridData($type = null)
  {
    // dd("dhg");
    $wh = '';
    if ($_GET['_search'] == 'true') {
      $search_tables = array('tb_users', 'ma_department_t', 'machine_hdr_t', 'frequency_tbl');
      $wh = $this->jqgridsearch('m_checklist_hrd_tbl', $_GET['filters'], $search_tables);
    }
    $compy = \Session::get('companyid');
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    //dd($sidx);
    $sord = $_GET['sord'];
    $loc = \Session::get('location');
    $compy = \Session::get('companyid');
    $groupname = \Session::get('groupname');
    // if($groupname=='Superadmin' || $groupname=='Admin'){
    // $wh.='and  m_checklist_hrd_tbl.company_id='.$compy;  
    // }else{
    //     $wh.='and  m_checklist_hrd_tbl.company_id='.$compy;    
    // }   

    $loc = \Session::get('location');
    $wh1 = '';
    if ($loc != 0) {
      $wh1 = 'and  machine_hdr_t.location_id=' . $loc;
    }

    if (!$sidx)
      $sidx = 1;
    $result = \DB::select("SELECT COUNT(m_checklist_hrd_tbl.checklist_hrd_id) AS count FROM m_checklist_hrd_tbl left join ma_department_t on(ma_department_t.department_id=m_checklist_hrd_tbl.department_id)  left join frequency_tbl on (frequency_tbl.frequency_name =m_checklist_hrd_tbl.frequency_id)  left join machine_hdr_t on machine_hdr_t.machine_id =m_checklist_hrd_tbl.machine_id  where 1=1 $wh $wh1");
    //dd($result);
    $count = $result[0]->count;
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

    $SQL = "SELECT ma_department_t.department_name,machine_hdr_t.machine_name,frequency_tbl.frequency_name,m_checklist_hrd_tbl.checklist_hrd_id FROM m_checklist_hrd_tbl left join ma_department_t on(ma_department_t.department_id=m_checklist_hrd_tbl.department_id)
            left join frequency_tbl on (frequency_tbl.frequency_name =m_checklist_hrd_tbl.frequency_id)  left join machine_hdr_t on machine_hdr_t.machine_id =m_checklist_hrd_tbl.machine_id where 1=1  $wh $wh1 ORDER BY m_checklist_hrd_tbl.checklist_hrd_id $sord LIMIT $start , $limit";

    $download_SQL = "SELECT ma_department_t.department_name,machine_hdr_t.machine_name,frequency_tbl.frequency_name,m_checklist_hrd_tbl.checklist_hrd_id FROM m_checklist_hrd_tbl left join ma_department_t on(ma_department_t.department_id=m_checklist_hrd_tbl.department_id)
             left join frequency_tbl on (frequency_tbl.frequency_name =m_checklist_hrd_tbl.frequency_id)  left join machine_hdr_t on machine_hdr_t.machine_id =m_checklist_hrd_tbl.machine_id where 1=1  $wh $wh1 ORDER BY m_checklist_hrd_tbl.checklist_hrd_id $sord";

    $result1 = \DB::select($download_SQL);
    $result1 = collect($result1)->map(function ($x) {
      return (array) $x;
    })->toArray();
    if (isset($_GET['download'])) {
      return $result1;
    }


    $result = \DB::select($SQL);
    $responce->rows[] = '';
    $responce->rows = $result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);
  }

  public function create($id = null)
  {

    if (isset($_POST['id']))
      $id = $_POST['id'];
    //dd($id);
    if (!is_numeric($id)) {
      return \Redirect::back()->withErrors(['msg' => 'The Message']);
    } else {

      if ($id == '0') {
        $loc = \Session::get('location');
        $this->data['row'] = (object) array();
        $this->data['department_id'] = $this->jCombo('ma_department_t', 'department_id', 'department_name', '');
        $this->data['machine_id'] = $this->jcombolocation('machine_hdr_t', 'machine_id', 'asset_code|machine_name', '', 'and location_id=' . $loc);
        $this->data['frequency_id'] = $this->jCombologin('frequency_tbl', 'frequency_name', 'frequency_name', '');
        $this->data['created_by'] = $this->jCombologin('tb_users', 'id', 'username', \Session::get('id'));
        $this->data['row']->checklist_hrd_id = '';
        $this->data['linedata'] = array();
        $this->data['checklist_id'] = $this->jCombologin('checklist_tbl', 'checklist_id', 'checklist_name', '');
      } else {
        $loc = \Session::get('location');

        $this->data['id'] = $id;
        // dd($id);
        $table = \DB::table('m_checklist_hrd_tbl')->where('checklist_hrd_id', $id)->get();
        //dd($table);  
        $this->data['department_id'] = $this->jCombo('ma_department_t', 'department_id', 'department_name', $table[0]->department_id);
        $this->data['machine_id'] = $this->jcombolocation('machine_hdr_t', 'machine_id', 'asset_code|machine_name', $table[0]->machine_id, 'and location_id=' . $loc);
        $this->data['frequency_id'] = $this->jCombologin('frequency_tbl', 'frequency_name', 'frequency_name', $table[0]->frequency_id);
        $this->data['row'] = $table[0];

        $tablelines = \DB::table('checklist_lines_tbl')->where('checklist_hrd_id', $id)->get();
        $this->data['linedata'] = $tablelines;
        foreach ($this->data['linedata'] as $key => $val) {
          $this->data['linedata'][$key]->checklist_id = $this->jCombologin('checklist_tbl', 'checklist_id', 'checklist_name', $val->checklist_id);
        }
        $this->data['created_by'] = $this->jCombologin('tb_users', 'id', 'username', \Session::get('id'));
      }
    }


    return view('machinechecklist.form', $this->data);
  }

  public function save(Request $request)
  {

    $mac_id = $_POST['machine_id'];
    $loc_id = \DB::select("SELECT location_id from machine_hdr_t where machine_id=$mac_id");
    $loc = $loc_id[0]->location_id;
    $validatedData = $this->validate($request, [
      'department_id' => [
        'required',
        'numeric',
        // function($attribute, $value, $fail) {
        //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        //     $regex .= "(\:[0-9]{2,5})?"; // Port 
        //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //   {
        //     return $fail($attribute.' is invalid (contains url).');
        //   }
        // },function($attribute,$value,$fail){

        //   if (str_contains($value, 'script')) {  
        //       return $fail($attribute. ' contains script.');
        //   }
        //   if (str_contains($value, '=')) {  
        //       return $fail($attribute. ' contains Equal.');
        //   }
        // },
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail', 'noscript', 'nohtml', 'noequal'];
          $this->safeInput($attribute, $value, $valuesToCheck, $fail);
        },
      ],
      'machine_id' => [
        'required',
        'numeric',
        // function($attribute, $value, $fail) {
        //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        //     $regex .= "(\:[0-9]{2,5})?"; // Port 
        //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //   {
        //     return $fail($attribute.' is invalid (contains url).');
        //   }
        // },function($attribute,$value,$fail){

        //   if (str_contains($value, 'script')) {  
        //       return $fail($attribute. ' contains script.');
        //   }
        //   if (str_contains($value, '=')) {  
        //       return $fail($attribute. ' contains Equal.');
        //   }
        // },
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail', 'noscript', 'nohtml', 'noequal'];
          $this->safeInput($attribute, $value, $valuesToCheck, $fail);
        },
      ],
      'frequency_id' => [
        'required',
        // function($attribute, $value, $fail) {
        //     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        //     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        //     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        //     $regex .= "(\:[0-9]{2,5})?"; // Port 
        //     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        //     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        //     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        //   if(preg_match("/^$regex$/i", $value)) // `i` flag for case-insensitive
        //   {
        //     return $fail($attribute.' is invalid (contains url).');
        //   }

        // },function($attribute,$value,$fail){

        //   if (str_contains($value, 'script')) {  
        //       return $fail($attribute. ' contains script.');
        //   }
        //   if (str_contains($value, '=')) {  
        //       return $fail($attribute. ' contains Equal.');
        //   }
        // },
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail', 'noscript', 'nohtml', 'noequal'];
          $this->safeInput($attribute, $value, $valuesToCheck, $fail);
        },
      ]

    ]);

    // dd($validatedData);
    $data = $this->validatePost($request->all(), $this->table, 'header');
    $lines_data = $this->validatePost($request->all(), $this->subtable, 'lines');

    $id = '';
    \DB::beginTransaction();
    try {
      $id = $this->model->insertRow($data);
      $lid = $this->submodel->subgridSave($lines_data, $id);
      /*deepika purpose:audit log*/
      if ($_POST['checklist_hrd_id'] == "") {
        $action = "create";
      } else {
        $action = "update";
      }
      $this->auditlog($id, "machinechecklist", $action, $data, "m_checklist_hrd_tbl");
      /*end*/
      \DB::commit();
      return response()->json(array('status' => 'success', 'message' => 'Saved Successfully', 'id' => $id, 'lid' => $lid, 'auto_no' => $_POST['machine_name']));
    } catch (\Illuminate\Database\QueryException $e) {
      $message = explode('(', $e->getMessage());
      $dbCode = rtrim($message[0], ']');
      $dbCode = trim($dbCode, '[');

      \DB::rollback();
      return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
    }
  }
  /*end*/



  public function show($id = null)
  {
    if (isset($_POST['id']))
      $id = $_POST['id'];
    if (!is_numeric($id)) {
      return \Redirect::back()->withErrors(['msg' => 'The Message']);
    } else {
      $header = \DB::table('m_checklist_hrd_tbl')
        ->leftjoin('ma_department_t', 'ma_department_t.department_id', '=', 'm_checklist_hrd_tbl.department_id')
        ->leftjoin('machine_hdr_t', 'machine_hdr_t.machine_id', '=', 'm_checklist_hrd_tbl.machine_id')
        ->leftjoin('frequency_tbl', 'frequency_tbl.frequency_name', '=', 'm_checklist_hrd_tbl.frequency_id')
        ->select('m_checklist_hrd_tbl.checklist_hrd_id', 'machine_hdr_t.machine_name', 'ma_department_t.department_name', 'frequency_tbl.frequency_name')->where('checklist_hrd_id', $id)->get();
      $this->data['header'] = $header[0];

      $linesdata = \DB::table('checklist_lines_tbl')->leftjoin('m_checklist_hrd_tbl', 'm_checklist_hrd_tbl.checklist_hrd_id', '=', 'checklist_lines_tbl.checklist_hrd_id')->leftjoin('checklist_tbl', 'checklist_tbl.checklist_id', '=', 'checklist_lines_tbl.checklist_id')->where('m_checklist_hrd_tbl.checklist_hrd_id', $id)->get();
      $this->data['linesdata'] = $linesdata;
      return view("machinechecklist.view", $this->data);
    }
  }
  public function downloadtemplate()
  {

    //   dd($_POST); 
//   dd($this->indexs());
// Initialize a file URL to the variable

    $url = 'http://besthrms.in/landt/public/download/checklist.csv';
    // window.location.href($url); 
//  file_put_contents("Tmp.csv", fopen("http://besthrms.in/landt/public/download/checklist.csv", 'r'));
// Use basename() function to return the base name of file 

    //$file= \URL::to("download/checklist.csv");

    $myFile = public_path("/download/checklist.csv");

    return response()->download($myFile);

    $headers = ['Content-Type: application/csv'];
    $newName = 'checklist' . time() . '.csv';


    //	return response()->download($myFile, $newName, $headers);


    // $headers = array(
    //           'Content-Type: application/csv',
    //         );

    // // return Response::download("http://besthrms.in/landt/public/download/checklist.csv", 'filename.csv', $headers);
    // response()->download($file, 'temp.csv', $headers);

  }

  public function downloadmachinechecklisttemplate()
  {

    $url = 'http://besthrms.in/landt/public/download/machine_template.csv';

    $myFile = public_path("download\machinechecklist.csv");

    return response()->download($myFile);

  }
  public function downloadtempletepmupload()
  {

    $url = 'http://besthrms.in/landt/public/download/pm_template.csv';

    $myFile = public_path("download\pmmachineupload.csv");

    return response()->download($myFile);

  }


  public function downloadmachinetemplate()
  {

    $url = 'http://besthrms.in/landt/public/download/machine_template.csv';

    $myFile = public_path("download\machine_template.csv");

    return response()->download($myFile);

  }


  //    }

}