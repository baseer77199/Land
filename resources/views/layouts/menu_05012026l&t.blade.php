<nav>

    <ul class="main-menu">

        <!-------------------------------first list------------>
        <?php

$headers = DB::table("tb_menus")->select('*')->where('parent_id', '=', 0)->orderBy('menus_id', 'asc')->get();
$access = \DB::table('a_user_access_t')->select('*')->where('user_id', \Session::get('id'))->get();
$access = json_decode($access[0]->menus);


$subsubmenu = array();
$controllers = array();
$controller = array();

foreach ($headers as $key => $value) {


  $subsubmenu[$value->menus_id] = array();
  $controller[$value->menus_id] = $value->controller_name;
  $controllers[$value->menus_id] = array();
  $createurl[$value->menus_id] = array();

  $subhead = DB::table("tb_menus")->select('*')->where('parent_id', '=', $value->menus_id)->orderBy('menus_id', 'asc')->get();

  foreach ($subhead as $k => $v) {

    $subname = DB::table("tb_menus")->select('*')->where('parent_id', '=', $v->menus_id)->orderBy('menus_id', 'asc')->get();
    $subsubmenu[$value->menus_id][$v->menus_id] = array();

    foreach ($subname as $k1 => $v1) {
      $subsubmenu[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->menus_name;
      $controllers[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->controller_name;
      $createurl[$value->menus_id][$v->menus_id][$v1->menus_id] = $v1->createurl;

    }

  }


}  ?>

        <?php foreach ($subsubmenu as $key => $value) {
  if (isset($access->$key)) {
    $name = DB::table("tb_menus")->select('*')->where('menus_id', '=', $key)->get(); ?>
        <li class="mega-parent">


            <a href="#" onclick="return false;" class="menuhover"><?php    echo $name[0]->menus_name;   ?>
            </a>
            <div class="mega-menu-area hp2style2 mega-menu-area2">
                <?php    foreach ($value as $k => $v) {
      if (isset($access->$k)) {
        $name1 = DB::table("tb_menus")->select('*')->where('menus_id', '=', $k)->get(); ?>
                <ul class="single-mega-item single-mega-item2">

                    <li class="mega-title mega-title1"><a href="#" class="mega_sub_menu"
                            onclick="return false;"><?php        echo $name1[0]->menus_name; ?></a>
                    </li>
                    <?php        foreach ($v as $k1 => $v1) {
          if (isset($access->$k1)) {  ?>
                    <li><a
                            href="<?php            echo URL::to($controllers[$key][$k][$k1]); ?>">{{$v1}}</a><?php            if (isset($createurl[$key][$k][$k1]) && $createurl[$key][$k][$k1] != '') { ?>
                        <a href="<?php              echo URL::to($createurl[$key][$k][$k1]); ?>"><i
                                class="fa fa-plus-circle"></i></a><?php            } ?>
                    </li>
                    <?php          }
        }  ?>

                </ul>
                <?php      }
    }?>



            </div>
        </li>
        <?php  }
} ?>
    </ul>
</nav>