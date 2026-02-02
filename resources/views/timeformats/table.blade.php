@extends('layouts.header')
@section('content')

<h2 class="heads">Time Formats</h2>

<div class="panel panel-visible" id="spy1">

<div class="panel-title">
<!-- <span class="glyphicon glyphicon-tasks"></span> -->
<div class="row">
<!--div class="col-md-12">
<a href='timeformatscreate' class='btn add create'>Create</a>
<a id="editdata"  class="btn sec edit"> Edit</a>

<button type='button' href='' class='btn del delete'> Delete </button>
</div-->
	<div class="col-md-12">
	<?php include('toolbar.php'); ?>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<table id="grid1"></table>
</div>

</div>
</div>





<script>
	$(document).ready(function(){

		var data="{{ $datas }}";
		var result = jQuery.parseJSON(data.replace(/&quot;/g, '"' ));

		$("#grid1").jqGrid({
		url: "gettimeformatsData",
		datatype: "json",
		mtype: "GET",
        width:1200,
			 colModel: [
			{ name: "time_formats_id", label: "id",hidden: true, },
			{ name: "php_format", label: "Php Format" ,editable:true, editrules:{date:true}},
			{ name: "js_format", label: "Javascript Format",editable:true, editrules:{date:true}},
			{ name: "display_format", label: "Display Format",editable:true, editrules:{date:true}},
			],
			 /*data:result,*/

		   iconSet: "fontAwesome",
				   rowNum: 100,
			   rowList: [10,20,50,100],
			   sortorder: "asc",
			   viewrecords: true,
			   gridview: true,
			   rownumbers:true,
			   caption: "",
				 pager:"#grid1",
			   searching: {
				   defaultSearch: "cn"
			   }
			 });
		jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
$("#grid1").jqGrid("setLabel", "rn", "S.No");
	
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
  fileName : "Timeformat.pdf",
  mimetype : "application/pdf"  
});
   });
   $(document).on('click',".exportexcel",function() {
$("#grid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Timeformat.xlsx"
              
        })  
});

showcolumn('grid1');

	
	$(document).on('click','.del',function(e){
        e.preventDefault();
        var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
        var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'time_formats_id');
        if(cellValue)
        {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: !0,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }, function(e) {
                 if(e == true)
                 {
                    $.get('timeformatdelete/'+cellValue, function(data,status)
                    {
                        var data = $.trim(data);
                        if(data =='0')
                        {
                            notyMsg('success','Deleted Successfully!!!');
                            setTimeout(function(){
                            $("#grid1")[0].triggerToolbar();
                            }, 1500);
                        }
                        if(data =='2')
                        {
                            notyMsg('error',"You Cant't delete  Used in SomeWhere!!!");
                            setTimeout(function(){
                            $("#grid1")[0].triggerToolbar();
                            }, 1500);
                        }
                    });
                }
                else{
                  $('.apply').css('display','none');
                  swal("Cancelled");
                }
            })
             $('.apply').css('display','none');
        }
        else
        {
            notyMsg('info',"Please Select Row");
        }
   	});


		$("#editdata").click(function()
			{
			 var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
			 var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'time_formats_id');
			
			
			
				if(gr)
				{
					var url = "timeformatsedit";
					var editUrl = url + '/' + cellValue + '/edit';
					window.location.replace('timeformatsedit/' +cellValue);
				}
				else
				{
				notyMsgs('info',"Please Select Row");
				}
			});
		
		$(".create").click(function()
			{
			 var url = "{{ URL::to('timeformatscreate') }}";
					window.location.replace(url);
				
			});
		
	$(".clearsearch").click(function()
  { 

      var grid = $("#grid1");
      grid.jqGrid('setGridParam',{search:false});

      var postData = grid.jqGrid('getGridParam','postData');
      $.extend(postData,{filters:""});
      grid.trigger("reloadGrid",[{page:1}]);
      $('input[id*="gs_"]').val("");
     
  });
  /*End*/



		$('#viewdata').click(function(){
		  var gr=$('#grid1').jqGrid('getGridParam','selrow');
		  var cellValue = $("#grid1").jqGrid ('getCell', gr, 'time_formats_id');  //alert(cellValue);

		  if(cellValue)
		  {
			 var url="timeformatsview";
			 var viewurl = url+'/'+cellValue+'/view';
			 window.location.replace('timeformatsview/' +cellValue);
		  }
		  else
		  {
			 alert("Please Select Row");
		  }
		});

	})


</script>

@endsection
