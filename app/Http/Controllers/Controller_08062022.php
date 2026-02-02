<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect,Input;
use Illuminate\Support\Facades\Auth;
use App\productgroup;
use DB;
use session;
use DateTime;

class Controller extends BaseController
{

use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
/*pavan:purpose for Controller jcombo*/


//$this->data['pageMethod']=\Request::route()->getName();
//die(\Request::route()->getName());

public function __construct()
{
date_default_timezone_set("Asia/Calcutta");
$this->middleware('auth')->except(['passwordhash']);

}
/** kaviya purpose for save common feilds in table  for hrms  start**/
public function hrmssaveinsert($table,$column,$id,$insert_update)
{
$data['company_id']=\Session::get('companyid');
$data['location_id']=\Session::get('location');
    if($insert_update==1)
$data['created_by']=\Session::get('id');
$data['last_updated_by']=\Session::get('id');

$update = DB::table($table)->where($column,$id)->update($data);
}
/** kaviya purpose for save common feilds for hrms  end**/
public function indexs()
{
//dd(\Request::route()->action['menu']);


   //dd("JH");
 if(isset(\Request::route()->action['menu']) && \Request::route()->action['menu']!="userprofile")
 {
               $url_data['check']= $check=\Request::route()->action['check'];
        $url_data['menu']= $menu=\Request::route()->action['menu'];
                $url_data['label']= $label=\Request::route()->action['label'];
                

 $this->middleware(function ($request, $next,$a=null) {
           if(\Auth::user()){

        $check=\Request::route()->action['check'];
        $menu=\Request::route()->action['menu'];
        $data=\Session::get('data');
        $menu_data=\Session::get('menu_data');
        $u_name=\Session::get('username');

        $url = \Request::route()->getName();
        
        $menu_s = \DB::table('tb_menus')->where('controller_name',$url)->get();
        
        $menu_name = 0;
        if(count($menu_s)>0){
            $menu_name = $menu_s[0]->menus_name;
        }
                //echo "<pre>";
			//print_r(\Request::route()->getName());die;
//    print_r($menu_name);print_r($menu_data);exit;
if(\Session::get('id')==0)
{
        if(!empty($check)){
    
          if(!isset($data[$menu][$check]) )
                {
        
                    return redirect('permissioindenied');

                }


        }else if (!empty($menu)){
			

            if(!isset($data[$menu]) && array_search(\Request::route()->action['menu'],\Session::get('menu_data'))=='')
            {

                return redirect('permissioindenied');
            }
           

        
        }
}
else
{
  return $next($request);
}

           }else{


                return redirect('/login')->with('message',"Your Session Has Been Expired");
           }


    return $next($request);

        });

        return $url_data;
 }
 else
 {
     return 1;
 }

}

/* vimala purpose: Jq Grid Search Select option with out company condition */
public function jqgridselectlogin($table,$val,$option)
{

$data=\DB::table($table)->get();

$opt=":--Please Select--";
foreach ($data as $key => $value)
{
$opt.=";".$value->$val.":".trim($value->$option);
}


return $opt;
}
/*End*/


    public function jcustommultiselect1($table,$option,$display,$selected,$condition)
{

  $selected=explode(",",$selected);

$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
// echo "select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition; exit;
$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);
$html="<option value=''>-- Please Select --</option>";

//  print_r($value1);
    foreach ($select_query as $value)
{

    //foreach($selected as $key=>$value1){
if(in_array($value->$option,$selected))
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";//;
}
//}
}//dd($html);
return $html;
}
    /*end*/
/****** Only for notification *****/
public function getnoty(){
    $user=\Session::get('id'); 
    $comp=\Session::get('companyid'); 
    $count_no = \DB::table('notifications_t')->where('company_id',$comp)->where('read/unread','unread')->where('user_id',$user)->select('*','read/unread as noty')->orderBy('notification_id','DESC')->get();
    $data=array(); 
    $htnl='';
    if(count($count_no) > 0 ){ 
        if($_GET['id']==count($count_no)){
            $data['count']=0;  
            $data['html']='';
        }else{
            foreach ($count_no as $key => $value) { 
                $htnl.='<div ';
                if($value->noty=="read") { 
                    $htnl.= 'class="alert alert-success"';
                } else {
                    $htnl.='class="alert alert-info"';
                }
                $user_data=\DB::table('tb_users')->where('id',$value->created_by)->get();  
                if(count($user_data)>0){
                    $name=$user_data[0]->username;
                }else{
                  $name='';
                }
                if($value->noty=="read") {  $style="green";  } else {  $style="blue";   } 
                    $htnl.= '><a href="'.\URL::to($value->reference_url.'/'.$value->reference_source_id.'?btnval='.$value->btn_val.'&ref_id='.$value->notification_id).'" style="color: '.$style.';" >'.$value->description.'-'.$name.'</a></div>';  
                    $data['count']=count($count_no);
                    $data['html']=$htnl;
                }
            }                
    }else{
        $data['count']=0;  
        $data['html']='';
    } 
                 
 return $data;
    }
     public function sendPopUpHomeNoty($poID,$module_name,$noti_message,$msg,$hist,$pageurl,$to,$cc,$cid,$btnval){

     $id = $to;
        $notification_setting= DB::table('notification_module_t')
                ->select('*')
                ->where('module_name', $module_name)->get();

       

        if(count($notification_setting) > 0){
            $users=\DB::select("select * from tb_users where id IN ($id) ");
            foreach($users as $k=>$v){
                $message = [];
                $popnoti['reference_source'] = $daata['reference_source']=$module_name;
                $popnoti['reference_source_id']= $daata['reference_source_id']=$poID;
                $popnoti['reference_url']= $daata['reference_url']=$pageurl;
                $popnoti['user_id']= $daata['user_id']=$v->id;
                $popnoti['date']= $daata['date']=date('Y-m-d');
                $popnoti['read/unread']= $daata['read/unread']="unread";
                $popnoti['description']= $daata['description']=$noti_message;
                $popnoti['company_id']= $daata['company_id']=1;
                $popnoti['btn_val']= $daata['btn_val']=$btnval;
                $popnoti['created_by']= $daata['created_by']=$cid;
                $popnoti['created_at']= $daata['created_at']=date('Y-m-d h:i:s');
                $popnoti['updated_at']= $daata['updated_at']=date('Y-m-d h:i:s');

                \DB::table('notifications_t')->insert($popnoti);
            
                $users=\DB::select("select * from tb_users where id IN ($v->id) ");
                $created_users=\DB::select("select * from tb_users where id = $cid ");
                if(count($created_users)>0){
                    $daata['created_emp'] = $users[0]->first_name;
                }else{
                    $daata['created_emp'] = '';
                }
                if(count($users)>0){
                    $email = $users[0]->email;
                    $daata['emp_name'] = $users[0]->first_name;
                    $daata['noti_message'] = $noti_message;
                    $subject = "Notification Mail";
                    if($email!=null && $email!=''){
                    $daata['msg'] = $msg;
                    $daata['history'] = $this->getTicketHistory($poID,$hist);
    // print_r($daata);die;
                        \Mail::send('sendescalationmail',$daata, function($message) use($email,$subject)
                        {
                            $to=$email;
                            // $to = 'cs.vigneshvj@gmail.com';
                            $message->to($to);
                            $message->subject($subject);
                            $message->from('no-reply@lntecc.com');
                        });
                    }
                }
                    
                
            }
        }else {
            $noti_message = [];
        }
        return $noti_message;
    }



        /****** for notification and email *****/
    public function sendPopUpNotification($poID,$module_name,$noti_message,$pageurl){

        $notification_setting= DB::table('notification_module_t')
                        ->select('*')
                        ->where('module_name', $module_name)->get();
            $header_table =$notification_setting[0]->header_tbl;
            $line_table =$notification_setting[0]->lines_tbl;
            $ids =$notification_setting[0]->header_id;


        define('FIREBASE_API_KEY', 'AAAA6yke-Eo:APA91bHOjlO2JnvUkTVeCmw3PMBCXhuAzFhVelDWblIXQpR8LKWHHJ3nD4To8H0Ew9cegRkliu30F37BdCgXOYuZli2tJdT-yDpcd525nxX6UDEHtQbCR0eMrLqpcpg0opertUkp4_fcGAnrX69tXuy4k8F1FFrlPg');
        $notification_messag= \DB::select("select " .$header_table. ".*,". $line_table .".* from ".$header_table." left join ".$line_table." on ".$header_table.".".$ids."=".$line_table.".".$ids." where ".$header_table.".".$ids."='$poID'");
        $notification_time= DB::table('nofication_user_tbl')
                ->select('*')
                ->where('module_type', $module_name)->get();

        if(count($notification_time) > 0){

            $email_user_id=implode(',',json_decode($notification_time[0]->email_user_id));
            $user_id=implode(',',json_decode($notification_time[0]->user_id));
            $email_users=\DB::select("select * from tb_users where id IN ('$email_user_id') ");
            $users=\DB::select("select * from tb_users where id IN ($user_id) ");

            if(count($email_users) > 0){

                foreach($email_users as $k=>$v){

                    if($pageurl == "salesinvoiceapproval"){
                        $controller=new Salesinvoicecontroller();
                        $data=$controller->show($poID,"welcome");
                        $page = 'salesinvoice.welcome';
                    }else if($pageurl == "salesquoteapproval"){
                        $controller=new Soquotecontroller();
                        $data=$controller->view($poID,"welcome");
                        $page = 'soquote.welcome';
                    }else if($pageurl == "salesorderapproval"){
                        $controller=new Soordercontroller();
                        $data=$controller->show($poID,"welcome");
                        $page = 'soorder.welcome';
                    }else if($pageurl == "poinvoiceapproval"){
                        $controller=new Purchaseinvoicecontroller();
                        $data=$controller->poinvapprovdatashow($poID,"","welcome");
                        $page = 'purchaseinvoice.welcome';
                    }else if($pageurl == "purchasequtoetionapprove"){
                        $controller=new Purchasequotationcontroller();
                        $data=$controller->show($poID,"welcome");
                        $page = 'purchasequotation.welcome';
                    }else{
                        $controller=new Purchaseordercontroller();
                        $data=$controller->show($poID,"welcome");
                        $page = 'purchaseorder.welcome';
                    }
if($v->email!='')
{
                    \Mail::send($page,$data, function($message) use ($v,$module_name,$noti_message)
                    {
                        $to=$v->email;
                        $message->to($to);
                        $message->subject($noti_message);
                        $message->from('Saipavan9010@gmail.com');
                    });
}
                    $notifi['notification_source']=$module_name;
                    $notifi['reference_id']=$poID;
                    $notifi['user_id']=$v->id;
                    $notifi['interval_time']=$notification_time[0]->email_duration;
                    $notifi['type']=Email;
                    \DB::table('notification_genration_tbl')->insert($notifi);
                }
            }
            if(count($users) > 0){
                foreach($users as $k=>$v){
                    $notification_message['order']=json_encode($notification_messag[0]);

                    $message = [];

                    $message[] = $this->fcmMsgNotification($v->fcm_token,$notification_message);
                    $notifi['notification_source']=$module_name;
                    $notifi['reference_id']=$poID;
                    $notifi['user_id']=$v->id;
                    $notifi['interval_time']=$notification_time[0]->duration;
                    $notifi['type']=Notification;
                    \DB::table('notification_genration_tbl')->insert($notifi);

                    $popnoti['reference_source']=$module_name;
                    $popnoti['reference_source_id']=$poID;
                    $popnoti['reference_url']=$pageurl;
                    $popnoti['user_id']=\Session::get('id');
                    $popnoti['date']=date('Y-m-d');
                    $popnoti['read/unread']="unread";
                    $popnoti['description']=$noti_message;
                    $popnoti['company_id']=\Session::get('companyid');
                    $popnoti['location_id']=\Session::get('location');
                    $popnoti['organization_id']=\Session::get('organization');
                    $popnoti['created_by']=\Session::get('id');
                    $popnoti['created_at']=date('Y-m-d h:i:s');
                    $popnoti['last_updated_by']=\Session::get('id');
                    $popnoti['updated_at']=date('Y-m-d h:i:s');

                    \DB::table('notifications_t')->insert($popnoti);
                }
            }
        } else {
            $message = [];
        }


        return $message;
    }

    public function fcmMsgNotification($token,$res){

        $fields = array(
            'to' => $token,
            'data' => $res
        );

        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
// dd(FIREBASE_API_KEY);
        $headers = array(
            'Authorization: key=' .FIREBASE_API_KEY,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        //dd($result);

        return $result;
    }



/*karthigaa:purpose for jcustomselect*/

public function jcustomproductdataselect($table,$option,$display,$selected,$condition,$where){
//dd($where);
    $con=\DB::select("SELECT product_group_id,select_option FROM `m_product_setting_t` WHERE module_name='$condition'");

    if($con){
        $con_data=  explode(',', $con[0]->product_group_id);
        $condition=' and  ';
        foreach($con_data as $index=>$val){
            if($index!=0)
                $condition.=" or ";
            $condition.="product_group_id='$val'";
        }
    } else {
        $condition='';
    }


    $select_query=\DB::select("select  CONCAT(".$con[0]->select_option.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition."".$where);

$html="";

    foreach ($select_query as $value)
    {

        if($value->$option == $selected)
        {
            $html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
        } else {
            $html.= "<option value='".$value->$option."' >".$value->name."</option>";
        }
    }
//dd($html);
    return $html;

}
/*end*/
public function jcustomproductselect($table,$option,$display,$selected,$condition){

    $con=\DB::select("SELECT product_group_id,select_option FROM `m_product_setting_t` WHERE module_name='$condition'");

    if($con){
        $con_data=  explode(',', $con[0]->product_group_id);
        $condition=' and  ';
        foreach($con_data as $index=>$val){
            if($index!=0)
                $condition.=" or ";
            $condition.="product_group_id='$val'";
        }
    } else {
        $condition='';
    }


    $select_query=\DB::select("select  CONCAT(".$con[0]->select_option.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);

    $html="<option value=''>-- Please Select --</option>";

    foreach ($select_query as $value)
    {

        if($value->$option == $selected)
        {
            $html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
        } else {
            $html.= "<option value='".$value->$option."' >".$value->name."</option>";
        }
    }

    return $html;

}


public function jcustomproductselect1($table,$option,$display,$selected,$condition){

   // $con=\DB::select("SELECT product_group_id FROM `m_product_setting_t` WHERE module_name='$condition'");

    /*
    if($con){
        $con_data=  explode(',', $con[0]->product_group_id);
        $condition=' and  ';
        foreach($con_data as $index=>$val){
            if($index!=0)
                $condition.=" or ";
            $condition.="product_group_id='$val'";
        }
    } else {
        $condition='';
    }
*/
    $display_name=explode("|",$display);
    $display_n="";
    foreach($display_name as $val)
    {

        $display_n.=$val.","."' - ',";
    }

    $dis_name=rtrim($display_n,",' - ',");
    $select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);
    $html="<option value=''>-- Please Select --</option>";

    foreach ($select_query as $value)
    {

        if($value->$option == $selected)
        {
            $html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
        } else {
            $html.= "<option value='".$value->$option."' >".$value->name."</option>";
        }
    }

    return $html;

}
//kaviya purpose for jcombo no company and no active
public function jCombologin($table,$option,$display,$selects)
{

    $display_name=explode("|",$display);
    $dis="";

    foreach($display_name as $value)
    {
        $dis.=$value.","."' - ', ";
    }
    $loc=\Session::get('location');
    $cond='';
    
    if($loc != 0){
        if($table=='tb_users'){
            $cond.=' and  loc_id='.$loc;
        }else if($table=='user_department_t' || $table=='m_company_t' || $table=='m_cities_t' || $table=='m_states_t' || $table=='m_countries_t'){

        }else{
            $cond.=' and location_id='.$loc;
        }
        
    }      


    $dis_name=rtrim($dis,",' - ',");
    if($table == "m_countries_t" )
        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where 1=1 ".$cond." and country_id != '6'" );
    else if( $table =="m_states_t")
        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where 1=1 ".$cond." and state_id != '41'");
    else if($table =="m_cities_t" )
        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where 1=1 ".$cond." and city_id!='1'");
    else
        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table." where  1=1 ".$cond );

    $html="<option value=''>-- Please Select --</option>";

    foreach($select as $val)
    {
        if($val->$option==$selects)
        {
            $html.= "<option value='".$val->$option."' selected='selected'>".$val->name."</option>";
        }
        else
        {
            $html.= "<option value='".$val->$option."'>".$val->name."</option>";
        }
    }

    return $html;
}
//Vignesh technician
public function jCombologintechnician($table,$option,$display,$selects,$cond_col)
{

    $display_name=explode("|",$display);
    $dis="";

    foreach($display_name as $value)
    {
        $dis.=$value.","."' - ', ";
    }
    $loc=\Session::get('location');
    $cond='';
    
    if($loc != 0){
        if($table=='tb_users'){
            $cond.=' and  loc_id='.$loc;
        }else if($table=='user_department_t' || $table=='m_company_t' || $table=='m_cities_t' || $table=='m_states_t' || $table=='m_countries_t'){

        }else{
            $cond.=' and location_id='.$loc;
        }
        
    }      

    
    
    $dis_name=rtrim($dis,",' - ',");
    $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table." inner join ma_department_t on ma_department_t.department_id=$table.$cond_col where  1=1 and ma_department_t.is_technician='Yes' ".$cond );
