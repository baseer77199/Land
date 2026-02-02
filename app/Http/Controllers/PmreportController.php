<?php

namespace App\Http\Controllers;

use App\pmreport;
use App\machinefiles;
use Illuminate\Http\Request;
use DB;
use DateTime;

class PmreportController extends Controller
{
  public function __construct()
  {
    $this->data = array();
    $this->model = new machinefiles();
    $this->data['pageMethod'] = \Request::route()->getName();
    $this->data['pageFormtype'] = 'ajax';
    $this->data['pageModule'] = 'machine';
    $this->table = " machine_hdr_t";
    $this->middleware('auth');
    $this->data['urlmenu'] = $this->indexs();

  }

  public function index()
  {
    $this->data = array();
    $this->data['urlmenu'] = $this->indexs();
    $this->data['pageMethod'] = \Request::route()->getName();
    $this->data['pageFormtype'] = 'ajax';
  }

  public function pmmonthlyindex()
  {
    $this->data['department_id'] = $this->jcombo('ma_department_t', 'department_id', 'department_name', '');
    //dd($this->data['employee_id']);
    return view('report.pmmonthly', $this->data);
  }

  public function pmmachineindex()
  {
    $this->data['department_id'] = $this->jcombo('ma_department_t', 'department_id', 'department_name', '');
    //dd($this->data['employee_id']);
    return view('report.machine', $this->data);
  }

  public function pmhistoryindex()
  {
    $this->data['machine_id'] = $this->jcomboComp('machine_hdr_t', 'machine_id', 'machine_name', '');

    return view('report.history', $this->data);
  }


  public function pmyearlyindex()
  {
    $this->data['department_id'] = $this->jcombo('ma_department_t', 'department_id', 'department_name', '');

    return view('report.pmyearly', $this->data);
  }

  public function pmdailyindex()
  {
    $this->data['department_id'] = $this->jcombo('ma_department_t', 'department_id', 'department_name', '');

    return view('report.pmdaily', $this->data);
  }

