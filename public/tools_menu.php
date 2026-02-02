<style>
	

.dropdown-content {
display: none;
position: absolute;
background-color: #f9f9f9;
width: auto;
box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
z-index: 999;
margin-top: 40px;
margin-left: 10px;
}
	
</style>

<div class="dropdown">
<span class="dropbtn dropdown-content"></span>
<div class="has-submenu ">
	<a href="#"></a>
<table class="cg__subMenu" border="1">



<?php
//dd("dhfg");

$pageModule_name = $pageModule;

error_reporting(0);

$test="select
tlh.m_toolmenus_listing_hdr_id,
tlh.pagemodule,
tll.submenu_region
from
m_toolmenus_listing_hdr_t tlh
left join m_toolmenus_listing_lines_t tll on tll.m_toolmenus_listing_hdr_id = tlh.m_toolmenus_listing_hdr_id where tlh.pagemodule='".$pageModule_name."' group by tll.submenu_region ";
$data_result = \DB::select($test);
	
foreach($data_result as $key => $values)
{



?>
<tr class="mtabclstr">
<?php

$tool="select
tlh.m_toolmenus_listing_hdr_id,tll.submenu_url,tll.submenu_icon,tll.submenu_label,tll.submenu_region,tll.submenu_order from m_toolmenus_listing_hdr_t tlh left join m_toolmenus_listing_lines_t tll on tll.m_toolmenus_listing_hdr_id = tlh.m_toolmenus_listing_hdr_id  where tlh.pagemodule='".$values->pagemodule."' and tll.submenu_region='".$values->submenu_region."' group by tll.submenu_name order by tll.submenu_order";



$result_l = \DB::select($tool);

foreach($result_l as $key => $values_l)
{
	//dd($values_l);
$urlplace = url("$values_l->submenu_url");
$urlicon = url("$values_l->submenu_icon");
$icon =$values_l->submenu_icon;
?>

<td class="tdcls">

<a href='<?php echo $urlplace; ?>' target="_blank"><i class="<?php echo $icon; ?>"></i> <?php echo $values_l->submenu_label; ?></a>

</td>
<?php
}
?>
</tr>
<?php

}

?>


</table>

</div>
</div>