// print_r($select);die;
    // if($table == "m_countries_t" )
    //     $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where 1=1 ".$cond." and country_id != '6'" );
    // else if( $table =="m_states_t")
    //     $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where 1=1 ".$cond." and state_id != '41'");
    // else if($table =="m_cities_t" )
    //     $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where 1=1 ".$cond." and city_id!='1'");
    // else
    //     $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table." where  1=1 ".$cond );

    $html="<option value=''>-- Please Select --</option>";

    foreach($select as $val)
    {
        if($val->$option==$selects)
        {
            $html.= "<option value='".$val->$option."' selected='selected'>".$val->name."</option>";
        }
        else
        {
            $html.= "<option value='".$val->$option."'>".$val->name."</option>";
        }
    }

    return $html;
}

//kaviya purpose for jcombo no company and no active
public function jCombolocation_old($table,$option,$display,$selects)
{
  $location=\Session::get('location');
    $display_name=explode("|",$display);
    $dis="";

    foreach($display_name as $value)
    {
        $dis.=$value.","."' - ', ";
    }
    
    $dis_name=rtrim($dis,",' - ',");
//    if($table == "m_countries_t" )
//        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where country_id != '6'" );
//    else if( $table =="m_states_t")
//        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where state_id != '41'");
//    else if($table =="m_cities_t" )
//        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where city_id!='1'");
//    else
        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table. " where locationid=".$location );
print_r("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table. " where locationid=".$location );die;
    $html="<option value=''>-- Please Select --</option>";

    foreach($select as $val)
    {
        if($val->$option==$selects)
        {
            $html.= "<option value='".$val->$option."' selected='selected'>".$val->name."</option>";
        }
        else
        {
            $html.= "<option value='".$val->$option."'>".$val->name."</option>";
        }
    }

    return $html;
}

public function jCombolocation($table,$option,$display,$selects)
{
  $location=\Session::get('location');
    $display_name=explode("|",$display);
    $dis="";

    foreach($display_name as $value)
    {
        $dis.=$value.","."' - ', ";
    }
    
    $dis_name=rtrim($dis,",' - ',");
//    if($table == "m_countries_t" )
//        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where country_id != '6'" );
//    else if( $table =="m_states_t")
//        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where state_id != '41'");
//    else if($table =="m_cities_t" )
//        $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table ." where city_id!='1'");
//    else
if($location != 0){
$select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table. " where locationid=".$location );
} else {
    $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table);
}

    $html="<option value=''>-- Please Select --</option>";

    foreach($select as $val)
    {
        if($val->$option==$selects)
        {
            $html.= "<option value='".$val->$option."' selected='selected'>".$val->name."</option>";
        }
        else
        {
            $html.= "<option value='".$val->$option."'>".$val->name."</option>";
        }
    }

    return $html;
}

//kaviya purpose for jcombo company and location and active
        public function jCombo($table,$option,$display,$selects)
        {
             $compy=\Session::get('companyid');
             $loc=\Session::get('location');

            $display_name=explode("|",$display);
            $dis="";

            foreach($display_name as $value)
            {
                $dis.=$value.","."' - ', ";

            }

            
            $cond='';
            
            if($loc != 0){
                if($table=='tb_users'){
                    $cond.=' and  loc_id='.$loc;
                }else if($table=='user_department_t' || $table=='m_company_t' || $table=='m_cities_t' || $table=='m_states_t' || $table=='m_countries_t'){
        
                }else{
                    $cond.=' and location_id='.$loc;
                }
                
            }  

            $dis_name=rtrim($dis,",' - ',");

            $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table. " where company_id=".$compy." and active='Yes' $cond" );
            $html="<option value=''>-- Please Select --</option>";

            foreach($select as $val)
            {
                
                if($val->$option==$selects)
                {
                    $html.= "<option value='".$val->$option."' selected='selected'>".$val->name."</option>";
                }
                else
                {
                    $html.= "<option value='".$val->$option."'>".$val->name."</option>";

                }
            }

            return $html;
        }
        //kaviya purpose for jcombo company and active
        public function jCombowolocation($table,$option,$display,$selects)
        {
             $compy=\Session::get('companyid');

            $display_name=explode("|",$display);
            $dis="";

            foreach($display_name as $value)
            {
                $dis.=$value.","."' - ', ";

            }

            $dis_name=rtrim($dis,",' - ',");

            $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table. " where company_id=".$compy." and active='Yes'" );
            $html="<option value=''>-- Please Select --</option>";

            foreach($select as $val)
            {
                
                if($val->$option==$selects)
                {
                    $html.= "<option value='".$val->$option."' selected='selected'>".$val->name."</option>";
                }
                else
                {
                    $html.= "<option value='".$val->$option."'>".$val->name."</option>";

                }
            }

            return $html;
        }
    //kaviya purpose for jcombo company and no active
     public function jCombocomp($table,$option,$display,$selects)
        {
             $compy=\Session::get('companyid');

            $display_name=explode("|",$display);
            $dis="";

            foreach($display_name as $value)
            {
                $dis.=$value.","."' - ', ";
            }

            $dis_name=rtrim($dis,",' - ',");

            $select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table. " where company_id=".$compy );

            $html="<option value=''>-- Please Select --</option>";

            foreach($select as $val)
            {
                if($val->$option==$selects)
                {
                    $html.= "<option value='".$val->$option."' selected='selected'>".$val->name."</option>";
                }
                else
                {
                    $html.= "<option value='".$val->$option."'>".$val->name."</option>";
                }
            }

            return $html;
        }
/*end*/


///*pavan:purpose for displayname*/


    function idname($displayname,$table,$condition,$value){
        $display_name=explode("|",$displayname);
        $display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
    $name=\DB::select("select CONCAT(".$dis_name.") as disname from $table where $condition = '$value' ");
    if($name)
           return $name[0]->disname;
        else
           return "";
    }

//end

     /*kavya purpose jcustom no company and no active*/
  public function jcustomselecttool($table,$option,$display,$selected,$condition)
{

$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");

$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);
$html="<option value=''>-- Please Select --</option>";

foreach ($select_query as $value)
{
if($value->$option == $selected)
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";
}
}

return $html;
}
/*kavya:purpose for jcustomselect with company and active*/
public function jcustomselect($table,$option,$display,$selected,$condition)
{
 $compy=\Session::get('companyid');
$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 and company_id=".$compy." and active='Yes' ".$condition);
$html="<option value=''>-- Please Select --</option>";
foreach ($select_query as $value)
{

if($value->$option == $selected)
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";
}
}
return $html;
}
/*end*/
    /*kavya:purpose for jcustomselect with no company and active*/
public function jcustomselectactive($table,$option,$display,$selected,$condition)
{

$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1  and active='Yes' ".$condition);
$html="<option value=''>-- Please Select --</option>";

foreach ($select_query as $value)
{

if($value->$option == $selected)
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";
}
}
return $html;
}
/*end*/
/*kavya:purpose for jcustomselect with company and no active*/
public function jcustomselectcomp($table,$option,$display,$selected,$condition)
{
 $compy=\Session::get('companyid');
$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition." and company_id=".$compy);
$html="<option value=''>-- Please Select --</option>";
foreach ($select_query as $value)
{

if($value->$option == $selected)
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";
}
}
return $html;
}
/*end*/
/*deepika:purpose for jcustomselect with company and no active and group by*/
public function jcustomselectcomp1($table,$option,$display,$selected,$condition,$groupby)
{
 $compy=\Session::get('companyid');
$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition." and company_id=".$compy." group by $groupby");

$html="<option value=''>-- Please Select --</option>";
foreach ($select_query as $value)
{

if($value->$option == $selected)
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";
}
}
return $html;
}
/*end*/
/*purpose for focus product*/
public function jcustomfocusproduct($table,$option,$display,$selected,$condition)
{

$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);
$html='';

foreach ($select_query as $value)
{

if($value->$option == $selected)
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";
}
}
return $html;
}
/*end*/


 /*deepika purpose:to get multiselect*/
    public function jcustommultiselect($table,$option,$display,$selected,$condition)
{

  $selected=explode(",",$selected);

$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");

$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);
$html="<option value=''>-- Please Select --</option>";

//  print_r($value1);
    foreach ($select_query as $value)
{

    //foreach($selected as $key=>$value1){
if(in_array($value->$option,$selected))
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";//;
}
//}
}//dd($html);
return $html;
}
    /*end*/

/*deepika purpose:to get multiselect*/
public function technicianjcustommultiselect($table,$option,$display,$selected,$condition)
{

  $selected=explode(",",$selected);

$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");

$loc=\Session::get('location');
    $cond='';
    
    if($loc != 0){
        if($table=='tb_users'){
            $cond.=' and  loc_id='.$loc;
        }else if($table=='user_department_t' || $table=='m_company_t' || $table=='m_cities_t' || $table=='m_states_t' || $table=='m_countries_t'){

        }else{
            $cond.=' and location_id='.$loc;
        }
        
    }      
// print_r("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table." inner join ma_department_t on ma_department_t.department_id=$table.machine_department_id where  1=1 and ma_department_t.is_technician='Yes' ".$cond );die;
    
$select_query=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name ,".$option." from ".$table." inner join ma_department_t on ma_department_t.department_id=$table.machine_department_id where  1=1 and ma_department_t.is_technician='Yes' ".$cond );

// $select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);
$html="<option value=''>-- Please Select --</option>";

//  print_r($value1);
    foreach ($select_query as $value)
{

    //foreach($selected as $key=>$value1){
if(in_array($value->$option,$selected))
{
$html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
}
else
{
$html.= "<option value='".$value->$option."' >".$value->name."</option>";//;
}
//}
}//dd($html);
return $html;
}
    /*end*/
/*deepika purpose:to get select data without please select*/
    public function jcustomdataselect($table,$option,$display,$selected,$condition)
{
$display_name=explode("|",$display);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
$select_query=\DB::select("select  CONCAT(".$dis_name.") as  name ,".$option."  from ".$table." WHERE 1=1 ".$condition);
$html="";

foreach ($select_query as $value)
{
    if($value->$option == $selected)
    {
    $html.= "<option value='".$value->$option."' selected='selected'>".$value->name."</option>";
    }
    else
    {
    $html.= "<option value='".$value->$option."' >".$value->name."</option>";
    }
}
//dd($html);
return $html;
}
/*end*/

/* Jq Grid Search Select option */
public function jqgridselect($table,$val,$option)
{
$data=\DB::table($table)->get();

$opt=":--Please Select--";
foreach ($data as $key => $value)
{
$opt.=";".$value->$val.":".trim($value->$option);
}


return $opt;
}
/*End*/

/*Karthigaa Purpose for No table Jqgrid Search */
public function jqgridsearchnotab($table1,$data){
$wh='';
$search=json_decode($_GET['filters']);
foreach ($search->rules as $key => $value)
{

if($value->data!=''){
if($value->op=='cn')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."%'";
}
else if($value->op=='bw')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."%'";
}
else if($value->op=='eq')
{
$wh.=" and $table1.".$value->field. " = '".$value->data."'";
}
else if($value->op=='gt')
{
$wh.=" and $table1.".$value->field. " = '".$value->data."'";
}
else if($value->op=='ne')
{
$wh.=" and $table1.".$value->field. " != '".$value->data."'";
}
else if($value->op=='bn')
{
$wh.=" and $table1.".$value->field. " not like '".$value->data."%'";
}
    else if($value->op=='ew')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."'";
}
        else if($value->op=='en')
{
$wh.=" and $table1.".$value->field. " not like '%".$value->data."'";
}
    else if($value->op=='cn')
{
$wh.=" and $table1.".$value->field. " not like '%".$value->data."%'";
}
    else if($value->op=='nu')
{
$wh.=" and $table1.".$value->field. " = ''";
}
        else if($value->op=='nn')
{
$wh.=" and $table1.".$value->field. " != ''";
}
            else if($value->op=='in')
{
$wh.=" and $table1.".$value->field. " in (".$value->data.")";
}
                else if($value->op=='ni')
{
$wh.=" and $table1.".$value->field. " not in (".$value->data.")";
}
}
}
return $wh;
}

