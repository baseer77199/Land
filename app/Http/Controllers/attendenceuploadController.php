<?php

namespace App\Http\Controllers;

use App\attendanceupload;
use App\Http\Controllers\File;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Illuminate\Database\Eloquent\Model,Input;


class attendenceuploadController extends Controller
{
	public function __construct()
	{
		$this->data=array();
		$this->model = new attendanceupload;
		$this->data['pageMethod']=\Request::route()->getName();
		$this->data['pageFormtype']='ajax';
		$this->data['pageModule']='attendenceupload';
		$this->table="attendance_upload_t";
		$this->middleware('auth');
        $this->data['urlmenu']=$this->indexs(); 
	}
	/*end*/
    public function index()
    {

           return view("attendenceupload.form",$this->data);
		}


public function save(Request $request)
{
// print_r($request->input('employee_id'));exit();
$todayDate = date('d-m-Y');

$validatedData=   $this->validate($request, [
            'employee_no' =>  [
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
                //       return $fail($attribute. ' contains equal.');
                //   }
                // },
                function ($attribute, $value, $fail) {
                  //no url = nourl
                  //no url no email = nourlnoemail
                  $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                  $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                },
            ],
            'checkin' =>  [
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
                //   } if (str_contains($value, 'equal')) {  
                //       return $fail($attribute. ' contains equal.');
                //   }
                // },
                function ($attribute, $value, $fail) {
                  //no url = nourl
                  //no url no email = nourlnoemail
                  $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                  $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                },
            ],
             'checkout' =>  [
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
                //   if (str_contains($value, 'equal')) {  
                //       return $fail($attribute. ' contains equal.');
                //   }
                // },
                function ($attribute, $value, $fail) {
                  //no url = nourl
                  //no url no email = nourlnoemail
                  $valuesToCheck = ['nourlnoemail','noscript','nohtml','noequal'];
                  $this->safeInput($attribute, $value,$valuesToCheck, $fail);
                },
            ],
             'date' =>  'required|after_or_equal:'.$todayDate,
            ]);

      $employee_id = $request->input('employee_id');
if($employee_id == '')
        {

                        $attendenceupload = new attendanceupload();   
                        $date = $request->input('date');
                        $newDate = date("Y-m-d", strtotime($date));
                        $attendenceupload->date = $newDate;
                        $attendenceupload->created_by= $request->input('created_by');
                        $attendenceupload->employee_no= $request->input('employee_no');
                        $attendenceupload->checkin= $request->input('checkin');
                        $attendenceupload->checkout= $request->input('checkout');

                //  $attendenceupload->ref_no      = $request->input('ref_no');
                // $requester->part_no      = $request->input('part_no');
                // $requester->review_id       = $request->input('review_id');
                // $requester->part_name      = $request->input('part_name');
                // $requester->part_date       = $newDate;
                //  $requester->remarks      = $request->input('remarks');
                // $requester->department_id       = $request->input('department_id');
                // $requester->engineer_id       = $request->input('engineer_id');
                 //$attendenceupload->updated_at       = $request->input('engineer_head_id');
                $attendenceupload->created_by      = $request->input('created_by');

                $attendenceupload->company_id      = \Session::get('companyid');
                $attendenceupload->organization_id = \Session::get('organization');
                $attendenceupload->location_id          = json_encode($request->input('loc_id'));
              //  dd($attendenceupload);
                                 $attendenceupload->save();

                return 1;


        }


}

public function getgriddata()
{

 $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
          $wh='';
     
        if($_GET['_search']=='true')
        {
        $wh.=$this->jqgridsearch('attendance_upload_t',$_GET['filters']);
        }
    if(!$sidx) $sidx =1;
$result = \DB::select("SELECT COUNT(employee_id) AS count FROM  attendance_upload_t where 1=1 $wh");
  $count = $result[0]->count;
    if( $count > 0 && $limit > 0)
        {
            $total_pages = ceil($count/$limit);
    }
        else
        {
            $total_pages = 0;
    }

    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit;
    if($start <0) $start = 0;
  
    $SQL = "SELECT
   
  attendance_upload_t.employee_no,
  attendance_upload_t.date,
    attendance_upload_t.checkin,

  attendance_upload_t.checkout


FROM
    attendance_upload_t



     where  1=1 $wh ORDER BY attendance_upload_t.employee_id desc
 LIMIT $start , $limit";



   $result = \DB::select( $SQL );
   // DD($result);
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);

}
   
}
