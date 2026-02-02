@extends('layouts.header')
@section('content')

<style type="text/css">

</style>

<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
  
                                <h4 class="panel-title">
                                    <a role="button">
                                       <?php if($pageMethod=="allocateengineer") {?>
                                       	Allocate Engineer
                                       <?php }else if($pageMethod=="allocatetechnician"){ ?>
                                       	Allocate Technician
                                     <?php  }else if($pageMethod=="requestraise"){?>
                                     	Ticket Closure Request
                                     <?php } else if($pageMethod=="approverequest"){ ?>
                                     	 Ticket Closure Approval
                                     	<?php } else if($pageMethod=="closerequest"){?>
                                     		Close Request
                                     		  <?php }else if($pageMethod=="sopupload"){?>
                                      		  SOP
                                     		<?php } else if($pageMethod=="createissue"){ ?>
                                        Create Issue
                                    <?php } ?>
                                    </a>
                                </h4>

                             
                            </div>

</div>

<form id="create-user" action="{{URL::to('issuecreate')}}" method="POST" style="display: none;">
                               {{ csrf_field() }}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    <input type='hidden' name='btnval' value='' id='btnval' class='btnval'>   
                                  </form>
                                  
                                  
    <form id="view-user" action='{{URL::to("userview")}}' method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                     <input type='hidden' name='btnval' value='' id='btnval' class='btnval'>   
                                  </form> 
                                  
    <form id="engineerallocate-user" action='{{URL::to("engineerallocate")}}' method="POST" style="display: none;">
                                   {{ csrf_field() }}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                     <input type='hidden' name='btnval' value='' id='btnval' class='btnval'>   
                                  </form> 


  <div class="panel panel-visible" id="spy1">

 <?php include('toolbar.php'); ?>
 <?php if($pageMethod=="sopupload"){ ?>
<button type="button" class="btn add upload" id="create" value="">Create</button>
<button type="button" class="btn add vie sopview" id="sopview" value="">View</button>
<button type="button" class="btn add sopdownload" id="sopdownload" value="">Download</button>
<!-- <a href="#" class=" btn sopdownload" id="sopdownload">Download</a> -->
 <?php } ?>


<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>

<div class="row">
<div class="col-md-12">

  <table id="grid1"></table>
</div>
</div>

<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>


  </div>
  





<script type="text/javascript">
$( document ).ready(function() {

var method="{{$pageMethod}}";
$("#grid1").jqGrid({
url:"{{URL::to('issueData')}}?status="+method,
mtype:'GET',
datatype:'json',

colModel: [
{ name: "id", label: "S.NO",hidden:true },
{ name: "breakdown_name", label: "Breakdown Type" },
{ name: "ticket_number", label: "Ticket Number" },
{ name: "issue_date", label: "Issue Date" },
{ name: "severity_name", label: "Breakdown Sevearity"},
{ name: "causes", label: "Causes of Breakdown",editable:true, editrules:{date:true}},
{ name: "department_name", label: "Department",editable:true, editrules:{date:true}},
{ name: "error_code", label: "Error Code",editable:true, editrules:{date:true}},
{ name: "files", label: "Files",editable:true, editrules:{date:true}},

],
iconSet: "fontAwesome",
   rowNum: 10,
    rowList: [10,20,50,100,250,500,1000],
    sortorder: "desc",
    viewrecords: true,
    gridview: true,
    rownumbers:true,
      pager: "#grid1",
      autowidth: true,
viewrecords: true,
searching: {
defaultSearch: "cn"
},onCellSelect: function (rowid) {
    var rowData = $(this).jqGrid("getRowData", rowid);
    console.log(rowData['files']);
    var file_path = 'upload/sop/'+rowData['files'];
    if(rowData['files']){
    	$("#sopdownload").attr("href",file_path);
/*var a = document.createElement('A');
a.href = file_path;
a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
document.body.appendChild(a);
a.click();
document.body.removeChild(a);*/
}
    // now you can use rowData.name2, rowData.name3, rowData.name4 ,...
}
});

        jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, defaultSearch:'cn'});
$("#grid1").jqGrid("setLabel", "rn", "S.No");
	
	
$("#sopdownload").click(function(){
	var index = $("#grid1").jqGrid('getGridParam','selrow');
	var id = $("#grid1").jqGrid ('getCell', index, 'id');
	var files = $("#grid1").jqGrid ('getCell', index, 'files');
	if(id)
	{
    var file_path = 'upload/sop/'+files;
    // alert(file_path);
    if(files){
    	// alert(files);
var a = document.createElement('A');
a.href = file_path;
a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
document.body.appendChild(a);
a.click();
document.body.removeChild(a);
}else{
	notyMsgs("info","There is No file to Download");
}
 
	}
	else
	{
			 notyMsgs("info","Please Select a Row");
	}
});

