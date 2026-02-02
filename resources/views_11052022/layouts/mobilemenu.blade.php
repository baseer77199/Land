<link rel="stylesheet" type="text/css" href="{{asset('mobilemenu/component.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('mobilemenu/default.css')}}">
<script type="text/javascript" src="{{asset('mobilemenu/modernizr.custom.js')}}"></script>
 <style type="text/css">
  .dl-trigger{
    border: 1px solid #fff !important;
  }
  .dl-menu{
    z-index: 99999 !important;
  }
 </style>

<div class="main clearfix">
        
        <div class="column">
          <div id="dl-menu" class="dl-menuwrapper">
            <button class="dl-trigger">Open Menu</button>
            <ul class="dl-menu">
<?php

                       $headers=DB::table("tb_menus")->select('*')->where('parent_id', '=', 0)->orderBy('menus_id', 'asc')->get();


$access=\DB::table('a_user_access_t')->select('*')->where('user_id',\Session::get('id'))->get();
$access=   json_decode($access[0]->menus);


$subsubmenu=array();
                                $controllers=array();
                                $controller=array();

                                foreach($headers as $key=>$value){


  $subsubmenu[$value->menus_id]=array();
  $controller[$value->menus_id]=$value->controller_name;
  $controllers[$value->menus_id]=array();
  $createurl[$value->menus_id]=array();

                                $subhead=DB::table("tb_menus")->select('*')->where('parent_id', '=', $value->menus_id)->orderBy('menus_id', 'asc')->get();

                                foreach($subhead as $k=>$v){

                                $subname=DB::table("tb_menus")->select('*')->where('parent_id', '=', $v->menus_id)->orderBy('menus_id', 'asc')->get();
$subsubmenu[$value->menus_id][$v->menus_id]=array();

                                foreach($subname as $k1=>$v1){
                                $subsubmenu[$value->menus_id][$v->menus_id][$v1->menus_id]=$v1->menus_name;
                                $controllers[$value->menus_id][$v->menus_id][$v1->menus_id]=$v1->controller_name;
                                $createurl[$value->menus_id][$v->menus_id][$v1->menus_id]=$v1->createurl;

                                }

                                }


                              }  ?>






  <?php foreach($subsubmenu as $key=>$value)   {    if(isset($access->$key)) {    $name=DB::table("tb_menus")->select('*')->where('menus_id', '=', $key)->get(); ?>


              <li>
                <a href="#" onclick="return false;"><?php echo $name[0]->menus_name;   ?></a>


                <ul class="dl-submenu">
                  <?php foreach($value as $k=>$v) {  if(isset($access->$k)) {  $name1=DB::table("tb_menus")->select('*')->where('menus_id', '=', $k)->get(); ?>
                  <li>
                    <a href="#" onclick="return false;"><?php echo $name1[0]->menus_name; ?></a>
                    <ul class="dl-submenu">
                       <?php foreach($v as $k1=>$v1) {  if(isset($access->$k1)) {  ?>



                      <li><a href="<?php echo URL::to($controllers[$key][$k][$k1]); ?>">{{$v1}} </a></li>
                     <?php }  }?>
                    </ul>
                  </li>
                  
                  <?php }  }?>
                </ul>
                
              </li>
              <?php } } ?>
              
            </ul>
          </div><!-- /dl-menuwrapper -->
        </div>
      </div>
 
<script type="text/javascript" src="{{asset('mobilemenu/jquery.dlmenu.js')}}"></script>
<script type="text/javascript">
  $(function() {
        $( '#dl-menu' ).dlmenu();
      });
</script>