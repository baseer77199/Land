<?php

namespace App\Http\Controllers;

use App\Useraccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UseraccessController extends Controller
{
       public $module="Useraccess";
    public function __construct()
    {
		
        $this->data=array(
                    'pageModule'=> 'Useraccess',
                    'pageUrl'   =>  url('Useraccess')
                  );
$this->data['urlmenu']=$this->indexs(); 
        $this->pageModule="Useraccess";

        $this->data['pageModule']=$this->pageModule;
        $this->data['pageMethod']=\Request::route()->getName();
        $this->data['pageFormtype']='ajax';
    }
    public function index()
    {
	        $loc=\Session::get('location');

        $this->data['data'] = \DB::table('a_user_access_t')

            ->join('tb_users', 'a_user_access_t.user_id', '=', 'tb_users.id')
            ->select('a_user_access_t.a_user_access_id as id','tb_users.username as username','tb_users.email')->where('loc_id',$loc)
            ->get();

      return view('useraccess.table',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
if(isset($_POST['id']))    
    $id=$_POST['id'];    
        
        $headhtml=""; 
        $sub_headhtml=""; 
        $sub_menuhtml=""; 
        $buttonhtml=""; 
        
    $total_menu = \DB::table("tb_menus")->select("*")->where("parent_id","=","0")->get();
    $result = \DB::select("SELECT a_user_access_t.a_user_access_id,a_user_access_t.user_id,a_user_access_t.permission as group_button_access_menu,a_user_access_t.menus as group_access_menu,a_group_menu_access_t.menus as company_access_menu,a_group_menu_access_t.permission as button_access_menu FROM `a_user_access_t` left join a_group_menu_access_t on a_group_menu_access_t.group_id=a_user_access_t.group_id WHERE a_user_access_t.a_user_access_id='".$id."'"); 
     $company_access_menu= get_object_vars(json_decode($result[0]->company_access_menu));
     $button_access_menu= get_object_vars(json_decode($result[0]->button_access_menu));
        $group_access_menu= get_object_vars(json_decode($result[0]->group_access_menu)); 
        $group_button_access_menu= get_object_vars(json_decode($result[0]->group_button_access_menu)); 
    
$this->data['user_name']=$this->jCombologin('tb_users','id','username',$result[0]->user_id);
$this->data['a_user_access_id']=$result[0]->a_user_access_id;
    
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
        $sub_headhtml.="<tr><td>".$i1."</td><td><a class='main_menu subheadmenus subhea".$v1->menus_id."' href='' data-value=".$v1->menus_id.">".$v1->menus_name."</a></td><td><input type='checkbox' class='sub_headmenus subhead".$v1->menus_id." sub_headmenu".$v->menus_id."' myval=".$v1->menus_id." name='menu_id[".$v1->menus_id."]' ".$check."   value='".$v1->menus_name."'></td>  </tr> "; 
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
                 
              $sub_menuhtml.="<tr><td>".$i2."</td><td><a class='main_menu submenus subtri".$v2->menus_id."' href='' data-value=".$v2->menus_id.">".$v2->menus_name."</a></td><td><input type='checkbox' class='sub_child_menus subheads".$v2->menus_id." sub_headmenu".$v1->menus_id."' myval=".$v2->menus_id." name='menu_id[".$v2->menus_id."]'  ".$checked." value='".$v2->menus_name."'></td>  </tr> ";   
              $buttonhtml.="<div id='button_names".$v2->menus_id."' class='button_menu_hides'><div class='table-responsive'>  <table class='table myTable'><thead> <tr><th> Sno </th> <th>Button Name</th> <th><input type='checkbox' name='checkall3' class='check_head'   value='".$v2->menus_id."'> </th> </tr> </thead> <tbody> "; 
              $childhead_menus = \DB::select("select * from button_names_tbl left join tb_menus on tb_menus.controller_name=button_names_tbl.module_name where tb_menus.menus_id='".$v2->menus_id."'");
           
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
           
                      $buttonhtml.='<tr>  <td>'.$i3.'</td> <td><strong><a  class="button">'.$v3->button_name.'</a></strong></td>  <td><input type="checkbox" class="button_list '.$v3->click_name.$v3->button_id.' sub_headmenu'.$v2->menus_id.'"   name="button['.$v3->module_name.']['.$v3->click_name.']" value='.$v3->button_id.' '.$checkss.' ></td></tr>';
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
        
        return view('useraccess.form',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function menudata($id=null)
    {
        
        $result = \DB::select("SELECT
    a_user_access_t.menus AS user_access_menu,
    a_group_menu_access_t.menus AS group_access_menu
FROM
    a_user_access_t
LEFT JOIN a_group_menu_access_t ON a_group_menu_access_t.group_id = a_user_access_t.group_id
WHERE
    a_user_access_t.user_id = '$id'");
      
        if(isset($_GET['id']))
        {
        
        $data['total_menu'] = \DB::table("tb_menus")->select("*")->where("parent_id","=",$_GET['id'])->get();
        }
        else
        {
        $data['total_menu'] = \DB::table("tb_menus")->select("*")->where("parent_id","=","0")->get();
        }
         
        $data['user_access_menu']= json_decode($result[0]->user_access_menu);
        $data['group_access_menu']= json_decode($result[0]->group_access_menu);
        $data['user_id']= $id;


       
        return $data;

    }

      public function subheaddata($id=null,$ids=null)
    {
        $user_id=\DB::table("tb_users")->select("group_id")->where("id","=",$ids)->get();

      $datas=\DB::table("a_group_menu_access_t")->select("*")->where("group_id",$user_id[0]->group_id)->get();
       $data['menu']= json_decode($datas[0]->menus);


        $data['totalmenu']=\DB::table("tb_menus")->select("*")->where("parent_id","=",$id)->get();
        return $data;

    }

          public function buttonname($buttonname=null)
    {
              
        $user_id['button']=\DB::table("button_names_tbl")->select("*")->where("module_name","=",$buttonname)->get();
        if(isset($_GET['id']))    
        {
        $user_id['check_button']=\DB::table("a_group_menu_access_t")->select("*")->where("a_group_menu_access_id","=",$_GET['id'])->get();
            
        if(count($user_id['check_button'])>0)
            $user_id['check_button']=json_decode($user_id['check_button'][0]->permission);
        }     
     
        return $user_id;

    }
    
     public function buttonnameuser($buttonname=null)
    {
              
        $user_id['button']=\DB::table("button_names_tbl")->select("*")->where("module_name","=",$buttonname)->get();
         
         $result = \DB::select("SELECT
                a_user_access_t.permission AS user_access_permission,
                a_group_menu_access_t.permission AS group_access_permission
            FROM
                a_user_access_t
            LEFT JOIN a_group_menu_access_t ON a_group_menu_access_t.group_id = a_user_access_t.group_id
            WHERE
                a_user_access_t.user_id = '".$_GET['user_id']."'");
         
        
    
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Useraccess  $useraccess
     * @return \Illuminate\Http\Response
     */
    public function save()

    {

        if(!empty($_POST['a_user_access_id'])){
                 $data['user_id']=$_POST['user_id'];
    $data['menus']=  json_encode($_POST['menu_id']);
    $data['permission']=  json_encode($_POST['button']);

    
   \DB::table('a_user_access_t')->where('a_user_access_id',"=",$_POST['a_user_access_id'])->update($data);
    return "1";
        }
        else{
            
     $data['user_id']=$_POST['user_id'];
    $data['menus']=  json_encode($_POST['menu_id']);
    $data['permission']=  json_encode($_POST['button']);
   \DB::table('a_user_access_t')->insert($data);
    return "2";
    }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Useraccess  $useraccess
     * @return \Illuminate\Http\Response
     */
    public function edit(Useraccess $useraccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Useraccess  $useraccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Useraccess $useraccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Useraccess  $useraccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(Useraccess $useraccess)
    {
        //
    }
}