/* Jq Grid Search Select option */
public function jqgridcustselect($table,$val,$option,$condition)
{
//$data=\DB::table($table)->whereIn('customer_id', $condition)->get();
$data=\DB::select("select * from $table where 1=1 $condition");


$opt=":--Please Select--";
foreach ($data as $key => $value)
{
$opt.=";".$value->$val.":".$value->$option;
}

return $opt;
}
/*End*/
  
/*pqgrid search*/
    public function pqgridsearchsum($table1,$data){



$wh='';

foreach ($data as $key => $value)
{
  
            if($value->condition=='begin')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." like '".$value->value."%'";
            }
            else if($value->condition=='between')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." between '".$value->value."' and '".$value->value2."'";
            }
            else if($value->condition=='contain')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." LIKE '%".$value->value."%'";
            }
        else if($value->condition=='empty')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." = '".$value->value."'";
            }
            else if($value->condition=='end')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." like '%".$value->value."'";
            }
            else if($value->condition=='equal')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." = '".$value->value."'";
            }
            else if($value->condition=='great')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." > '".$value->value."%'";
            }
            else if($value->condition=='gte')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." >= '".$value->value."'";
            }
            else if($value->condition=='less')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." < '".$value->value."%'";
            }
            else if($value->condition=='lte')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." <= '".$value->value."' and '".$value->value2."'";
            }
            else if($value->condition=='notbegin')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." NOT LIKE '%".$value->value."%'";
            }
            else if($value->condition=='notcontain')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." NOT LIKE '%".$value->value."%'";
            }
            else if($value->condition=='notempty')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." != '".$value->value."'";
            }
            else if($value->condition=='notend')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." not like '%".$value->value."'";
            }
            else if($value->condition=='notequal')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." != '".$value->value."'";
            }
            else if($value->condition=='range')
            {
                $value1=implode("','",$value->value);
                                //$value1=  str_replace(',',"','",$value1);
                                //dd($value1);
                $wh.=" and ".$value->dataIndx." in ('".$value1."')";
            }else{
                //regexp
            $wh.=" and ".$table1.'.'.$value->dataIndx." REGEXP '".$value->value."'";
            }



}
return $wh;
}
    /*end*/
/*pqgrid search*/
    public function pqgridsearch($table,$data,$array=array()){



$wh='';

foreach ($data as $key => $value)
{
    //dd("SHOW COLUMNS FROM $table where Field='$value->field'");

    $table1='';
            foreach($array as $t)
        {

            $check=\DB::select("SHOW COLUMNS FROM $t where Field='$value->dataIndx'");

       if($check)
       {

        $table1=$t;
           break;
       }
        }
        if($table1==''){
                $table1=$table;
        }





            if($value->condition=='begin')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." like '".$value->value."%'";
            }
            else if($value->condition=='between')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." between '".$value->value."' and '".$value->value2."'";
            }
            else if($value->condition=='contain')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." LIKE '%".$value->value."%'";
            }
        else if($value->condition=='empty')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." = '".$value->value."'";
            }
            else if($value->condition=='end')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." like '%".$value->value."'";
            }
            else if($value->condition=='equal')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." = '".$value->value."'";
            }
            else if($value->condition=='great')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." > '".$value->value."%'";
            }
            else if($value->condition=='gte')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." >= '".$value->value."'";
            }
            else if($value->condition=='less')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." < '".$value->value."%'";
            }
            else if($value->condition=='lte')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." <= '".$value->value."' and '".$value->value2."'";
            }
            else if($value->condition=='notbegin')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." NOT LIKE '%".$value->value."%'";
            }
            else if($value->condition=='notcontain')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." NOT LIKE '%".$value->value."%'";
            }
            else if($value->condition=='notempty')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." != '".$value->value."'";
            }
            else if($value->condition=='notend')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." not like '%".$value->value."'";
            }
            else if($value->condition=='notequal')
            {
                $wh.=" and ".$table1.'.'.$value->dataIndx." != '".$value->value."'";
            }
            else if($value->condition=='range')
            {
                $value1=implode("','",$value->value);
                                //$value1=  str_replace(',',"','",$value1);
                                //dd($value1);
                $wh.=" and ".$value->dataIndx." in ('".$value1."')";
            }else{
                //regexp
            $wh.=" and ".$table1.'.'.$value->dataIndx." REGEXP '".$value->value."'";
            }



}
return $wh;
}
    /*end*/
/* Jq Grid Search Query Build */
public function jqgridsearch($table,$data,$array=array()){

$search=json_decode($_GET['filters']);

$wh='';

foreach ($search->rules as $key => $value)
{
    //dd("SHOW COLUMNS FROM $table where Field='$value->field'");
$check=\DB::select("SHOW COLUMNS FROM $table where Field='$value->field'");
    //dd($check);
    // print_r("SHOW COLUMNS FROM $table where Field='$value->field'");die;
    if($check)
    {

        $table1=$table;

    }
    else
    {

        foreach($array as $t)
        {

            $check=\DB::select("SHOW COLUMNS FROM $t where Field='$value->field'");

       if($check)
       {

        $table1=$t;
           break;
       }
        }
    }

if($value->data!=''){
if($value->op=='cn')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."%'";
}
else if($value->op=='bw')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."%'";
}
else if($value->op=='eq')
{
$wh.=" and $table1.".$value->field. " = '".$value->data."'";
}
else if($value->op=='gt')
{
$wh.=" and $table1.".$value->field. " = '".$value->data."'";
}
else if($value->op=='ne')
{
$wh.=" and $table1.".$value->field. " != '".$value->data."'";
}
else if($value->op=='bn')
{
$wh.=" and $table1.".$value->field. " not like '".$value->data."%'";
}
    else if($value->op=='ew')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."'";
}
        else if($value->op=='en')
{
$wh.=" and $table1.".$value->field. " not like '%".$value->data."'";
}
    else if($value->op=='cn')
{
$wh.=" and $table1.".$value->field. " not like '%".$value->data."%'";
}
    else if($value->op=='nu')
{
$wh.=" and $table1.".$value->field. " = ''";
}
        else if($value->op=='nn')
{
$wh.=" and $table1.".$value->field. " != ''";
}
            else if($value->op=='in')
{
$wh.=" and $table1.".$value->field. " in (".$value->data.")";
}
                else if($value->op=='ni')
{
$wh.=" and $table1.".$value->field. " not in (".$value->data.")";
}
}
}
return $wh;
}
/*End*/
public function jqgridsearch1($table,$data,$array=array()){

$search=json_decode($_GET['filters']);

$wh='';
foreach ($search->rules as $key => $value)
{

    //dd("SHOW COLUMNS FROM $table where Field='$value->field'");
$check=\DB::select("SHOW COLUMNS FROM $table where Field='$value->field'");
    //dd($check);
    if($check)
    {

        $table1=$table;

    }
    else
    {

        foreach($array as $t)
        {

            $check=\DB::select("SHOW COLUMNS FROM $t where Field='$value->field'");

       if($check)
       {

        $table1=$t;
           break;
       }
        }
    }

if($value->data!=''){
if($value->op=='cn')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."%'";
}
else if($value->op=='bw')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."%'";
}
else if($value->op=='eq')
{
$wh.=" and $table1.".$value->field. " = '".$value->data."'";
}
else if($value->op=='gt')
{
$wh.=" and $table1.".$value->field. " = '".$value->data."'";
}
else if($value->op=='ne')
{
$wh.=" and $table1.".$value->field. " != '".$value->data."'";
}
else if($value->op=='bn')
{
$wh.=" and $table1.".$value->field. " not like '".$value->data."%'";
}
    else if($value->op=='ew')
{
$wh.=" and $table1.".$value->field. " like '%".$value->data."'";
}
        else if($value->op=='en')
{
$wh.=" and $table1.".$value->field. " not like '%".$value->data."'";
}
    else if($value->op=='cn')
{
$wh.=" and $table1.".$value->field. " not like '%".$value->data."%'";
}
    else if($value->op=='nu')
{
$wh.=" and $table1.".$value->field. " = ''";
}
        else if($value->op=='nn')
{
$wh.=" and $table1.".$value->field. " != ''";
}
            else if($value->op=='in')
{
$wh.=" and $table1.".$value->field. " in (".$value->data.")";
}
                else if($value->op=='ni')
{
$wh.=" and $table1.".$value->field. " not in (".$value->data.")";
}
}
}
return $wh;
}

/**********************Insert Data****************/
function insertData($model_name,$primary,$data,$id,$module)
{
if($id == '')
{
$data->save();
$id=\DB::getPdo()->lastInsertId();
$this->auditlog($id,$module,'create',$data,'');
}
else
{
$model_name::find($id)->update($_POST);
$this->auditlog($id,$module,'edit',$data,'');
}
	return $id;
}
/*deepika purpose:insert data using model */
function insertData1($model_name,$primary,$data,$id,$module)
{
	
if($id == '')
{
$data->save();
	$id= \DB::getPdo()->lastInsertId();
	$this->auditlog($id,$module,'create',$data,'');
}
else
{
$model_name::find($id)->update($data);
$this->auditlog($id,$module,'edit',$data,'');

}
return $id;
}
	/*end*/
  /* kaviya Purpose for Form Jcombo no company and no active */
public function jcomboformlogin()
{
$table=$_GET['table'];
if(isset($_GET['parent']) && isset($_GET['order_by']))
{

$parent="where ".$_GET['parent'];
$orderby="ORDER BY ".$_GET['order_by'];
}else if(isset($_GET['parent']))
{

$parent="where ".$_GET['parent'];
$orderby="";
}
else if(isset($_GET['group_by']))
{

$parent="where 1=1";
$orderby=$_GET['group_by'];
}
    else if(isset($_GET['order_by']))
{
$parent="where 1=1";
$orderby="ORDER BY ".$_GET['order_by'];
}
else
{
$parent='where 1=1 ';
$orderby='';
}

$table=explode(":",$table);
$result = \DB::select("SELECT $table[1] as val, $table[2] as option_name FROM $table[0] $parent $orderby");
$data= json_encode($result);

$response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;
return $response;
}

/*End*/

/*kavya-m Purpose for Form Jcombo company and  active */
public function jcomboform()
{
 $compy=\Session::get('companyid');
$table=$_GET['table'];
if(isset($_GET['parent']) && isset($_GET['order_by']))
{

$parent="where ".$_GET['parent'];
$orderby="ORDER BY ".$_GET['order_by'];
}
else if(isset($_GET['parent']) )
{

$parent="where ".$_GET['parent'];
$orderby="";
}
else
{
$parent='where 1=1 ';
$orderby='';
}
$table=explode(":",$table);
$display_name=explode("|",$table[2]);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");

$result = \DB::select("SELECT $table[1] as val, CONCAT(".$dis_name.") as option_name FROM $table[0] $parent  $orderby");
$data= json_encode($result);
// dd(count($result));
if(count($result)==0){
 $response="[{'val':0,'option_name':'--Please Select --'}]";
}else{
  $response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;
}
return $response;
}



/*Harish Purpose for choosing all category*/
public function jcomboformallcheck()
{
 $compy=\Session::get('companyid');
$table=$_GET['table'];
if(isset($_GET['parent']) && isset($_GET['order_by']))
{

$parent="where ".$_GET['parent'];
$orderby="ORDER BY ".$_GET['order_by'];
}
else if(isset($_GET['parent']))
{

$parent="where ".$_GET['parent'];
$orderby="";
}
else if(isset($_GET['parent']) )
{

$parent="where ".$_GET['parent'];
$orderby="";
}
else
{
$parent='where 1=1 ';
$orderby='';
}
$table=explode(":",$table);
    $display_name=explode("|",$table[2]);
    $display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");

$result = \DB::select("SELECT $table[1] as val, CONCAT(".$dis_name.") as option_name FROM $table[0] $parent and company_id=".$compy." and active='Yes'  $orderby");
if(count($result)>0){
    $count=count($result);
    $all = (object) array();
$all->val = "9999";
$all->option_name = "ALL";
    array_unshift($result, $all);

}
//dd($result);
$data= json_encode($result);
if(count($result)==0){
 $response="[{'val':0,'option_name':'--Please Select --'}]";
}else{
  $response= isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;
}
return $response;
}


public function jcomboformrerule()
{

 $compy=\Session::get('companyid');
$table=$_GET['table'];//dd($table[1]);

if(isset($_GET['parent']) && isset($_GET['order_by']))
{

$parent="where ".$_GET['parent'];
$orderby="ORDER BY ".$_GET['order_by'];
}
else if(isset($_GET['parent']) )
{

$parent="where ".$_GET['parent'];
$orderby="";
}
else
{
$parent='where 1=1 ';
$orderby='';
}
$table=explode(":",$table);
    $display_name=explode("|",$table[2]);
    $display_n="";

foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
//echo $dis_name; exit;
//echo "SELECT $table[1] as val, CONCAT(".$dis_name.") as option_name FROM $table[0] $parent and company_id=".$compy." and active='Yes'  $orderby"; exit;
$result = \DB::select("SELECT $table[1] as val, CONCAT(".$dis_name.") as option_name FROM $table[0] $parent and company_id=".$compy." and active='Yes'  $orderby");
//$result = \DB::select("SELECT $table[1] as val, CONCAT(".$dis_name.") as option_name FROM $table[0] $parent and company_id=".$compy." and active='Yes'  $orderby");
//foreach($result as $key=>$value)
//{
//
//    $result[$key] = (object)array();
//    $result[$key]->val = $value->val;
//    $parent_class = $this->getparent(parent_class_id);
//    $result[$key]->option_name = $parent_class."-".$value->sub_department_name;
//
//}
//dd($result);
//date($display_n)
$data= json_encode($result);

$response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;
return $response;
}

