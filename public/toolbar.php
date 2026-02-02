
<!-- <ul class="breadcrumb">
  <li><a href="#"><i class="fa fa-home" style="color: #333; font-size: 14px"></i> Home</a></li>
  <li><a href="#">Pictures</a></li>
  
</ul> -->


<?php
$data=\Session::get('data');
$button_name=\Session::get('button_name');

$button_val=array();
if(isset($button_name)) {
foreach($button_name as $val){
    $id=$val->button_id;
    $button_val[$id]=$val;
}
if(isset($data[$pageMethod])){

$i=0;

    foreach($data[$pageMethod] as $index=>$val)
    {

      if($i ==2)
      break;
       ?>
<a> <button type="button" class="<?php echo $button_val[$val]->button_class;?>" id="<?php echo $button_val[$val]->button_id_name;?>" value="<?php echo $button_val[$val]->value;?>"><?php echo $button_val[$val]->button_name;?></button></a>
<?php $i++;
}?>
<div class="btn-group">
<button type = "button" class = "btn btn-default dropdown-toggle vie more" data-toggle = "dropdown">
      More
      <span class = "caret"></span>
   </button>

<ul class = "dropdown-menu Menu" role = "menu">
<?php  $i=0; foreach($data[$pageMethod] as $index=>$val)
  { if($i >1) {
     
    ?>
  <li><a href="#" class="<?php echo str_replace("btn","",$button_val[$val]->button_class);?>" id="<?php echo $button_val[$val]->button_id_name;?>" value="<?php echo $button_val[$val]->value;?>"><?php echo $button_val[$val]->button_name;?></a></li>
<?php } $i++; } ?>
	<li><a id="exportexcel" href="#" class="exportexcel">Export as Excel</a></li>
	<li><a id="exportpdf" href="#" class="exportpdf">Export as Pdf</a></li>
<li><a id="clearsearch" href="#" class="search clearsearch">Clear Search</a></li>
<li><a href="#" id="showcolumn" value="1" class='showcolumn vie '> Show column </a></li>
   </ul>


</div>

<?php }

}
?>

<!-- <style>
img {
    vertical-align: text-bottom;
}
.panel-title{
  font-size: unset;
}
.breadcrumb{
  margin-top: 9px;
  margin-bottom: unset;
}
ul.breadcrumb {
  float: right;
  padding: 0px 0px;
  list-style: none;
  background-color:unset;
}
ul.breadcrumb li {

  display: inline;
  font-weight: normal;
  font-size: 13px;
  font-family: TypoGroteskBoldDemo;
  
}
ul.breadcrumb li+li:before {
  padding: 8px;
  color: black;
  content: "/\00a0";
}
ul.breadcrumb li:nth-child(2){
  text-transform: uppercase;
}

ul.breadcrumb li a {
  color: #333;
  text-decoration: none;
}
ul.breadcrumb li a:hover {
  font-size: 14px;
  
}
</style> -->
