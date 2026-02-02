<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Rules\Notinurl;

class DepartmentController extends Controller
{

  public function __construct()
  {

    $this->data = array();
    $this->model    = new Department();
    $this->data['pageMethod'] = \Request::route()->getName();
    $this->data['pageFormtype'] = 'ajax';
    $this->data['pageModule'] = 'department';
    $this->table = " ma_department_t";
    $this->middleware('auth');
    $this->data['urlmenu'] = $this->indexs();
  }

  public function index($id = null)
  {
    $this->data['pageMethod'] = "department";
    return view('department.form', $this->data);
  }
  
  public function save($id = null, Request $request)
  {
    // dd($request);
    // dd($request);
    $validatedData =   $this->validate($request, [
      'department_name' => [
        'required',
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
          $this->safeInput($attribute, $value,$valuesToCheck, $fail);
        },
      ],
      'description' => [
        
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
          $this->safeInput($attribute, $value,$valuesToCheck, $fail);
        },
      ],
      'department_no' => [
        
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
          $this->safeInput($attribute, $value,$valuesToCheck, $fail);
        },
      ],
      'is_technician' => [
        'required',
        function ($attribute, $value, $fail) {
          //no url = nourl
          //no url no email = nourlnoemail
          $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
          $this->safeInput($attribute, $value,$valuesToCheck, $fail);
        },
      ],
    ]);

    $edit_id = $request->input('edit_id');
    if ($edit_id == '') {

      $department = new Department();
      $department->department_name = $request->input('department_name');
      $department->department_no =  $request->input('department_no');
      $department->description =  $request->input('description');
      $department->is_technician =  $request->input('is_technician');

      $department->created_by =  \Session::get('id');
      $department->last_updated_by =  '';
      $department->company_id =  \Session::get('companyid');
      $department->location_id =  \Session::get('location');
      $department->organization_id =  \Session::get('organization');
      $department->created_at =  date('Y-m-d H:i:s');
      $department->updated_at =  "";

      $department->save();

      return 1;
    } else {
      $edit_id = $_POST['edit_id'];
      // $_POST['created_by'] =  \Sesion::get('id');
      $_POST['last_updated_by'] =  \Session::get('id');
      $_POST['company_id'] =  \Session::get('companyid');
      $_POST['location_id'] =  \Session::get('location');
      $_POST['organization_id'] =  \Session::get('organization');
      // $_POST['created_at'] =  date('Y-m-d H:i:s');
      $_POST['updated_at'] =  date('Y-m-d H:i:s');
      Department::find($edit_id)->update($_POST);
      return 2;
    }
  }

  public function departmentgriddata(Department $department)
  {

    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    $loc = \Session::get('location');
    $wh = '';

    if ($_GET['_search'] == 'true') {
      $wh .= $this->jqgridsearch('ma_department_t', $_GET['filters']);
    }
    $wh1 = '';
    if ($loc != 0) {
      $wh1 = 'and  ma_department_t.location_id=' . $loc;
    }
    if (!$sidx) $sidx = 1;



    $result = \DB::select("SELECT COUNT(department_id) AS count FROM  ma_department_t as ma_department_t where 1=1 $wh1 $wh");
    $count = $result[0]->count;
    if ($count > 0 && $limit > 0) {
      $total_pages = ceil($count / $limit);
    } else {
      $total_pages = 0;
    }

    if ($page > $total_pages) $page = $total_pages;
    $start = $limit * $page - $limit;
    if ($start < 0) $start = 0;


    $SQL = "SELECT * FROM ma_department_t  WHERE   1 = 1 $wh1 $wh ORDER BY $sidx $sord LIMIT $start,$limit";
    $download_SQL = "SELECT * FROM ma_department_t  WHERE   1 = 1 $wh1 $wh ORDER BY $sidx $sord";
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


  public function destroy(Request $request, $id = null)
  {
    echo $_POST['id'];die;
    dd('dd');
    if (isset($_POST['id'])) {
      $del_id = $_POST['id'];
      $id = $_POST['id'];
      if (!is_numeric($del_id)) {
        return \Redirect::back()->withErrors(['msg' => 'Invalid Id']);
      } else {
        $column = array('department');

        $table = array('drawing_tbl');
        for ($i = 0; $i < count($table); $i++) {
          // dd($column[$i]);
          $j = 0;
          $query = \DB::table($table[$i])->where($column[$i], $id)->get();
          // dd($query);
          if (count($query) > 0) {
            $j = 1;
            break;
          }
        }
        if ($j == 0) {
          // dd("fdg");
          $query = \DB::table('ma_department_t')->where('department_id', $id)->delete();
          /**Auditlog**/
          $action = "Delete";
          $this->auditlog($id, "department", $action, $id, "ma_department_t");
        }

        return $j;
      }
    } else {
      return \Redirect::back()->withErrors(['msg' => 'Invalid Input']);
    }

    if (!is_numeric($id)) {
      return \Redirect::back()->withErrors(['msg' => 'The Message']);
    } else {
      $column = array('department');

      $table = array('drawing_tbl');
      for ($i = 0; $i < count($table); $i++) {
        // dd($column[$i]);
        $j = 0;
        $query = \DB::table($table[$i])->where($column[$i], $id)->get();
        // dd($query);
        if (count($query) > 0) {
          $j = 1;
          break;
        }
      }
      if ($j == 0) {
        // dd("fdg");
        $query = \DB::table('ma_department_t')->where('department_id', $id)->delete();
        /**Auditlog**/
        $action = "Delete";
        $this->auditlog($id, "department", $action, $id, "ma_department_t");
      }

      return $j;
    }
  }
  public function getCheckname(Request $request)
  { //dd("sadf");
    $department_id = $_GET['edit_id']; //dd($vendor_id);

    if ($department_id == '') {
      $whereData = [['department_name', $_GET['department_name']]];
      $department = DB::table('ma_department_t')->where($whereData)->get();
    } else {
      $whereData = [['department_name', $_GET['department_name']], ['department_id', '!=', $break_type_id]];
      $department = DB::table('ma_department_t')->where($whereData)->get();
    }

    if (count($department) > 0)
      return 1;
    else
      return 0;
  }
}