/* Purpose for Form Jcombo company and no active */
                public function jcomboformcomp()
                {
                    $compy=\Session::get('companyid');
                    $table=$_GET['table'];
					$orderby="";
					$parent="";
                    if(isset($_GET['parent']))
                    {
                        $parent="where ".$_GET['parent'];
                     
                    }else if(isset($_GET['order_by']))
                    {
                        $orderby="ORDER BY ".$_GET['order_by'];
                    }
                    else
                    {
                        $parent='where 1=1 ';
                        $orderby='';
                    }
                        $table=explode(":",$table);
                       $display_name=explode("|",$table[2]);
                       $display_n="";
                        foreach($display_name as $val)
                        {
                            $display_n.=$val.","."' - ',";
                        }
                        $dis_name=rtrim($display_n,",' - ',");
                        $result =\DB::select("SELECT $table[1] as val, CONCAT(".$dis_name.") as option_name FROM $table[0] $parent and company_id=".$compy." $orderby");
                        $data= json_encode($result);
                        $response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;

                        return $response;
                }
            /*End*/


                /* Purpose for Form Jcombo company and no active */
                public function jcomboformcompwithref()
                {

                    $compy=\Session::get('companyid');
                    $table=$_GET['table'];

                    if(isset($_GET['parent']) && isset($_GET['order_by']))
                    {
                        $parent="where ".$_GET['parent'];
                        $orderby="ORDER BY ".$_GET['order_by'];
                    }
                    else
                    {
                        $parent='where 1=1 ';
                        $orderby='';
                    }
                        $table=explode(":",$table);
                       $display_name=explode("|",$table[2]);

                       $display_n="";
                        foreach($display_name as $val)
                        {
                            $display_n.=$val.","."' - ',";
                        }

                        $dis_name=rtrim($display_n,",' - ',");
                        $list = array();

                        $result = \DB::select("SELECT product_id FROM $table[0] $parent and company_id=".$compy." $orderby");


                        if(count($result)>0)
                        {
                            foreach($result as $key=>$value){
                                $list[] = $value->product_id;
                            }
                                $list = implode(',',$list);

                        }
                        else{
                            $list = '0';
                        }
                       // echo "SELECT $table[1] as val,CONCAT(".$dis_name.") as option_name FROM m_products_t where product_id in($list) $orderby"; exit;
                        $result = \DB::select("SELECT $table[1] as val,CONCAT(".$dis_name.") as option_name FROM m_products_t where product_id in($list) $orderby");
                        $data= json_encode($result);
                        $response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;

                        return $response;
                }
            /*End*/

   /*saravanan purpose: in condition in jcombo*/
public function jcomboform1()
{

    $table=$_GET['table'];

    if(!empty($_GET['parent']) && !empty($_GET['order_by']))
    {
        $parent="where 1=1 ".$_GET['parent'];
        $orderby="ORDER BY ".$_GET['order_by'];
    }
    else if(!empty($_GET['parent']) && empty($_GET['order_by']))
    {
        $parent="where 1=1 ".$_GET['parent'];
       $orderby='';
    }
    else
    {
        $parent='';
        $orderby='';
    }
    $table=explode(":",$table);
    //dd($table[2]);
$display_name=explode("|",$table[2]);
$display_n="";
foreach($display_name as $val)
{

$display_n.=$val.","."' - ',";
}
$dis_name=rtrim($display_n,",' - ',");
//dd("SELECT CONCAT(".$dis_name.") as option_name, $table[1] as val FROM $table[0] $parent $orderby");

    $result = \DB::select("SELECT CONCAT(".$dis_name.") as option_name, $table[1] as val FROM $table[0] $parent $orderby");
    if(!empty($result))
    {
        $data= json_encode($result);
    }
    else
    {
        $data1=(object)array();
        $data1->val= '';
        $data =json_encode($data1);
    }


    $response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;
    return $response;
}
public function jcomboforminv()
{

$table=$_GET['table'];
if(isset($_GET['parent'])&&isset($_GET['order_by'])&&isset($_GET['group_by']))
{
$parent="where ".$_GET['parent'];
$orderby="ORDER BY ".$_GET['order_by'];
$groupby="GROUP BY ".$_GET['group_by'];
}
else
{
$parent='';
$orderby='';
$groupby='';
}
//dd($_GET['parent']  );
$table=explode(":",$table);
$result = \DB::select("SELECT $table[1] as val, $table[2] as option_name FROM $table[0] $parent $groupby $orderby ");

if(!empty($result))
{
    $data= json_encode($result);
}
else
{
$data1=(object)array();
$data1->val= '';
$data =json_encode($data1);
}

$response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;
return $response;
}


public function decvalue($id=null)
{
$decivalue = \DB::select("select decimal_points from settings_tbl");
$decidtl= $decivalue[0]->decimal_points;
return $decidtl;
}


public function dateform($id=null)
{
   $datevalue = \DB::select("select df.javascript_format from settings_tbl st left JOIN date_formats_tbl df on df.date_formats_id = st.date_format");
   $datefrmt =$datevalue[0]->javascript_format;
   return $datefrmt;
}

/*Karthigaa purpose:get Supplier Details*/
public function getSuppliergridData(){
        $wh='';
    $search_table=array();
    $search_table[]="m_supplier_sites_t";
    $search_table[]="m_suppliertypes_t";
    $search_table[]="m_countries_t";
    $search_table[]="m_states_t";
    $search_table[]="m_cities_t";
if($_GET['_search']=='true')
{
$wh=$this->jqgridsearch("m_supplier_t",$_GET['filters'],$search_table);
}
if(!empty($_GET['site_type'])){
    $wh.=" and m_supplier_sites_t.site_type='".$_GET['site_type']."' and m_supplier_sites_t.supplier_id=".$_GET['cid'];
}

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
if(!$sidx) $sidx =1;
$SQL_Count = "SELECT count(m_supplier_t.supplier_id) AS count,m_suppliertypes_t.suppliertype_name FROM `m_supplier_t` left join m_supplier_sites_t on(m_supplier_sites_t.supplier_site_id=m_supplier_t.`supplier_id`)left join m_suppliertypes_t on(m_suppliertypes_t.suppliertype_id=m_supplier_t.`supplier_type_id`) left join m_countries_t on(m_countries_t.country_id=m_supplier_sites_t.`country`)left join m_cities_t on(m_cities_t.city_id=m_supplier_sites_t.`city`)left join m_states_t on(m_states_t.state_id=m_supplier_sites_t.`state`)where 1=1 $wh  ";
$result = \DB::select( $SQL_Count );
$count = $result[0]->count;
if( $count > 0 && $limit > 0){
$total_pages = ceil($count/$limit);
} else {
$total_pages = 0;
}
if ($page > $total_pages)
$page=$total_pages;
$start = $limit*$page - $limit;
if($start <0) $start = 0;
$SQL = "SELECT m_supplier_t.supplier_id as supplierid,m_supplier_t.supplier_number as supplier_number,m_supplier_t.supplier_name,m_suppliertypes_t.suppliertype_name,m_supplier_sites_t.supplier_site_name as supplier_site_name,m_supplier_sites_t.site_type as site_type,m_supplier_sites_t.address as address,m_cities_t.city_name,m_states_t.state_name,m_countries_t.country_name FROM `m_supplier_t` left join m_supplier_sites_t on(m_supplier_sites_t.supplier_site_id=m_supplier_t.`supplier_id`)left join m_suppliertypes_t on(m_suppliertypes_t.suppliertype_id=m_supplier_t.`supplier_type_id`) left join m_countries_t on(m_countries_t.country_id=m_supplier_sites_t.`country`)left join m_cities_t on(m_cities_t.city_id=m_supplier_sites_t.`city`)left join m_states_t on(m_states_t.state_id=m_supplier_sites_t.`state`)where 1=1 and m_supplier_t.active= 'Yes' and m_supplier_sites_t.active='Yes' $wh ORDER BY $sidx $sord LIMIT $start , $limit";
$result = \DB::select( $SQL );
$responce->rows[]='';
$responce->rows=$result;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
echo json_encode($responce);
}
/*end*/

