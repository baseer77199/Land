@extends('layouts.header')
@section('content')


<h2 class="heads">Look Ups</h2>
<div class="panel panel-visible" id="spy1">
	<div class="row">
		<div class="col-md-12">
			<?php include('toolbar.php'); ?>
		</div>
</div>
<div class="row">
<div class="col-md-12">
<table id="grid1"></table>
</div>
</div>
</div>




<script type="text/javascript">
$( document ).ready(function() {
	var data="{{$result}}";
	var data=JSON.parse(data.replace(/&quot;/g,'"'));
$("#grid1").jqGrid({

datatype: "local",
	 colModel: [
	{ name: "lookuphdr_id", label: "id",hidden:true },
	{ name: "lookup_type", label: "Field Option",editable:true,width:50, editrules:{date:true}},
		],
        iconSet: "fontAwesome",
        rowNum: 10,

        rowList: [10,20,50,100],
        sortorder: "desc",
        viewrecords: true,
        gridview: true,
        rownumbers:true,
         data:data,
        caption: "",
	    autowidth:true,
        pager: "#grid1",
        searching: {
			
            defaultSearch: "cn"
        }
      });
jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
$("#grid1").jqGrid("setLabel", "rn", "S.No");
jQuery("#gs_grid1_customerid").select2();

	
/*deepika purpose: show column*/
jQuery("#grid1").jqGrid('hideCol');
showcolumn('grid1');

/*end*/
$(document).on('click','.create',function()
{
var inquirytype = $(this).val();
var url="{{ url('lookcreate') }}";

window.location.replace(url);
});

$("#editdata").click(function()
{
	var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
	var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'lookuphdr_id');
	if( gr )
	{
		var url = "{{ url('lookupcreate') }}";
                var editUrl = url + '/' + cellValue;
		window.location.replace(editUrl);
	}
	else
	{
	notyMsg("info","Please Select a Row");
	}
});


	$(document).on('click',".exportexcel",function() {
$("#grid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Common Lookups.xlsx"
              
        })  
});
	
$(document).on('click',".exportpdf",function() {
    $("#grid1").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "Common Lookups.pdf",
  mimetype : "application/pdf"  
});
   });	
	
	

$('#view').click(function()
{
  var gr=$('#grid1').jqGrid('getGridParam','selrow');
  var cellValue = $("#grid1").jqGrid ('getCell', gr, 'lookuphdr_id');
  if(gr)
  {
     var url="lookupsaveview";
     var viewurl = url+'/'+cellValue+'/view';
     window.location.replace('lookupsaveview/' +cellValue);
  }
  else
  {
	  
     notyMsgs('info',"Please Select a Row");
  }
});


/*deepika purpose:clear search the jqgrid*/
	$(".clearsearch").click(function()
{
var grid = $("#grid1");
grid.jqGrid('setGridParam',{search:false});

var postData = grid.jqGrid('getGridParam','postData');
$.extend(postData,{filters:""});
grid.trigger("reloadGrid",[{page:1}]);
		$('input[id*="gs_"]').val("");
         $('select[id*="gs_"]').select2('val',['']);
});
/*end*/
	$(window).scroll(function() {
if ($(this).scrollTop() >150){
    $('.header-sticky').addClass("sticky");
  }
  else{
    $('.header-sticky').removeClass("sticky");
  }
});

});
  </script>
@endsection
