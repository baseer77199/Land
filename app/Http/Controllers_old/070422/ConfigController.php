<?php

namespace App\Http\Controllers;

use App\Confighdr;
use App\Configlines;

use Illuminate\Http\Request,DB;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->data=array();
        $this->data['urlmenu']=$this->indexs(); 
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['urlname']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
        $this->data['pageModule']=\Request::route()->getName();
        $this->table="c_config_hdr_t";
        $this->subtable="c_config_lines_t";
        $this->model=new Confighdr;
        $this->submodel=new Configlines;
       
        
    }

   
    /*isac purpose:configuration*/
     public function index1()
    {
       $this->data['pageMethod']=\Request::route()->getName();
        $this->data['urlname']=\Request::route()->getName();
       
    $table=\DB::select("show tables");
    
    $html='<option value="">--Please Select--</option>';
    
    foreach($table as $value)
    {
        
        
        $html.="<option value='".$value->Tables_in_l_t_db."'>".$value->Tables_in_l_t_db."</option>";
        
    }
    $this->data['table']=$html;
             
          return view("configform.fileconfigform",$this->data);

    }

public function gettablefield($table){
  $table=\DB::select("SHOW COLUMNS FROM $table");
   return $table;
    
}
public function configurationdatasave(Request $request){
 
    
    $data = $this->validatePost($_POST,$this->table,'header');
 
        
        $lines_data = $this->validatePost($request->all(),$this->subtable,'lines');
        // dd($data);    
        
        \DB::beginTransaction();
        try
        {
     $id=$this->model->insertRow($data);
     $lid=$this->submodel->subgridSave($lines_data,$id);
   
   
            \DB::commit();
                    /**Auditlog**/
                       if($_POST['config_hdr_id']==""){
                                    $action="Save";
                                    }else{
                                    $action="Update";
                                    }
                  return response()->json(array('status' => 'success', 'message' => 'Config Saved','id' => $id,'lid' => $lid,'auto_no'=>''));
            }
            catch (\Illuminate\Database\QueryException$e)
            {
                $message = explode('(', $e->getMessage());
                $dbCode = rtrim($message[0], ']');
                $dbCode = trim($dbCode, '[');
                dd($dbCode);
                \DB::rollback();
                return response()->json(array('status' => 'error', 'message' => 'DatabaseError:=>' . $dbCode . "\n"));
            }
    
    
   
}
/*end*/
  public function uploadindex()
    {
       $this->data['pageMethod']=\Request::route()->getName();
        $this->data['urlname']=\Request::route()->getName();
		$module = '';
		if($this->data['urlname']=='agencyupload'){
			$module = 31;
		}else if($this->data['urlname']=='vendorupload'){
			$module = 32;
		}else if($this->data['urlname']=='sparesupload'){
			$module = 33;
		}else if($this->data['urlname']=='departmentupload'){
			$module = 34;
		}else if($this->data['urlname']=='breakdowntypeupload'){
			$module = 35;
		}else if($this->data['urlname']=='designationupload'){
			$module = 37;
		}else if($this->data['urlname']=='userupload'){
			$module = 38;
		}
		
        $this->data['module_name']=$this->jcombocomp('c_config_hdr_t','config_hdr_id','module_name',$module);
 return view ('configform.uploadconfig',$this->data);
    }
/*end*/	
 /* deepika purpose:download template with dynamic title*/  
    function getDownloadtemplate($module = null) {
         $sql_c = \DB::table('c_config_hdr_t')->leftjoin('c_config_lines_t','c_config_lines_t.config_hdr_id','=','c_config_hdr_t.config_hdr_id')->where('c_config_hdr_t.config_hdr_id',$module)->where('c_config_lines_t.type','Yes')->select('c_config_hdr_t.module_name','c_config_lines_t.title')->get();
     
			$a1=array();
		foreach($sql_c as $k=>$v){
		$level= json_decode(json_encode($v->title),true);
			array_push($a1,$level);
		}
				$arr=$a1;
	$module1=$sql_c[0]->module_name;
        if (!empty($sql_c)) {
                $result = array_map(function ($item) {
                    return $item;
                },$arr );
			 // array_unshift($result, 'PS DATE');
                 $filepath =$module1.' TEMPLATE.csv';
                array_map('unlink', glob("uploads/".$module1." TEMPLATE"));
                $output = fopen("uploads/". $filepath, 'w+');
                $re[0] = $result;
          
                fputcsv($output, $re[0]);
               // fputcsv($output, $re[1]);
                return array('status' => 1);
           
        } else {
            return array('status' => 0);
        }
    }