$('.allocate').on('click',function(){
  var index = $("#grid1").jqGrid('getGridParam','selrow');
	var edit_id = $("#grid1").jqGrid ('getCell', index, 'id');
 	var btnval="{{$pageMethod}}";
 
     var id=$('.id').val(edit_id);
     var btnval=$('.btnval').val(btnval);
        if(index){     
document.getElementById('engineerallocate-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })
     
     $('.create').on('click',function(){
         var btnval="{{$pageMethod}}";
        
         var btnval=$('.btnval').val(btnval);
     });
// $(".allocate").click(function(){
// 	var btnval="{{$pageMethod}}";
// 	//alert(method);
// 	//var btnval = $(this).val();
//     var index = $("#grid1").jqGrid('getGridParam','selrow');
// 	var edit_id = $("#grid1").jqGrid ('getCell', index, 'id');
// 	//alert(edit_id);
//       if(edit_id){
// 		window.location.replace('engineerallocate/'+edit_id+'?btnval='+btnval);
// 	}
// 	else
// 	{
// 		 notyMsgs("info","Please Select a Row");
// 	}

// });

<?php if($pageMethod!="sopupload")
{?>
jQuery("#grid1").jqGrid('hideCol',["error_code","files"]);
<?php } ?>
$('.upload').on('click',function(){
     var index = $("#grid1").jqGrid('getGridParam','selrow');
	var edit_id = $("#grid1").jqGrid ('getCell', index, 'id');
 	var btnval="{{$pageMethod}}";
     var id=$('.id').val(edit_id);
     var btnval=$('.btnval').val(btnval);
        if(index){     
document.getElementById('engineerallocate-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })
// $(".upload").click(function(){
// 	var btnval="{{$pageMethod}}";
// 	//alert(method);
// 	//var btnval = $(this).val();
//     var index = $("#grid1").jqGrid('getGridParam','selrow');
// 	var edit_id = $("#grid1").jqGrid ('getCell', index, 'id');
// 	//alert(edit_id);
//       if(edit_id){
// 		window.location.replace('engineerallocate/'+edit_id+'?btnval='+"sopupload");
// 	}
// 	else
// 	{
// 		 notyMsgs("info","Please Select a Row");
// 	}

// });
// $(document).on('click','.create',function()
// {
// var inquirytype = $(this).val();
// var url="{{ url('issuecreate') }}";

// window.location.replace(url);
// });

$('.create').on('click',function(){
    
document.getElementById('create-user').submit(); 
       
     })
     
showcolumn('grid1');

$('#viewdata').on('click',function(){
    var index = $("#grid1").jqGrid('getGridParam','selrow');
 	var id = $("#grid1").jqGrid ('getCell', index, 'id');
 	var btnval="{{$pageMethod}}";
     var id=$('.id').val(id);
     var btnval=$('.btnval').val(btnval);
        if(index){     
document.getElementById('view-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })
//       $("#viewdata").click(function(){

// 	var index = $("#grid1").jqGrid('getGridParam','selrow');
// 	var id = $("#grid1").jqGrid ('getCell', index, 'id');
// 	if(id)
// 	{
// 		window.location.replace('userview/'+id +'?btnval='+method);
// 	}
// 	else
// 	{
// 			 notyMsgs("info","Please Select a Row");
// 	}
// });

$("#sopview").click(function(){
	var index = $("#grid1").jqGrid('getGridParam','selrow');
	var id = $("#grid1").jqGrid ('getCell', index, 'id');
	if(id)
	{
		window.location.replace('sopview/'+id);
	}
	else
	{
			 notyMsgs("info","Please Select a Row");
	}
});
       $(".delete").click(function(){
		var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
		var pohdrid = jQuery("#grid1").jqGrid ('getCell', gr, 'id');
		if( pohdrid != false ){
		window.location.replace('userdelete/' +pohdrid);
		}
		else{
		 notyMsg("info","Please Select a Row");
		}
	});
/***** Delete Row ********/

	$("#clearsearch").click(function() {
		var grid = $("#grid1");
		grid.jqGrid('setGridParam',{search:false});

		var postData = grid.jqGrid('getGridParam','postData');
		$.extend(postData,{filters:""});
		grid.trigger("reloadGrid",[{page:1}]);
		 $('input[id*="gs_"]').val("");
         $('select[id*="gs_"]').select2('val',['']);
	});
/*End*/

	$("#exportpdf").on("click", function(){
		
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
  fileName : "Issue.pdf",
  mimetype : "application/pdf"  
});
	});	
		
		$("#exportexcel").on("click", function(){
				$("#grid1").jqGrid("exportToExcel",{
					includeLabels : true,
					includeGroupHeader : true,
					includeFooter: true,
					fileName : "Issue.xlsx",
					maxlength : 40000 
				})
		
		
			})

});
    </script>
@endsection
