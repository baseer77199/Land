<?php

namespace App\Http\Controllers;

use App\Groupmenuaccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GroupmenuaccessController extends Controller
{
       public $module="Groupmenuaccess";
	public function __construct()
	{
		$this->data=array(
                    'pageModule'=> 'Groupmenuaccess',
                    'pageUrl'	=>  url('Groupmenuaccess')
                  );
                $this->data['urlmenu']=$this->indexs(); 
		$this->pageModule="Groupmenuaccess";

		$this->data['pageModule']=$this->pageModule;
		$this->data['pageMethod']=\Request::route()->getName();
		$this->data['pageFormtype']='ajax';
	}

    public function index()
    {
        $loc=\Session::get('location');
        if($loc != 0){
            // $wh1='and  ma_agency_t.location_id='.$loc;
            $this->data['data'] = \DB::table('a_group_menu_access_t')->join('a_m_group_t', 'a_group_menu_access_t.group_id', '=', 'a_m_group_t.group_id')->select('a_group_menu_access_t.a_group_menu_access_id as menus', 'a_m_group_t.group_name as group_name')->where('a_m_group_t.location_id',$loc)->get();
        }else{
            $this->data['data'] = \DB::table('a_group_menu_access_t')->join('a_m_group_t', 'a_group_menu_access_t.group_id', '=', 'a_m_group_t.group_id')->select('a_group_menu_access_t.a_group_menu_access_id as menus', 'a_m_group_t.group_name as group_name')->get();
        }  
      
      
      return view('groupaccessmenu.table',$this->data);
    }
   
    public function subheadmenu($ids=null)
    {
        $subheadermenu=\DB::table("tb_menus")->select("*")->where("parent_id","=",$ids)->get();
        return $subheadermenu;
    }
  
    public function buttonnameuser($buttonname=null)
    {
              
        $user_id['button']=\DB::table("button_names_tbl")->select("*")->where("module_name","=",$buttonname)->get();
         
         $result = \DB::select("SELECT
                a_company_menu_access_t.permission AS user_access_permission,
                a_group_menu_access_t.permission AS group_access_permission
            FROM
                a_company_menu_access_t
            LEFT JOIN a_group_menu_access_t ON a_group_menu_access_t.companyaccess_id = a_company_menu_access_t.company_id
            WHERE
                a_group_menu_access_t.group_id = '".$_GET['group_id']."'");
         
      
    
            $user_id['user_access_permission']=json_decode($result[0]->user_access_permission);
            $user_id['group_access_permission']=json_decode($result[0]->group_access_permission);
         $html ='<div class="table-responsive "> <table class="table myTable">    <thead>   <th > Sno </th><th>Head Menu Name </th><th><input type="checkbox"  name="checkall" id="child_button" value="1" > </th></thead>';
         $i=1;
         
         foreach($user_id['button'] as $key => $value){
            
             $x = $value->click_name;
             if(isset($user_id['group_access_permission']->{$buttonname}->{$x}))
             {
                 $checked='';
                 if(isset($user_id['user_access_permission']->{$buttonname}->{$x}))
                 {
                     $checked='checked';
                    
                 }
                 
                  $html.='<tr>
                  
                            <td>'.$i.'</td>
                            <td><strong><a  class="button">'.$value->button_name.'</a></strong></td>
                            <td><input type="checkbox" class="button_list '.$value->click_name.$value->button_id.'" name="button['.$value->module_name.']['.$value->click_name.']" value='.$value->button_id.' '.$checked.'></td>
                          </tr>';
                 $i++;
             }
         }
         $html .='</div>';
        
      //dd($user_id);
        return $html;

    }

	   public function indexcompany(){

      $this->data['data'] = \DB::table('a_company_menu_access_t')
            ->join('m_company_t', 'a_company_menu_access_t.company_id', '=', 'm_company_t.company_id')
            ->select('a_company_menu_access_t.a_company_menu_access_id as menus', 'm_company_t.company_name as company_name')
            ->get();
      return view('groupaccessmenu.companytable',$this->data);
   }
	
  public function createcompany($id=null)
    {
     
        if($id != null)
        {
         $headhtml=""; 
        $sub_headhtml=""; 
        $sub_menuhtml=""; 
        $buttonhtml=""; 
        
    $total_menu = \DB::table("tb_menus")->select("*")->where("parent_id","=","0")->get();
    $result = \DB::select("SELECT a_company_menu_access_t.a_company_menu_access_id,a_company_menu_access_t.company_id,a_company_menu_access_t.permission as company_access_menu,a_company_menu_access_t.menus as button_access_menu FROM `a_company_menu_access_t` WHERE a_company_menu_access_t.a_company_menu_access_id='".$id."'");  
     $company_access_menu= get_object_vars(json_decode($result[0]->company_access_menu));
     $button_access_menu= get_object_vars(json_decode($result[0]->button_access_menu));

   
$this->data['company_name']=$this->jCombologin('m_company_t','company_id','company_name',$result[0]->company_id);
$this->data['a_company_menu_access_id']=$result[0]->a_company_menu_access_id;
    
 
 $headhtml .="<div class='col-md-3 headmenu'>  <div class='table-responsive'> <table class='table myTable'> <thead><tr><th>sno</th><th>Head Menu Name</th><th><input type='checkbox' class='head check_head' name='checkall'  value='0'></th></tr> </thead> <tbody>";
  $sub_headhtml.="<div class='col-md-3 sub_menu'>";
  $sub_menuhtml.="<div class='col-md-3 child_menu'>";
  $buttonhtml.="<div class='col-md-3 button_menu'>";
  
      $i=1;
 foreach($total_menu as $k=>$v){  
      
  
      
          $checks='';
           if(isset($button_access_menu[$v->menus_id])){
               $checks='checked';
           }
    $headhtml .= "<tr><td>".$i."</td><td><a class='main_menu headmenus head".$v->menus_id."' href='' data-value=".$v->menus_id.">".$v->menus_name."</a></td><td><input type='checkbox' class='header".$v->menus_id." sub_headmenu0' name='menu_id[".$v->menus_id."]' myval=".$v->menus_id."  ".$checks." value='".$v->menus_name."'></td>  </tr> ";
    $sub_headhtml.="<div id='sub_menu".$v->menus_id."' class='sub_menu_hide'><div class='table-responsive'>  <table class='table myTable'>    <thead> <tr><th> Sno </th> <th>Head Menu Name</th> <th><input type='checkbox' name='checkall1' class='check_head'  value='".$v->menus_id."'> </th> </tr> </thead> <tbody>  ";
    $buttonhtml.="<div id='child_head_menu".$v->menus_id."' > ";
    $subhead_menus = \DB::table("tb_menus")->select("*")->where("parent_id","=",$v->menus_id)->get();
      $i1=1;
  foreach($subhead_menus as $k1=>$v1){
      
          $check='';
           if(isset($button_access_menu[$v1->menus_id])){
               $check='checked';
               
           }
        $sub_headhtml.="<tr><td>".$i1."</td><td><a class='main_menu subheadmenus subhea".$v1->menus_id."' href='' data-value=".$v1->menus_id.">".$v1->menus_name."</a></td><td><input type='checkbox' class='sub_headmenus subhead".$v1->menus_id." sub_headmenu".$v->menus_id."' name='menu_id[".$v1->menus_id."]' ".$check." myval=".$v1->menus_id."   value='".$v1->menus_name."'></td>  </tr> "; 
        $sub_menuhtml.="<div id='sub_head_menu".$v1->menus_id."' class='child_menu_hide'><div class='table-responsive'>  <table class='table myTable'><thead> <tr><th> Sno </th> <th>Head Menu Name</th> <th><input type='checkbox' name='checkall2' class='check_head'  value='".$v1->menus_id."'> </th> </tr> </thead> <tbody> "; 
        $buttonhtml.="<div id='button_menu".$v1->menus_id."' class='button_menu_hide' > "; 
        $childhead_menus = \DB::table("tb_menus")->select("*")->where("parent_id","=",$v1->menus_id)->get();
          $i2=1;
           foreach($childhead_menus as $k2=>$v2){
            
                  
                  $checked='';
           if(isset($button_access_menu[$v2->menus_id])){
               $checked='checked';
           }
                 
              $sub_menuhtml.="<tr><td>".$i2."</td><td><a class='main_menu submenus subtri".$v2->menus_id."' href='' data-value=".$v2->menus_id.">".$v2->menus_name."</a></td><td><input type='checkbox' class='sub_child_menus subheads".$v2->menus_id." sub_headmenu".$v1->menus_id."' name='menu_id[".$v2->menus_id."]'  ".$checked." myval=".$v2->menus_id." value='".$v2->menus_name."'></td>  </tr> ";   
              $buttonhtml.="<div id='button_names".$v2->menus_id."' class='button_menu_hides'><div class='table-responsive'>  <table class='table myTable'><thead> <tr><th> Sno </th> <th>Button Name</th> <th><input type='checkbox' name='checkall3' class='check_head'   value='".$v2->menus_id."'> </th> </tr> </thead> <tbody> "; 
              $childhead_menus = \DB::select("select * from button_names_tbl left join tb_menus on tb_menus.controller_name=button_names_tbl.module_name where tb_menus.menus_id='".$v2->menus_id."'");
             
			 $i3=1;
            foreach($childhead_menus as $k3=>$v3){
             
                      $checkss='';
                  $b_id=$v3->button_id;
                 
                     if(isset($company_access_menu[$v3->module_name])){
                     $b_array=$company_access_menu[$v3->module_name];
                      $b_array1=get_object_vars($b_array);
             if(in_array($b_id,$b_array1) !== False) {
                      $checkss='checked';
           } 
                     }
           
                      $buttonhtml.='<tr>  <td>'.$i3.'</td> <td><strong><a  class="button">'.$v3->button_name.'</a></strong></td>  <td><input type="checkbox" class="button_list '.$v3->click_name.$v3->button_id.' sub_headmenu'.$v2->menus_id.'"   name="button['.$v3->module_name.']['.$v3->click_name.']" value='.$v3->button_id.' '.$checkss.' ></td></tr>';
                      $i3++;
                    
                    }
                      $buttonhtml.="</tbody></table></div></div>";
                      $i2++;
             
      
          }
                     $buttonhtml.="</div>";
                     $sub_menuhtml.="</tbody></table></div></div>";
                     $i1++;
        
      }  
                     $buttonhtml.="</div>"; 
                     $sub_headhtml.="</tbody></table></div></div>";
                     $i++;

  
  }
                     $headhtml .="</tbody>  </table>     </div></div>";
                     $sub_headhtml.="</div>";
                     $sub_menuhtml.="</div>";
                     $buttonhtml.="</div>";
                     $this->data['headhtml']=$headhtml;
                     $this->data['sub_headhtml']=$sub_headhtml; 
                     $this->data['sub_menuhtml']=$sub_menuhtml; 
                     $this->data['buttonhtml']=$buttonhtml; 
      
        }else{
         $headhtml=""; 
        $sub_headhtml=""; 
        $sub_menuhtml=""; 
        $buttonhtml=""; 
        
    $total_menu = \DB::table("tb_menus")->select("*")->where("parent_id","=","0")->get();
 
   
$this->data['company_name']=$this->jCombologin('m_company_t','company_id','company_name','');
$this->data['a_company_menu_access_id']='';
    
 
 $headhtml .="<div class='col-md-3 headmenu'>  <div class='table-responsive'> <table class='table myTable'> <thead><tr><th>sno</th><th>Head Menu Name</th><th><input type='checkbox' class='head check_head' name='checkall'  value='0'></th></tr> </thead> <tbody>";
  $sub_headhtml.="<div class='col-md-3 sub_menu'>";
  $sub_menuhtml.="<div class='col-md-3 child_menu'>";
  $buttonhtml.="<div class='col-md-3 button_menu'>";
  
      $i=1;
 foreach($total_menu as $k=>$v){  
          $checks='';
    $headhtml .= "<tr><td>".$i."</td><td><a class='main_menu headmenus head".$v->menus_id."' href='' data-value=".$v->menus_id.">".$v->menus_name."</a></td><td><input type='checkbox' class='header".$v->menus_id." sub_headmenu0' name='menu_id[".$v->menus_id."]' myval=".$v->menus_id."  ".$checks." value=".$v->menus_name."></td>  </tr> ";
    $sub_headhtml.="<div id='sub_menu".$v->menus_id."' class='sub_menu_hide'><div class='table-responsive'>  <table class='table myTable'>    <thead> <tr><th> Sno </th> <th>Head Menu Name</th> <th><input type='checkbox' name='checkall1' class='check_head'  value='".$v->menus_id."'> </th> </tr> </thead> <tbody>  ";
    $buttonhtml.="<div id='child_head_menu".$v->menus_id."' > ";
    $subhead_menus = \DB::table("tb_menus")->select("*")->where("parent_id","=",$v->menus_id)->get();
      $i1=1;
  foreach($subhead_menus as $k1=>$v1){
    
          $check='';
         
        $sub_headhtml.="<tr><td>".$i1."</td><td><a class='main_menu subheadmenus subhea".$v1->menus_id."' href='' data-value=".$v1->menus_id.">".$v1->menus_name."</a></td><td><input type='checkbox' class='sub_headmenus subhead".$v1->menus_id." sub_headmenu".$v->menus_id."' name='menu_id[".$v1->menus_id."]' ".$check."  myval=".$v1->menus_id."  value=".$v1->menus_name."></td>  </tr> "; 
        $sub_menuhtml.="<div id='sub_head_menu".$v1->menus_id."' class='child_menu_hide'><div class='table-responsive'>  <table class='table myTable'><thead> <tr><th> Sno </th> <th>Head Menu Name</th> <th><input type='checkbox' name='checkall2' class='check_head'  value='".$v1->menus_id."'> </th> </tr> </thead> <tbody> "; 
        $buttonhtml.="<div id='button_menu".$v1->menus_id."' class='button_menu_hide' > "; 
        $childhead_menus = \DB::table("tb_menus")->select("*")->where("parent_id","=",$v1->menus_id)->get();
          $i2=1;
           foreach($childhead_menus as $k2=>$v2){                  
                  $checked='';                 
              $sub_menuhtml.="<tr><td>".$i2."</td><td><a class='main_menu submenus subtri".$v2->menus_id."' href='' data-value=".$v2->menus_id.">".$v2->menus_name."</a></td><td><input type='checkbox' class='sub_child_menus subheads".$v2->menus_id." sub_headmenu".$v1->menus_id."' name='menu_id[".$v2->menus_id."]'  ".$checked." myval=".$v2->menus_id." value=".$v2->menus_name."></td>  </tr> ";   
              $buttonhtml.="<div id='button_names".$v2->menus_id."' class='button_menu_hides'><div class='table-responsive'>  <table class='table myTable'><thead> <tr><th> Sno </th> <th>Button Name</th> <th><input type='checkbox' name='checkall3' class='check_head'   value='".$v2->menus_id."'> </th> </tr> </thead> <tbody> "; 
              $childhead_menus = \DB::select("select * from button_names_tbl left join tb_menus on tb_menus.controller_name=button_names_tbl.module_name where tb_menus.menus_name='".$v2->menus_name."'");
              $i3=1;
            foreach($childhead_menus as $k3=>$v3){
          
                      $checkss='';
                  $b_id=$v3->button_id;
                 
                 
           
                      $buttonhtml.='<tr>  <td>'.$i3.'</td> <td><strong><a  class="button">'.$v3->button_name.'</a></strong></td>  <td><input type="checkbox" class="button_list '.$v3->click_name.$v3->button_id.' sub_headmenu'.$v2->menus_id.'"   name="button['.$v3->module_name.']['.$v3->click_name.']" value='.$v3->button_id.' '.$checkss.' ></td></tr>';
                      $i3++;
                    
                    }
                      $buttonhtml.="</tbody></table></div></div>";
                      $i2++;
             
      
          }
                     $buttonhtml.="</div>";
                     $sub_menuhtml.="</tbody></table></div></div>";
                     $i1++;
        
      }  
                     $buttonhtml.="</div>"; 
                     $sub_headhtml.="</tbody></table></div></div>";
                     $i++;

  
  }
                     $headhtml .="</tbody>  </table>     </div></div>";
                     $sub_headhtml.="</div>";
                     $sub_menuhtml.="</div>";
                     $buttonhtml.="</div>";
                     $this->data['headhtml']=$headhtml;
                     $this->data['sub_headhtml']=$sub_headhtml; 
                     $this->data['sub_menuhtml']=$sub_menuhtml; 
                     $this->data['buttonhtml']=$buttonhtml; 
        }
   
        return view('groupaccessmenu.companyformnew',$this->data);
    }
    public function create($id=null)
    {
         if(isset($_POST['id']))    
    $id=$_POST['id'];
        $headhtml=""; 
        $sub_headhtml=""; 
        $sub_menuhtml=""; 
        $buttonhtml=""; 
        
    $total_menu = \DB::table("tb_menus")->select("*")->where("parent_id","=","0")->get();
    $result = \DB::select("SELECT a_group_menu_access_t.a_group_menu_access_id,a_group_menu_access_t.group_id,a_group_menu_access_t.permission as group_button_access_menu,a_group_menu_access_t.menus as group_access_menu,a_company_menu_access_t.menus as company_access_menu,a_company_menu_access_t.permission as button_access_menu FROM `a_group_menu_access_t` left join a_company_menu_access_t on a_company_menu_access_t.company_id=a_group_menu_access_t.companyaccess_id WHERE a_group_menu_access_t.a_group_menu_access_id='".$id."'");  
     $company_access_menu= get_object_vars(json_decode($result[0]->company_access_menu));
     $button_access_menu= get_object_vars(json_decode($result[0]->button_access_menu));
        $group_access_menu= get_object_vars(json_decode($result[0]->group_access_menu)); 
        $group_button_access_menu= get_object_vars(json_decode($result[0]->group_button_access_menu)); 
   
$this->data['group_name']=$this->jCombologin('a_m_group_t','group_id','group_name',$result[0]->group_id);
$this->data['a_group_menu_access_id']=$result[0]->a_group_menu_access_id;
    
 
 $headhtml .="<div class='col-md-3 headmenu'>  <div class='table-responsive'> <table class='table myTable'> <thead><tr><th>sno</th><th>Head Menu Name</th><th><input type='checkbox' class='head check_head' name='checkall'  value='0'></th></tr> </thead> <tbody>";
  $sub_headhtml.="<div class='col-md-3 sub_menu'>";
  $sub_menuhtml.="<div class='col-md-3 child_menu'>";
  $buttonhtml.="<div class='col-md-3 button_menu'>";
  
      $i=1;
 foreach($total_menu as $k=>$v){  
      
    if(isset($company_access_menu[$v->menus_id])){ 
      
          $checks='';
           if(isset($group_access_menu[$v->menus_id])){
               $checks='checked';
           }
    $headhtml .= "<tr><td>".$i."</td><td><a class='main_menu headmenus head".$v->menus_id."' href='' data-value=".$v->menus_id.">".$v->menus_name."</a></td><td><input type='checkbox' class='header".$v->menus_id." sub_headmenu0' name='menu_id[".$v->menus_id."]' myval=".$v->menus_id."  ".$checks." value='".$v->menus_name."'></td>  </tr> ";
    $sub_headhtml.="<div id='sub_menu".$v->menus_id."' class='sub_menu_hide'><div class='table-responsive'>  <table class='table myTable'>    <thead> <tr><th> Sno </th> <th>Head Menu Name</th> <th><input type='checkbox' name='checkall1' class='check_head'  value='".$v->menus_id."'> </th> </tr> </thead> <tbody>  ";
    $buttonhtml.="<div id='child_head_menu".$v->menus_id."' > ";
    $subhead_menus = \DB::table("tb_menus")->select("*")->where("parent_id","=",$v->menus_id)->get();
      $i1=1;
  foreach($subhead_menus as $k1=>$v1){
      if(isset($company_access_menu[$v1->menus_id])){
          $check='';
           if(isset($group_access_menu[$v1->menus_id])){
               $check='checked';
               
           }
        $sub_headhtml.="<tr><td>".$i1."</td><td><a class='main_menu subheadmenus subhea".$v1->menus_id."' href='' data-value=".$v1->menus_id.">".$v1->menus_name."</a></td><td><input type='checkbox' class='sub_headmenus subhead".$v1->menus_id." sub_headmenu".$v->menus_id."' name='menu_id[".$v1->menus_id."]' ".$check."  myval=".$v1->menus_id." value='".$v1->menus_name."'></td>  </tr> "; 
        $sub_menuhtml.="<div id='sub_head_menu".$v1->menus_id."' class='child_menu_hide'><div class='table-responsive'>  <table class='table myTable'><thead> <tr><th> Sno </th> <th>Head Menu Name</th> <th><input type='checkbox' name='checkall2' class='check_head'  value='".$v1->menus_id."'> </th> </tr> </thead> <tbody> "; 
        $buttonhtml.="<div id='button_menu".$v1->menus_id."' class='button_menu_hide' > "; 
        $childhead_menus = \DB::table("tb_menus")->select("*")->where("parent_id","=",$v1->menus_id)->get();
          $i2=1;
           foreach($childhead_menus as $k2=>$v2){
             if(isset($company_access_menu[$v2->menus_id])){
                  
                  $checked='';
           if(isset($group_access_menu[$v2->menus_id])){
               $checked='checked';
           }
                 
              $sub_menuhtml.="<tr><td>".$i2."</td><td><a class='main_menu submenus subtri".$v2->menus_id."' href='' data-value=".$v2->menus_id.">".$v2->menus_name."</a></td><td><input type='checkbox' class='sub_child_menus subheads".$v2->menus_id." sub_headmenu".$v1->menus_id."' name='menu_id[".$v2->menus_id."]'  ".$checked." myval=".$v2->menus_id." value='".$v2->menus_name."'></td>  </tr> ";   
              $buttonhtml.="<div id='button_names".$v2->menus_id."' class='button_menu_hides'><div class='table-responsive'>  <table class='table myTable'><thead> <tr><th> Sno </th> <th>Button Name</th> <th><input type='checkbox' name='checkall3' class='check_head'   value='".$v2->menus_id."'> </th> </tr> </thead> <tbody> "; 
              $childhead_menus = \DB::select("select * from button_names_tbl left join tb_menus on tb_menus.controller_name=button_names_tbl.module_name where tb_menus.menus_name='".$v2->menus_name."'");
              $i3=1;
            foreach($childhead_menus as $k3=>$v3){
              if(isset($button_access_menu[$v3->module_name])){
                      $checkss='';
                  $b_id=$v3->button_id;
      
                     if(isset($group_button_access_menu[$v3->module_name])){
                      $b_array=$group_button_access_menu[$v3->module_name];
                      $b_array1=get_object_vars($b_array);
             if(in_array($b_id,$b_array1) !== False) {
                      $checkss='checked';
           } 
                     }
           
                      $buttonhtml.='<tr>  <td>'.$i3.'</td> <td><strong><a  class="button">'.$v3->button_name.'</a></strong></td>  <td><input type="checkbox" class="button_list '.$v3->click_name.$v3->button_id.'  sub_headmenu'.$v2->menus_id.'"   name="button['.$v3->module_name.']['.$v3->click_name.']" value='.$v3->button_id.' '.$checkss.' ></td></tr>';
                      $i3++;
                    }
                    }
                      $buttonhtml.="</tbody></table></div></div>";
                      $i2++;
             }
      
          }
                     $buttonhtml.="</div>";
                     $sub_menuhtml.="</tbody></table></div></div>";
                     $i1++;
        }
      }  
                     $buttonhtml.="</div>"; 
                     $sub_headhtml.="</tbody></table></div></div>";
                     $i++;

  }
  }
                     $headhtml .="</tbody>  </table>     </div></div>";
                     $sub_headhtml.="</div>";
                     $sub_menuhtml.="</div>";
                     $buttonhtml.="</div>";
                     $this->data['headhtml']=$headhtml;
                     $this->data['sub_headhtml']=$sub_headhtml; 
                     $this->data['sub_menuhtml']=$sub_menuhtml; 
                     $this->data['buttonhtml']=$buttonhtml;
        return view('groupaccessmenu.formnew',$this->data);
    }



  public function menudata($id=null){
   
            
        $result = \DB::select("SELECT a_group_menu_access_t.menus as group_access_menu,a_company_menu_access_t.menus as company_access_menu FROM `a_group_menu_access_t` left join a_company_menu_access_t on a_company_menu_access_t.company_id=a_group_menu_access_t.companyaccess_id WHERE a_group_menu_access_t.group_id=$id"); 
//dd("SELECT a_group_menu_access_t.menus as group_access_menu,a_company_menu_access_t.menus as company_access_menu FROM `a_group_menu_access_t` left join a_company_menu_access_t on a_company_menu_access_t.company_id=a_group_menu_access_t.companyaccess_id   WHERE a_group_menu_access_t.group_id='$id'");
        //dd($result);
        if(isset($_GET['id']))
        {
        
        $data['total_menu'] = \DB::table("tb_menus")->select("*")->where("parent_id","=",$_GET['id'])->get();
        }
        else
        {
            $data['total_menu'] = \DB::table("tb_menus")->select("*")->where("parent_id","=","0")->get();
        }
  
         $data['company_access_menu']= json_decode($result[0]->company_access_menu);
        $data['group_access_menu']= json_decode($result[0]->group_access_menu);
     //   dd( $data['group_access_menu']);
        $data['group_id']= $id;

   return $data;

  }

    public function companyaccesssave(Request $request)
    {
         
        if(!empty($_POST['a_company_menu_access_id']))
		{
			
				$data['company_id']=$_POST['company_name'];
				$data['menus']=  json_encode($_POST['menu_id']);
				$data['permission']=json_encode($_POST['button']);
			
    			$result = \DB::table('a_company_menu_access_t')->where('a_company_menu_access_id',"=",$_POST['a_company_menu_access_id'])->update($data);
			
			
				$result1=\DB::table('a_company_menu_access_t')->where('a_company_menu_access_id',$_POST['a_company_menu_access_id'])->get();
				if(count($result1)>0)
				{
					$menus = $result1[0]->menus;
					$group = $result1[0]->company_id;
					$permission = $result1[0]->permission;
				}
    			return "2";
        } 
	    else
		{

				$data['company_id']=$_POST['company_name'];
				$data['menus']=  json_encode($_POST['menu_id']);
				$data['permission']=json_encode($_POST['button']);				

				$result= $inserted_id =\DB::table('a_company_menu_access_t')->insertGetId($data);
				$result1 = DB::table('a_company_menu_access_t')->where('a_company_menu_access_id',$inserted_id)->get();

				if(count($result1)>0)
				{
					$menus = $result1[0]->menus;
					$group = $result1[0]->company_id;
					$permission = $result1[0]->permission;
				}
			
				
				return "1";
                }
    }

     public function save(Request $request)
    {

		 
        if(!empty($_POST['a_group_menu_access_id']))
		{
			
				$data['group_id']=$_POST['group_name'];
				$data['menus']=  json_encode($_POST['menu_id']);
				$data['permission']=json_encode($_POST['button']);
			
    			$result = \DB::table('a_group_menu_access_t')->where('a_group_menu_access_id',"=",$_POST['a_group_menu_access_id'])->update($data);
			
			
				$result1=\DB::table('a_group_menu_access_t')->where('a_group_menu_access_id',$_POST['a_group_menu_access_id'])->get();
				if(count($result1)>0)
				{
					$menus = $result1[0]->menus;
					$group = $result1[0]->group_id;
					$permission = $result1[0]->permission;
				}
			
				//$result1 = DB::table('a_user_access_t')->where('group_id',$group)->update(['menus'=>$menus,'permission'=>$permission]);
			
    			return "2";
        } 
	    else
		{

				$data['group_id']=$_POST['group_name'];
				$data['menus']=  json_encode($_POST['menu_id']);
				$data['permission']=json_encode($_POST['button']);				

				$result= $inserted_id =\DB::table('a_group_menu_access_t')->insertGetId($data);
				$result1 = DB::table('a_group_menu_access_t')->where('a_group_menu_access_id',$inserted_id)->get();

				if(count($result1)>0)
				{
					$menus = $result1[0]->menus;
					$group = $result1[0]->group_id;
					$permission = $result1[0]->permission;
				}
			
				//$user_access = DB::table('a_user_access_t')->where('group_id',$group)->update(['menus'=>$menus,'permission'=>$permission]);
				return "1";
        }

    }

    public function show(Groupmenuaccess $groupmenuaccess)
    {
        //
    }


    public function edit($id=null)
    {
         $data=\DB::table("a_group_menu_access_t")->select("*")->where("a_group_menu_access_id",$id)->get();
         $this->data['group_name']=$this->jcombologin("a_m_group_t","group_id","group_name","");
         $this->data['header']=\DB::table("tb_menus")->select("*")->where("parent_id","=","0")->get();

        return view('groupaccessmenu.form',$this->data);
    }

   
    public function update(Request $request, Groupmenuaccess $groupmenuaccess)
    {
        //
    }

    public function destroy(Groupmenuaccess $groupmenuaccess)
    {
        //
    }
}