/*End*/ 
/*Vignesh purpose:upload config save*/

  public function uploadsave(Request $request)
    {

if($_POST['stage']=='1')
{
    
    	if (!is_null(\Input::file('upload_file')))
        {

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

                if($c == 0) {
                $filesop;

                }

       break;

                }

             

            }
        }
            else
            {
            	return response()->json(array(
				'message'	=> "Upload CSV File",
				'status'	=> 'error'
			));
            }
    
    $option="<option value=''>--Please Select--</option>";
    foreach($filesop  as $k=>$v)
    {
      $option.="<option value='".$k."'>$v</option>";  
    }
    
    
    //dd($option);
    
    
     $column_names = \DB::select("SELECT c_config_lines_t.field,c_config_lines_t.title FROM `c_config_lines_t` where type='Yes' and config_hdr_id='".$_POST['module_name']."'");

            $column_fields ='';
            foreach($column_names as $key=>$fields)
            {

          $column_fields.='<div class="form-group row col-md-4">
                    <label for="inputIsValid" class="form-control-label col-md-4">'.$fields->title.'</label>
                    <div class="col-md-8">
                        <select name="'.$fields->field.'" class="form-control select2 field'.$key.'"  tabindex="'.($key+1).'" >
                            '.$option.'
                        </select>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>';
            }
           $column_fields.='<div class="row">
<button type="button" name="upload" id="upload" class="upload btn btn-primary btn-sm saveform"><i class="fa  fa-save "></i>  Upload </button>                              
 