/*deepika purpose:get Customer Details*/
public function getCustomergridData()
{
   $wh='';
    $search_table=array("m_customer_types_t","m_customer_sites_t","m_cities_t","m_states_t","m_countries_t");
if($_GET['_search']=='true')
{
    //dd($_GET['filters']);
$wh=$this->jqgridsearch("m_customers_t",$_GET['filters'],$search_table);
}
if((!empty($_GET['site_type'])))
{
    //dd($_GET['site_type']);
    $wh.=" and m_customer_sites_t.site_type='".$_GET['site_type']."' and m_customer_sites_t.customer_id=".$_GET['cid'];
}
if(isset($_GET['statusship'])){
    $wh.=" and  m_customer_sites_t.site_type='SHIP_TO'";
}
if(isset($_GET['status'])){

$wh.=" and (m_customers_t.status='QUICKCUSTOMER' OR m_customers_t.savestatus='SAVE')  and m_customer_sites_t.active='Yes' ";
}
 else{
$wh.="  and m_customers_t.active='Yes'  and  m_customer_sites_t.active='Yes'";
 }

    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sidx = $_GET['sidx'];
    $sord = $_GET['sord'];
    if(!$sidx) $sidx =1;
            
            $SQL_Count = "SELECT count(m_customers_t.customer_id) as count  from m_customers_t  left join  m_customer_sites_t on(m_customers_t.customer_id=m_customer_sites_t.customer_id) left join m_cities_t on(m_customer_sites_t.city=m_cities_t.city_id) left join m_states_t on(m_customer_sites_t.state=m_states_t.state_id) left join m_countries_t  on(m_countries_t.country_id=m_customer_sites_t.country) left join m_customer_types_t  on (m_customer_types_t.customer_type_id=m_customers_t.customer_type_id) where 1=1 $wh ";

    $result = \DB::select( $SQL_Count );

    $count = $result[0]->count;
    if( $count > 0 && $limit > 0)
    {
    $total_pages = ceil($count/$limit);
    } else {
    $total_pages = 0;
    }
    if ($page > $total_pages)
    $page=$total_pages;
    $start = $limit*$page - $limit;
    if($start <0) $start = 0;
    $SQL = "SELECT m_customers_t.customer_id,m_customers_t.customer_number,m_customers_t.customer_name,m_customer_types_t.customer_type,m_customer_sites_t.customer_site_id,m_customer_sites_t.customer_site_name,m_customer_sites_t.site_type,m_customer_sites_t.address,m_cities_t.city_name,m_states_t.state_name,m_countries_t.country_name,m_customer_sites_t.pincode,m_customer_sites_t.contact_number,m_customer_sites_t.primary_address  from m_customers_t  left join  m_customer_sites_t on(m_customers_t.customer_id=m_customer_sites_t.customer_id) left join m_cities_t  on(m_customer_sites_t.city=m_cities_t.city_id) left join m_states_t  on(m_customer_sites_t.state=m_states_t.state_id) left join m_countries_t  on(m_countries_t.country_id=m_customer_sites_t.country) left join m_customer_types_t on (m_customer_types_t.customer_type_id=m_customers_t.customer_type_id) where 1=1 $wh ORDER BY $sidx $sord LIMIT $start , $limit";

    $result = \DB::select( $SQL );


 
    $responce->rows[]='';
    $responce->rows=$result;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    echo json_encode($responce);
}
/*end*/
/*deepika purpose:get Product Details*/
public function getProductgridData()
{
        // dd($_GET);
    $prdgp="";
    $prdgpname="";
	$comp=\Session::get('companyid');
    if(isset($_GET['prggrp']))
    {
            $sql=\DB::select("select product_group_id,group_name from m_product_groups_t where group_name in(".$_GET['prggrp'].")");
            $prdgp.="and m_products_t.product_group_id='".$sql[0]->product_group_id."'";
            $prdgpname.="and m_product_groups_t.group_name in(".$_GET['prggrp']." )";
    }

        $wh='';
        $search_table=array("m_product_groups_t","m_product_category_t");

        if($_GET['_search']=='true')
        {
            $wh.=$this->jqgridsearch('m_products_t',$_GET['filters'],$search_table);
        }
   $wh.=" and m_products_t.active='Yes' and m_products_t.company_id=".$comp;
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        if(!$sidx) $sidx =1;

        if(isset($_GET['pricelist_id']))
        {
            $result = \DB::select("SELECT COUNT(m_products_t.product_group_id) AS count FROM m_products_t left join m_product_groups_t on(m_product_groups_t.product_group_id=m_products_t.product_group_id)  left join m_product_category_t on(m_product_category_t.product_category_id=m_products_t.product_category_id) left join i_pricelist_lines_t on i_pricelist_lines_t.product_id=m_products_t.product_id WHERE  1=1  and  i_pricelist_lines_t.pricelist_hdr_id='".$_GET['pricelist_id']."'  and i_pricelist_lines_t.active='Yes' $prdgp $wh");
        }
        else
        {
            $result = \DB::select("SELECT COUNT(m_products_t.product_group_id) AS count FROM m_products_t left join m_product_groups_t on(m_product_groups_t.product_group_id=m_products_t.product_group_id)  left join m_product_category_t on(m_product_category_t.product_category_id=m_products_t.product_category_id) where 1=1 $prdgp $wh");
        }

        $count = $result[0]->count;
        if( $count > 0 && $limit > 0)
        {
            $total_pages = ceil($count/$limit);
        }
        else
        {
            $total_pages = 0;
        }
        if ($page > $total_pages)
        $page=$total_pages;
        $start = $limit*$page - $limit;
        if($start <0) $start = 0;

        if(isset($_GET['pricelist_id']))
        {
            $SQL = "SELECT m_products_t.product_id,m_products_t.product_code,m_products_t.concatenated_product,m_product_groups_t.group_name,m_product_category_t.category_name from m_products_t left join m_product_groups_t on(m_product_groups_t.product_group_id=m_products_t.product_group_id)  left join m_product_category_t on(m_product_category_t.product_category_id=m_products_t.product_category_id) left join i_pricelist_lines_t on i_pricelist_lines_t.product_id=m_products_t.product_id where 1=1  and i_pricelist_lines_t.pricelist_hdr_id='".$_GET['pricelist_id']."'  and i_pricelist_lines_t.active='Yes' $prdgpname $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        }
        else
        {
            $SQL = "SELECT m_products_t.product_id,m_products_t.product_code,m_products_t.concatenated_product,m_product_groups_t.group_name ,m_product_category_t.category_name from m_products_t left join m_product_groups_t on(m_product_groups_t.product_group_id=m_products_t.product_group_id)  left join m_product_category_t on(m_product_category_t.product_category_id=m_products_t.product_category_id) where 1=1 $prdgpname $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        }

    $result = \DB::select($SQL);
        $responce->rows[]='';
        $responce->rows=$result;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        echo json_encode($responce);
}


/*end*/

public function getProductgridDatasubinventory()
{

    $prdgp="";
    $prdgpname="";


        $wh='';
        $search_table=array("m_product_groups_t","m_product_category_t");

        if($_GET['_search']=='true')
        {
            $wh=$this->jqgridsearch('m_products_t',$_GET['filters'],$search_table);
        }

        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        if(!$sidx) $sidx =1;



        if(isset($_GET['sub_inve']))
        {

            $result = \DB::select("SELECT count(i_qoh_detail_t.qoh_detail_id) AS count FROM i_qoh_detail_t LEFT JOIN m_products_t ON ( m_products_t.product_code = i_qoh_detail_t.product_id ) LEFT JOIN m_product_groups_t ON ( m_product_groups_t.product_group_id = m_products_t.product_group_id ) LEFT JOIN m_product_category_t ON ( m_product_category_t.product_category_id = m_products_t.product_category_id ) WHERE 1=1 and i_qoh_detail_t.subinventory_id='".$_GET['sub_inve']."' $prdgp $wh");
        }
        else
        {
            $result = \DB::select("SELECT count(i_qoh_detail_t.qoh_detail_id) AS count FROM i_qoh_detail_t LEFT JOIN m_products_t ON ( m_products_t.product_code = i_qoh_detail_t.product_id ) LEFT JOIN m_product_groups_t ON ( m_product_groups_t.product_group_id = m_products_t.product_group_id ) LEFT JOIN m_product_category_t ON ( m_product_category_t.product_category_id = m_products_t.product_category_id ) where 1=1 $prdgp $wh");
        }

        $count = $result[0]->count;
        if( $count > 0 && $limit > 0)
        {
            $total_pages = ceil($count/$limit);
        }
        else
        {
            $total_pages = 0;
        }
        if ($page > $total_pages)
        $page=$total_pages;
        $start = $limit*$page - $limit;
        if($start <0) $start = 0;



        $compy=\Session::get('companyid');

        if(isset($_GET['sub_inve']))
        {

            $SQL = "SELECT m_products_t.product_code, m_product_groups_t.group_name, m_product_category_t.category_name, m_products_t.concatenated_product,m_products_t.product_id FROM i_qoh_detail_t LEFT JOIN m_products_t ON( m_products_t.product_id = i_qoh_detail_t.product_id ) LEFT JOIN m_product_groups_t ON( m_product_groups_t.product_group_id = m_products_t.product_group_id ) LEFT JOIN m_product_category_t ON( m_product_category_t.product_category_id = m_products_t.product_category_id ) WHERE 1 = 1 AND i_qoh_detail_t.subinventory_id = '".$_GET['sub_inve']."' and i_qoh_detail_t.company_id='$compy' $prdgpname $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        }
        else
        {

            $SQL = "SELECT m_products_t.product_code, m_product_groups_t.group_name, m_product_category_t.category_name, m_products_t.concatenated_product,m_products_t.product_id FROM i_qoh_detail_t LEFT JOIN m_products_t ON( m_products_t.product_id = i_qoh_detail_t.product_id ) LEFT JOIN m_product_groups_t ON( m_product_groups_t.product_group_id = m_products_t.product_group_id ) LEFT JOIN m_product_category_t ON( m_product_category_t.product_category_id = m_products_t.product_category_id ) WHERE 1 = 1 AND i_qoh_detail_t.company_id='$compy' $prdgpname $wh ORDER BY $sidx $sord LIMIT $start , $limit";
        }
        //echo "SELECT m_products_t.product_id,m_products_t.product_code,m_products_t.concatenated_product,m_product_groups_t.group_name ,m_product_category_t.category_name from m_products_t left join m_product_groups_t on(m_product_groups_t.product_group_id=m_products_t.product_group_id)  left join m_product_category_t on(m_product_category_t.product_category_id=m_products_t.product_category_id) where 1=1 $prdgpname $wh ORDER BY $sidx $sord LIMIT $start , $limit"; exit;

    $result = \DB::select($SQL);
        $responce->rows[]='';
        $responce->rows=$result;
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        echo json_encode($responce);
}

//getProductgridDatasubinventory

public function taxdetails($id=null,$suppsite=null,$mtype=null)  {
    $prd_data1=array();
    $date=date('Y-m-d');
        $tax_value=0;
    $current_location= \Session::get('location');
//dd($current_location);
    $query=\DB::select("SELECT `state_id` FROM `m_location_t` where `location_id` ='$current_location'");
//dd($query);
    if(!empty($query))
    {
        $cur_state=$query[0]->state_id;
    }
    $query1='';
    $supplier_location=array();

    if($mtype == "PURCHASE"){

        $query1=\DB::select("SELECT `state` FROM `m_supplier_sites_t` WHERE `supplier_site_id`='$suppsite'");
    }else{
        $query1=\DB::select("SELECT `state` FROM `m_customer_sites_t` WHERE `customer_site_id`='$suppsite'");
    }
  
    if(!empty($query1))
    {
        $supplier_location['state']=$query1[0]->state;
    }
    else
    {
        $supplier_location['state']='';
    }

    $supplier_state = $supplier_location['state'];

     if($cur_state!='' && $supplier_state!=''){

        if($cur_state==$supplier_state){


            $tax=\DB::select("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and ('$date' between start_date and end_date) and active='Yes' and tax_location_type='Intrastate(within-state)'");
          // dd("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and ('$date' between start_date and end_date) and active='Yes' and tax_location_type='Intrastate(within-state)'");
            if(!empty($tax)){
                $prd_data1['tax_group_id']=$tax_value=$tax[0]->tax_group_id;
                $tax1=\DB::table("m_tax_group_t")->select('display_name')->where('tax_group_id',$tax[0]->tax_group_id)->get();
                $prd_data1['display_name']=$tax1[0]->display_name;

            }
            else{
                $prd_data1['tax_group_id']=$tax_value=0;
                $type=1;
            }
        }else{
            $tax=\DB::select("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and ('$date' between start_date and end_date) and active='Yes' and tax_location_type='Interstate'");
            //dd("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and ('$date' between start_date and end_date) and active='Yes' and tax_location_type='Interstate'");
            if(!empty($tax)){
                $prd_data1['tax_group_id']=$tax_value=$tax[0]->tax_group_id;
            }else{
                $prd_data1['tax_group_id']=$tax_value=0;
                $type=2;
            }
        }
    }else{
        $prd_data1['tax_group_id']=$tax_value=0;
    }
    //-----------------------------------

    if($tax_value==0){
        if($type='1'){
            $tax_check=\DB::select("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and  active='Yes' and tax_location_type='Intrastate(within-state)'");

        }else{
            $tax_check=\DB::select("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and  active='Yes' and tax_location_type='Interstate'");

        }
//     dd($tax_check);
        if(count($tax_check)>0){
            $tax_group=$tax_check[0]->tax_group_id;
            $tax_expiry=\DB::select("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and tax_group_id='$tax_group'");
           // dd("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$id' and tax_group_id='$tax_group'");
            if(count($tax_expiry)>0)
            {
                $prd_data1['tax_group_id_expiry']="expiry";
            }
        }
        else{
            $prd_data1['tax_group_id_expiry']="location";
        }

    }
//dd($prd_data1);
    return $prd_data1;
}


/*Karthigaa Purpose for loading product details*/
public function productDetails($pid=null,$plid=null,$suppsite=null,$type=null)
{

    $prd_data=array();
    $prd_data['uom_code_id']='';
    $prd_data['unit_price']='';
    $prd_data['tax_group_id']='';
    $prd_data['hsn_code']='';
    $prd_data['multihsn']='';
     $prd_data['qoh_qty']='';
    $supplier_id = $_GET['supplier_id'];
    $source= $_GET['source'];
    $compy=\Session::get('companyid');

    if($pid!=''){
        if(isset($_GET['supplier_id'])){
            $manufactpartno=\DB::select('select * from m_manufacturer_partno_t where product_id='.$pid.' and manufacturer_source_value_id='.$_GET['supplier_id'].' and manufacturer_source="SUPPLIER"');
        }

        if(count($manufactpartno)>0){
            $prd_data['part_no']=$manufactpartno[0]->manufacturer_partno_id;
        }
        else{
            $prd_data['part_no']=0;
        }

        if($type=='STANDARD'){
            $pro_details=\DB::table("m_products_t")->select('product_id','primary_uom_id','hsn_code','defalut_hsn_code','min_order_qty','max_order_qty')->where('product_id',$pid)->get();

            if(!empty($pro_details))
                $prd_data['product_id']=$pro_details[0]->product_id;
                $prd_data['uom_code_id']=$pro_details[0]->primary_uom_id;
            $hsn_code=$pro_details[0]->defalut_hsn_code;
                $prd_data['hsn_code']=$pro_details[0]->defalut_hsn_code;

            $prd_data['multihsn'] = $pro_details[0]->hsn_code;

            //$prd_data['min_order_qty']=$pro_details[0]->min_order_qty;
            //$prd_data['max_order_qty']=$pro_details[0]->max_order_qty;
            $date=date('Y-m-d');
        }else{
            $pro_details=\DB::table("m_products_t")->select('primary_uom_id','hsn_code','min_order_qty','max_order_qty')->where('product_id',$pid)->get();
            if(!empty($pro_details))
                $prd_data['uom_code_id']=$pro_details[0]->primary_uom_id;
            $hsn_code=$pro_details[0]->hsn_code;
           // $prd_data['min_order_qty']=$pro_details[0]->min_order_qty;
          //  $prd_data['max_order_qty']=$pro_details[0]->max_order_qty;
            $date=date('Y-m-d');
        }
        //-----------------------------------

        $price_cnd=array('pricelist_hdr_id'=>$plid,'product_id'=>$pid);
        $pricelist_details=$this->pricelist_details($price_cnd);
//        dd($pricelist_details);
        if(!empty($pricelist_details))
        {
            $prd_data['unit_price']=$pricelist_details[0]->unit_price;
        }
        $qoh_qty=DB::SELECT("select sum(f.qty-IFNULL(f.qtyy,0)) as qoh_qty,f.product_id from (select sum(qoh_trx_qty)as qty,0 as qtyy,product_id FROM i_qoh_detail_t where product_id=".$pid." and  i_qoh_detail_t. company_id=".$compy."  GROUP by product_id   UNION ALL SELECT 0 as qty,sum(reserv_trx_qty) as qtyy,product_id as fdfd from i_reservation_detail_t where product_id=".$pid." and  i_reservation_detail_t. company_id=".$compy."  GROUP by product_id)f");


        if(!empty($qoh_qty))
        {
            $prd_data['qoh_qty']=$qoh_qty[0]->qoh_qty;
        }
        else
        {
            $prd_data['qoh_qty']=0;
        }
        $mtype='PURCHASE';
        $taxdata=$this->taxdetails($hsn_code,$suppsite,$mtype);
//        dd($taxdata);
        $prd_data['tax_group_id']=$taxdata['tax_group_id'];
    }
//    dd($prd_data);
    return $prd_data;
}

public function productdetails_so($pid=null,$plid=null,$cussite=null,$type=null)
{

    $prd_data=array();

    $prd_data['uom_code_id']='';
    $prd_data['unit_price']='';
    $prd_data['tax_group_id']='';
    $prd_data['qoh_qty']='';
    $prd_data['manufactpartno']=0;
    $customer_id = '';

    if(isset($_GET['customer_id'])){
        $cus = $_GET['customer_id'];
        $col = 'customer_id';
    }else{
        $cus = $cussite;
        $col = 'customer_site_id';
    }

    $customer = \DB::table('m_customer_sites_t')->where($col,$cus)->select('customer_id')->groupBy('customer_id')->get();
    
    if(count($customer)>0){
        $customer_id = $customer[0]->customer_id;
    }else{
        $customer_id = '';
    }

    $data=\DB::table('m_manufacturer_partno_t')->where('product_id',$pid)->where('manufacturer_source_value_id',$customer_id)->get();

    if(count($data)>0){
        $prd_data['manufactpartno']=$data[0]->manufacturer_partno_id;
    }

    $pro_details=\DB::table("m_products_t")->select('trx_uom_id','hsn_code','defalut_hsn_code','min_order_qty','max_order_qty')->where('product_id',$pid)->get();

    if(!empty($pro_details))
        $prd_data['uom_code_id']=$pro_details[0]->trx_uom_id;

    $hsn_code=$pro_details[0]->defalut_hsn_code;
    $prd_data['hsn_code']=$pro_details[0]->defalut_hsn_code;
    $prd_data['multihsn'] = $pro_details[0]->hsn_code;

    $date=date('Y-m-d');

    $tax=\DB::select("select tax_group_id from f_gst_code_lines_t where gst_code_hdr_id='$hsn_code' and start_date<='$date' and end_date>='$date' and active='Yes'");
    if(!empty($tax))
    {
        $prd_data['tax_group_id']=$tax[0]->tax_group_id;
    }


    $price_cnd=array('pricelist_hdr_id'=>$plid,'product_id'=>$pid);

    $pricelist_details=$this->pricelist_details($price_cnd);

    if(!empty($pricelist_details))
    {
        $prd_data['unit_price']=$pricelist_details[0]->unit_price;
    }

    $compy=\Session::get('companyid');
    $qoh_qty=DB::SELECT("select sum(f.qty-IFNULL(f.qtyy,0)) as qoh_qty,f.product_id from (select sum(qoh_trx_qty)as qty,0 as qtyy,product_id FROM i_qoh_detail_t where product_id=".$pid." and  i_qoh_detail_t. company_id=".$compy."  and i_qoh_detail_t.qualitystatus=1 GROUP by product_id   UNION ALL SELECT 0 as qty,sum(reserv_trx_qty) as qtyy,product_id as fdfd from i_reservation_detail_t where product_id=".$pid." and  i_reservation_detail_t. company_id=".$compy."  GROUP by product_id)f");

    if(!empty($qoh_qty))
    {
        $prd_data['qoh_qty']=$qoh_qty[0]->qoh_qty;
    }
    else
    {
        $prd_data['qoh_qty']=0;
    }
    $mtype='SALES';

    $taxdata=$this->taxdetails($hsn_code,$cussite,$mtype);

    $prd_data['tax_group_id']=$taxdata['tax_group_id'];

    return $prd_data;
}

public function productdetails_so_old($pid=null)
{

    $prd_data=array();


    $prd_data['uom_code_id']='';
    $prd_data['unit_price']='';
    $prd_data['tax_group_id']='';
    $prd_data['qoh_qty']='';

    $pro_details=\DB::table("m_products_t")->select('trx_uom_id')->where('product_id',$pid)->get();
    // dd($pro_details);
    if(!empty($pro_details))
        $prd_data['uom_code_id']=$pro_details[0]->trx_uom_id;


    $compy=\Session::get('companyid');
    $qoh_qty=DB::SELECT("select sum(f.qty-f.qtyy) as qoh_qty,f.product_id from (select sum(qoh_trx_qty)as qty,0 as qtyy,product_id FROM i_qoh_detail_t where product_id=".$pid." and  i_qoh_detail_t. company_id=".$compy."  GROUP by product_id   UNION ALL SELECT 0 as qty,sum(reserv_trx_qty) as qtyy,product_id as fdfd from i_reservation_detail_t where product_id=".$pid." and  i_reservation_detail_t. company_id=".$compy."  GROUP by product_id)f");



    if(!empty($qoh_qty))
    {
        $prd_data['qoh_qty']=$qoh_qty[0]->qoh_qty;
    }
    else
    {
        $prd_data['qoh_qty']=0;
    }
    $mtype='SALES';

    return $prd_data;
}

public function single_select_to_outer_array($array=null)
{
$new_array=array();

if(!empty($array))
{
foreach($array as $k=>$v)
{
foreach($v as $k1=>$v1)
{
array_push($new_array,$v1);
}

}

}

return $new_array;
}


public function pricelist_details($price_cnd=null)
{
$cond='';

if(!empty($price_cnd))
{
$price_cnd_cnt=count($price_cnd);

foreach($price_cnd as $col_name=>$col_val)
{
if($price_cnd_cnt>1)
{
$cond.=" and $col_name='$col_val'";
}
else
{
$cond=" and $col_name='$col_val'";
}
}
}

$q="select * from (SELECT pll.`pricelist_line_id` pricelist_line_id, plh.`pricelist_hdr_id`pricelist_hdr_id, plh.`pricelist_name` pricelist_name, plh.`price_list_type` price_list_type, plh.`description` description, plh.`currency_code_id` currency_code_id, pll.`start_date` start_date, pll.`end_date` end_date, plh.`remarks` remarks, plh.`organization_id` organization_id, plh.`company_id` company_id, pll.`line_no` line_no, pll.`product_id` product_id, pll.`unit_price` unit_price, pll.`std_price` std_price, pll.`active` active, pll.`comments` comments FROM `i_pricelist_lines_t` pll JOIN i_pricelist_hdr_t plh ON ( pll.`pricelist_hdr_id` = plh.pricelist_hdr_id )) pldata where 1=1 and (CURDATE() between start_date and end_date) and active='Yes'".$cond;

$res=\DB::select($q);

if(empty($res))
{
$res=[];
$res[0]=(object)$res;
$res[0]->unit_price=0;
}

return $res;
}


public function productDetails1($id=null)
{

$prd_data=array();

if($id!='')
{
$uom_code_id='1';
$unit_price='100';
$tax_group_id='1';

$prd_data['uom_code_id']=$uom_code_id;
$prd_data['unit_price']=$unit_price;
$prd_data['tax_group_id']=$tax_group_id;
}

return $prd_data;
}

public function jcomboformtax()
{
    $compy=\Session::get('companyid');
    $table=$_GET['table'];
    if(isset($_GET['parent']) && isset($_GET['order_by']))
    {
        $parent="where ".$_GET['parent'];
        $orderby="ORDER BY ".$_GET['order_by'];
    }
    else if(isset($_GET['parent']) )
    {
        $parent="where ".$_GET['parent'];
        $orderby="";
    }
    else
    {
        $parent='where 1=1 ';
        $orderby='';
    }
        $table=explode(":",$table);

        $display_name=explode("|",$table[2]);
        $display_n="";
    foreach($display_name as $val)
    {

        $display_n.=$val.","."' - ',";
    }
    $dis_name=rtrim($display_n,",' - ',");

    $result = \DB::select("SELECT $table[1] as val, CONCAT(".$dis_name.") as option_name,$table[3] as datadisplay FROM $table[0] $parent and company_id=".$compy." and active='Yes'  $orderby");
    $data= json_encode($result);

    if(count($result)==0){
        $response="[{'val':0,'datadisplay':'0','option_name':'--Please Select --'}]";
    }else{
        $response = isset($_GET['callback'])?$_GET['callback']."(".$data.")":$data;
    }

    return $response;
}

public function jCombotax($table,$option,$display,$selects)
{
$display_name=explode("|",$display);
$dis="";
foreach($display_name as $value)
{
$dis.=$value.","."' - ', ";
}

$dis_name=rtrim($dis,",' - ',");
//dd("select DISTINCT CONCAT(".$dis_name.") as name,display_name ,".$option." from ".$table);
$select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name,display_name ,".$option." from ".$table);
$html="<option value=''>-- Please Select --</option>";
foreach($select as $val)
{
if($val->$option==$selects)
{
$html.= "<option value='".$val->$option."' data-display='".$val->display_name."' selected='selected'>".$val->name."</option>";
}
else
{
$html.= "<option value='".$val->$option."'  data-display='".$val->display_name."' >".$val->name."</option>";
}
}
return $html;
}
/*end*/


function validatePost($form_data=null,$table=null,$module_type=null)
{

    $request = new Request;
    $data = array();

    $col_data=$this->Configtabledata($table);
    if(!empty($col_data))
    {
        $form_config=json_decode(urldecode($form_data['form_data_json']),true);
        // $str = $form_config['header'];

        $str = $form_config[$module_type];
        $tablePimarykey=$col_data['tablePimarykey'];

        if(isset($_REQUEST['removed_line_id']))
        {

        $data['removed_line_id'] = $_REQUEST['removed_line_id'];

        }

        if($module_type=='header')
        {
            foreach($str as $f)
            {
                $field = $f['field'];
//dd($col_data['field_data']);
                $header_field_chk=array_key_exists($field,$col_data['field_data']);
                if($header_field_chk==true)
                {
                    if($f['type'] == 'textarea_editor' || $f['type'] == 'textarea')
                    {

                        $content = (isset($_REQUEST[$field]) ? $_REQUEST[$field] : '');
                        $data[$field] = $content;
                    }
                    else
                    {

                        if(isset($_REQUEST[$field]))
                        {
                        //dd();
                        $data[$field] = $_REQUEST[$field];

                        }
                        // if post is file or image


                        if($f['type'] =='file')
                        {

                        $files ='';
                        if(isset($f['option']['image_multiple']) && $f['option']['image_multiple'] ==1)
                        {

                        if(isset($_REQUEST['curr'.$field]))
                        {
                        $curr =  '';
                        for($i=0; $i<count($_REQUEST['curr'.$field]);$i++)
                        {
                        $files .= $_REQUEST['curr'.$field][$i].',';
                        }
                        }

                        if(!is_null(Input::file($field)))
                        {

                        $destinationPath = '.'. $f['option']['path_to_upload'];
                        foreach($_FILES[$field]['tmp_name'] as $key => $tmp_name ){
                        $file_name = $_FILES[$field]['name'][$key];
                        $file_tmp =$_FILES[$field]['tmp_name'][$key];
                        if($file_name !='')
                        {
                        move_uploaded_file($file_tmp,$destinationPath.'/'.$file_name);
                        $files .= $file_name.',';

                        }

                        }

                        if($files !='') $files = substr($files,0,strlen($files)-1);
                        }

                        $data[$field] = $files;


                        }
                        else
                        {

                            if(!is_null(Input::file($field)))
                            {

                            $file = Input::file($field);
                            $destinationPath = public_path(). $f['option']['path_to_upload'];
                            $filename = $file->getClientOriginalName();
                            $extension =$file->getClientOriginalExtension(); //if you need extension of the file
                            $rand = rand(1000,100000000);
                            $newfilename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;
                            $uploadSuccess = $file->move($destinationPath, $newfilename);
                            if($f['option']['resize_width'] != '0' && $f['option']['resize_width'] !='')
                            {
                            if( $f['option']['resize_height'] ==0 )
                            {
                            $f['option']['resize_height']   = $f['option']['resize_width'];
                            }
                            $orgFile = $destinationPath.'/'.$newfilename;
                            \SiteHelpers::cropImage($f['option']['resize_width'] , $f['option']['resize_height'] , $orgFile ,  $extension,   $orgFile)  ;
                            }

                            if( $uploadSuccess ) {
                            $data[$field] = $newfilename;
                            }
                            }
                            else
                            {
                            unset($data[$field]);
                            }

                        }
                        }
                // if post is radio
                     if($f['type'] =='radio')
                        {
                        if(isset($_REQUEST[$field]) && !is_null($_REQUEST[$field]))
                        {

                        $data[$field] = $_REQUEST[$field];

                        }
                        }
                        // if post is checkbox
                        if($f['type'] =='checkbox')
                        {

                        if(!is_null($_REQUEST[$field]))
                        {

                        $data[$field] = implode(",",$_REQUEST[$field]);

                        }
                        }

                        // if post is date
                        if($f['type'] =='date')
                        {
                        $data[$field] = date("Y-m-d",strtotime($request->input($field)));
                        }

                        // if post is seelct multiple
                        if($f['type'] =='select')
                        {

                        if( isset($f['option']['select_multiple']) &&  $f['option']['select_multiple'] ==1 )
                        {
                        $multival = (is_array($_REQUEST[$field]) ? implode(",",$_REQUEST[$field]) :  $_REQUEST[$field]);
                        $data[$field] = $multival;
                        }
                        else
                        {
                        if(isset($_REQUEST[$field]))
                                                {
                        $data[$field] = $_REQUEST[$field];
                                                }
                                                else
                                                {
                                                 $data[$field] ='';
                                                }


                        }

                        }

                    }
                }
            }

            $global = (isset($this->access['is_global']) ? $this->access['is_global'] : 0 );

            if($global == 0 )
            {

            //$data['created_by'] = \Session::get('uid');
            $data['created_by'] = \Session::get('id');

            /*
                $data['created_at'] = time();
            $data['last_updated_by'] = \Session::get('uid');
            $data['last_updated_at'] = time();
            */

                /*
            $data['created_at'] = date('Y-m-d');
            $data['last_updated_by'] = \Session::get('uid');
            $data['last_updated_at'] = date('Y-m-d');
            */

            $data['created_at'] = date('Y-m-d');
            $data['last_updated_by'] = \Session::get('id');
            $data['updated_at'] = date('Y-m-d');


            }
        }
        else
        {

            error_reporting(0);

            foreach($str as $k=>$f)
            {
                $field = $f['field'];
                $field_bracket_removed= preg_replace("/\[\]/", "", $f['field']);
                $field_bulk_removed = preg_replace("/\[\]|bulk_/", "", $f['field']);

                $counter_array=$_REQUEST['counter'];


                foreach($counter_array as $cnt_key=>$cnt_val)
                {

                    //if($f['view'] ==1 && $field_bulk_removed!='counter' && $field_bulk_removed!='removed_line_id')
                    if($f['view'] ==1 && $field_bulk_removed!='counter')
                    {
                        $form_post_field=$_REQUEST[$field_bracket_removed][$cnt_key];


                        if($f['type'] =='textarea_editor' || $f['type'] =='textarea')
                        {
                            $content = (isset($form_post_field) ? $form_post_field : '');
                            $data[$field_bulk_removed][$cnt_key] = $content;
                        }
                        else
                        {


                                                    if(isset($form_post_field))
                            {

                            $data[$field_bulk_removed][$cnt_key] = $form_post_field;

                            }

                            // if post is file or image

                            if($f['type'] =='file')
                            {

                            $files ='';
                            if(isset($f['option']['image_multiple']) && $f['option']['image_multiple'] ==1)
                            {

                            if(isset($_REQUEST['curr'.$field_bracket_removed[$cnt_key]]))
                            {
                            $curr =  '';
                            for($i=0; $i<count($_REQUEST['curr'.$field_bracket_removed[$cnt_key]]);$i++)
                            {
                            $files .= $_REQUEST['curr'.$field_bracket_removed[$cnt_key]][$i].',';
                            }
                            }

                            if(!is_null(Input::file($field_bracket_removed)))
                            {

                            $destinationPath = '.'. $f['option']['path_to_upload'];
                            foreach($_FILES[$field_bracket_removed[$cnt_key]]['tmp_name'] as $key => $tmp_name ){
                            $file_name = $_FILES[$field_bracket_removed[$cnt_key]]['name'][$key];
                            $file_tmp =$_FILES[$field_bracket_removed[$cnt_key]]['tmp_name'][$key];
                            if($file_name !='')
                            {
                            move_uploaded_file($file_tmp,$destinationPath.'/'.$file_name);
                            $files .= $file_name.',';

                            }

                            }

                            if($files !='') $files = substr($files,0,strlen($files)-1);
                            }
                            $data[$field_bulk_removed][$cnt_key] = $files;


                            }
                            else
                            {



                            if(!is_null(Input::file($field_bracket_removed[$cnt_key])))
                            {

                            $file = Input::file($field_bracket_removed[$cnt_key]);
                            $destinationPath = public_path(). $f['option']['path_to_upload'];
                            $filename = $file->getClientOriginalName();
                            $extension =$file->getClientOriginalExtension(); //if you need extension of the file
                            $rand = rand(1000,100000000);
                            $newfilename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;
                            $uploadSuccess = $file->move($destinationPath, $newfilename);
                            if($f['option']['resize_width'] != '0' && $f['option']['resize_width'] !='')
                            {
                            if( $f['option']['resize_height'] ==0 )
                            {
                            $f['option']['resize_height']   = $f['option']['resize_width'];
                            }
                            $orgFile = $destinationPath.'/'.$newfilename;
                            \SiteHelpers::cropImage($f['option']['resize_width'] , $f['option']['resize_height'] , $orgFile ,  $extension,   $orgFile)  ;
                            }

                            if( $uploadSuccess )
                            {
                            $data[$field_bulk_removed][$cnt_key] = $newfilename;
                            }
                            }
                            else
                            {
                            unset($data[$field_bracket_removed[$cnt_key]]);
                            }
                            }
                            }

                            // if post is checkbox
                            if($f['type'] =='checkbox')
                            {
                            if(!is_null($form_post_field))
                            {
                            // $data[$field] = implode(",",$_REQUEST[$field]);
                                $data[$field_bulk_removed][$cnt_key] = implode(",",$form_post_field);

                            }
                            }

                            // if post is date
                            if($f['type'] =='date')
                            {

                            $data[$field_bulk_removed][$cnt_key] = date("Y-m-d",strtotime($form_post_field));

                            }

                            // if post is seelct multiple
                            if($f['type'] =='select')
                            {

                            if( isset($f['option']['select_multiple']) &&  $f['option']['select_multiple'] ==1 )
                            {
                            $multival = (is_array($form_post_field) ? implode(",",$form_post_field) :  $form_post_field);
                            $data[$field_bulk_removed][$cnt_key] = $multival;

                            }
                            else if(isset($form_post_field))
                            {

                            $data[$field_bulk_removed][$cnt_key] = $form_post_field;
                            //dd($table_field);

                            }
                            }
                        }
                        $global = (isset($this->access['is_global']) ? $this->access['is_global'] : 0 );
                        if($global == 0 )
                        {
                        $data['created_by'][$cnt_key] = 1;
                        $data['created_at'][$cnt_key]= date('Y-m-d');
                        $data['last_updated_by'][$cnt_key] = 1;
                        $data['updated_at'][$cnt_key] = date('Y-m-d');
                        }
                    }
                }


            }


        }

    }

    //dd($data,auth()->user());
//dd($data);
    return $data;
    }

    function Configtabledata($table=null)
{

$new_field_data=array();

$get_table_columns="SHOW COLUMNS FROM $table";
$col_data=\DB::select($get_table_columns);

if(!empty($col_data))
{
    // HEADER AND LABEL DETAILS
$new_field_data['tablePimarykey']='';

    foreach($col_data as $key=>$field)
    {
        $table_field_key=$field->Key;
        $field=$field->Field;

        $new_field_data['field_data'][$field]=$field;


        if($table_field_key=="PRI")
        {
        $new_field_data['tablePimarykey']=$field;
        }

        //dd($table_field_key,$new_field_data);


    }
}

return $new_field_data;

}
    /*deepika purpose:seqno for batch in job card*/
    public function BatchSeqno($seqname,$seqname1,$seqno,$table,$type)
{


//$seqno = \DB::table($table)->count('seq_count');

    $seqname = $seqname;

    $seqno = sprintf('%03d',$seqno+1);

return $seqname.$seqno.$seqname1;
}
/*end*/
public function Seqno($seqname,$table,$type)
{


$seqno = \DB::table($table)->count();


if($type == "LABOUR")
{
    $seqname = $seqname.'L';
}
if($type =="STANDARD")
{
    $seqname = $seqname.'S';
}
    $seqno = sprintf('%03d',$seqno+1);

return $seqname.$seqno;
}

public function Seqnoe($seqname,$table,$type,$column)
{


     $seqno = \DB::table($table)->where('location_id',\Session::get('location'))->orderBy($column,'desc')->get();

    if(count($seqno)>0)
    {
         $seqno = $count = $seqno[0]->{$column};
    }
    else
    {
        $seqno = $count = 0;
    }

if($type == "LABOUR")
{
    $seqname = $seqname.'L';
}
if($type =="STANDARD")
{
    $seqname = $seqname.'S';
}
    if($type =="SAMPLE")
{
    $seqname = $seqname.'SM';
}
$y = date('Y');
                    $nxt = date('Y',strtotime('+1 year'));
    $seqno = sprintf('%03d',$seqno+1);
    $count = $count+1;
if($table == "s_dispatch_hdr_t"){
	$out_put[0] = $seqname."-".$y.$nxt.$seqno;
}else{
	$out_put[0] = $seqname.$seqno;
}
    
    $out_put[1] = $count;


    return $out_put;

}

    public function Seqnoapproved($seqname,$table,$type,$column,$status,$page_module,$count_column)
    {
        if($page_module == "salesinvoice")
        {
            $seqno = \DB::table($table)->where($column,$status)->orderBy($count_column,'desc')->get();
            if(count($seqno)>0)
            {
                 $seqno = $count = $seqno[0]->{$count_column};
            }
            else
            {
                $seqno = $count = 0;
            }
        }
        else
        {
            $seqno = \DB::table($table)->orderBy($count_column,'desc')->get();
            if(count($seqno)>0)
            {
                $seqno = $count = $seqno[0]->{$count_column};
            }
            else
            {
                $seqno = $count= 0;
            }
        }

        if($type == "LABOUR")
        {
            $seqname = $seqname.'L';
        }
        if($type =="STANDARD")
        {
            $seqname = $seqname.'S';
        }
		if($type =="SAMPLE")
         {
         $seqname = $seqname.'SM';
         }
$y = date('Y');
                    $nxt = date('Y',strtotime('+1 year'));
        $seqno = sprintf('%03d',$seqno+1);
        $count = $count+1;
         if($page_module == "salesinvoice")
        {
        	$out_put[0] = $seqname."-".$y.$nxt.$seqno;
        }else{
        $out_put[0] = $seqname.$seqno;	
        }

        $out_put[1] = $count;


    return $out_put;

    }
/*deepika purpose:to get qoh for product*/
public function Qohdetails($prdid=null,$orgid=null){
    if($orgid==''){
        $orgid=2;
    }
$sql="SELECT sum(qohtbl.available_qoh) as totalqoh from (SELECT
    i_qoh_detail_t.qoh_trx_qty,
    i_reservation_detail_t.reserv_trx_qty,
    (
        i_qoh_detail_t.qoh_trx_qty - i_reservation_detail_t.reserv_trx_qty
    ) AS available_qoh
FROM
    i_qoh_detail_t
LEFT JOIN i_reservation_detail_t ON
    (
        i_reservation_detail_t.product_id = i_qoh_detail_t.product_id
    )
LEFT JOIN m_products_t ON
    (
        m_products_t.product_id = i_qoh_detail_t.product_id
    )
WHERE
    1 = 1 AND m_products_t.product_id = ".$prdid." and i_qoh_detail_t.organization_id=".$orgid."
group by
 i_qoh_detail_t.product_id
ORDER BY
    i_qoh_detail_t.product_id) qohtbl";
        $qohresult=\DB::Select($qoh);
        return $qohresult[0]->totalqoh;
    }



public function pricelistdetails($pid=null,$pricelistid)
{
$prd_data=array();
  
if($pid !='')
{
    $plist=\DB::table('i_pricelist_lines_t')->where('pricelist_hdr_id',$pricelistid)->where('product_id',$pid)->get();
    if($plist->isEmpty())
    {
    $unitprice = '0.00';
    }
    else
    {
    $unitprice = $plist[0]->unit_price;
    }
    //return $unitprice;
}
else
{
$unitprice = '0.00';
}

return $unitprice;
}
public function customerpricelist($id)
{

    if($id !='')
    {
    $plist=\DB::table('m_customers_t')->where('customer_id',$id)->get();
        if($plist->isNotEmpty())
        {  //dd($plist);

            return $plist[0]->pricelist_id;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 0;
    }
}
/*Karthigaa Purpose For Supplier Based Pricelist load*/
public function supplierpricelist($id)
{
    if($id !='')
    {
       $plist=\DB::table('m_supplier_t')->where('supplier_id',$id)->get();

        if($plist->isNotEmpty())
        {
      $suppdatas1['supplier_id']=$plist[0]->supplier_id;
      $suppdatas1['supplier_type_id']=$plist[0]->supplier_type_id;
      $suppdatas1['default_payment_terms_id']=$plist[0]->default_payment_terms_id;
      $suppdatas1['default_payment_method_id']=$plist[0]->default_payment_method_id;
      $suppdatas1['delivery_terms_id']=$plist[0]->delivery_terms_id;
            $suppdatas1['insurance_term_id']=$plist[0]->insurance_term_id;
            $suppdatas1['frieghtterm_id']=$plist[0]->frieghtterm_id;
            $suppdatas1['frieghtcarriers_id']=$plist[0]->frieghtcarriers_id;

            //$supsite=\DB::select("select supplier_site_id,supplier_site_name from m_supplier_sites_t where supplier_id='".$suppdatas[0]->supplier_id."' and primary_address='YES'");
       $supsite=\DB::select("select supplier_site_id,supplier_site_name from m_supplier_sites_t where supplier_id='".$id."'");
    if(!empty($supsite))
            $suppdatas1['supplier_site_id']=$supsite[0]->supplier_site_id;
    else
        $suppdatas1['supplier_site_id']=0;

$suppdatas1['price_list']=$plist[0]->default_pricelist_id;
           // dd($suppdatas1);

            return $suppdatas1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 0;
    }
}

  function getLocationaddress(){
        $sql=array();
        $location=\Session::get('location');

       $sql=\DB::SELECT('select * from m_location_t where location_id='.$location.'');
        if(!empty($sql)){
            return $sql;
        }else{
            return 0;
        }
}
function getCompany()
    {
        $sql=array();
        $company=\Session::get('location');
        $sql=\DB::SELECT("SELECT company_id,company_name FROM `m_company_t` WHERE `company_id`=".$company."");
        if(!empty($sql))
        {
        return $sql;
        }
        else
        {
        return 0;
        }
    }
    function getCity($id=null){
        $sql=array();

        $sql=\DB::SELECT('select city_id,city_name from m_cities_t where city_id='.$id.'');
        if(!empty($sql)){
            return $sql[0]->city_name;
        }else{
            return 0;
        }

    }    function getState($id=null){
        $sql=array();

        $sql=\DB::SELECT('select state_id,state_name from m_states_t where state_id='.$id.'');
        if(!empty($sql)){
            return $sql[0]->state_name;
        }else{
            return 0;
        }

    }
    function getCountry($id=null){
        $sql=array();
        $sql=\DB::SELECT('select country_id,country_name from m_countries_t where country_id ='.$id.'');
        if(!empty($sql)){
            return $sql[0]->country_name;
        }else{
            return 0;
        }
    }

    function getSuppliersite($id=null)
        {
            $sql=array();
               $sql=\DB::SELECT('select * from m_supplier_sites_t where supplier_id='.$id.'');

            if(!empty($sql))
            {
                return $sql;
            }
            else
            {
                return 0;
            }
        }

    function getSupplier($id=null)
    {
        $sql=array();
       $sql=\DB::SELECT('select * from m_supplier_t where supplier_id='.$id.'');
        if(!empty($sql)){
            return $sql;
        }else{
            return 0;
        }

    }
    public function getpriceproduct($id=null,$pid=null)
    {

        if(isset($_GET['condition'])){

            $con=\DB::select("SELECT select_option FROM `m_product_setting_t` WHERE module_name='".$_GET['condition']."'");

            if(count($con)>0){
                $cond=$con[0]->select_option;
            }
            else{
                $cond='concatenated_product';
            }
        }
        else{
            $cond='concatenated_product';
        }
        $productid=\DB::select("SELECT   CONCAT(".$cond.") as name,m_products_t.product_id as id FROM i_pricelist_lines_t JOIN m_products_t ON i_pricelist_lines_t.product_id=m_products_t.product_id WHERE i_pricelist_lines_t.pricelist_hdr_id='$id' and i_pricelist_lines_t.active='Yes'");

        $this->data['productid']='<option value="">-- Please Select --</option>';

        foreach ($productid as $key => $value) {
            if($value->id==$pid)
                $select="selected";
            else
                $select='';

            $this->data['productid'].="<option value=".$value->id." ".$select.">".$value->name."</option>";
        }

        return $this->data['productid'];    //dd($this->data['productid']);
    }

    public function productgroupid(){

        $module_name = $_GET['module_name'];

        $query = DB::table('m_product_setting_t')->where('module_name',$module_name)->get();

        $group_id = $query[0]->product_group_id;
        return $group_id;
    }
    public function jCombodiscount($table,$option,$display,$selects)
{
            $compy=\Session::get('companyid');
$display_name=explode("|",$display);
$dis="";
foreach($display_name as $value)
{
$dis.=$value.","."' - ', ";
}

$dis_name=rtrim($dis,",' - ',");
//dd("select DISTINCT CONCAT(".$dis_name.") as name,display_name ,".$option." from ".$table);
$select=\DB::select("select DISTINCT CONCAT(".$dis_name.") as name,default_discount_amount ,".$option." from ".$table." where company_id=".$compy." and active='Yes'");
$html="<option value=''>-- Please Select --</option>";
foreach($select as $val)
{
if($val->$option==$selects)
{
$html.= "<option value='".$val->$option."' data-display='".$val->default_discount_amount."' selected='selected'>".$val->name."</option>";
}
else
{
$html.= "<option value='".$val->$option."'  data-display='".$val->default_discount_amount."' >".$val->name."</option>";
}
}
return $html;
}

public function Approvaldatacheck($module=null,$total=null){
    $wh="";
    
    if($module=='poquote'){
        $wh.= " and m_approvalsettings_hdr_t.module_name='Purchase Quotation Approval' and $total between m_approvalsettings_line_t.value_from and m_approvalsettings_line_t.value_to";
    }else if($module=='poinvoice'){
    $wh.= " and m_approvalsettings_hdr_t.module_name='Purchase Invoice Approval' and $total between m_approvalsettings_line_t.value_from and m_approvalsettings_line_t.value_to";

    }else if($module=='poorder'){
    $wh.= " and m_approvalsettings_hdr_t.module_name='Purchaseorder Approval' and $total between m_approvalsettings_line_t.value_from and m_approvalsettings_line_t.value_to";
    }else if($module=='soinvoice'){
        $wh.= " and m_approvalsettings_hdr_t.module_name='Sales Invoice Approval' and $total between m_approvalsettings_line_t.value_from and m_approvalsettings_line_t.value_to";
    }else if($module=='soquote'){
        $wh.= " and m_approvalsettings_hdr_t.module_name='Sales Quote Approval' and $total between m_approvalsettings_line_t.value_from and m_approvalsettings_line_t.value_to";
    }else if($module=='soorder'){
        $wh.= " and m_approvalsettings_hdr_t.module_name='Sales Order Approval' and $total between m_approvalsettings_line_t.value_from and m_approvalsettings_line_t.value_to";
    }
 $sql_chk = \DB::SELECT("select m_approvalsettings_hdr_t.*,m_approvalsettings_line_t.* from m_approvalsettings_hdr_t left join m_approvalsettings_line_t on (m_approvalsettings_hdr_t.approvalsettings_hdr_id=m_approvalsettings_line_t.approvalsettings_hdr_id) Where 1=1 $wh and m_approvalsettings_line_t.approve_required='Yes'");
 
            if(count($sql_chk)>0){
                $data['approver_id'] = $sql_chk[0]->approver_id;
                return $data['approver_id'];
            }else{
                return 0;
            }

}
 public function timeoutcheck()
 {
     if(isset($_GET['popup']))
     {
       setcookie("popup","ok");
     }
 else {
         
 
     if (isset($_COOKIE["start"]) and $_COOKIE["start"]<time()){
         setcookie("popup","yes");
         if(isset($_COOKIE["popup"]) and $_COOKIE["popup"]=="yes")
         {
          $return ="2";   
         }
         else if(isset($_COOKIE["popup"]) and $_COOKIE["popup"]=="ok")
         {
       $return ="3";
         }
 else {
      $return ="1";
 }
         return $return;
     }else{
           setcookie("popup","no");
           $return['time']=\Session::get('session_time');
           $return['return']="4";
         return $return;
     }
 }
 }
/*deepika purpose:to save audit log details*/	
public function auditlog($id=null,$module=null,$action=null,$note=null,$table_name=null){
   
	  $data['ipaddress']=$_SERVER['REMOTE_ADDR'];
	  $data['primary_id']=$id;
	  $data['module']=$module;
	  $data['action']=$action;
	  $data['note']=json_encode($note);
	  $data['table_name']=$table_name;
	  $data['company_id']=\Session::get('companyid');
	  $data['location_id']=\Session::get('location');
	  $data['organization_id']=\Session::get('organization');
	  $data['created_by']=\Session::get('id');
	  $data['created_at']=date('Y-m-d H:i:s');
	  $data['last_updated_by']=\Session::get('id');
	  $data['last_updated_at']=date('Y-m-d H:i:s');
          \DB::table('tb_logs')->insert($data);
}
/*end*/	

 public function passwordhash()
    {
     // dd("Dsds");
        echo \Crypt::encrypt("WAft345123dsedasdQWE".$_POST['password'].'AC#$1235');
    }
public function getNotySettings($location,$dept_id,$module){
    $noti_setting = \DB::select("select * from m_mailsetting_lines_tbl
                                          left join m_mailsetting_hrd_tbl  on m_mailsetting_lines_tbl.mailsetting_hrd_id = m_mailsetting_hrd_tbl.mailsetting_hrd_id 
                                          where m_mailsetting_hrd_tbl.active='Yes' 
                                            and m_mailsetting_hrd_tbl.location_id='".$location."' and module='$module'");
    $to='';$cc='';
   // print_r($noti_setting);
    if(count($noti_setting)>0){
        $usr = array();
       // print_r($noti_setting);
        foreach($noti_setting as $nkey=>$nval){
            $dept = $nval->department_id;
            $desig = $nval->designation_id;
            $type = $nval->type;
            //print_r($type);
            $user = \DB::table('tb_users')->where('designation_id',$desig)->where('machine_department_id',$dept)->get();
            foreach($user as $uk=>$uv){
                
                if(!in_array($uv->id,$usr)){
                    if($type=='TO'){
                        $usr[] = $uv->id;
                        $to.=$uv->id.','; 
                    }else{
                        $usr[] = $uv->id;
                        $cc.=$uv->id.','; 
                    }
                }
            }
        }
        if($noti_setting[0]->created_by_mail=='Yes'){
            $user = \DB::table('tb_users')->where('machine_department_id',$dept_id)->get();
            foreach($user as $uk1=>$uv1){
                if(!in_array($uv1->id,$usr)){
                    $usr[] = $uv1->id;
                    $to.=$uv1->id.','; 
                }
            }
        }
    }
  
    $this->data['to'] = rtrim($to, ',');
    $this->data['cc'] = rtrim($cc, ',');
    
    return $this->data;
             
}

public function escalationmail(){
    $escalation_hdr = \DB::select("select * from m_escalation_hrd_tbl where active='Yes'");
    // $escalation_data = \DB::select("select * from m_escalation_lines_tbl join m_escalation_hrd_tbl on m_escalation_hrd_tbl.escalation_hrd_id = m_escalation_lines_tbl.escalation_hrd_id where active='Yes'");
    foreach($escalation_hdr as $k=>$v){
        // print_r($v);

        $condition = $v->condition;
        $hdr = $v->escalation_hrd_id;
        $severity = $v->severity;
        $location = $v->location_id;
        $escalation_lines = \DB::select("select * from m_escalation_lines_tbl 
                    left join duration_tbl on duration_tbl.duration_id = m_escalation_lines_tbl.duration 
                    where escalation_hrd_id='$hdr'");
        $to_mail = $cc_mail = '';
        
        foreach($escalation_lines as $lk=>$lv){
            $usr = array();
            $to_mailids = array();
            $cc_mailids = array();
            $no_hrs = $lv->no_hrs;
            $from = $lv->from_hrs;
            $to = $lv->to_hrs;
            $department_id = $lv->department_id;
            $designation_id = $lv->designation_id;
            $level = $lv->level;
            $type = $lv->type;
            
            $to_mail = $cc_mail = '';
            
            $user1 = \DB::table('tb_users')->where('designation_id',$designation_id)->where('machine_department_id',$department_id)->get();
            // print_R($user1);

            foreach($user1 as $uk=>$uv){
                
                if(!in_array($uv->id,$usr)){
                    if($type=='TO'){
                        $usr[] = $uv->id;
                        $to_mail.=$uv->id.','; 
                        $to_mailids[] = $uv->email;
                    }else{
                        $usr[] = $uv->id;
                        $cc_mail.=$uv->id.','; 
                        $cc_mailids[] = $uv->email;
                    }
                }
            }
            
            $half=0;
            if($from=='0.5' || $to=='0.5'){$from=$from*60;$to=$to*60;$half=1;}
            // print_r($severity);
            $wh=" and breakdown_sevearity='$severity'";
            $cstatus = '';
            $history = '';
            if($condition==1){
                $wh.=" and request_status='OPEN'";
                $cstatus = "Ticket Not Yet Allocated";
            }else if($condition==2){
                $wh.=" and request_status='INITIATED'";
                $cstatus = "Ticket Closure Request Not Yet Raised";
            }else if($condition==3){
                $wh.=" and request_status='REQUESTED'";
                $cstatus = "Ticket Closure Request Not Yet Acknowledged";
            }else if($condition==4){
                $wh.=" and (request_status='APPROVED' or request_status='REJECTED')";
                $cstatus = "Ticket Not Yet Closed";
            }

            if($half==0){
                $wh.=" and TIMESTAMPDIFF(HOUR,issue_created_on,CURRENT_TIMESTAMP()) between '$from' and '$to' ";
            }else{
                $wh.=" and TIMESTAMPDIFF(MINUTE,issue_created_on,CURRENT_TIMESTAMP()) between '$from' and '$to' ";
            }
                
            $breakdown = \DB::select("select * from b_maintenance_t left join machine_hdr_t on machine_hdr_t.machine_id = b_maintenance_t.machine_id where 1=1 $wh");
           
            //  echo '1';
            //  print_r($breakdown);
            $usr1 = array();
            
            foreach($breakdown as $bk=>$bv){
                $to_mail_ids = array();
                $to_mail1 = '';
                
// echo '2'.'-'.$lk."\r\n";
                
                $data['cstatus'] = $cstatus;
                $data['level'] = $level;
                $data['ticket_no'] = $bv->ticket_number;
                $data['ticket_status'] =  $bv->request_status;
                $data['dept_id'] =  $bv->department_id;
                $data['machine_name'] =  $bv->machine_name;
                $data['machine_no'] =  $bv->machine_no;
                $data['asset_code'] =  $bv->asset_code;

                $data['tiket_created_by'] =  $this->getusername($bv->issue_created_by);
                $data['tiket_created_on'] =  $bv->issue_created_on;

                $data['allocate_by'] =  $this->getusername($bv->allocate_engineer_by);
                $data['allocate_on'] =  $bv->allocate_engineer_on;

                $data['request_by'] =  $this->getusername($bv->request_request_by);
                $data['request_on'] =  $bv->request_request_on;

                $data['approve_by'] =  $this->getusername($bv->request_approve_by);
                $data['apporve_on'] =  $bv->request_approve_on;
                
                $data['closed_by'] =  $this->getusername($bv->closed_engineer_by);
                $data['closed_on'] =  $bv->closed_engineer_on;
        //  print_r($bk);       
// if($bk==1){$bv->department_id=2;}
                if($v->created_by_mail=='Yes'){
                    $user = \DB::table('tb_users')->where('machine_department_id',$bv->department_id)->get();
                    // if($bk==1){print_r($uv1);}
                    foreach($user as $uk1=>$uv1){
                        // if($bk==1){print_r($uv1->id,);}
                        
                        if(!in_array($uv1->id,$usr1) && !in_array($uv1->id,$usr)){
                           
                            $usr1[] = $uv1->id;
                            $to_mail1.=$uv1->id.','; 
                            $to_mail_ids[] = $uv1->email;
                        }
                    }
                }
                
                $data['history']="";
                if($condition==1){
                    $data['history'].= "Ticket Generated by ".$data['tiket_created_by']." (".$data['tiket_created_on'].")"."\r\n"."<br>";
                }else if($condition==2){
                    $data['history'].= "Ticket Generated by ".$data['tiket_created_by']." (".$data['tiket_created_on'].")"."\r\n"."<br>";
                    $data['history'].= "Ticket Allocated by ".$data['allocate_by']." (".$data['allocate_on'].")"."\r\n"."<br>";
                }else if($condition==3){
                    $data['history'].= "Ticket Generated by ".$data['tiket_created_by']." (".$data['tiket_created_on'].")"."\r\n"."<br>";
                    $data['history'].= "Ticket Allocated by ".$data['allocate_by']." (".$data['allocate_on'].")"."\r\n"."<br>";
                    $data['history'].= "Ticket Closure Request Raised by ".$data['request_by']." (".$data['request_on'].")"."\r\n"."<br>";
                }else if($condition==4){
                    $data['history'].= "Ticket Generated by ".$data['tiket_created_by']." (".$data['tiket_created_on'].")"."\r\n"."<br>";
                    $data['history'].= "Ticket Allocated by ".$data['allocate_by']." (".$data['allocate_on'].")"."\r\n"."<br>";
                    $data['history'].= "Ticket Closure Request Raised by ".$data['request_by']." (".$data['request_on'].")"."\r\n"."<br>";
                    $data['history'].= "Ticket Closure Request ".$data['ticket_status']." by ".$data['closed_by']." (".$data['closed_on'].")"."\r\n"."<br>";
                }
                // print_r($data);die;
                $tomailids = array_merge($to_mailids,$to_mail_ids);
                $ccmailids = $cc_mailids;
                $subject = $data['level'].' - '.$data['cstatus'].' ['.$data['ticket_no'].']';
                $data['msg'] = $data['level'].' - '.$data['cstatus'].' ['.$data['ticket_no'].'] on Machine - ['.$data['asset_code'].'-'.$data['machine_name'].']';
// print_r($tomailids);echo "\r\n";print_r($ccmailids);die;
                \Mail::send('sendescalationmail',$data, function($message) use($tomailids,$ccmailids,$subject)
                {
                    foreach($tomailids as $tmk=>$tmv){
                        $message->to($tmv);
                    }
                    foreach($ccmailids as $cmk=>$cmv){
                        $message->cc($cmv);
                    }
                     
                    // $message->to($to);
                    $message->subject($subject);
                    $message->from('no-reply@lntecc.com');
                });
                // die;
            }
            // $to_mail = $cc_mail = '';
        }
       
        
        
    }
    return 'completed';
}

public function getusername($id){
    $user = \DB::table('tb_users')->where('id',$id)->get();
    
    if(count($user)>0){
        $data['user_name'] = $user[0]->employee_number.'-'.$user[0]->first_name.' '.$user[0]->last_name;
    }else{
        $data['user_name'] = '-';
    }
    return $data['user_name'];
}
public function getTicketHistory($id,$module){
    $history='';
    if($id!=''){
        $breakdown = \DB::select("select * from b_maintenance_t left join machine_hdr_t on machine_hdr_t.machine_id = b_maintenance_t.machine_id where 1=1 and id='$id'");
        if(count($breakdown)>0){
            $bv = $breakdown[0]; 
            $eng_shift = \DB::select("select * from engineer_history_tbl where breakdown_id='".$bv->id."'");
            $history1='';
            if(count($eng_shift)>0){
                foreach($eng_shift as $sk=>$sv){
                    $history1.= "Ticket Allocated by ".$this->getusername($sv->created_by)." to ".$this->getusername($sv->engineer)." (".date('d-m-Y H:i:s',strtotime($sv->created_at)).")"."\r\n"."<br>";
                }
            }
           
            $data['tiket_created_by'] =  $this->getusername($bv->issue_created_by);
            $data['tiket_created_on'] =  $bv->issue_created_on;

            $data['tiket_updated_by'] =  $this->getusername($bv->issue_updated_by);
            $data['tiket_updated_on'] =  $bv->issue_updated_on;
            $data['engineer'] =  $this->getusername($bv->engineer);

            $data['allocate_by'] =  $this->getusername($bv->allocate_engineer_by);
            $data['allocate_on'] =  $bv->allocate_engineer_on;

            $data['request_by'] =  $this->getusername($bv->request_request_by);
            $data['request_on'] =  $bv->request_request_on;

            $data['approve_by'] =  $this->getusername($bv->request_approve_by);
            $data['apporve_on'] =  $bv->request_approve_on;
            
            $data['closed_by'] =  $this->getusername($bv->closed_engineer_by);
            $data['closed_on'] =  $bv->closed_engineer_on;


            if($module=='ticket_updated'){
                $history.= "Ticket Generated by ".$data['tiket_created_by']." (".date('d-m-Y H:i:s',strtotime($data['tiket_created_on'])).")"."\r\n"."<br>";

            }
            if($data['tiket_updated_on']!='' && $data['tiket_updated_on']!='0000-00-00 00:00:00' && $data['tiket_updated_on']!=null){
                $history.= "Ticket Updated by ".$data['tiket_updated_by']." (".$data['tiket_updated_on'].")"."\r\n"."<br>";
            }
            
            if($module=='ticket_allocated'){
                $history.= "Ticket Generated by ".$data['tiket_created_by']." (".date('d-m-Y H:i:s',strtotime($data['tiket_created_on'])).")"."\r\n"."<br>";
                if($history1!=''){
                    $history.=$history1;
                }
            }else if($module=='ticket_requested'){
                $history.= "Ticket Generated by ".$data['tiket_created_by']." (".date('d-m-Y H:i:s',strtotime($data['tiket_created_on'])).")"."\r\n"."<br>";
                if($history1!=''){
                    $history.=$history1;
                }else{
                    $history.= "Ticket Allocated by ".$data['allocate_by']." to ".$data['engineer']." (".date('d-m-Y H:i:s',strtotime($data['allocate_on'])).")"."\r\n"."<br>";
                }
            }else if($module=='ticket_approved'){
                $history.= "Ticket Generated by ".$data['tiket_created_by']." (".date('d-m-Y H:i:s',strtotime($data['tiket_created_on'])).")"."\r\n"."<br>";
                if($history1!=''){
                    $history.=$history1;
                }else{
                    $history.= "Ticket Allocated by ".$data['allocate_by']." to ".$data['engineer']." (".date('d-m-Y H:i:s',strtotime($data['allocate_on'])).")"."\r\n"."<br>";
                }
                $history.= "Ticket Closure Request Raised by ".$data['request_by']." (".date('d-m-Y H:i:s',strtotime($data['request_on'])).")"."\r\n"."<br>";
            }else if($module=='ticket_rejected'){
                $history.= "Ticket Generated by ".$data['tiket_created_by']." (".date('d-m-Y H:i:s',strtotime($data['tiket_created_on'])).")"."\r\n"."<br>";
                if($history1!=''){
                    $history.=$history1;
                }else{
                    $history.= "Ticket Allocated by ".$data['allocate_by']." to ".$data['engineer']." (".date('d-m-Y H:i:s',strtotime($data['allocate_on'])).")"."\r\n"."<br>";
                }
                $history.= "Ticket Closure Request Raised by ".$data['request_by']." (".date('d-m-Y H:i:s',strtotime($data['request_on'])).")"."\r\n"."<br>";
            }else if($module=='ticket_closed'){
                $history.= "Ticket Generated by ".$data['tiket_created_by']." (".date('d-m-Y H:i:s',strtotime($data['tiket_created_on'])).")"."\r\n"."<br>";
                if($history1!=''){
                    $history.=$history1;
                }else{
                    $history.= "Ticket Allocated by ".$data['allocate_by']." to ".$data['engineer']." (".date('d-m-Y H:i:s',strtotime($data['allocate_on'])).")"."\r\n"."<br>";
                }
                $history.= "Ticket Closure Request Raised by ".$data['request_by']." (".date('d-m-Y H:i:s',strtotime($data['request_on'])).")"."\r\n"."<br>";
                $history.= "Ticket Closure Request Approved by ".$data['ticket_status']." by ".$data['closed_by']." (".date('d-m-Y H:i:s',strtotime($data['closed_on'])).")"."\r\n"."<br>";
            }
        }
    }
    return $history;
}

}