  public function getpmyearlydata($i_year = null, $dept_id = null)
  {
    $this->data['row'] = [];
    $dept_id = $_GET['department_id'];
    $i_year = $_GET['start_date'];
    if ($i_year == "0") {
      $i_year = date("Y");
    }
    $this->data['year'] = $i_year;
    $week = [];
    $month_wise = ["01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December"];
    for ($i = "1"; $i <= "12"; $i++) {


      $noweek = $this->weeks_in_month($i_year, $i, 1);
      if ($i <= 9) {
        $i = "0" . $i;
      }
      $week[$i] = $noweek;

    }

    $this->data['weeks'] = $week;
    $loc = \Session::get('location');
    $wh1 = '';
    if ($loc != 0) {
      $wh1 = 'and machine_hdr_t.location_id=' . $loc;
    }
    $this->data['machine_details'] = $machine_details = \DB::select("SELECT machine_hdr_t.*,machine_lines_t.frequency_date from machine_hdr_t left join machine_lines_t on(machine_lines_t.machine_id=machine_hdr_t.machine_id) where machine_hdr_t.department_id='$dept_id' $wh1");

    $data = [];
    $equip_name = [];
    $equip_no = [];

    foreach ($machine_details as $key => $value) {
      $week_no = $this->week_no($value->frequency_date);
      $machine_id = $value->machine_id;
      $pm_date = $i_year . "-01-01";

      $pm_actual_month = explode("-", $pm_date);
      $month_no1 = $pm_actual_month[1];
      $data[$machine_id][$month_no1][$week_no]['date'] = date("d", strtotime($pm_date));

      foreach ($month_wise as $no => $no_val) {
        $result_data2 = \DB::select("select done_on_date from machine_pm_detail_t where MONTH(done_on_date) = '$no' and YEAR(done_on_date) = '$i_year' and machine_id='$machine_id'");
        if (count($result_data2) != "0") {
          $done_date2 = $result_data2[0]->done_on_date;
          $done_pm_date2 = date("d", strtotime($done_date2));

          $data[$machine_id][$no][$week_no]['done_date'] = date("d", strtotime($done_date2));
        }
      }

      $i = 0;
      while ($i < 1) {

        $date = new DateTime($pm_date);
        $date->modify('+1' . ' month');

        $year = $date->format('Y');
        $pm_dates = $date->format('d');
        $pm_month = (string) $date->format('F');
        $current_year = date('Y');
        $pm_date = (string) $date->format('Y-m-d');

        $years1 = (string) $date->format('Y');

        $months1 = (string) $date->format('m');
        $month_no = (int) $months1;
        if ($month_no <= "9") {
          $month_no = "0" . $month_no;
        }


        if ($years1 == $i_year) {
          $i = 0;
          $data[$machine_id][$month_no][$week_no]['date'] = date("d", strtotime($pm_date));
        } else {
          $i = 1;
        }

      }

    }

    $this->data['data'] = $data;

    $this->data['dept_id'] = $dept_id;

    return view('report.plan', $this->data);
  }
  public function getpmmonthlydata()
  {


    $this->data['row'] = [];
    $dept_id = $_GET['department_id'];
    $i_year = $_GET['start_date'];
    if ($i_year == "0") {
      $i_year = date("Y");
    }
    $m_da = $_GET['start_date'];
    $sele_mon = substr($m_da, -2);
    $this->data['sele_mon'] = $sele_mon;
    //   dd($sele_mon);
    $yearmth = explode("-", $i_year);
    $this->data['year'] = $yearmth[0];
    $this->data['month'] = $yearmth[1];
    $week = [];
    $monthNum = $this->data['month'];
    $dateObj = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F');
    //  $month_wise = ["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"];
    $month_wise = [$this->data['month'] => $monthName];
    for ($i = "1"; $i <= "5"; $i++) {


      $noweek = $this->weeks_in_month($this->data['year'], $this->data['month'], 1);
      if ($i <= 5) {
        $i = "0" . $i;
      }
      $week[$i] = $noweek;

    }

    $this->data['weeks'] = $week;
    $loc = \Session::get('location');
    $wh1 = '';
    if ($loc != 0) {
      $wh1 = 'and machine_hdr_t.location_id=' . $loc;
    }
    $this->data['machine_details'] = $machine_details = \DB::select("SELECT machine_hdr_t.*,machine_lines_t.frequency_date from machine_hdr_t left join machine_lines_t on(machine_lines_t.machine_id=machine_hdr_t.machine_id) where machine_hdr_t.department_id='$dept_id' $wh1");

    $data = [];
    $equip_name = [];
    $equip_no = [];

    if (count($machine_details) > 0) {
      foreach ($machine_details as $key => $value) {
        $week_no = $this->week_no($value->frequency_date);
        $machine_id = $value->machine_id;
        $pm_date = $i_year . "-01-01";

        $pm_actual_month = explode("-", $pm_date);
        $month_no1 = $pm_actual_month[1];
        $data[$machine_id][$month_no1][$week_no]['date'] = date("d", strtotime($pm_date));

        foreach ($month_wise as $no => $no_val) {
          $result_data2 = \DB::select("select done_on_date from machine_pm_detail_t where MONTH(done_on_date) = '$no' and YEAR(done_on_date) = '$i_year' and machine_id='$machine_id'");
          if (count($result_data2) != "0") {
            $done_date2 = $result_data2[0]->done_on_date;
            $done_pm_date2 = date("d", strtotime($done_date2));

            $data[$machine_id][$no][$week_no]['done_date'] = date("d", strtotime($done_date2));
          }
        }

        $i = 0;
        while ($i < 1) {

          $date = new DateTime($pm_date);
          $date->modify('+1' . ' month');

          $year = $date->format('Y');
          $pm_dates = $date->format('d');
          $pm_month = (string) $date->format('F');
          $current_year = date('Y');
          $pm_date = (string) $date->format('Y-m-d');

          $years1 = (string) $date->format('Y');

          $months1 = (string) $date->format('m');
          $month_no = (int) $months1;
          if ($month_no <= "9") {
            $month_no = "0" . $month_no;
          }


          if ($years1 == $i_year) {
            $i = 0;
            $data[$machine_id][$month_no][$week_no]['date'] = date("d", strtotime($pm_date));
          } else {
            $i = 1;
          }
        }
      }
    }

    $this->data['data'] = $data;

    $this->data['dept_id'] = $dept_id;
    // print_r($this->data);exit();
    return view('report.monthlyplan', $this->data);
  }
  function weeks_in_month($year, $month, $start_day_of_week)
  {

    $num_of_days = date("t", mktime(0, 0, 0, $month, 1, $year));


    $num_of_weeks = 0;
    for ($i = 1; $i <= $num_of_days; $i++) {
      $day_of_week = date('w', mktime(0, 0, 0, $month, $i, $year));
      if ($day_of_week == $start_day_of_week)
        $num_of_weeks++;
    }

    return $num_of_weeks;
  }
  function week_no($date_string)
  {

    $date = explode("-", $date_string);
    if ($date[1] == '01') {
      $week_number = (int) date('W', strtotime("$date[0]-$date[1]-$date[2]"));
      if ($week_number > 5)
        $week_number = 1;
    } else {
      $firstOfMonth = date("$date[0]-$date[1]-01");
      $week_number = intval(date("W", strtotime("$date[0]-$date[1]-$date[2]"))) - intval(date("W", strtotime($firstOfMonth))) + 1;
    }


    return $week_number;
  }
  public function getpmmonthlydata1()
  {
    $wh = '';
    // dd("dfg");

    $wh = '';
    if (isset($_GET['pq_filter'])) {

      $data = json_decode($_GET['pq_filter']);
      $data = $data->data;
      // dd($data);
      // $table=array('machine_pm_detail_t','machine_hdr_t');
      $wh .= $this->pqgridsearchsum('pm1', $data);
    }
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ? date("Y-m", strtotime($_GET['start_date'])) : '';
    //dd($start_date);
    //     $end_date =  isset($_GET['end_date']) && !empty($_GET['end_date']) ? date("Y-m-d", strtotime($_GET['end_date'])) : '';
    $department_id = $_GET['department_id'];
    //   dd($department_id);
    $sidx = '';
    if (!$sidx)
      $sidx = 1;

    $department_data = \DB::select("Select * from(SELECT machine_hdr_t.machine_name,machine_hdr_t.machine_no,ma_department_t.department_name,WEEKDAY(machine_pm_detail_t.actual_pm_date) FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where STR_TO_DATE(machine_pm_detail_t.actual_pm_date,'%Y-%m')=STR_TO_DATE('$start_date','%Y-%m') and ma_department_t.department_id ='$department_id') as pm1 where 1=1 $wh ");

    //dd($overall_data);
    $count = count($department_data);
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
    $loc = \Session::get('location');

    $sql = \DB::select("Select * From (SELECT machine_hdr_t.machine_name,machine_hdr_t.machine_no,ma_department_t.department_name,WEEKDAY(machine_pm_detail_t.actual_pm_date) AS wdy FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where STR_TO_DATE(machine_pm_detail_t.actual_pm_date,'%Y-%m')=STR_TO_DATE('$start_date','%Y-%m') and ma_department_t.department_id ='$department_id') as pm1 where 1=1 $wh ");
    dd($sql);

    foreach ($sql as $key => $value) {

      if ($value->wdy == 1) {

        $sql[$key]->wdy1 = "Planned";
        $sql[$key]->wdy2 = "-";
        $sql[$key]->wdy3 = "-";
        $sql[$key]->wdy4 = "-";
        $sql[$key]->wdy5 = "-";

      }
      if ($value->wdy == 2) {
        $sql[$key]->wdy2 = "Planned";
        $sql[$key]->wdy1 = "-";
        $sql[$key]->wdy3 = "-";
        $sql[$key]->wdy4 = "-";
        $sql[$key]->wdy5 = "-";

      }
      if ($value->wdy == 3) {
        $sql[$key]->wdy3 = "Planned";
        $sql[$key]->wdy2 = "-";
        $sql[$key]->wdy1 = "-";
        $sql[$key]->wdy4 = "-";
        $sql[$key]->wdy5 = "-";

      }
      if ($value->wdy == 4) {
        $sql[$key]->wdy4 = "Planned";
        $sql[$key]->wdy2 = "-";
        $sql[$key]->wdy3 = "-";
        $sql[$key]->wdy1 = "-";
        $sql[$key]->wdy5 = "-";

      } else {
        $sql[$key]->wdy5 = "Planned";
        $sql[$key]->wdy2 = "-";
        $sql[$key]->wdy3 = "-";
        $sql[$key]->wdy4 = "-";
        $sql[$key]->wdy1 = "-";

      }
    }
    $download_SQL = "Select * From (SELECT machine_hdr_t.machine_name,machine_hdr_t.machine_no,ma_department_t.department_name,WEEKDAY(machine_pm_detail_t.actual_pm_date) AS wdy FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where STR_TO_DATE(machine_pm_detail_t.actual_pm_date,'%Y-%m')=STR_TO_DATE('$start_date','%Y-%m') and ma_department_t.department_id ='$department_id') as pm1 where 1=1 $wh ";

    $result1 = \DB::select($download_SQL);
    $result1 = collect($result1)->map(function ($x) {
      return (array) $x;
    })->toArray();
    if (isset($_GET['download'])) {
      return $result1;
    }



    $responce->rows[] = '';
    $responce->data = $sql;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);

  }

  public function getpmmachinedata()
  {
    //dd("fgdfg");
    $wh = '';
    if (isset($_GET['pq_filter'])) {
      $data = json_decode($_GET['pq_filter']);
      $data = $data->data;
      // $table=array('machine_hdr_t');
      $wh .= $this->pqgridsearch('v1', $data);
    }

    $loc = \Session::get('location');

    $wh1 = '';
    if ($loc != 0) {
      $wh1 = 'and  machine_hdr_t.location_id=' . $loc;
    }
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];
    $result = \DB::select("SELECT * From (SELECT machine_id,asset_code,machine_name,machine_no,purchased_date FROM  machine_hdr_t where 1=1 $wh1) v1 where 1=1  $wh");
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
    $loc = \Session::get('location');
    $sql = "SELECT * FROM (SELECT machine_id,asset_code,machine_name,machine_no,purchased_date  from machine_hdr_t where 1=1 $wh1) v1 where 1=1 $wh";


    if (isset($_GET['download'])) {
      $download_SQL = "SELECT * from (SELECT machine_id,asset_code,machine_name,machine_no,purchased_date  from machine_hdr_t where 1=1 $wh )v1 where 1=1 $wh";

      $result1 = \DB::select($download_SQL);
      $result1 = collect($result1)->map(function ($x) {
        return (array) $x;
      })->toArray();
      return $result1;
    }
    $result = \DB::select($sql);
    //print_r($result);
    //exit();


    $responce->rows[] = '';
    $responce->data = $result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);

  }



  public function getpmyearlydata1()
  {
    $wh = '';

    if (isset($_GET['pq_filter'])) {
      $data = json_decode($_GET['pq_filter']);
      $data = $data->data;
      $table = array('machine_pm_detail_t', 'machine_hdr_t');
      $wh .= $this->pqgridsearch('ma_department_t', $data, $table);
    }
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ? date("Y", strtotime($_GET['start_date'])) : '';
    //dd($start_date);
    //     $end_date =  isset($_GET['end_date']) && !empty($_GET['end_date']) ? date("Y-m-d", strtotime($_GET['end_date'])) : '';
    $department_id = $_GET['department_id'];
    //   dd($department_id);

    $loc = \Session::get('location');
    $wh1 = '';

    $wh1 = 'and  machine_hdr_t.location_id=' . $loc;

    $sidx = '';
    if (!$sidx)
      $sidx = 1;



    $department_data = \DB::select("SELECT ma_department_t.*,machine_pm_detail_t.*,machine_hdr_t.*,Case WHEN machine_pm_detail_t.status=0 then 'Not Initiated' WHEN machine_pm_detail_t.status=1 then 'Initiated' WHEN machine_pm_detail_t.status=2 then 'Pending' WHEN machine_pm_detail_t.status=3 then 'Completed' End AS status FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where STR_TO_DATE(machine_pm_detail_t.actual_pm_date,'%Y')=STR_TO_DATE('$start_date','%Y') and ma_department_t.department_id ='$department_id' $wh1 ");

    //dd($overall_data);
    $count = count($department_data);
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
    $loc = \Session::get('location');

    $sql = \DB::select("SELECT ma_department_t.*,machine_pm_detail_t.*,machine_hdr_t.*,Case WHEN machine_pm_detail_t.status=0 then 'Not Initiated' WHEN machine_pm_detail_t.status=1 then 'Initiated' WHEN machine_pm_detail_t.status=2 then 'Pending' WHEN machine_pm_detail_t.status=3 then 'Completed' End AS status FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where STR_TO_DATE(machine_pm_detail_t.actual_pm_date,'%Y')=STR_TO_DATE('$start_date','%Y') and ma_department_t.department_id ='$department_id' $wh $wh1");
    //  dd($sql);
    $download_SQL = "SELECT ma_department_t.*,machine_pm_detail_t.*,machine_hdr_t.*,Case WHEN machine_pm_detail_t.status=0 then 'Not Initiated' WHEN machine_pm_detail_t.status=1 then 'Initiated' WHEN machine_pm_detail_t.status=2 then 'Pending' WHEN machine_pm_detail_t.status=3 then 'Completed' End AS status FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where STR_TO_DATE(machine_pm_detail_t.actual_pm_date,'%Y')=STR_TO_DATE('$start_date','%Y') and ma_department_t.department_id ='$department_id' $wh $wh1";

    $result1 = \DB::select($download_SQL);
    $result1 = collect($result1)->map(function ($x) {
      return (array) $x;
    })->toArray();
    if (isset($_GET['download'])) {
      return $result1;
    }


    $responce->rows[] = '';
    $responce->data = $sql;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);

  }
  public function getpmdailydata()
  {
    $wh = '';

    if (isset($_GET['pq_filter'])) {
      $data = json_decode($_GET['pq_filter']);
      $data = $data->data;
      // $table=array('machine_pm_detail_t','machine_hdr_t');
      $table = array();
      $wh .= $this->pqgridsearch('v1', $data, $table);
    }
    // print_r($wh);die;
    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];

    $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ? date("Y-m-d", strtotime($_GET['start_date'])) : '';
    //dd($start_date);
    //     $end_date =  isset($_GET['end_date']) && !empty($_GET['end_date']) ? date("Y-m-d", strtotime($_GET['end_date'])) : '';
    $department_id = $_GET['department_id'];
    //   dd($department_id);
    $sidx = '';
    if (!$sidx)
      $sidx = 1;


    $loc = \Session::get('location');

    $wh1 = '';
    if ($loc != 0) {
      $wh1 = 'and  machine_hdr_t.location_id=' . $loc;
    }
    //  $department_data=\DB::select("select * from (SELECT ma_department_t.department_name,machine_pm_detail_t.*,machine_hdr_t.machine_name,Case WHEN machine_pm_detail_t.status=0 then 'Not Initiated' WHEN machine_pm_detail_t.status=1 then 'Initiated' WHEN machine_pm_detail_t.status=2 then 'Pending' WHEN machine_pm_detail_t.status=3 then 'Completed' End AS statuss FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where machine_pm_detail_t.actual_pm_date='$start_date' and ma_department_t.department_id ='$department_id' $wh1) v1 where 1=1 $wh ");
    $sql = \DB::select("select* from 
            (SELECT ma_department_t.department_name,
            machine_pm_detail_t.*,
            machine_hdr_t.machine_name,
            Case WHEN machine_pm_detail_t.status=0 then 'Not Initiated' WHEN machine_pm_detail_t.status=1 then 'Initiated' WHEN machine_pm_detail_t.status=2 then 'Pending' WHEN machine_pm_detail_t.status=3 then 'Completed' End AS statuss 
            FROM ma_department_t 
            LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id 
            left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id 
             where machine_pm_detail_t.actual_pm_date='$start_date' and ma_department_t.department_id ='$department_id' $wh1
             ) as v1 where 1=1 $wh");

    //dd($overall_data);
    $count = count($sql);
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
    $loc = \Session::get('location');


    //  $download_SQL="select* from (SELECT ma_department_t.department_name,machine_pm_detail_t.*,machine_hdr_t.machine_name,Case WHEN machine_pm_detail_t.status=0 then 'Not Initiated' WHEN machine_pm_detail_t.status=1 then 'Initiated' WHEN machine_pm_detail_t.status=2 then 'Pending' WHEN machine_pm_detail_t.status=3 then 'Completed' End AS statuss FROM ma_department_t LEFT join machine_pm_detail_t on machine_pm_detail_t.department_id = ma_department_t.department_id left join machine_hdr_t on machine_hdr_t.machine_id = machine_pm_detail_t.machine_id  where machine_pm_detail_t.actual_pm_date='$start_date' and ma_department_t.department_id ='$department_id' $wh1) as v1 where 1=1 $wh";

    //  $result1 = \DB::select( $sql );
    $result1 = collect($sql)->map(function ($x) {
      return (array) $x;
    })->toArray();
    if (isset($_GET['download'])) {
      return $result1;
    }


    $responce->rows[] = '';
    $responce->data = $sql;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);

  }


  public function gethistoryreport()
  {

    $wh = '';

    if (isset($_GET['pq_filter'])) {
      $data = json_decode($_GET['pq_filter']);
      $data = $data->data;
      $table = array('machine_hdr_t', 'm_breakdowntype_t', 'breakdown_severity');

      $wh .= $this->pqgridsearch('b_maintenance_t', $data, $table);
    }
    //                dd($wh);
    $org = \Session::get('organization');
    $compy = \Session::get('companyid');
    $loc = \Session::get('location');

    $wh1 = '';
    if ($loc != 0) {
      $wh1 = 'and  machine_hdr_t.location_id=' . $loc;
    }




    $page = $_GET['pq_curpage'];
    $limit = $_GET['pq_rpp'];
    $sidx = '';
    if (!$sidx)
      $sidx = 1;
    $result = \DB::select("SELECT COUNT(b_maintenance_t.id) AS count FROM  b_maintenance_t 
          left join machine_hdr_t on (machine_hdr_t.machine_id = b_maintenance_t.machine_id)
          left join m_breakdowntype_t on (m_breakdowntype_t.breakdowntype_id = b_maintenance_t.break_type_id)
          left join breakdown_severity on (breakdown_severity.breakdownseverity_id = b_maintenance_t.breakdown_sevearity)
         where b_maintenance_t.request_status='CLOSED' $wh $wh1");

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

    $compy = \Session::get('companyid');

    $SQL = "SELECT machine_hdr_t.machine_name,
          b_maintenance_t.id,
          machine_hdr_t.asset_code,
          b_maintenance_t.issue_date,
          b_maintenance_t.shift,
          m_breakdowntype_t.breakdown_name,
          breakdown_severity.severity_name,
        EXTRACT(HOUR From (b_maintenance_t.end_date-b_maintenance_t.start_date)) as tym, 
          b_maintenance_t.request_status
         FROM  b_maintenance_t 
          left join machine_hdr_t on (machine_hdr_t.machine_id = b_maintenance_t.machine_id)
          left join m_breakdowntype_t on (m_breakdowntype_t.breakdowntype_id = b_maintenance_t.break_type_id)
          left join breakdown_severity on (breakdown_severity.breakdownseverity_id = b_maintenance_t.breakdown_sevearity)
         where 1=1 and b_maintenance_t.request_status='CLOSED' $wh $wh1 ORDER BY $sidx LIMIT $start , $limit  ";
    $result = \DB::select($SQL);
    //dd($result);
// foreach ($result as $key => $value) {
    //   EXTRACT(HOUR From (b_maintenance_t.start_date-b_maintenance_t.end_date)) as tym, 
    //      24*(b_maintenance_t.start_date - to_date(b_maintenance_t.end_date,'YYYY-MM-DD HH24:MM')) as tym,
//     $start_date=$value->start_date;
//     // $end_date=$value->end_date;
//     //  $interval = $end_date->diff($start_date);     
//     //   $time = $interval->format('%H')
//     $result[$key]->time=$start_date;
// }

    $download_SQL = "SELECT machine_hdr_t.machine_name,
          b_maintenance_t.id,
          machine_hdr_t.asset_code,
          b_maintenance_t.issue_date,
          m_breakdowntype_t.breakdown_name,
          b_maintenance_t.shift,
          breakdown_severity.severity_name,
          b_maintenance_t.start_date,
          EXTRACT(HOUR From (b_maintenance_t.end_date-b_maintenance_t.start_date)) as tym, 
          b_maintenance_t.end_date,
          b_maintenance_t.request_status
         FROM  b_maintenance_t 
          left join machine_hdr_t on (machine_hdr_t.machine_id = b_maintenance_t.machine_id)
          left join m_breakdowntype_t on (m_breakdowntype_t.breakdowntype_id = b_maintenance_t.break_type_id)
          left join breakdown_severity on (breakdown_severity.breakdownseverity_id = b_maintenance_t.breakdown_sevearity)
         where 1=1 and b_maintenance_t.request_status='CLOSED' $wh $wh1 ORDER BY $sidx ";


    $result1 = \DB::select($download_SQL);
    $result1 = collect($result1)->map(function ($x) {
      return (array) $x;
    })->toArray();
    if (isset($_GET['download'])) {
      return $result1;
    }

    $responce->rows[] = '';
    $responce->data = $result;
    $responce->curPage = $page;
    $responce->total = $total_pages;
    $responce->totalRecords = $count;
    echo json_encode($responce);
  }

}