</div>';
            
            foreach($column_names as $key=>$fields)
            {
                $p=0;
                
              foreach($filesop  as $k=>$v)
    {
     $sim = similar_text($fields->title,$v, $perc);
     

     if($p<$perc)
     {
       $column_names[$key]->position=$k;
       $p=$perc;
     }

        
    }
                
            }
            

          			return response()->json(array(
				'filesop'=>$column_names,
				'table_fields'=>$column_fields,
				'status'=> 'mapping'
			));




}
else
{
    
     $file = $request->file('upload_file');
         $destinationPath = './uploads/templte/';
         $path = $_FILES['upload_file']['name'];
         $extension = pathinfo($path, PATHINFO_EXTENSION);
         $file = $_FILES['upload_file']['tmp_name'];
         $handle = fopen($file, "r");
         $c = 0;
 $column_names = \DB::select("SELECT * FROM `c_config_lines_t` where type='Yes' and config_hdr_id='".$_POST['module_name']."'");

            $column_fields ='';
       
        $table = \DB::select("select module_table,module_table_pk from c_config_hdr_t where c_config_hdr_t.config_hdr_id='".$_POST['module_name']."'");
        //dd($table)
        $pk=$table[0]->module_table_pk;
        $table=$table[0]->module_table;
         if(isset($_POST['read_option'])){
                $read_option = $_POST['read_option'];
            }else{
                $read_option = 'Clone';
            }  
       
          
$total_record=0;
$skip=0;
$clone=0;
$overwrite=0;
$new=0;
$excel=array();
       if ($extension == "csv") {

            while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
               // dd($_POST);
                if($c > 0) {
                $insert=array();
                $s=1;
                $total_record++;
                $excel[$c]=(object)array();
                $reason='';
 foreach($column_names as $key=>$fields)
            {
				if($_POST['module_name']!=38){
					$insert['location_id']=\Session::get('location');
					$insert['company_id']=\Session::get('companyid');
					$insert['organization_id']=\Session::get('organization');
					$insert['created_by']=\Session::get('emp_id');
				}else{
					$insert['loc_id']=\Session::get('location');
					$insert['company_id']=\Session::get('companyid');
					$insert['org_id']=\Session::get('organization');
					$insert['password']=bcrypt('welcome123');
					//$insert['created_by']=\Session::get('emp_id');
				}
				$ins_id = 0;
				$upd_id = 0;
              // dd($fields); 
               if($fields->field_type=='Select')
               {
                   $name=$filesop[$_POST[$fields->field]];
                   
                   $d=\DB::select("select ".$fields->select_option_pri_id." from ".$fields->select_option_tbl." where ".$fields->display1."='".$name."' ");
                 if(count($d)>0)
                 {
                    // dd($d);
                   $excel[$c]->{$fields->title}=$name;  
                  $insert[$fields->field]=$d[0]->{$fields->select_option_pri_id}; 
                 }
                  else
                  {
                      $excel[$c]->{$fields->title}=$name; 
                      $s=0;
                      $reason.=$fields->title." Not available in master,";
                  }
               }
               else
               {
                 $excel[$c]->{$fields->title}=$filesop[$_POST[$fields->field]];   
                 $insert[$fields->field]= $filesop[$_POST[$fields->field]]; 
               }
            }
            if($s==1)
            {
           $where='1=1';
            if(isset($_POST['find_duplicate'])){
             foreach($_POST['find_duplicate'] as $rkey=>$rval){
                 $where .=" and  $rval='".$insert[$rval]."'";
             }   
            }
           if($read_option=='clone')
           {
               $d=\DB::select("select * from $table where $where");
              if(count($d)==0)
              {
                $ins_id = \DB::table($table)->insertGetId($insert); 
                 $new++;
                 $excel[$c]->Status="Upload"; 
              }
              else
              {
                 $ins_id = \DB::table($table)->insertGetId($insert);
                  $clone++;
                  $excel[$c]->Status="Clone"; 
              }

           }
           else if($read_option=='skip')
           {
              $d=\DB::select("select * from $table where $where");
              if(count($d)==0)
              {
                 $ins_id = \DB::table($table)->insertGetId($insert); 
                 $new++;
                 $excel[$c]->Status="Upload"; 
              }
              else
              {
                  $skip++;
                  $excel[$c]->Status="Skip"; 
              }
           }
           else if($read_option=='overwrite')
           {
			   
              $d=\DB::select("select * from $table where $where");
              if(count($d)==0)
              {
                 $ins_id = \DB::table($table)->insertGetId($insert); 
                 $new++;
                 $excel[$c]->Status="Upload"; 
              } 
              else
              {
				//print_r($insert);  
				  //dd($insert);
				  $val = $d[0]->{$pk};
				  //echo $val.'-'.$pk;die;
                $upd_id = \DB::table($table)->where($pk,$val)->update($insert); 
                $overwrite++;
                $excel[$c]->Status="Overwrite"; 
              }
           }
            }else
            {
                $skip++;
                
                $excel[$c]->Status="Skip"; 
                
            }
           $excel[$c]->Reason="$reason"; 
           // dd($insert);
		   if($_POST['module_name']==38){
			   
			   if($ins_id!=0){
				   $user_data = \DB::table('tb_users')->where('id',$ins_id)->get();
				   if(count($user_data)>0){
					   $group = $user_data[0]->group_id;
					   $group_data = \DB::table('a_group_menu_access_t')->where('group_id',$group)->get();
					   if(count($group_data)>0){
						   $acc_data['user_id'] = $ins_id;
						   $acc_data['group_id'] = $group;
						   
						   $acc_data['menus'] = $group_data[0]->menus;
						   $acc_data['permission'] = $group_data[0]->permission;
						   
							$acc_data['location_id']=\Session::get('location');
							$acc_data['company_id']=\Session::get('companyid');
							$acc_data['organization_id']=\Session::get('organization');
							$acc_data['created_by']=\Session::get('emp_id');
							
						   
						   DB::table('a_user_access_t')->insert($acc_data);
					   }
				   }
				   
			   }else if($upd_id!=0){
				   $user_data = \DB::table('tb_users')->where('id',$upd_id)->get();
				   if(count($user_data)>0){
					   $ua_data = \DB::table('a_user_access_t')->where('id',$upd_id)->get();
					   if(count($ua_data)>0){
						   $group = $user_data[0]->group_id;
						   $group_data = \DB::table('a_group_menu_access_t')->where('group_id',$group)->get();
						   if(count($group_data)>0){
							   $acc_data['user_id'] = $ins_id;
							   $acc_data['group_id'] = $group;
							   
							   $acc_data['menus'] = $group_data[0]->menus;
							   $acc_data['permission'] = $group_data[0]->permission;
							   
								$acc_data['location_id']=\Session::get('location');
								$acc_data['company_id']=\Session::get('companyid');
								$acc_data['organization_id']=\Session::get('organization');
								$acc_data['created_by']=\Session::get('emp_id');
								
							   
							   DB::table('a_user_access_t')->where('a_user_access_id',$ua_data[0]->a_user_access_id)->update($acc_data);
						   }

					   }else{
						   $group = $user_data[0]->group_id;
						   $group_data = \DB::table('a_group_menu_access_t')->where('group_id',$group)->get();
						   if(count($group_data)>0){
							   $acc_data['user_id'] = $ins_id;
							   $acc_data['group_id'] = $group;
							   
							   $acc_data['menus'] = $group_data[0]->menus;
							   $acc_data['permission'] = $group_data[0]->permission;
							   
								$acc_data['location_id']=\Session::get('location');
								$acc_data['company_id']=\Session::get('companyid');
								$acc_data['organization_id']=\Session::get('organization');
								$acc_data['created_by']=\Session::get('emp_id');
								
							   
							   DB::table('a_user_access_t')->insert($acc_data);
						   }
					   }
				   }
				   
			   }
		   }
		   
                }

       $c++;

                }
                if(count($excel)>0)
                {
 $excel=collect($excel)->map(function($x){ return (array) $x; })->toArray();
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
 $output = fopen('uploads/upload_log.csv', 'w');     
//dd($excel[1]);
 fputcsv($output, array_keys($excel[1])); 
      foreach($excel as  $row)
{
  
    fputcsv($output, $row); 
   
}
                }       

            }
    
    
    	return response()->json(array(
				'totalrecords'=>$total_record,
				'clone'=>$clone,
				'overwrite'=>$overwrite,
				'skip'=>$skip,
				'new'=>$new,
				'status'=> 'Success'
			));
    
    
}
    
    }
/*End*/
}
